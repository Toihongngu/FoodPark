<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhyChooseUsCreateRequest;
use App\Models\SectionTitle;
use App\Models\WhyChooseUs;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $key = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
        $titles = SectionTitle::whereIn('key', $key)->pluck('value', 'key');
        $whyChooseUs = WhyChooseUs::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $whyChooseUs->where('title', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%");
        }

        $whyChooseUss =  $whyChooseUs->paginate(10)->appends(['search' => $request->input('search')]);
        return view('admin.why-choose-us.index', compact('whyChooseUss', 'titles'));
    }


    public function create()
    {
        return view('admin.why-choose-us.create');
    }
    public function store(WhyChooseUsCreateRequest $request)
    {
        WhyChooseUs::create($request->validated());
        toastr('Create Why Choose ... Successfuly!', 'success');
        return to_route('admin.why-choose-us.index');
    }

    public function edit(string $id)
    {
        $whyChooseUs = WhyChooseUs::findOrFail($id);
        return view('admin.why-choose-us.edit', compact('whyChooseUs'));
    }

    public function update(WhyChooseUsCreateRequest $request, string $id)
    {
        $whyChooseUs = WhyChooseUs::findOrFail($id);
        $whyChooseUs->update($request->validated());
        toastr('Update why choose ... Successfuly!', 'success');
        return to_route('admin.why-choose-us.index');
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'why_choose_top_title' => ['max:100'],
            'why_choose_main_title' => ['max:200'],
            'why_choose_sub_title' => ['max:500']
        ]);

        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_top_title'],
            ['value' => $request->why_choose_top_title]
        );
        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_main_title'],
            ['value' => $request->why_choose_main_title]
        );
        SectionTitle::updateOrCreate(
            ['key' => 'why_choose_sub_title'],
            ['value' => $request->why_choose_sub_title]
        );
        toastr('Update Title Successfuly!', 'success');
        return redirect()->back();
    }
    public function destroy($id)
    {
        try {
            $whyChooseUs = WhyChooseUs::findOrFail($id);
            $whyChooseUs->delete();
            toastr('Delete Slider Successfuly!', 'success');
            return to_route('admin.why-choose-us.index');
        } catch (\Exception $e) {
            toastr('Delete Slider ERROR!', 'danger');
            return to_route('admin.why-choose-us.index');
        }
    }

}
