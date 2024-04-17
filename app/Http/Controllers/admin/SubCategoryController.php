<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    //data display/searching/first teble join to second table
    public function index(Request $request)
    {
        $subCategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->latest('sub_categories.id')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        // leftJoin(table name,filed name,table mathi anu id)

        if (!empty($request->get('search'))) {
            $subCategories = $subCategories->where('sub_categories.name', 'like', '%' . $request->get('search') . '%');
            $subCategories = $subCategories->orWhere('categories.name', 'like', '%' . $request->get('search') . '%');
        }
        $subCategories = $subCategories->paginate(10);
        return view('admin.sub_category.list', compact('subCategories'));
    }

    //insert page view
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create', $data);
    }

    //data insert
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required',

        ]);
        if ($validator->passes()) {
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;
            $subCategory->save();
            // echo "hello";
            $request->session()->flash('success', 'Sub-Category added successfully!!');

            return response([
                'status' => true,
                'message' => 'Sub-Category created Successfully!!',
            ]);
        } else {
            return response([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }
    }

    //data edit
    public function edit(Request $request, $id)
    {
        // echo "<h1>" . $id . "</h1>";
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Record not found !!');
            return redirect()->route('sub-categories.index');
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit', $data);
    }

    //data update
    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::find($id);

        if (empty($subCategory)) {
            $request->session()->flash('error', 'Record not found !!');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
            // return redirect()->route('sub-categories.index');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'slug' => 'required|unique:sub_categories',
            'slug' => 'required |unique:sub_categories,slug,' . $subCategory->id . 'id',
            'category' => 'required',
            'status' => 'required',

        ]);
        if ($validator->passes()) {
            // $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;
            $subCategory->save();
            // echo "hello";
            $request->session()->flash('success', 'Sub-Category updated successfully!!');

            return response([
                'status' => true,
                'message' => 'Sub-Category updated Successfully!!',
            ]);
        } else {
            return response([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }
    }

    //data delete
    public function destroy($id, Request $request)
    {
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Record not found !!');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }
        $subCategory->delete();
        $request->session()->flash('success', 'Sub-Category deleted Successfully!!');
        return response([
            'status' => true,
            'message' => 'Sub-Category deleted Successfully!!',
        ]);
    }
}
