<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
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
    public function visited()
    {
        $Product = Product::get();
        if (!empty($Product)) {
            
            $response = ['status' => true, 'Product' => $Product];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Product' => ''];
            return response($response, 400);
        }
    }
    public function view1()
    {
        $Product = Product::get();
        if (!empty($Product)) {
            $response = ['status' => true, 'Product' => $Product];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Product' => ''];
            return response($response, 400);
        }
    }
    public function view($user_id)
    {
        $Product = Product::where('user_id', $user_id)->get();
        $okay = Product::find($user_id);
        return $this->saveUserPayment($okay, $Product);
    }
    public function viewid($id)
    {
        $Product = Product::where('id', $id)->get();
        $okay = Product::find($id);
        return $this->saveUserPayment($okay, $Product);
    }
    public function saveUserPayment($okay, $Product)
    {
        $update_id =  $okay->id;
        if (isset($update_id) && !empty($update_id)) {
            $user = Product::where('id', $update_id)->latest()->first();
            if (isset($user) && !empty($user)) {
                $user->visits = 1;
                $user->most_visits = $user->most_visits + $user->visits;
                $user->save();

                if (!empty($Product)) {
                    $response = ['status' => true, 'Product' => $Product];
                    return response($response, 200);
                 
                } else {
                    $response = ['status' => false, 'Product' => ''];
                    return response($response, 400);
                }
            }
        }
    }
    public function search(Request $request)
    {
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $Product = Product::query()
            ->where('Name', 'LIKE', "%{$search}%")
            ->get();

        if (!empty($Product)) {
            $response = ['status' => true, 'Product' => $Product];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Product' => ''];
            return response($response, 400);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function UpdateProduct(Request $request)
    {
        $update_id = $request->id;
        if (isset($update_id) && !empty($update_id)) {
            $product = Product::find($update_id);
            if ($request->hasfile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $product->image = $imageName;
                $request->image->move(public_path('images'), $imageName);
            }
            $product->Name = $request->Name;
            $product->Description = $request->Description;
            $product->Price = $request->Price;
            $product->Category = $request->Category_id;
            $product->user_id = $request->user_id;
            $product->market_id = $request->market_id;
            $product->update();
            $response = ['status' => true, 'message' => "Product Updated Successfully!"];
            return response($response, 200);
        }
    }
    public function AddProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required',
            'Description' => 'required',
            'user_id' => 'required',
            'Price' => 'required',
            'Category_id' => 'required',
            'market_id' => 'required',
        ]);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $product = new Product();


        if ($request->hasfile('image')) {
            $imageName = time() . rand(1, 100) . '.' . $request->image->extension();
            $product->image = $imageName;
            $request->image->move(public_path('images'), $imageName);
        }
        $product->Name = $request->Name;
        $product->Description = $request->Description;
        $product->Price = $request->Price;
        $product->Category = $request->Category_id;
        $product->user_id = $request->user_id;
        $product->market_id = $request->market_id;
        $product->save();
        $response = ['status' => true, 'message' => "Product Added Successfully!"];
        return response($response, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Product::find($id);
        $company->delete();
        $response = ['status' => true, 'message' => "Product Deleted Successfully!"];
        return response($response, 200);
    }
}
