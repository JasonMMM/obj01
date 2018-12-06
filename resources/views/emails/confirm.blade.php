<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册确认链接</title>
</head>
<body>
    <h1>感谢您的注册</h1>

    <p>
        请点击下面的链接完成注册：
        <a href="{{ route('confirm_email', $user->activation_token) }}"></a>
        {{ route('confirm_email', $user->activation_token) }}
    </p>

    <p>
        如果不是您本人操作，请忽略此邮件~
    </p>
</body>
</html>