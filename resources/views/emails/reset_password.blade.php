<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รหัสยืนยันการรีเซ็ตรหัสผ่าน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>รหัสยืนยันการรีเซ็ตรหัสผ่าน</h1>
        <p>รหัสยืนยันของคุณคือ:</p>
        <p class="code">{{ $code }}</p>
        <p>รหัสนี้จะหมดอายุในไม่ช้า หากคุณไม่พบหน้าจอยืนยันตัวตน กรุณาลองใหม่อีกครั้ง</p>
        <p>หากคุณไม่ได้พยายามรีเซ็ตรหัสผ่านบัญชีนี้ โปรดติดต่อเราได้ที่ <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
    </div>
</body>
</html>
