<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user,
            'latest_vitals' => $user->vitalSigns()->latest()->take(5)->get(),
            'latest_analysis' => $user->aiAnalyses()->latest()->first(),
            'notifications_count' => $user->notifications()->where('read', false)->count(),
        ]);
    }
}