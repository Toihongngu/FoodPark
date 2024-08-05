<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderCreateRequest;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $slider = Slider::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $slider->where('title', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%")
                ->orWhere('sub_title', 'like', "%{$search}%")
                ->orWhere('offer', 'like', "%{$search}%");
        }

        $sliders = $slider->paginate(10)->appends(['search' => $request->input('search')]);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image', 'sliders');
        $slider = new Slider();
        $slider->image = $imagePath;
        $slider->offer = $request->offer;
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;
        $slider->save();
        toastr('Create Slider Successfuly!', 'success');
        return to_route('admin.slider.index');
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
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', 'sliders', $slider->image);
        $slider->image = isset($imagePath) ? $imagePath : $slider->image;
        $slider->offer = $request->offer;
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->button_link = $request->button_link;
        $slider->status = $request->status;
        $slider->save();
        toastr('Update Slider Successfuly!', 'success');
        return to_route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $this->removeImage($slider->image);
            $slider->delete();
            toastr('Delete Slider Successfuly!', 'success');
            return to_route('admin.slider.index');
        } catch (\Exception $e) {
            toastr('Delete Slider ERROR!', 'danger');
            return to_route('admin.slider.index');
        }
    }

}
