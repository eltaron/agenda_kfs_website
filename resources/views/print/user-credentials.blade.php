<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>طباعة بيانات الدخول - {{ $user->name }}</title>
    <!-- خط تجوال الرسمي -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        /* إعدادات الطباعة الأساسية */
        @page {
            size: A4;
            /* إجبار حجم الورقة A4 */
            margin: 0;
            /* إزالة هوامش المتصفح تماماً */
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
                padding: 0;
                background: white;
                -webkit-print-color-adjust: exact;
            }

            @page {
                margin: 0;
            }
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #1e293b;
        }

        /* الإطار الخارجي والداخلي */
        .paper {
            width: 210mm;
            /* A4 width */
            min-height: 280mm;
            /* A4 height */
            background: white;
            padding: 10mm;
            box-sizing: border-box;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .border-frame {
            border: 4px solid #1a3674;
            /* الإطار الأزرق */
            height: 100%;
            padding: 4px;
            position: relative;
        }

        .inner-border {
            border: 2px solid #dba634;
            /* الإطار الذهبي الداخلي */
            height: 100%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* الهيدر */
        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 90px;
        }

        .header-text {
            text-align: left;
            color: #1a3674;
        }

        .header-text h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }

        .header-text h2 {
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: 500;
            color: #555;
        }

        /* الشريط الأزرق العنوان */
        .blue-banner {
            background: #1a3674;
            color: white;
            width: 100%;
            padding: 12px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            border-radius: 4px;
            margin-bottom: 30px;
        }

        /* صفوف المعلومات */
        .info-row {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 0 20px;
        }

        .info-label {
            color: #1a3674;
            font-weight: 800;
            font-size: 16px;
        }

        .info-value {
            font-weight: 500;
            font-size: 16px;
            color: #333;
        }

        /* الصناديق المنقطة */
        .dashed-box-container {
            width: 80%;
            text-align: center;
            margin-bottom: 25px;
        }

        .box-label {
            color: #556;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        .dashed-box {
            border: 2px dashed #1a3674;
            padding: 15px;
            border-radius: 10px;
            background: #f8fafc;
        }

        .dashed-box span {
            font-family: 'Courier New', Courier, monospace;
            /* خط شبيه بالآلة الكاتبة للوضوح */
            font-size: 22px;
            font-weight: 700;
            color: #1a3674;
            letter-spacing: 2px;
        }

        /* الفوتر والإقرار */
        .footer-section {
            margin-top: auto;
            /* يدفع الفوتر للأسفل */
            width: 100%;
            text-align: right;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .warning-label {
            color: #e11d48;
            font-weight: 800;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .warning-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 13px;
            color: #64748b;
            line-height: 1.8;
        }

        .warning-list li:before {
            content: "•";
            color: #1a3674;
            margin-left: 5px;
        }

        .signature {
            text-align: center;
            margin-top: 40px;
            color: #1a3674;
            font-weight: 800;
            font-size: 16px;
        }

        /* زر الطباعة */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dba634;
            color: #000;
            border: none;
            padding: 10px 20px;
            font-family: 'Tajawal';
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .print-btn:hover {
            background: #c59226;
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="print-btn no-print">
        <i class="fa fa-print"></i> بدء الطباعة
    </button>

    <div class="paper">
        <div class="border-frame">
            <div class="inner-border">

                <!-- الهيدر -->
                <div class="header">
                    <div class="header-text " style="text-align: right">
                        <h1>محافظة كفر الشيخ</h1>
                        <h2>المنظومة الإلكترونية الموحدة - إدارة التحول الرقمي</h2>
                    </div>
                    <img src="{{ asset('logo.png') }}" alt="Logo">
                </div>

                <!-- الشريط الأزرق -->
                <div class="blue-banner">
                    بيانات تسجيل الدخول الرسمية للمنظومة
                </div>

                <!-- بيانات الموظف -->
                <div class="info-row">
                    <div>
                        <span class="info-label">الأسم :</span>
                        <span class="info-value" style="margin-right: 10px;">{{ $user->name }}</span>
                    </div>
                    <div>
                        <span class="info-label">الإدارة المختصة:</span>
                        <span class="info-value" style="margin-right: 10px;">
                            {{ $user->category ? $user->category->name : 'غير محدد' }}
                        </span>
                    </div>
                </div>

                <!-- بيانات الدخول (الصناديق) -->

                <!-- 1. البريد الإلكتروني -->
                <div class="dashed-box-container">
                    <span class="box-label">اسم المستخدم للدخول (Email)</span>
                    <div class="dashed-box">
                        <span>{{ $user->email }}</span>
                    </div>
                </div>

                <!-- 2. رابط النظام -->
                <div class="dashed-box-container">
                    <span class="box-label">رابط الدخول (URL)</span>
                    <div class="dashed-box">
                        <!-- يمكنك تغيير الرابط هنا للرابط الحقيقي للسيرفر -->
                        <span>{{ request()->root() }}</span>
                    </div>
                </div>

                <!-- 3. كلمة المرور -->
                <div class="dashed-box-container">
                    <span class="box-label">كلمة المرور الافتراضية (Default Password)</span>
                    <div class="dashed-box">
                        <span style="color: #e11d48; letter-spacing: 3px;">Kfs@2026</span>
                    </div>
                    <small style="font-size: 11px; color: #888; margin-top: 5px; display: block;">
                        * كلمة المرور مشفرة ولا تظهر، هذه هي كلمة المرور الموحدة لأول مرة
                    </small>
                </div>

                <!-- الفوتر والتعليمات -->
                <div class="footer-section">
                    <div class="warning-label">إقرار مسؤولية هامة:</div>
                    <ul class="warning-list">
                        <li>تستخدم هذه البيانات فقط بواسطة الموظف المذكور أعلاه وهي عهدة شخصية.</li>
                        <li>يجب تغيير كلمة المرور فور استلام الحساب لضمان أمان البيانات.</li>
                        <li>في حال فقدان البيانات أو نسيانها، يرجى مراجعة إدارة التحول الرقمي بالديوان.</li>
                    </ul>

                    <div class="signature">
                        إدارة التحول الرقمي - محافظة كفر الشيخ
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
