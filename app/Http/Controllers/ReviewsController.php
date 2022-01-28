<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ReviewsController extends Controller
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
    
    public function reviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'PlaceorderId' => 'required',
            'Message' => 'required',
            'Rating' => 'required',
        ]);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
            $review = new Reviews();
            $review->user_id = $request->user_id;
            $review->PlaceorderId = $request->PlaceorderId;
            $review->Message = $request->Message;
            $review->Rating = $request->Rating;
            $review->save();
            $response = ['status' => true, 'message' => "Reviews Saved Successfully!"];
            return response($response, 200);
    }

    public function GetReviews($id)
    {
        $Reviews = Reviews::where('id' , $id)->get();

        if(!empty($Reviews))
        {
            $response = ['status' => true, 'Review' => $Reviews];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'Review' => ''];
            return response($response, 400);
        }

    }

    public function UserID($userid)
    {
        $Reviews = Reviews::where('user_id' , $userid)->get();

        if(!empty($Reviews))
        {
            $response = ['status' => true, 'Review' => $Reviews];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'Review' => ''];
            return response($response, 400);
        }

    }
    public function AllReviews()
    {
        $Reviews = Reviews::get();

        if(!empty($Reviews))
        {
            $response = ['status' => true, 'Review' => $Reviews];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'Review' => ''];
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviews $reviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reviews  $reviews
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviews $reviews)
    {
        //
    }
}
