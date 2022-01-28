<?php

namespace App\Http\Controllers;

use App\Models\Authenticate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use Carbon;

class AuthenticateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        return view('success');
    }
    public function welcome()
    {
        return view('welcome');
    }
    public function image()
    {
        $user = Product::get();
        return view('okay', compact('user'));
    }
    public function Productimage()
    {
        $image = Product::get();

        if(!empty($image))
        {
            $response = ['status' => true, 'image' => $image];
            return response($response, 200);
        }
        else{
            $response = ['status' => false, 'image' => ''];
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
    public function getUser($id)
    {
        $User = User::where('id', $id)->get();

        if (!empty($User)) {
            $response = ['status' => true, 'User' => $User];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'User' => ''];
            return response($response, 400);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:5',
        ]);
        if ($validator->fails()) {

            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
        $request->validate([]);
        $user = new User();
        if ($request->hasfile('image')) {
            $imageName = time() . rand(1, 100) . '.' . $request->image->extension();
            $user->image = $imageName;
            $request->image->move(public_path('images'), $imageName);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->save();
        $response = ['status' => true, 'message' => "Account Created Successfully!"];
        return response($response, 200);
    }
    public function updateProfile(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if (isset($user) && !empty($user)) {
            if ($request->hasfile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $user->image = $imageName;
                $request->image->move(public_path('images'), $imageName);
            }
            $user->name = $request->name;
            $user->country = $request->country;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->save();
            $response = ['status' => true, 'message' => "User Updated Successfully!"];
            return response($response, 200);
        } else {
            $response = ['status' => false, 'message' => "Parameters is not valid!"];
            return response($response, 402);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
        ]);
        if ($validator->fails()) {
            return response(['status' => false, 'errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['status' => true, 'message' => "User LoggedIn success!", 'token' => $token, 'data' => $user];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Authenticate  $authenticate
     * @return \Illuminate\Http\Response
     */
    public function show(Authenticate $authenticate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authenticate  $authenticate
     * @return \Illuminate\Http\Response
     */
    public function edit(Authenticate $authenticate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authenticate  $authenticate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Authenticate $authenticate)
    {
        //
    }
    public function reset_form(Request $request)
    {
        $token = $request->segment(3);
        $email = $request->email;
        return view('reset-form', compact('token', 'email'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Authenticate  $authenticate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authenticate $authenticate)
    {
        //
    }
    public function checkemail(Request $req)
    {

        $email = $req->email;
        $emailcheck = User::where('email', $email)->count();
        if ($emailcheck < 0) {

            return redirect()->back()->with('error', 'User Not Exists!');
        }
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Str::random(60),
            'created_at' => Carbon\Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $email)->first();

            if ($this->sendResetEmail($email, $tokenData->token)) {
                $response = ['status' => true, 'message' => "A reset link has been sent to your email address."];
                return response($response, 200);
            }
    }

    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = url('/') . '/password/reset/' . $token . '?email=' . urlencode($user->email);
        try {
            Mail::to($email)->send(new \App\Mail\MyTestMail($link));
            return true;
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required',
            'password_token' => 'required'
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->password_token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('auth.passwords.email');

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email1' => 'Email not found']);
        //Hash and update the new password
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        //Send Email Reset Success Email
        if ($user) {
            return redirect('/success')->with('success', 'Password Change Successfully!');
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }
    }
}
