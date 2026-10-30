<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            // ربط المرفق بالاجتماع
            $table->foreignId('meeting_id')->constrained()->onDelete('cascade');

            // مسار الملف في السيرفر
            $table->string('file_path');

            // اسم الملف الأصلي (للعرض للمستخدم)
            $table->string('file_name');

            // نوع الملف (pdf, docx, png...)
            $table->string('file_type')->nullable();

            // حجم الملف بالبايت
            $table->bigInteger('file_size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
