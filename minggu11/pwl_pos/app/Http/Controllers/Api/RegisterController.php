<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $profilePicName = null;

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
        
            // Bikin nama file yang aman
            $profilePicName = $file->hashName();
        
            // Copy file ke public/uploads/profile, bukan move
            File::copy(
                $file->getRealPath(), // ambil path file asli (tmp)
                public_path('uploads/profile/' . $profilePicName) // tujuan copy
            );
        }
        
        

        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password,
            'level_id' => $request->level_id,
            'profile_pic' => $profilePicName,
        ]);

        if ($user) {
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create user',
        ], 409);
    }
}
