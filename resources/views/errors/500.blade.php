<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>خطأ في النظام - AgendaPro</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #fff1f2;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
            padding: 50px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .icon-pulse {
            font-size: 4rem;
            color: #be123c;
            animation: pulse 2s infinite;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 900;
            color: #be123c;
            margin: 10px 0;
        }

        .error-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 800;
            color: #881337;
        }

        .error-desc {
            color: #4b5563;
            margin-bottom: 30px;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .btn-refresh {
            background: #be123c;
            color: white;
            padding: 12px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-family: 'Tajawal';
            font-size: 1rem;
        }

        .btn-refresh:hover {
            background: #9f1239;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="icon-pulse">⚠️</div>
        <h1 class="error-code">500</h1>
        <div class="error-title">حدث خطأ غير متوقع في الخادم</div>
        <p class="error-desc">
            نعتذر عن هذا العطل المؤقت. فريق التحول الرقمي يعمل حالياً على إصلاح المشكلة.<br>
            يرجى محاولة تحديث الصفحة أو العودة لاحقاً.
        </p>
        <button onclick="location.reload()" class="btn-refresh">تحديث الصفحة</button>
        <div style="margin-top: 20px; font-size: 0.9rem; color: #9ca3af;">Error Reference: Internal Server Error</div>
    </div>
</body>

</html>
