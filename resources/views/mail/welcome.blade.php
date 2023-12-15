<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Chào mừng bạn đến với trang web của chúng tôi</title>
    <style>
        /* Thêm CSS tại đây */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đăng Ký Thành Công</h1>
        <p>Xin chào {{ $user->full_name }},</p>
        <p>Chúng tôi rất vui mừng bạn đã đăng ký tài khoản tại trang web của chúng tôi.</p>
        <p>Cảm ơn bạn đã tham gia cùng chúng tôi.</p>
    </div>
</body>

</html>
