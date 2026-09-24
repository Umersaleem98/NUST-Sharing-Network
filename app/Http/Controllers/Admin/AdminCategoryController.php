<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Categories List
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim(
            (string) $request->search
        );

        $status =
            $request->status;


        $categories = Category::with('creator')
            ->withCount('products')

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                }
            )

            ->when(
                in_array(
                    $status,
                    [
                        'active',
                        'inactive',
                    ],
                    true
                ),
                function ($query) use ($status) {

                    $query->where(
                        'status',
                        $status
                    );
                }
            )

            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view(
            'pages.admins.categories.index',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'pages.admins.categories.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',

                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);


        Category::create([
            'user_id' =>
                Auth::id(),

            'name' =>
                trim(
                    $request->name
                ),

            'description' =>
                $request->description,

            'status' =>
                $request->status,
        ]);


        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Page
    |--------------------------------------------------------------------------
    */

    public function edit(Category $category)
    {
        return view(
            'pages.admins.categories.edit',
            compact('category')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Category $category
    ) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'categories',
                    'name'
                )->ignore(
                    $category->id
                ),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',

                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);


        $category->name =
            trim(
                $request->name
            );

        $category->description =
            $request->description;

        $category->status =
            $request->status;

        $category->save();


        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent Deleting Used Category
        |--------------------------------------------------------------------------
        */

        if ($category->products()->exists()) {

            return back()->with(
                'error',
                'This category cannot be deleted because products are using it.'
            );
        }


        $category->delete();


        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }
}