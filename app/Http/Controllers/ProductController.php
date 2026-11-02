<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('kategori')->get();

        return view('products.index', compact('products'));
    }

    public function masterBarang()
    {
        if (!session('login')) {
            return redirect('/login');
        }

        return view('barang.index');
    }
}