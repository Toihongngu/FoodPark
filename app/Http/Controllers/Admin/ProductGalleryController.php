<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(string $productId)
    {
        $images = ProductGallery::where('product_id', $productId)->get();
        $product = Product::findOrFail($productId);
        return view('admin.product.gallery.index', compact('product', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'product_id' => ['required', 'integer']
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'products');
        $gallery = new ProductGallery();
        $gallery->product_id = $request->product_id;
        $gallery->image = $imagePath;
        $gallery->save();
        toastr('Create Successfuly!', 'success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $image = ProductGallery::findOrFail($id);
            $this->removeImage($image->image);
            $image->delete();

            toastr('Delete Successfuly!', 'success');
            return to_route('admin.product-gallery.show-index');
        } catch (\Exception $e) {
            toastr('Delete ERROR!', 'danger');
            return to_route('admin.product-gallery.show-index');
        }
    }
}
