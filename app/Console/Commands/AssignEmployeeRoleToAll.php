<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignEmployeeRoleToAll extends Command
{
    // هذا هو الأمر الذي ستكتبه في CMD
    protected $signature = 'app:assign-employee-role';

    protected $description = 'Create employee role and assign it to all users';

    public function handle()
    {
        $this->info('جاري العمل...');

        // 1. إنشاء الدور إذا لم يكن موجوداً
        // سنسميه 'employee' كاسم برمجي، ويمكن عرضه كـ "موظف" لاحقاً
        $role = Role::firstOrCreate(['name' => 'employee']);

        // 2. جلب كل المستخدمين
        $users = User::where('id', "!=", 1)->get();

        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        foreach ($users as $user) {
            // إضافة الرول للمستخدم إذا لم تكن لديه
            if (! $user->hasRole('employee')) {
                $user->assignRole($role);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('تم إنشاء دور (employee) وتعيينه لجميع الموظفين بنجاح! ✅');
    }
}
