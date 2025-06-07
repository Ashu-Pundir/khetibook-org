<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\User;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CropController extends Controller
{
    public function index()
    {
        // Fetch only crops belonging to the authenticated user
        $crops = Crop::where('user_id', Auth::id())->paginate(4);
        // Log::info($crops);
        return view('crop.dashboard', compact('crops'));
    }
    
    public function create(){
        return view("crop.addcrop");
    }
    
    public function store(Request $request){
        Log::info($request);
        $request->validate([
            'cropname'=> 'required|string|max:255',
            'cropweight'=> 'required|numeric',
            'cropprice'=> 'required|numeric',
            'cropcategory'=> 'required|string',
        ]);
        Crop::create([
            'crop_name'=> $request->cropname,
            'crop_category'=> $request->cropcategory,
            'crop_weight'=> $request->cropweight,
            'crop_price'=> $request->cropprice,
            'user_id' => Auth::id(),
        ]);
        Flasher::addSuccess('Crop added successfully');
        return redirect()->route('crop.dashboard');
    }

    public function edit($id){
        $crop = Crop::findorFail($id);
        return view('crop.edit', compact('crop'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'crop_name' => 'required|string',
            'crop_category' => 'required|string',
            'crop_weight' => 'required|numeric',
            'crop_price' => 'required|numeric',
        ]);
        $crop = Crop::findOrFail($id);
        $crop->update([
            'crop_name' => $request->crop_name,
            'crop_category' => $request->crop_category,
            'crop_weight' => $request->crop_weight,
            'crop_price' => $request->crop_price,
        ]);
        Flasher::addSuccess('Crop updated successfully');
        return redirect()->route('crop.dashboard');
    }

    public function destroy($id)
    {
        $crop = Crop::findOrFail($id);
        $crop->delete();
        Flasher::addSuccess('Crop deleted successfully!');
        return redirect()->back();
    }
}

