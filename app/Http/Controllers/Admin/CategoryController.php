<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categrory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Categrory::all();
        return view('admin.category.index',compact('category'));
    }

    public function add()
    {
        return view('admin.category.add');
    }

    public function insert(Request $request)
    {
        $category = new Categrory();
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $extansion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extansion;
            $file->move('category',$filename);
            $category->image =$filename;
        }
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == TRUE ? '1' : '0';
        $category->populer = $request->input('populer') == TRUE ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->meta_descrip = $request->input('meta_descrip');
        $category->save();
        return redirect('/dashboard')->with('status',"Category Added Successfully");
    }

    public function edit($id)
    {
        $category = Categrory::find($id);
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request , $id)
    {
        $category = Categrory::find($id);

        if($request->hasFile('image'))
        {
            $path = 'category/'.$category->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('image');
            $extansion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extansion;
            $file->move('category/',$filename);
            $category->image =$filename;
        }
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == TRUE ? '1' : '0';
        $category->populer = $request->input('populer') == TRUE ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->meta_descrip = $request->input('meta_descrip');
        $category->update();
        return redirect('/dashboard')->with('status',"Category Updated Successfully");
    }

    public function delete($id)
    {
        $category = Categrory::find($id);
        if($category->image)
        {
            $path = 'category/'.$category->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
        }
        $category->delete();
        return redirect('/categories');
    }
}
