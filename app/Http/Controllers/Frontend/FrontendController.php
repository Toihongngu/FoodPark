<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();

        $sectionTitles = $this->getSectionTitle();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();

        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();
        $products = Product::where('show_at_home', 1)
            ->where('status', 1)
            ->whereHas('category', function ($query) {
                $query->where('show_at_home', 1)
                    ->where('status', 1);
            })
            ->orderBy('id', 'DESC')
            ->take(12)
            ->get();

        return view(
            'frontend.home.index',
            compact(
                'sliders',
                'sectionTitles',
                'whyChooseUs',
                'categories',
                'products'
            )
        );
    }

    private function getSectionTitle()
    {
        $key = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title'];
        return SectionTitle::whereIn('key', $key)->pluck('value', 'key');
    }

    public function detailProduct(string $slug)
    {
        $product = Product::with(['productImage','productSizes','productOptions'])->where(['slug' => $slug , 'status'=>1])->firstOrFail();
        $relatedProducts = Product::where('category_id',$product->category_id)
        ->where('id','!=',$product->id)->take(8)->latest()->get();
        return view('frontend.pages.product-detail',compact('product','relatedProducts'));
    }
}
