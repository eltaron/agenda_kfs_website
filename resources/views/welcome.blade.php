<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- === عنوان الصفحة === -->
    <title>AgendaPro | محافظة كفر الشيخ</title>

    <!-- === إعدادات الـ SEO الأساسية === -->
    <meta name="description"
        content="البوابة الرسمية لإدارة الاجتماعات والفاعليات بمحافظة كفر الشيخ. نظام إلكتروني موحد يربط الديوان العام بمجالس المدن والمديريات لتنظيم الجداول الزمنية والقاعات إلكترونياً.">
    <meta name="keywords"
        content="كفر الشيخ, محافظة كفر الشيخ, إدارة الاجتماعات, التحول الرقمي, البوابة الإلكترونية, حكومة إلكترونية, تنظيم المواعيد, مصر">
    <meta name="author" content="إدارة التحول الرقمي - محافظة كفر الشيخ">
    <meta name="robots" content="index, follow">

    <!-- === إعدادات التواصل الاجتماعي (Facebook, WhatsApp, LinkedIn) === -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="منظومة إدارة الاجتماعات | محافظة كفر الشيخ">
    <meta property="og:description"
        content="المنصة الموحدة لإدارة الاجتماعات والجداول الزمنية للقيادات والموظفين بمحافظة كفر الشيخ.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="بوابة محافظة كفر الشيخ الرقمية">
    <!-- الصورة التي تظهر عند مشاركة الرابط على واتساب أو فيسبوك -->
    <meta property="og:image" content="{{ asset('logo.png') }}">

    <!-- === إعدادات الـ Twitter Cards === -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="منظومة إدارة الاجتماعات | محافظة كفر الشيخ">
    <meta name="twitter:description" content="النظام الإلكتروني الرسمي لتنسيق الاجتماعات وإدارة القاعات.">
    <meta name="twitter:image" content="{{ asset('logo.png') }}">

    <!-- === إعدادات الـ Favicon (أيقونة المتصفح والموبايل) === -->
    <!-- الأيقونة الأساسية للمتصفحات -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">

    <!-- أيقونة عند حفظ الموقع على شاشة الآيفون/الآيباد -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">

    <!-- ثيم المتصفح (شريط العنوان في كروم للموبايل سيكون ذهبي) -->
    <meta name="theme-color" content="#d1a13c">

    <!-- === المكتبات والخطوط (CSS) === -->
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700;900&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-gold: #d1a13c;
            /* لون ذهبي مستوحى من القارب */
            --dark-gold: #b0842b;
            --waves-blue: #00bcd4;
            /* لون الأمواج */
            --text-dark: #2c3e50;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* --- Navbar --- */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .navbar-brand img {
            height: 60px;
            margin-left: 10px;
        }

        .navbar-brand span {
            font-weight: 800;
            color: var(--text-dark);
            font-size: 1.2rem;
        }

        /* --- Hero Section --- */
        .hero {
            position: relative;
            background: linear-gradient(135deg, #fff 0%, #fffbf2 100%);
            padding: 100px 0;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 300px;
            height: 300px;
            background: rgba(209, 161, 60, 0.05);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-content h1 {
            color: var(--text-dark);
            font-weight: 900;
            font-size: 3rem;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .hero-content h1 span {
            color: var(--primary-gold);
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .hero-logo-container {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-logo {
            max-width: 350px;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.15));
            animation: float 4s ease-in-out infinite;
        }

        /* --- Buttons --- */
        .btn-custom {
            background-color: var(--primary-gold);
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
            border: 2px solid var(--primary-gold);
            font-size: 1.1rem;
        }

        .btn-custom:hover {
            background-color: transparent;
            color: var(--primary-gold);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(209, 161, 60, 0.3);
        }

        /* --- Features Cards --- */
        .features {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-weight: 800;
            font-size: 2.5rem;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 80px;
            height: 4px;
            background: var(--primary-gold);
            border-radius: 2px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s;
            border-bottom: 4px solid transparent;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border-bottom: 4px solid var(--primary-gold);
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(209, 161, 60, 0.1);
            color: var(--primary-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px auto;
            transition: 0.3s;
        }

        .feature-card:hover .icon-box {
            background: var(--primary-gold);
            color: white;
        }

        .feature-card h4 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #777;
            font-size: 0.95rem;
        }

        /* --- Stats Section --- */
        .stats {
            background-color: var(--text-dark);
            color: white;
            padding: 60px 0;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIiBzdHlsZT0iYmFja2dyb3VuZDp0cmFuc3BhcmVudDsiPjxwYXRoIGQ9Ik0wIDBoNDB2NDBIMHoiIGZpbGw9IiMzNDQ5NWUiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==');
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary-gold);
            margin-bottom: 5px;
        }

        /* --- Footer --- */
        footer {
            background: #212529;
            color: #aaa;
            padding: 30px 0;
            text-align: center;
            border-top: 5px solid var(--primary-gold);
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* أمواج المحافظة أسفل الهيدر */
        .waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .waves svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }

        .waves .shape-fill {
            fill: #f8f9fa;
            /* يطابق لون السكشن التالي */
        }
    </style>
</head>

<body>


    <!-- Hero Section -->
    <section class="hero d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content text-center text-lg-start mb-5 mb-lg-0" data-aos="fade-left">
                    <!-- بادج الإصدار -->
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">AgendaPro v1.0</span>

                    <!-- العنوان الرئيسي -->
                    <h1 style="font-weight: 800; line-height: 1.6;">
                        مستقبل الإدارة الحكومية <br>
                        <span style="color: var(--primary-gold); font-family: 'Arial', sans-serif;">AgendaPro</span>
                    </h1>

                    <!-- الوصف -->
                    <p class="fs-5 text-muted mb-4">
                        المنصة الذكية الأولى من نوعها بمحافظة كفر الشيخ، صُممت لتمنح القيادات سيطرة كاملة على الجداول
                        الزمنية، تنسيق القاعات، وأرشفة المحاضر، مما يضمن كفاءة إدارية وسرعة في اتخاذ القرار.
                    </p>

                    <!-- الأزرار -->
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                        <a href="/admin" class="btn btn-custom btn-lg shadow">
                            <i class="fa-solid fa-gauge-high ms-2"></i> لوحة القيادة
                        </a>
                        <!-- زر إضافي اختياري -->
                        <!-- <a href="#features" class="btn btn-outline-dark btn-lg rounded-pill px-4">المميزات</a> -->
                    </div>
                </div>

                <div class="col-lg-6 hero-logo-container" data-aos="fade-right">
                    <img src="{{ asset('logo.png') }}" alt="AgendaPro Logo" class="hero-logo"
                        style="max-height: 400px;">
                </div>
            </div>
        </div>

        <!-- تأثير الموجة في الأسفل (من شعار المحافظة) -->
        <div class="waves">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M985.66,92.83C906.67,72,823.78,31,432.84,37.8c-274.05,4.76-274.83,57.74-432.85,33.56V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>مميزات المنظومة</h2>
            </div>

            <div class="row g-4">
                <!-- ميزة 1 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <h4>إدارة القيادات الهرمية</h4>
                        <p>نظام صلاحيات ذكي يتيح للقيادات رؤية شاملة للمواعيد، بينما تقتصر رؤية الموظفين على إداراتهم.
                        </p>
                    </div>
                </div>

                <!-- ميزة 2 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <h4>تنبيهات واتساب الذكية</h4>
                        <p>اربط المنظومة بحسابك الشخصي لاستقبال إشعارات بالمواعيد وتذكيرات قبل بدء الاجتماع.</p>
                    </div>
                </div>

                <!-- ميزة 3 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <h4>جدول وقاعات تفاعلي</h4>
                        <p>تقويم ديناميكي (Calendar) لعرض المواعيد، مع نظام ذكي لمنع تعارض حجز القاعات.</p>
                    </div>
                </div>

                <!-- ميزة 4 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <h4>الأرشفة والمرفقات</h4>
                        <p>أرفق ملفات الاجتماع وجداول الأعمال واطلع عليها إلكترونياً لتقليل التعامل الورقي.</p>
                    </div>
                </div>

                <!-- ميزة 5 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h4>تقارير وإحصائيات</h4>
                        <p>لوحة مؤشرات (Dashboard) تعرض إحصائيات دقيقة عن نشاط الإدارات والمديريات.</p>
                    </div>
                </div>

                <!-- ميزة 6 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fa-solid fa-city"></i>
                        </div>
                        <h4>تغطية المحافظة بالكامل</h4>
                        <p>ربط الديوان العام بمجالس المدن، الأحياء، والمديريات الخدمية في شبكة موحدة.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats" data-aos="zoom-in">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0 stat-item">
                    <div class="stat-number"><i class="fa-solid fa-people-group"></i></div>
                    <h4>كافة الإدارات</h4>
                    <p>قيادات، مديريات، ومدن</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0 stat-item">
                    <div class="stat-number"><i class="fa-solid fa-check-double"></i></div>
                    <h4>أرشفة فورية</h4>
                    <p>لكل المحاضر والنتائج</p>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number"><i class="fa-solid fa-shield-halved"></i></div>
                    <h4>خصوصية وأمان</h4>
                    <p>نظام تشفير وحماية بيانات</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <img src="{{ asset('logo.png') }}" alt="شعار صغير"
                        style="height: 50px; opacity: 0.5; margin-bottom: 15px;">
                    <p class="mb-0">جميع الحقوق محفوظة &copy; {{ date('Y') }} - البوابة الإلكترونية لمحافظة كفر
                        الشيخ</p>
                    <small>الإدارة العامة لنظم ومعلومات التحول الرقمي </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
</body>

</html>
