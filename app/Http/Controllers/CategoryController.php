<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        if (!session('login')) {
            return redirect('/login');
        }
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
}