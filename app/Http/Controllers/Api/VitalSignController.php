<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VitalSign;
use App\Models\Notification;
use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    public function index()
    {
        $vitals = auth()->user()->vitalSigns;
        return response()->json($vitals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:blood_pressure,blood_sugar,heart_rate,oxygen',
            'status' => 'required|in:normal,elevated,critical',
        ]);

        $vital = auth()->user()->vitalSigns()->create([
            'type' => $request->type,
            'value' => $request->value,
            'systolic' => $request->systolic,
            'diastolic' => $request->diastolic,
            'status' => $request->status,
            'measured_at' => now(),
        ]);

        if ($vital->status == 'critical') {
            auth()->user()->notifications()->create([
                'type' => 'critical',
                'title' => 'تنبيه خطر!',
                'message' => 'لقد تم تسجيل قراءة حرجة لـ ' . $vital->type . '، يرجى استشارة طبيب فوراً.',
                'action_required' => true
            ]);
        }

        return response()->json([
            'message' => 'تم حفظ القراءة بنجاح',
            'data' => $vital
        ], 201);
    }
}
