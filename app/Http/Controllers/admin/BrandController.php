<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    //display data
    public function index(Request $request)
    {
        $brands = Brand::latest('id');
        if (!empty($request->get('search'))) {
            $brands = $brands->where('name', 'like', '%' . $request->get('search') . '%');
        }
        $brands = $brands->paginate(10);
        return view('admin.brands.list', compact('brands'));
    }
    //insert page show
    public function create()
    {
        return view('admin.brands.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands'
        ]);
        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $request->session()->flash('success', 'Brand added successfully!!');

            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully!!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            $request->session()->flash('error', 'record not found:)');
            return redirect()->route('brands.index');
        }
        return view('admin.brands.edit', compact('brand'));
    }
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            $request->session()->flash('error', 'record not found:)');
            // return redirect()->route('brands.index');
            return response()->json([
                'status' => false,
                'notFound' => true,
            ]);
        }
        // return view('admin.brands.edit', compact('brand'));

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required |unique:brands,slug,' . $brand->id . 'id',
        ]);
        if ($validator->passes()) {
            // $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $request->session()->flash('success', 'Brand updated successfully!!');

            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully!!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    //data delete
    public function destroy($id, Request $request)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            $request->session()->flash('error', 'Record not found !!');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }
        $brand->delete();
        $request->session()->flash('success', 'Brand deleted Successfully!!');
        return response([
            'status' => true,
            'message' => 'Brand deleted Successfully!!',
        ]);
    }
}
