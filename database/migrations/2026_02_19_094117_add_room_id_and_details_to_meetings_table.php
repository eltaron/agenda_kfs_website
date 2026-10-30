<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->longText('agenda')->nullable(); // أجندة الاجتماع
            $table->json('attachments')->nullable(); // لتخزين مسارات الملفات
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            //
        });
    }
};
