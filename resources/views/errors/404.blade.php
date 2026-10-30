<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>صفحة غير موجودة - AgendaPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #f8fafc;
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: #d1a13c;
            margin: 0;
            line-height: 1;
            text-shadow: 4px 4px 0px rgba(209, 161, 60, 0.2);
        }

        .error-title {
            font-size: 1.5rem;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .error-desc {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .btn-home {
            background: #1a3674;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: #d1a13c;
            box-shadow: 0 5px 15px rgba(209, 161, 60, 0.3);
        }

        .logo {
            height: 60px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        <h1 class="error-code">404</h1>
        <div class="error-title">عفواً، هذه الصفحة غير موجودة!</div>
        <p class="error-desc">ربما تم حذف الرابط أو أنك حاولت الوصول لصفحة غير صحيحة.</p>
        <a href="/admin" class="btn-home">العودة للرئيسية</a>
    </div>
</body>

</html>
