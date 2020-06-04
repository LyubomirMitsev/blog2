<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('posts')
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        return view('admin.category_index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {

        $attributes = $request->only(['name', 'description']);
        $attributes['user_id'] = Auth::user()->id;

        $response = [
            'status' => 'success', 
            'message' => 'The new category was successfully created!'
        ];

        try {
            Category::create($attributes);
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        }

        return redirect()->route('category.index')->with($response['status'], $response['message']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category_edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $response = [
            'status' => 'success', 
            'message' => 'The requested category has successfully been updated!'
        ];

        try {
            $category->update($request->only(['name', 'description']));
            
        } catch (Exception $exception) {
            $response = [
                'status' => 'error',
                'message' => $exception->message
            ];
        } 

        return redirect()->route('category.index')->with($response['status'], $response['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $postCount = $category->posts->count();

        $response = [
            'status' => 'success', 
            'message' => 'The requested category has successfully been deleted.'
        ];

        if ($postCount > 0) {
            $response = [
                'status' => 'error',
                'message' => 'The requested for deletion category has active posts in it. Make sure you remove all active posts from the category before you try to delete it.'
            ];
        } else {
            try {
                $category->delete();
                
            } catch (Exception $exception) {
                $response = [
                    'status' => 'error',
                    'message' => $exception->message
                ];
            } 
        }

        return redirect()->route('category.index')->with($response['status'], $response['message']);
    }
}
