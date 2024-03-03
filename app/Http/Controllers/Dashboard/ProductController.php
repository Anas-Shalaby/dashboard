<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories  = Category::all();


        if (strlen($request->get('category_id')) > 0) {
            $products = Product::when($request->category_id, function ($q) use ($request) {
                return $q->where('category_id', $request->get('category_id'));
            })->latest()->paginate(5);
        } else {

            $products = Product::when($request->search, function ($q) use ($request) {
                return $q->whereTranslationLike('name', '%' . $request->search . '%');
            })->latest()->paginate(5);
        }
        return view('dashboard.products.index', compact('products', 'categories'));
    } // end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));
    } // end of create

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required', Rule::unique('product_translations', 'name')]];
        }

        $rules  += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();

        if ($request->image) {

            Image::make($request->image)->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }

        Product::create($request_data);

        session()->flash('success', __('site.added_successfully'));

        return redirect(route('dashboard.products.index'));
    } // end of store


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $categories = Category::all();

        return view('dashboard.products.edit', compact('categories', 'product'));
    } // end of edit

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules += [$locale . '.name' => ['required']];
            $rules += [$locale . '.description' => ['required']];
        }

        $rules  += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ];

        $request->validate($rules);

        $request_data = $request->all();

        if ($request->image) {

            if ($product->image != 'default.jpg') {
                Storage::disk('public_uploads')->delete('products_image' . $product->image);
            } // end of internal if


            Image::make($request->image)->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }



        $product->update($request_data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect(route('dashboard.products.index'));
    } // end of update

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect(route('dashboard.products.index'));
    } // end of destroy
}
