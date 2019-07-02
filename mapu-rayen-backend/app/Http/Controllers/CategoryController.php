<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{

    public function index(Request $request){


        $filter = $request->filter;

        if ($filter == '') {
            $categories = Category::select('categories.id', 'categories.name', 'categories.description')
                ->orderBy('categories.id', 'desc')->paginate(5);
        } else {
            $categories = Category::select('categories.id', 'categories.name', 'categories.description')
                ->where('categories.name', 'like', "%$filter%")
                ->orWhere('categories.description', 'like', "%$filter%")
                ->orWhere('categories.id', 'like', "%$filter%")
                ->orderBy('categories.id', 'desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
            ],
            'categories' => $categories
        ];
    }


    public function store(Request $request)
    {


        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();
        return ['status' => 'OK'];
    }

    public function update(Request $request)
    {

        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();
        return ['status' => 'OK'];
    }

    public function delete(Request $request, $id)
    {

        $category = Category::findOrFail($id)->delete();
        return ['status' => 'OK'];
    }



    public function getCategories()
    {

        $categories = Category::select('categories.id', 'categories.name')
        ->orderBy('categories.id', 'desc')->get();
        return [
            'categories' => $categories
        ];

    }

}
