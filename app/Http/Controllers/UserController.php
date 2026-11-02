<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        if (!session('login')) {
            return redirect('/login');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (!session('login')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => 'Pengguna berhasil ditambahkan', 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        if (!session('login')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['success' => 'Pengguna berhasil diubah', 'user' => $user]);
    }

    public function destroy($id)
    {
        if (!session('login')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        // Prevent admin from deleting their own currently logged-in account
        if ($user->email === session('username')) {
            return response()->json(['error' => 'Anda tidak dapat menghapus akun Anda yang sedang digunakan untuk login.'], 400);
        }

        $user->delete();

        return response()->json(['success' => 'Pengguna berhasil dihapus']);
    }
}
