<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\User;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin-login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'uphone' => 'required|digits:10',
            'upassword' => 'required',
        ]);

        // Find user by phone number
        $user = User::where('phone_number', $credentials['uphone'])->first();

        $mobile_number = 1122334466;

        if ($user && ($user->phone_number == $mobile_number) && Hash::check($credentials['upassword'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            Flasher::addSuccess('Admin logged in Successfully');
            return redirect()->route('admin.dashboard');
        }

        Flasher::addError('Invalid phone number or password');
        return redirect()->route('admin.login');
    }

    public function show()
    {
        $users = User::where('phone_number', '!=', '1122334466')->get();

        return view('admin.admin-db', compact('users'));
    }


    public function viewUser($id)
    {
        $user = User::where('id', $id)->first();
        $crop = Crop::where('user_id', $id)->get();

        return view('admin.user-view', compact(['user', 'crop']));
    }


    public function deleteUser($id)
    {

        $user = User::findorFail($id);
        $user->delete();
        Flasher::addDeleted('User deleted succesfully');
        return redirect()->back();
    }

    public function allcrops()
    {
        $crops = Crop::all();

        return view('admin.allcrops', compact('crops'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        Flasher::addUpdated('success', 'User updated successfully!');
        return redirect()->back();
    }

    public function userCropUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'crop_name' => 'required|string|max:255',
            'crop_category' => 'required|string|max:255',
            'crop_weight' => 'required|numeric',
            'crop_price' => 'required|numeric',
        ]);

        $crop = Crop::findOrFail($id);
        $crop->update($validated);

        return back()->with('success', 'Crop updated successfully!');
    }

    public function userCropDestroy($id)
    {
        $crop = Crop::findOrFail($id);
        $crop->delete();

        return back()->with('success', 'Crop deleted successfully!');
    }


    public function userSummary()
    {
        $users = User::withCount('crops')->where('phone_number', '!=', '1122334466')->get();
        return view('admin.user-summary', compact('users'));
    }

    public function createCrop(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'crop_name' => 'required|string|max:255',
            'crop_category' => 'required|string|max:255',
            'crop_weight' => 'required|string|max:100',
            'crop_price' => 'required|string|max:100',
        ]);

        Crop::create([
            'user_id' => $request->user_id,
            'crop_name' => $request->crop_name,
            'crop_category' => $request->crop_category,
            'crop_weight' => $request->crop_weight,
            'crop_price' => $request->crop_price,
        ]);

        return redirect()->back()->with('success', 'Crop added successfully.');
    }

    public function editAdmin()
    {
        return view('admin.adminsetting');
    }

    public function updateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'city' => 'required|string|max:60',
            'district' => 'nullable|string|max:60',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $user->email_verified = $request->has('email_verified') ? 1 : 0;
        $user->number_verified = $request->has('number_verified') ? 1 : 0;


        $user->fill($request->only([
            'name',
            'city',
            'district',
            'state',
            'pincode',
            'country',
            'latitude',
            'longitude',
            'email',
        ]));

        $user->user_verified = ($user->email_verified && $user->number_verified) ? 1 : 0;

        // ✅ Save all together
        $user->save();

        Flasher::addUpdated('Profile Updated Successfully');

        return redirect()->back();
    }
}
