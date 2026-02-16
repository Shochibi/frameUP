<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    return view('profile', ['user' => $user]);
  }

  public function updateProfile(Request $request)
  {
    $user = Auth::user();

    try {
      $validatedData = $request->validate([
        'username' => 'required|min:3|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
      ]);

      $user->username = $validatedData['username'];
      $user->email = $validatedData['email'];
      $user->save();

      if ($request->expectsJson()) {
        return response()->json([
          'success' => true,
          'message' => 'Profil berhasil diperbarui!'
        ]);
      }

      return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    } catch (\Illuminate\Validation\ValidationException $e) {
      if ($request->expectsJson()) {
        return response()->json([
          'success' => false,
          'errors' => $e->errors()
        ], 422);
      }
      throw $e;
    }
  }

  public function verifyPassword(Request $request)
  {
    $user = Auth::user();

    $validatedData = $request->validate([
      'old_password' => 'required|string',
    ]);

    if (!Hash::check($validatedData['old_password'], $user->password)) {
      return response()->json([
        'success' => false,
        'message' => 'Password lama tidak sesuai!'
      ], 401);
    }

    return response()->json([
      'success' => true,
      'message' => 'Password terverifikasi!'
    ]);
  }

  public function updatePassword(Request $request)
  {
    $user = Auth::user();

    try {
      $validatedData = $request->validate([
        'password' => 'required|min:5|confirmed',
        'password_confirmation' => 'required'
      ]);

      $user->password = Hash::make($validatedData['password']);
      $user->save();

      if ($request->expectsJson()) {
        return response()->json([
          'success' => true,
          'message' => 'Password berhasil diperbarui!'
        ]);
      }

      return redirect()->route('profile')->with('success', 'Password berhasil diperbarui!');
    } catch (\Illuminate\Validation\ValidationException $e) {
      if ($request->expectsJson()) {
        return response()->json([
          'success' => false,
          'errors' => $e->errors()
        ], 422);
      }
      throw $e;
    }
  }
}
