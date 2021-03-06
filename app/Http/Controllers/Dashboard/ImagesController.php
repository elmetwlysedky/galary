<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function index()
    {
        $images = Image::latest()->Paginate(5);
        return view('Dashboard.Images.index',compact('images'));
    }


    public function create()
    {
        $category = Category::pluck('name_en','id');
        return view('Dashboard.Images.create', compact('category'));
    }


    public function store(ImageRequest $request)
    {
        $data = $request->validated();
        $path = Storage::disk('public')->putFile('/Images',$request->image);
        $data['image']= $path;

        Image::create($data);
        return redirect()->route('Images.index');
    }

    public function show($id)
    {
        $image =Image::findOrFail($id);
        return view('Dashboard.Images.show', compact('image'));
    }


    public function edit($id)
    {
        $category = Category::pluck('name_en','id');
        $image =Image::findOrFail($id);
        return view('Dashboard.Images.edit', compact('image','category'));
    }


    public function update(ImageRequest $request, $id)
    {
        $image = Image::findOrFail($id);
        $data = $request->validated();

        if($request->photo != null) {
            $path = Storage::disk('public')->putFile('/Images', $request->image);
            $data['image'] = $path;
        }
        $image ->update($data);
        return redirect()->route('Images.index');
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        return redirect()->back();
    }

    public function trashed()
    {
        $image =Image::onlyTrashed()->latest()->Paginate(5);

        return view('Dashboard.Images.trashed',compact('image'));
    }

    public function hardDelete( $id)
    {
        $image =Image:: withTrashed()->where('id',$id)->first() ;
        $image->forceDelete();
        return redirect()->back();

    }

    public function restore( $id)
    {
        $image =Image:: withTrashed()->where('id',$id)->first() ;
        $image->restore();
        return redirect()->route('Images.index');
    }

}
