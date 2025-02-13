@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">รายชื่อเจ้าหน้าที่</h2>
        <a href="{{ route('create') }}" class="btn btn-success"> + เพิ่มเจ้าหน้าที่ใหม่</a>
    </div>

    <!-- ฟอร์มค้นหา -->
    <form action="{{ route('contacts.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="keyword" 
                class="form-control" 
                placeholder="ค้นหาชื่อ, อีเมล หรือเบอร์โทร..." 
                value="{{ request('keyword') }}">
            <button class="btn btn-primary" type="submit">ค้นหา</button>
        </div>
    </form>


    <!-- ตารางแสดงข้อมูล -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>รหัสประจำตัว</th>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>เบอร์โทร</th>
                    <th class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td class="text-center">
                            <!-- ปุ่มดูข้อมูลเจ้าหน้าที่ -->
                            <button class="btn btn-info btn-sm view-contact" data-id="{{ $contact->id }}">
                                <i class="fas fa-eye"></i> ดูข้อมูลเจ้าหน้าที่
                            </button>
                            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> แก้ไข
                            </a>
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('ยืนยันการลบ?')">
                                    <i class="fas fa-trash"></i> ลบ
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">ไม่พบข้อมูล</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- แสดง Pagination -->
    <div class="mt-4">
        {{ $contacts->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Bootstrap Modal (Popup) -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">ข้อมูลเจ้าหน้าที่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>ไอดี:</strong> <span id="contact_id"></span></p>
                <p><strong>ชื่อ:</strong> <span id="contact_name"></span></p>
                <p><strong>ตำแหน่ง:</strong> <span id="contact_position"></span></p>
                <p><strong>อีเมล:</strong> <span id="contact_email"></span></p>
                <p><strong>เบอร์โทร:</strong> <span id="contact_phone"></span></p>
                <p><strong>เบอร์สำนักงาน:</strong> <span id="contact_office_phone"></span></p>
                <p><strong>ที่อยู่:</strong> <span id="contact_address"></span></p>
                <p><strong>องค์กร:</strong> <span id="contact_organization"></span></p>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".view-contact").click(function() {
            let contactId = $(this).data("id");
            console.log("กดดูข้อมูลเจ้าหน้าที่ ID:", contactId); // Debug

            $.ajax({
                url: "/contacts/" + contactId + "/popup", // ใช้ route ที่เราได้สร้างไว้
                type: "GET",
                success: function(data) {
                    console.log("ข้อมูลที่ได้จาก Server:", data); // Debug

                    // แสดงข้อมูลใน modal (popup)
                    $("#contact_id").text(data.id);
                    $("#contact_name").text(data.name);
                    $("#contact_position").text(data.position);
                    $("#contact_email").text(data.email);
                    $("#contact_phone").text(data.phone);
                    $("#contact_office_phone").text(data.office_phone);
                    $("#contact_address").text(data.address);
                    $("#contact_organization").text(data.organization);

                    // เปิด modal
                    $("#contactModal").modal("show");
                },
                error: function() {
                    console.error("เกิดข้อผิดพลาดในการโหลดข้อมูล");
                    alert("ไม่สามารถโหลดข้อมูลเจ้าหน้าที่ได้");
                }
            });
        });
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Success Notification
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        @endif

        // Error Notification
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        @endif

        // Warning Notification
        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน!',
                text: '{{ session('warning') }}',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            });
        @endif
    });
</script>

@endsection
