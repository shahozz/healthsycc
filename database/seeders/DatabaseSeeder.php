<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VitalSign;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // هيعمل 50 قراءة عشوائية في جدول الـ vital_signs فوراً
        VitalSign::factory(50)->create();

        echo "تم ملء الداتابيز بـ 50 قراءة وهمية بنجاح! \n";
    }
}
