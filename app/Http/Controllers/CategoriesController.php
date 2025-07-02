<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesCollection;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // return response()->json(['categories' => Categories::all()]);
        return new CategoriesCollection(Categories::all());
    }
}
