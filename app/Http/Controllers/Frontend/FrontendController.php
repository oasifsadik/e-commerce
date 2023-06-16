<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Categrory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $featured_product = Product::where('trending','1')->take(15)->get();
        $trending_category = Categrory::where('populer','1')->take(15)->get();
        return view('frontend.index',compact('featured_product','trending_category'));
    }

    public function category()
    {
        $category = Categrory::where('status','0')->get();
        return view('frontend.category',compact('category'));
    }

    public function viewcategory($slug)
    {
        if(Categrory::where('slug',$slug)->exists())
        {
            $category = Categrory::where('slug',$slug)->first();
            $product = Product::where('cate_id',$category->id)->where('status','0')->get();
            return view('frontend.products.index', compact('product','category') );
        }
        else
        {
            return redirect('/')->with('status',"slug dosenot exists");
        }
    }

    public function productview($cat_slug,$prod_slug)
    {
        if(Categrory::where('slug',$cat_slug)->exists())
        {
            if(Product::where('slug',$prod_slug)->exists())
            {
                $product = Product::where('slug',$prod_slug)-> first();
                $ratings = Rating::where('prod_id',$product->id)->get();
                $rating_sum = Rating::where('prod_id',$product->id)->sum('stars_rated');
                $user_reting = Rating::where('prod_id',$product->id)->where('user_id',Auth::id())->first();
                $reviews = Review::where('prod_id',$product->id)->get();
                if($ratings->count() >0)
                {
                    $rating_value = $rating_sum/$ratings->count();
                }
                else
                {
                    $rating_value =0;
                }
                return view('frontend.products.view',compact('product','ratings','rating_value','user_reting','reviews'));
            }
            else
            {
                return redirect('/')->with('status',"the link was broken");
            }
        }
        else
            {
                return redirect('/')->with('status',"No such a Category Found");
            }
    }

    public function productlistAjax()
    {
        $products = Product::select('name')->where('status','0')->get();
        $data =[];

        foreach ($products as $item) {
            $data[] = $item['name'];
        }

        return $data;
    }

    public function searchProduct(Request $request)
    {
        $searched_product = $request->product_name;
        if($searched_product != "")
        {
            $product = Product::where("name","LIKE","%$searched_product%")->first();
            if($product)
            {
                return redirect('category/'.$product->category->slug.'/'.$product->slug);
            }
            else
            {
                return redirect()->back()->with("status","product not found");
            }
        }
        else
        {
            return redirect()->back();
        }
    }
}
