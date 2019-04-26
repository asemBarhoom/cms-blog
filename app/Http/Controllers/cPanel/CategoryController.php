<?php

namespace App\Http\Controllers\cPanel;
use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    /**
     * Display a listing of the Categories
     *
     * @param  \App\Category  $model
     * @return \Illuminate\View\View
     */
    public function index(Category $model)
    {
//        dd(Category::find(4)->posts->count());
        return view('Category.index', ['Categories' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new Category
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Category.create');
    }

    /**
     * Store a newly created Category in storage
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Category  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request, Category $model)
    {
        $model->create($request->all());

        return redirect()->route('category.index')->withStatus(__('Category successfully created.'));
    }

    /**
     * Show the form for editing the specified Category
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\View\View
     */
    public function edit(Category $Category)
    {
        return view('Category.edit', compact('Category'));
    }

    /**
     * Update the specified Category in storage
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, Category  $Category)
    {
        $Category->update(
            $request->all()
         );

        return redirect()->route('category.index')->withStatus(__('Category successfully updated.'));
    }

    /**
     * Remove the specified Category from storage
     *
     * @param  \App\Category  $Category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category  $Category)
    {
        $Category->delete();

        return redirect()->route('category.index')->withStatus(__('Category successfully deleted.'));
    }



}
