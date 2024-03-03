<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // search query
        $categories = Category::when( $request->search, function ($q) use($request) {
            return $q->whereTranslationLike('name' , '%' . $request->search . '%');

        })->latest()->paginate(5);
        return view('dashboard.categories.index' , compact('categories'));
    }// end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [];

        foreach (config('translatable.locales') as $locale)
        {
            $rules += [$locale . '.name' => ['required' , Rule::unique('category_translations' , 'name')]];
        }

        $request->validate($rules);

        Category::create($request->all());
        session()->flash('success' , __('site.added_successfully'));

        return redirect(route('dashboard.categories.index'));
    } // end of store


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit' ,compact('category'));
    }// end of edit

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $rules = [];

        foreach (config('translatable.locales') as $locale)
        {
            $rules += [$locale . '.name' => ['required' , Rule::unique('category_translations' , 'name')->ignore($category->id , 'category_id')]];
        }

        $request->validate($rules);

        $category->update($request->all());

        session()->flash('success' , __('site.updated_successfully'));

        return redirect(route('dashboard.categories.index'));


    }// end of update

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $category->delete();

        session()->flash('success' , __('site.deleted_successfully'));

        return redirect(route('dashboard.categories.index'));


    }// end of destroy
}
