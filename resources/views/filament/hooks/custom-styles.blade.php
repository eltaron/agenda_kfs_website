<style>
    /* تحميل خط Tajawal العربي */
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap');

    :root {
        --font-family: 'Tajawal', sans-serif;
    }

    * {
        font-family: 'Tajawal', sans-serif !important;
    }

    /* تحسين شكل الكروت في النظام */
    .fi-ta-content-grid {
        gap: 1.5rem !important;
    }

    .fi-ta-record {
        border-radius: 12px !important;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb !important;
    }

    .fi-ta-record:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(209, 161, 60, 0.1) !important;
        border-color: #d1a13c !important; /* اللون الذهبي الخاص بكفر الشيخ */
    }

    /* تنسيق زر تسجيل الدخول والأزرار الأساسية */
    .fi-btn-color-primary {
        background-color: #d1a13c !important;
    }

    /* ضبط اتجاه القائمة الجانبية للعربية */
    [dir="rtl"] .fi-sidebar-nav {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
</style>
