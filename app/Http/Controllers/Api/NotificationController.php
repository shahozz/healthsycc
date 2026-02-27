<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // عرض تنبيهات المريض
    public function index()
    {
        return response()->json(auth()->user()->notifications()->latest()->get());
    }

    // تعليم التنبيه كـ "مقروء"
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->update(['read' => true]);

        return response()->json(['message' => 'تم قراءة التنبيه']);
    }
}