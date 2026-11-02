<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;                          // BARU: Ditambahkan untuk menggunakan model User
use Illuminate\Support\Facades\Hash;   // BARU: Ditambahkan untuk mengecek enkripsi password (bcrypt)

class AdminController extends Controller
{
    public function login()
    {
        return view('login');
    }

    /**
     * Method untuk memproses verifikasi login dari database
     */
    public function authenticate(Request $request)
    {
        // Menangkap data input dari form login
        $username = $request->username; 
        $password = $request->password;

        // 1. Cari data user di database berdasarkan email/username yang diinput
        $user = User::where('email', $username)->first();

        // 2. Jika data user ditemukan di database DAN password-nya cocok setelah dicocokkan hash-nya
        if ($user && Hash::check($password, $user->password)) {
            
            // 3. Set session login untuk menandai user sudah sah masuk
            session(['login' => true, 'username' => $user->email]);
            
            // 4. Arahkan user ke halaman dashboard admin
            return redirect('/dashboard');
        }

        // 5. Jika data tidak ditemukan/password salah, kembali ke form login dengan alert error
        return back()->with('error', 'Username atau password salah');
    }

    public function dashboard()
    {
        // Middleware manual jika CheckLogin.php tidak didaftarkan di route (sebagai double check)
        if (!session('login')) {
            return redirect('/login');
        }

        return view('dashboard.index');
    }

    public function logout()
    {
        // Menghapus session login
        session()->forget('login');
        
        // Arahkan kembali ke halaman login
        return redirect('/login');
    }
}
