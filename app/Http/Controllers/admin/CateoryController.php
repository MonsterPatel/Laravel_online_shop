<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
// use Image;

class CateoryController extends Controller
{
    //categories list karva mate
    public function index(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('search'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('search') . '%');
        }
        $categories = $categories->paginate(10);
        return view('admin.category.list', compact('categories'));
    }
    //form show karava mate
    public function create()
    {
        return view('admin.category.create');
        // echo "Category Create Page!";
    }
    //form value store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required |unique:categories',
        ]);
        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            // Save Image Here
            // if (!empty($request->image_id)) {
            //     $tempImage = TempImage::find($request->image_id);
            //     $extensionArray = explode('.', $tempImage->name);
            //     $extension = last($extensionArray);

            //     $newImageName = $category->id . '.' . $extension;
            //     $sourcePath = public_path() . '/temp/' . $tempImage->name;
            //     $destinationPath = public_path() . '/uploads/category/' . $newImageName;
            //     File::copy($sourcePath, $destinationPath);

            //Genrate Image Thumbnail.
            // $destinationPath = public_path() . '/uploads/category/thumb/' . $newImageName;
            // $img = Image::make('$sourcePath');
            // $img->resize(450, 600);
            // $img->fit(800, 600, function ($constraint) {
            //     $constraint->upsize();
            // });
            // $img->save($destinationPath);

            //     $category->image = $newImageName;
            //     $category->save();
            // }

            $request->session()->flash('success', 'Category added successfully!!');
            // return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');


            return response()->json([
                'status' => true,
                'message' => 'Category Added Successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    //category edit
    public function edit(Request $request, $categoryId)
    {
        // echo $categoryId;
        $category = Category::find($categoryId);
        if (empty($categoryId)) {
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit', compact('category'));
    }
    //category update
    public function update($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($categoryId)) {
            $request->session()->flash('error', 'Category not found !!');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required |unique:categories,slug,' . $category->id . 'id',
        ]);
        if ($validator->passes()) {
            // $category = new Category(); //upper define
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            // $oldimage = $category->image;

            // Save Image Here
            // if (!empty($request->image_id)) {
            //     $tempImage = TempImage::find($request->image_id);
            //     $extensionArray = explode('.', $tempImage->name);
            //     $extension = last($extensionArray);

            //     $newImageName = $category->id . '-' . time() . '.' . $extension;
            //     $sourcePath = public_path() . '/temp/' . $tempImage->name;
            //     $destinationPath = public_path() . '/uploads/category/' . $newImageName;
            //     File::copy($sourcePath, $destinationPath);

            //Genrate Image Thumbnail.
            // $destinationPath = public_path() . '/uploads/category/thumb/' . $newImageName;
            // $img = Image::make('$sourcePath');
            // $img->resize(450, 600);
            // $img->fit(800, 600, function ($constraint) {
            //     $constraint->upsize();
            // });
            // $img->save($destinationPath);

            //     $category->image = $newImageName;
            //     $category->save();

            //Delete Old Images
            //     File::delete(public_path() . '/uploads/category/' . $oldimage);
            //     File::delete(public_path() . '/uploads/category/thumb/' . $oldimage);
            // }

            $request->session()->flash('success', 'Category Updated successfully!!');
            // return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');


            return response()->json([
                'status' => true,
                'message' => 'Category Updated Successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    //category destroy delete karva
    public function destroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {

            $request->session()->flash('error', 'Category not found !!');
            return response()->json([
                'status' => true,
                'message' => 'Category not found !!',
            ]);
            // return redirect()->route('categories.index');
        }
        File::delete(public_path() . '/uploads/category/' . $category->image);
        File::delete(public_path() . '/uploads/category/thumb/' . $category->image);

        $category->delete();

        $request->session()->flash('success', 'Category deleted successfully!!');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully!!',
        ]);
    }
}
