<x-filament-panels::page>
    {{-- التقويم سيظهر تلقائياً هنا لأنه مسجل في getHeaderWidgets --}}

    <style>
        /* كود إضافي لجعل التقويم يملأ الصفحة بشكل جميل */
        .fi-wi-widget {
            padding: 0 !important;
        }

        .fc {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .dark .fc {
            background: #0f172a;
            /* لون داكن يتناسب مع الثيم */
        }
    </style>
</x-filament-panels::page>
