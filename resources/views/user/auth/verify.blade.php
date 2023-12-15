<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Minh Tài Khoản</title>
</head>

<body>
    <h1>Xác Minh Tài Khoản</h1>


    <p>Vui lòng nhập mã xác minh bạn đã nhận được trong email để hoàn tất đăng ký tài khoản.</p>

    <form method="POST" action="{{ route('verify') }}">
        @csrf
        <label for="verification_code">Mã Xác Minh:</label>
        <input type="text" id="verification_code" name="verification_code" class="form-control"
            value="{{ old('verification_code') }}" required autocomplete="verification_code" autofocus>
        <!-- Display the error if it exists -->

        @if ($errors->has('verification_code'))
            <p>{{ $errors->first('verification_code') }}</p>
        @endif

        <button type="submit">Xác Minh</button>
    </form>
    <a href="{{ route('createVerificationCode') }}" class="btn btn-primary">Gửi mã xác minh</a>

</body>

</html>
