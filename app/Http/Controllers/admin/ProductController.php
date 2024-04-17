<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        // $subcategories = SubCategory::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['brands'] = $brands;

        return view('admin.products.create', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required |unique:categories',
        ]);
        if ($validator->passes()) {
            $product = new Product();
            $product->description = $request->description;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->slug = $request->slug;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;
            // $product->brand_id = $request->brand; //sub-category baki he...
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->save();

            // Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extensionArray = explode('.', $tempImage->name);
                $extension = last($extensionArray);

                $newImageName = $product->id . '.' . $extension;
                $sourcePath = public_path() . '/temp/' . $tempImage->name;
                $destinationPath = public_path() . '/uploads/product/' . $newImageName;
                File::copy($sourcePath, $destinationPath);

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

                $request->session()->flash('success', 'Product added successfully!!');
                // return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');


                return response()->json([
                    'status' => true,
                    'message' => 'Product Added Successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ]);
            }
        }
    }
}
