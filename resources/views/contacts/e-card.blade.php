<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บัตรประจำตัวนักศึกษา</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            height: 100vh;
            flex-direction: column;
        }

        .card-container {
            perspective: 1200px;
            width: 380px;
            height: 620px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card.is-flipped {
            transform: rotateY(180deg);
        }

        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-front {
            background: linear-gradient(180deg, #007bff, #0056b3);
            color: #fff;
            text-align: center;
            padding: 20px;
            flex-direction: column;
        }

        .card-back {
            background: #fff;
            transform: rotateY(180deg);
            flex-direction: column;
        }

        .logo img {
            width: 90px;
        }

        .profile {
            margin: 20px auto;
            width: 130px;
            height: 160px;
            border-radius: 8px;
            background: #fff;
            overflow: hidden;
            border: 3px solid #ddd;
        }

        .profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info p {
            margin: 6px 0;
            font-size: 18px;
        }

        .qr-code img {
            width: 220px;
            height: 220px;
            border: 2px solid #ddd;
            border-radius: 10px;
        }

        .actions {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 40px;
        }

        .icon {
            width: 65px;
            height: 65px;
            background: #ffcc00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s;
        }

        .icon:hover {
            transform: scale(1.1);
        }

        .icon img {
            width: 32px;
            height: 32px;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card" id="card">
            <div class="card-face card-front">
                <div class="logo">
                    <img src="{{ asset('image/TSU-LOGO-white.png') }}" alt="Thaksin Logo">
                </div>
                <p class="title">บัตรประจำตัวเจ้าหน้าที่</p>
                <p class="subtitle">EMPLOYEE IDENTITY CARD</p>
                <div class="profile">
                    <img src="{{ asset('storage/' . $contact->profile_image) }}" alt="Profile Image">
                </div>
                <div class="info">
                    <p><strong>เลขประจำตัวนักศึกษา:</strong> {{ $contact->id }}</p>
                    <p><strong>ชื่อ-นามสกุล:</strong> {{ $contact->name }}</p>
                    <p><strong>คณะ:</strong> {{ $contact->organization }}</p>
                </div>
            </div>

            <div class="card-face card-back">
                <div class="qr-code">
                    <img src="{{ asset('image/qr.png') }}" alt="QR Code">
                </div>
                <p>สแกน QR Code เพื่อดูข้อมูลเพิ่มเติม</p>
            </div>
        </div>
    </div>

    <div class="actions">
        <div class="icon" id="show-front">
            <img src="{{ asset('image/id-card.png') }}" alt="ID Icon">
        </div>
        <div class="icon" id="show-back">
            <img src="{{ asset('image/qr.png') }}" alt="QR Code Icon">
        </div>
    </div>

    <script>
        const card = document.getElementById('card');
        const showFront = document.getElementById('show-front');
        const showBack = document.getElementById('show-back');

        showFront.addEventListener('click', () => {
            card.classList.remove('is-flipped');
        });

        showBack.addEventListener('click', () => {
            card.classList.add('is-flipped');
        });
    </script>
</body>
</html>
