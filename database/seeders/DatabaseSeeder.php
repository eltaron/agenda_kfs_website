<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $categories = [
            ['name' => 'فئة القيادات', 'slug' => 'leaders'],
            ['name' => 'فئة رؤساء المدن', 'slug' => 'city-heads'],
            ['name' => 'فئة وكلاء الوزارة والديوان', 'slug' => 'undersecretaries'],
            ['name' => 'فئة مديري الإدارات', 'slug' => 'department-managers'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
