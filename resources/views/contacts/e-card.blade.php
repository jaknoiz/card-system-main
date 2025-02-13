<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บัตรประจำตัวเจ้าหน้าที่</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background:  #ffffff;
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
        background: linear-gradient(145deg, #007bff, #004f9e);
        color: #fff;
        text-align: center;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        border: 3px solid #fff;
    }

        .card-back {
            background: #fff;
            transform: rotateY(180deg);
            flex-direction: column;
        }

        .logo img {
        width: 80px;
        margin-bottom: 10px;
    }

    .profile {
        margin: 20px auto;
        width: 150px;
        height: 200px;
        border-radius: 12px;
        overflow: hidden;
        border: 4px solid #fff;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

        .profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .info {
        background: rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

        .info p {
        margin: 4px 0;
        font-size: 16px;
        line-height: 1.4;
    }
    .info p strong {
        color: #ffcc00;
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
        .title {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
    }

    .subtitle {
        font-size: 14px;
        color: #e0e0e0;
        letter-spacing: 1px;
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
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
                    <p><strong>เลขประจำเจ้าหน้าที่:</strong> {{ $contact->id }}</p>
                    <p><strong>ชื่อ-นามสกุล:</strong> {{ $contact->name }}</p>
                    <p><strong>องค์กร:</strong> {{ $contact->organization }}</p>
                </div>
            </div>

            <div class="card-face card-back">
            <div class="qr-code">
                {!! $qrCode !!}
            </div>
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
