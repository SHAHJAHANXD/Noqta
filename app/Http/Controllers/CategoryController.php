<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function Product($productid)
    {
        $Category = Category::where('Product_id', $productid)->get();
        if (!empty($Category)) {
            $response = ['status' => true, 'Category' => $Category];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Market' => ''];
            return response($response, 400);
        }
    }
    public function Market($marketid)
    {
        $Category = Category::where('Market_id', $marketid)->get();
        if (!empty($Category)) {
            $response = ['status' => true, 'Category' => $Category];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Market' => ''];
            return response($response, 400);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function UpdateCategory(Request $request)
    {
        $update_id = $request->id;
        if (isset($update_id) && !empty($update_id)) {
            $Category = Category::find($update_id);
            $Category->Name = $request->Name;
            $Category->Product_id = $request->Product_id;
            $Category->Market_id = $request->Market_id;
            $Category->update();
            $response = ['status' => true, 'message' => "Category Updated Successfully!"];
            return response($response, 200);
        }
    }
    public function AddCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required',
        ]);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
        $Category = new Category();
        $Category->Name = $request->Name;
        $Category->Product_id = $request->Product_id;
        $Category->Market_id = $request->Market_id;
        $Category->save();
        $response = ['status' => true, 'message' => "Category Added Successfully!"];
        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }
    public function viewid($id)
    {
        $Category = Category::where('id', $id)->get();
        if (!empty($Category)) {
            $response = ['status' => true, 'Category' => $Category];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Market' => ''];
            return response($response, 400);
        }
    }
    public function view1()
    {
        $Category = Category::get();
        if (!empty($Category)) {
            $response = ['status' => true, 'Category' => $Category];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Market' => ''];
            return response($response, 400);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Category::find($id);
        $Category->delete();
        $response = ['status' => true, 'message' => "Category Deleted Successfully!"];
        return response($response, 200);
    }
}
