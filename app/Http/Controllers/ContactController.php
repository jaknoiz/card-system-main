<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function showContactDetails($id)
    {
        $contact = Contact::findOrFail($id);
        $user = auth()->user();

        // ✅ Admin ดูได้ทุกคน
        // ✅ User ดูเฉพาะของตัวเอง
        if ($user->role !== 'admin' && $user->id !== $contact->id) {
            abort(403, 'Unauthorized.');
        }

        // สร้าง QR Code
        $currentUrl = route('contacts.show', ['id' => $contact->id]);
        $qrCode = QrCode::size(150)->encoding('UTF-8')->errorCorrection('L')->generate($currentUrl);

        return view('contact_detail', compact('contact', 'qrCode'));
    }
    

    

    
    


    

    


    /**
     * ดาวน์โหลดไฟล์ VCF
     */
    public function downloadVCF($id)
    {
        // ดึงข้อมูลผู้ติดต่อจากฐานข้อมูล
        $contact = Contact::findOrFail($id);
    
        // สร้างเนื้อหา VCF
        $vcfContent = $this->generateVCF($contact);
    
        // สร้างชื่อไฟล์โดยใช้ชื่อผู้ติดต่อ
        $fileName = str_replace(' ', '_', $contact->name) . '.vcf';
    
        return response($vcfContent)
            ->header('Content-Type', 'text/vcard')
            ->header('Content-Disposition', "attachment; filename=\"{$fileName}\"");
    }


private function generateVCF(Contact $contact): string
{
    $vcf = [
        "BEGIN:VCARD",
        "VERSION:4.0",
        "FN:" . ($contact->name ?? 'N/A'),
        "ORG:" . ($contact->organization ?? 'N/A'),
        "TITLE:" . ($contact->position ?? ''),
        "EMAIL:" . ($contact->email ?? ''),
        "TEL;TYPE=CELL:" . ($contact->phone ?? 'N/A'),
        "TEL;TYPE=WORK:" . ($contact->office_phone ?? 'N/A'),
        "ADR;TYPE=WORK:;;" . ($contact->address ?? 'N/A') . ";;;;",
    ];

    // จัดการรูปภาพ
    if ($contact->profile_image && Storage::disk('public')->exists($contact->profile_image)) {
        $imagePath = Storage::disk('public')->path($contact->profile_image);

        // ตรวจสอบไฟล์และ MIME type
        if (file_exists($imagePath) && is_readable($imagePath)) {
            $mimeType = mime_content_type($imagePath);

            if (strpos($mimeType, 'image/') === 0) {
                $imageContent = file_get_contents($imagePath);
                $base64Image = base64_encode($imageContent);
                $photoHeader = "PHOTO;ENCODING=b;TYPE=" . strtoupper(explode('/', $mimeType)[1]) . ":";
                $photoContent = wordwrap($base64Image, 75, "\r\n ", true); // ตัด Base64 ให้ถูกต้อง
                $vcf[] = $photoHeader . $photoContent;
            }
        }
    }

    // เพิ่มข้อมูลโซเชียล
    $socialLinks = [
        'line' => $contact->social['line'] ?? null,
        'facebook' => $contact->social['facebook'] ?? null,
        'youtube' => $contact->social['youtube'] ?? null,
        'instagram' => $contact->social['instagram'] ?? null,
        'twitter' => $contact->social['twitter'] ?? null,
        'linkedin' => $contact->social['linkedin'] ?? null,
    ];

    foreach ($socialLinks as $platform => $url) {
        if (!empty($url)) {
            $vcf[] = "X-SOCIALPROFILE;TYPE={$platform}:{$url}";
        }
    }

    $vcf[] = "END:VCARD";

    return implode("\r\n", $vcf);
}


// แสดงหน้ารายการเจ้าหน้าที่พร้อมค้นหา/กรอง
public function showContacts(Request $request)
{
    $query = Contact::query();

    // ฟิลเตอร์การค้นหาจากคีย์เวิร์ด (ชื่อ, อีเมล)
    if ($request->filled('keyword')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%')
              ->orWhere('email', 'like', '%' . $request->keyword . '%')
              ->orWhere('phone', 'like', '%' . $request->keyword . '%'); // หากต้องการค้นหาเบอร์โทร
        });
    }

    // ดึงข้อมูลพร้อม paginate และจัดเรียงตามชื่อ
    $contacts = $query->orderBy('name')->paginate(10);

    return view('contacts.index', compact('contacts'));
}


  // แสดงหน้าสร้างเจ้าหน้าที่
  public function create()
{
    return view('contacts.create');
}
public function newcreate()
{
    return view('create');
}

    // บันทึกข้อมูลเจ้าหน้าที่ใหม่
    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'title' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'email' => 'required|email|unique:contacts,email',
        'phone' => 'nullable|string|max:20',
        'office_phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'organization' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'social' => 'nullable|array',
        'social.*' => 'nullable|url',
    ]);

    // จัดการข้อมูลโปรไฟล์ภาพ
    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');
        $imagePath = $image->storeAs('profile_images', uniqid() . '.' . $image->extension(), 'public');
        $data['profile_image'] = $imagePath;
    }
    

    // บันทึกข้อมูลเจ้าหน้าที่
    Contact::create($data);

    return redirect()->route('contacts.index')->with('success', 'เพิ่มข้อมูลเจ้าหน้าที่สำเร็จ');
}


    // แสดงหน้าฟอร์มแก้ไขข้อมูล
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    // อัปเดตข้อมูลเจ้าหน้าที่
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'nullable|string|max:20',
            'office_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'organization' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'social' => 'nullable|array',
            'social.*' => 'nullable|url',
        ]);
    
        // ถ้ามีรูปใหม่ ลบรูปเก่าแล้วอัปโหลดใหม่
        if ($request->hasFile('profile_image')) {
            if ($contact->profile_image) {
                Storage::disk('public')->delete($contact->profile_image);
            }
    
            $image = $request->file('profile_image');
            $imagePath = $image->storeAs('profile_images', uniqid() . '.' . $image->extension(), 'public');
            $data['profile_image'] = $imagePath;
        }
    
        $contact->update($data);
    
        return redirect()->route('contacts.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }
    


    // ลบข้อมูลเจ้าหน้าที่
    public function destroy(Contact $contact)
{
    if (!empty($contact->profile_image) && Storage::disk('public')->exists($contact->profile_image)) {
        Storage::disk('public')->delete($contact->profile_image);
    }

    $contact->delete();

    return redirect()->route('contacts.index')->with('success', 'ลบข้อมูลสำเร็จ!');
}




public function showMyCard()
{
    $contact = Contact::findOrFail(auth()->user()->id);
    $qrCode = \QrCode::size(150)->encoding('UTF-8')->errorCorrection('L')->generate(route('contacts.show', ['id' => $contact->id]));

    return view('contacts.mycard', compact('contact', 'qrCode'));
}


public function showECard()
{
    $user = Auth::user(); // ดึงข้อมูล User ที่ล็อกอิน

    // ✅ ดึง Contact ของ User
    $contact = Contact::where('id', $user->id)->first();

    // ❌ ถ้าไม่พบ Contact ให้ redirect กลับและแจ้งเตือน
    if (!$contact) {
        return redirect()->route('home')->with('error', 'ไม่พบข้อมูลเจ้าหน้าที่');
    }

    // ✅ สร้างข้อมูลที่ต้องการส่งไปให้เครื่องสแกน (เช่น ชื่อ, เลขประจำตัว)
    $data = json_encode([
        'id' => $contact->id,
        'name' => $contact->name,
    ]);

    // ✅ สร้าง QR Code ที่เก็บข้อมูลนี้
    $qrCode = QrCode::size(200)->encoding('UTF-8')->errorCorrection('L')->generate($data);

    return view('contacts.e-card', compact('contact', 'qrCode'));
}

public function showContactPopup($id)
{
    // ดึงข้อมูลเจ้าหน้าที่ตาม ID
    $contact = Contact::findOrFail($id);
    
    // ส่งข้อมูลไปยัง View สำหรับ popup
    return response()->json($contact);
}


}
