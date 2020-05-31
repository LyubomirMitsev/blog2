<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')
            ->where('deleted_at', null)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($categories as $category) {
            $current = Category::find($category->id);
            $category->posts = $current->posts->count();
        }

        return response()->json($categories);
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

        Session::flash($response['status'], $response['message']);
        return redirect()->route('admin.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return response()->json($category);
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
        try {
            $category->update($request->only(['name', 'description']));
            Session::flash('success', 'The requested category has successfully been updated!');
        } catch (Exception $exception) {
            Session::flash('error', 'An error occured and we could not update the requested category!');
        } 

        return redirect()->route('admin.dashboard');
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

        if ($postCount > 0) {
            Session::flash('error', 'The requested for deletion category has active posts in it. Make sure you remove all active posts from the category before you try to delete it.');
        } else {
            try {
                $category->delete();
                Session::flash('success', 'The requested category has successfully been deleted.');
            } catch (Exception $exception) {
                Session::flash('error', 'An error occured and we could not delete the requested category!');
            } 
        }

        return redirect()->route('admin.dashboard');
    }
}
