<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        if (!session('login')) {
            return redirect('/login');
        }

        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }
}