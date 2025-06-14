<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Crop;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function view()
    {
        Log::info();
        return view('crop.addcrop');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uname' => 'required|string|max:255',
            'uphone' => 'required|digits:10',
            'uemail' => 'nullable|email|unique:users,email',
            'upassword' => 'required|min:6|max:12',
            'ucpassword' => 'required|same:upassword',
            'city' => 'required|string|max:80',
            'district' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|digits_between:4,10',
            'country' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'uphone.required' => 'Phone Number field is required',
            'uphone.digits' => 'Phone Number must be exactly 10 digits',
            'upassword.required' => 'Password is required',
            'upassword.min' => 'Password must be at least 6 characters',
            'ucpassword.same' => 'Confirm Password must be the same as Password.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Flasher::addError($error);
            }
            return back()->withInput();
        }

        // Create user if validation passed
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

        Auth::login($user);

        return redirect()->route('login')->with('message', 'Registration successful!');
    
    }


    public function login(Request $request)
    {
        // Manually validate inputs
        $validator = Validator::make($request->all(), [
            'uphone' => 'required|digits:10',
            'upassword' => 'required',
        ]);

        // Show validation errors using Flasher
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Flasher::addError($error);
            }
            return back()->withInput();
        }

        // Attempt to authenticate user
        $user = User::where('phone_number', $request->uphone)->first();

        if ($user && Hash::check($request->upassword, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            Flasher::addSuccess('User logged in successfully');
            return redirect()->route('crop.dashboard');
        }

        Flasher::addError('Invalid phone number or password');
        return redirect()->route('login');
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        // Validate user input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'city' => 'nullable|string|max:60',
            'district' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Flasher::addError($error);
            }
            return redirect()->back()
                ->withInput();
        }

        // Update user data (excluding password and phone)
        $user->name = $request->input('name');
        $user->city = $request->input('city');
        $user->district = $request->input('district');
        $user->state = $request->input('state');
        $user->pincode = $request->input('pincode');
        $user->country = $request->input('country');
        $user->latitude = $request->input('latitude');
        $user->longitude = $request->input('longitude');
        $user->email = $request->input('email');
        $user->save();

        // Show flash success message using Flasher
        Flasher::addSuccess('Profile updated successfully!');

        return redirect()->back();
    }


    public function updateUser(){
        return view('crop.usersetting');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Flasher::addSuccess('Logged out successfully');
        return redirect()->route('login');
    }


}


