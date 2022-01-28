<?php

namespace App\Http\Controllers;

use App\Models\PlaceOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceOrderController extends Controller
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
    public function Prodcts($ids)
    {
        $Products = Product::whereIn('id', [$ids])->get();

        if(!empty($Products))
        {
            $response = ['status' => true, 'Products' => $Products ?? "No Record Found"];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'Products' => 'No Record Found'];
            return response($response, 400);
        }
    }
    public function viewid($userid)
    {
        $PlaceOrder = PlaceOrder::where('userid', $userid)->get();

        if(!empty($PlaceOrder))
        {
            $response = ['status' => true, 'PlaceOrder' => $PlaceOrder ?? "No Record Found"];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'PlaceOrder' => 'No Record Found'];
            return response($response, 400);
        }
    }
    public function view($id)
    {
        $PlaceOrder = PlaceOrder::where('id', $id)->get();

        if(!empty($PlaceOrder))
        {
            $response = ['status' => true, 'PlaceOrder' => $PlaceOrder];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'PlaceOrder' => ''];
            return response($response, 400);
        }
    }
    public function GetAllOrders()
    {
        $PlaceOrder = PlaceOrder::get();

        if(!empty($PlaceOrder))
        {
            $response = ['status' => true, 'PlaceOrder' => $PlaceOrder];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'PlaceOrder' => ''];
            return response($response, 400);
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function UpdatePlaceOrder(Request $request)
    {
        $update_id = $request->id;
        if (isset($update_id) && !empty($update_id)) {
            $PlaceOrder = PlaceOrder::find($update_id);
            $PlaceOrder->userid = $request->userid;
            $PlaceOrder->total_amount = $request->total_amount;
            $PlaceOrder->delivery_fee = $request->delivery_fee;
            $PlaceOrder->product_id = $request->product_id;
            $PlaceOrder->quantity = $request->quantity;
            $PlaceOrder->market_id = $request->market_id;
            $PlaceOrder->delivery_address = $request->delivery_address;
            $PlaceOrder->update();
            $response = ['status' => true, 'message' => "PlaceOrder Updated Successfully!"];
            return response($response, 200);
        }
    }
    public function PlaceOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => 'required',
            'total_amount' => 'required',
            'delivery_fee' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'market_id' => 'required',
            'delivery_address' => 'required',
        ]);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $PlaceOrder = new PlaceOrder();
        $PlaceOrder->userid = $request->userid;
        $PlaceOrder->total_amount = $request->total_amount;
        $PlaceOrder->delivery_fee = $request->delivery_fee;
        $PlaceOrder->product_id = $request->product_id;
        $PlaceOrder->quantity = $request->quantity;
        $PlaceOrder->market_id = $request->market_id;
        $PlaceOrder->delivery_address = $request->delivery_address;
        $PlaceOrder->save();
        $response = ['status' => true, 'message' => "Order Placed Successfully!"];
        return response($response, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceOrder $placeOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PlaceOrder $placeOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlaceOrder $placeOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlaceOrder  $placeOrder
     * @return \Illuminate\Http\Response
     */
    public function DeletePlaceOrder($id)
    {
        $PlaceOrder = PlaceOrder::find($id);
        $PlaceOrder->delete();
        $response = ['status' => true, 'message' => "Order Deleted Successfully!"];
        return response($response, 200);
    }
}
