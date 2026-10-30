<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تتطلب تسجيل دخول - AgendaPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #eff6ff;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .error-container {
            max-width: 500px;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.1);
            border-top: 5px solid #3b82f6;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 900;
            color: #3b82f6;
            margin: 0;
        }

        .error-title {
            font-size: 1.5rem;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .error-desc {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .btn-login {
            background: #3b82f6;
            color: white;
            padding: 12px 40px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);
        }

        .btn-login:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div style="font-size: 4rem; margin-bottom: 10px;">🔒</div>
        <h1 class="error-code">401</h1>
        <div class="error-title">انتهت الجلسة أو لم تسجل الدخول</div>
        <p class="error-desc">يرجى تسجيل الدخول مرة أخرى للمتابعة إلى النظام.</p>
        <a href="/admin/login" class="btn-login">تسجيل الدخول</a>
    </div>
</body>

</html>
