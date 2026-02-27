<?php

namespace Database\Factories;

use App\Models\VitalSign;
use Illuminate\Database\Eloquent\Factories\Factory;

class VitalSignFactory extends Factory
{
    protected $model = VitalSign::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::first()->id, // كدة هيربطهم بأول مريض مسجل عندك
            'type' => $this->faker->randomElement(['blood_pressure', 'blood_sugar', 'heart_rate', 'oxygen']),
            'value' => $this->faker->randomFloat(2, 60, 150), // رقم عشري للسكر أو النبض
            'systolic' => $this->faker->numberBetween(110, 140), // العالي للضغط
            'diastolic' => $this->faker->numberBetween(70, 90),  // الواطي للضغط
            'status' => $this->faker->randomElement(['normal', 'elevated', 'critical']),
            'measured_at' => $this->faker->dateTimeBetween('-1 month', 'now'), // تواريخ عشوائية خلال الشهر اللي فات
        ];
    }
}
