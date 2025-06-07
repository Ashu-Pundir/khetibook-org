<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|max:255',
            'uphone' => 'required|digits:10|unique:users,phone_number',
            'uemail' => 'required|email|unique:users,email',
            'upassword' => 'required|min:6|max:12',
            'ucpassword' => 'required|same:upassword',
            'city' => 'required|string|max:80',
            'district' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|digits_between:4,10',
            'country' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'All fields are compulsory',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = new User();
        $user->name = $request->uname;
        $user->phone_number = $request->uphone;
        $user->email = $request->uemail;
        $user->password = Hash::make($request->upassword);
        $user->city = $request->city;
        $user->district = $request->district;
        $user->state = $request->state;
        $user->pincode = $request->pincode;
        $user->country = $request->country;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User registered Successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'uphone' => 'required|digits:10',
            'upassword' => 'required|min:6|max:12'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('phone_number', $request->uphone)->first();

        if(!$user || !Hash::check($request->upassword, $user->password)){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid phone or passowrd'
            ], 401);
        }

        // create token using sanctum
        $token = $user->createToken('khetibook_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login Successful',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function getCrops(Request $request){
        $user = $request->user();
        $crops = $user->crops;

        return response()->json([
            'status' => 'success',
            'message' => 'user Crops fetch Successfully',
            'data' => $crops
        ]);
    }

    public function addCrops(Request $request){
        
        $validator = Validator::make($request->all(),[
            'crop_name' => 'required|string|max:255',
            'crop_category' => 'required|string|max:255',
            'crop_weight' => 'required|numeric|min:1',
            'crop_price' => 'required|numeric|min:0',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();

        $crop = new Crop();
        $crop->user_id = $user->id;
        $crop->crop_name = $request->crop_name;
        $crop->crop_category = $request->crop_category;
        $crop->crop_weight = $request->crop_weight;
        $crop->crop_price = $request->crop_price;
        $crop->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Crop added successfully',
            'crop' => $crop
        ], 201);
    }
}
