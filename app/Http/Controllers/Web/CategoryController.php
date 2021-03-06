<?php


namespace App\Http\Controllers\Web;

use App\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Show list of category
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(15);
        return response()->view('web.category.index', compact('categories'));
    }
}
