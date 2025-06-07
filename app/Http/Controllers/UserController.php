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

        Flasher::addSuccess('Registration successful');
        return redirect()->route('login');
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

    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Flasher::addSuccess('Logged out successfully');
        return redirect()->route('login');
    }


}


