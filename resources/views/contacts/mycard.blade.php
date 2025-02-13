@extends('layouts.appuser')

@section('content')

<style>
    /* พื้นหลังแบบ Gradient */


/* ตั้งค่ากล่องใหญ่ */
.container {
    text-align: center;
}

/* หัวข้อ */
h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #000;
    margin-bottom: 20px;
}

/* ตั้งค่าการ์ดให้จัดเรียงซ้ายขวา */
.card-container {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

/* ตั้งค่าการ์ด */
.card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    width: 250px;
    height: 250px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    text-decoration: none;
}

/* เอฟเฟกต์ Hover */
.card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

/* ไอคอนกลมๆ ด้านบน */
.card .icon {
    width: 60px;
    height: 60px;
    background: rgba(0, 0, 255, 0.1);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
}

.card .icon img {
    width: 30px;
}

/* ข้อความการ์ด */
.card h2 {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
}

.card p {
    font-size: 0.9rem;
    color: #666;
}

/* การ์ดสีฟ้า */
.card.blue {
    background: #007bff;
    color: white;
}

.card.blue .icon {
    background: rgba(255, 255, 255, 0.2);
}

.card.blue h2, .card.blue p {
    color: white;
}

    </style>

<body>

<div class="container">
    <h1>My Card</h1>
    <div class="card-container">
        <!-- Contact Details Card -->
        <a href="{{ route('contacts.show', ['id' => auth()->user()->id]) }}"  class="card">
            <div class="icon">
                
            </div>
            <h2>นามบัตรดิจิทัล</h2>
            <p>แสดงนามบัตรดิจิทัลของเจ้าหน้าที่</p>
        </a>

        <!-- E-Card -->
        <a href="{{ route('e-card') }}" class="card blue" target="_blank" rel="noopener noreferrer">
            <div class="icon">
                
            </div>
            <h2>Virtual Employee Card</h2>
            <p>แสดงบัตร Virtual Employee Card ของเจ้าหน้าที่</p>
        </a>
    </div>
</div>

@endsection