<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>غير مصرح بالدخول - AgendaPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* نفس ستايل الصفحة السابقة مع تغيير لون الكود للأحمر */
        body {
            font-family: 'Tajawal', sans-serif;
            background: #fef2f2;
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
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.05);
            border-top: 5px solid #ef4444;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 900;
            color: #ef4444;
            margin: 0;
        }

        .error-title {
            font-size: 1.5rem;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            color: #991b1b;
        }

        .error-desc {
            color: #7f1d1d;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .btn-home {
            background: #ef4444;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div style="font-size: 4rem; margin-bottom: 10px;">🚫</div>
        <h1 class="error-code">403</h1>
        <div class="error-title">عفواً، ليس لديك صلاحية للدخول هنا</div>
        <p class="error-desc">يبدو أنك تحاول الوصول لمنطقة إدارية مخصصة للقيادات فقط.</p>
        <a href="/admin" class="btn-home">العودة للوحة التحكم</a>
    </div>
</body>

</html>
