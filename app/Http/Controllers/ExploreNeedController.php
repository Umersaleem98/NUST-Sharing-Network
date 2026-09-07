<?php

namespace App\Http\Controllers;

use App\Models\Category;

class ExploreNeedController extends Controller
{
    public function index()
    {
        

        $categories = Category::query()
            ->orderBy('name', 'asc')
            ->get();

        $totalCategories = $categories->count();

        return view(
            'pages.home.exploreNeed.index',
            compact(
                'categories',
                'totalCategories'
            )
        );
    }
}