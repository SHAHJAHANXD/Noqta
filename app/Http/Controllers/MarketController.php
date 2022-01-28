<?php

namespace App\Http\Controllers;

use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarketController extends Controller
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
    public function view1()
    {
        $Market = Market::get();
        if (!empty($Market)) {
            $response = ['status' => true, 'Market' => $Market];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Market' => ''];
            return response($response, 400);
        }
    }
    public function view($userid)
    {
        $Market = Market::where('user_id', $userid)->get();
        $okay = Market::find($userid);
        return $this->saveUserPayment($okay, $Market);
    }
    public function viewid($id)
    {
        $Market = Market::where('id', $id)->get();
        $okay = Market::find($id);
        return $this->saveUserPayment($okay, $Market);
    }
    public function saveUserPayment($okay, $Market)
    {
        $update_id =  $okay->id;
        if (isset($update_id) && !empty($update_id)) {
            $user = Market::where('id', $update_id)->latest()->first();
            if (isset($user) && !empty($user)) {
                $user->visits = 1;
                $user->most_visits = $user->most_visits + $user->visits;
                $user->save();

                if (!empty($Market)) {
                    $response = ['status' => true, 'Market' => $Market];
                    return response($response, 200);
                } else {
                    $response = ['status' => false, 'Market' => ''];
                    return response($response, 400);
                }
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $Market = Market::query()
            ->where('Name', 'LIKE', "%{$search}%")
            ->get();

        if (!empty($Market)) {
            $response = ['status' => true, 'Market' => $Market];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'Market' => ''];
            return response($response, 400);
        }
    }
    public function UpdateMarket(Request $request)
    {
        $update_id = $request->id;
        if (isset($update_id) && !empty($update_id)) {
            $Market = Market::find($update_id);

            if ($request->hasfile('image')) {
                $imageName = time() . rand(1, 100) . '.' . $request->image->extension();
                $Market->image = $imageName;
                $request->image->move(public_path('images'), $imageName);
            }

            $Market->Name = $request->Name;
            $Market->Description = $request->Description;
            $Market->user_id = $request->user_id;
            $Market->Email = $request->Email;
            $Market->Owner = $request->Owner;
            $Market->address = $request->address;
            $Market->Category = $request->Category_id;
            $Market->update();
            $response = ['status' => true, 'message' => "Market Updated Successfully!"];
            return response($response, 200);
        }
    }
    public function AddMarket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required',
            'Description' => 'required',
            'Owner' => 'required',
            'user_id' => 'required',
            'Email' => 'required',
            'address' => 'required',
            'Category_id' => 'required',

        ]);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $Market = new Market();


        if ($request->hasfile('image')) {
            $imageName = time() . rand(1, 100) . '.' . $request->image->extension();
            $Market->image = $imageName;
            $request->image->move(public_path('images'), $imageName);
        }
        $Market->Name = $request->Name;
        $Market->Description = $request->Description;
        $Market->user_id = $request->user_id;
        $Market->Email = $request->Email;
        $Market->Owner = $request->Owner;
        $Market->address = $request->address;
        $Market->Category = $request->Category_id;
        $Market->save();
        $response = ['status' => true, 'message' => "Market Added Successfully!"];
        return response($response, 200);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function show(Market $market)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function edit(Market $market)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Market $market)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Market  $market
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Market::find($id);
        $company->delete();
        $response = ['status' => true, 'message' => "Market Deleted Successfully!"];
        return response($response, 200);
    }
}
