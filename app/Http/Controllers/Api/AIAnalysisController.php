<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AIAnalysis;
use Illuminate\Http\Request;

class AIAnalysisController extends Controller
{
    public function analyze()
    {
        $user = auth()->user();
        // 1. نجيب آخر قراءة للمريض
        $latestVital = $user->vitalSigns()->latest()->first();

        if (!$latestVital) {
            return response()->json(['message' => 'لا توجد قراءات كافية للتحليل'], 404);
        }

        // 2. منطق التحليل (Logic) - تخيل إن ده الـ AI
        $riskLevel = 'low';
        $recommendations = ["حافظ على شرب الماء", "التزم بنظام غذائي صحي"];
        $score = 90;

        if ($latestVital->status == 'critical') {
            $riskLevel = 'high';
            $recommendations = ["توجه لأقرب مستشفى فوراً", "اتصل بطبيبك الخاص", "تجنب أي مجهود بدني"];
            $score = 40;
        } elseif ($latestVital->status == 'elevated') {
            $riskLevel = 'medium';
            $recommendations = ["راقب ضغطك كل ساعتين", "قلل من الأملاح في طعامك"];
            $score = 70;
        }

        // 3. حفظ التحليل في الداتابيز عشان يظهر في الـ History
        $analysis = AIAnalysis::create([
    'user_id' => $user->id,
    'risk_level' => $riskLevel,
    'summary' => "بناءً على آخر قراءة ({$latestVital->type}), حالتك {$riskLevel}.",
    'recommendations' => json_encode($recommendations), // تحويلها لنص JSON
    'explanation' => "الـ AI لاحظ إن القراءة غير مستقرة...",
    'health_score' => $score,
]);
        

        return response()->json($analysis);
    }
}
