<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * إنشاء حساب لوحة Octagon (قراءة فقط).
 *
 * التشغيل: php artisan db:seed --class=OctagonUserSeeder
 * يمكن تغيير البيانات من ملف .env:
 *   OCTAGON_EMAIL, OCTAGON_PASSWORD
 */
class OctagonUserSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $role = Role::firstOrCreate(['name' => 'octagon', 'guard_name' => 'web']);

        $email = env('OCTAGON_EMAIL', 'octagon@kfs.gov.eg');
        $password = env('OCTAGON_PASSWORD', 'Octagon@2026');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Octagon',
                'password' => $password,
            ],
        );

        $user->assignRole($role);

        $this->command?->info("Octagon account ready: {$email}" . ($user->wasRecentlyCreated ? " / {$password}" : ' (already existed, password unchanged)'));
    }
}
