<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }
  
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        
        $user = User::where('email', $request->email)->first();

       
        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
        }

        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'access_token' => $token,
            'user' => $user
        ]);


        
    }

    public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|in:male,female,other',
        'chronic_conditions' => 'nullable|array', 
    ]);

    $user->update($request->only([
        'date_of_birth',
        'gender',
        'chronic_conditions',
        'name'
    ]));

    return response()->json([
        'message' => 'تم تحديث البيانات بنجاح',
        'user' => $user
    ]);
}



public function forgotPassword(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $code = (string)rand(100000, 999999);

    \DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => $code,
            'created_at' => now()
        ]
    );

    return response()->json([
        'message' => 'تم إرسال كود التحقق (تجريبي)',
        'code' => $code 
    ]);
}


public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required',
        'password' => 'required|min:8|confirmed', 
    ]);

    
    $resetData = \DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('token', $request->code) 
        ->first();

    
    if (!$resetData) {
        return response()->json(['message' => 'الكود غير صحيح أو انتهت صلاحيته'], 400);
    }

    
    if (\Carbon\Carbon::parse($resetData->created_at)->addMinutes(60)->isPast()) {
        return response()->json(['message' => 'انتهت صلاحية الكود'], 400);
    }

    $user = User::where('email', $request->email)->first();
    if ($user) {
        $user->update(['password' => \Hash::make($request->password)]);
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json(['message' => 'تم تغيير كلمة السر بنجاح']);
    }

    return response()->json(['message' => 'المستخدم غير موجود'], 404);
}





    

    

}
