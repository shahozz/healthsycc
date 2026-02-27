<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // تأكد من هذا السطر
use Illuminate\Database\Eloquent\Model;

class AIAnalysis extends Model
{
    use HasFactory; // تأكد أن الحروف كبيرة وصغيرة بهذا الشكل
    
    // أضف هذا السطر وحدد اسم الجدول كما هو في الـ Migration الخاص بك
    protected $table = 'ai_analyses';

    protected $fillable = [
        'user_id', 
        'risk_level', 
        'summary', 
        'recommendations', 
        'explanation', 
        'health_score'
    ];

    protected $casts = [
        'recommendations' => 'array',
    ];
}