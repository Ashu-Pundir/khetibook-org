<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use Illuminate\Http\Request;
use App\Services\CropPriceService;

class PriceController extends Controller
{
    protected $priceSvc;

    public function __construct(CropPriceService $priceSvc)
    {
        $this->priceSvc = $priceSvc;
    }

    public function index()
    {
        $crops = Crop::orderBy('crop_name')->get();
        return view('market.price-check', compact('crops'));
    
    }
    public function adminIndex()
    {
        $crops = Crop::orderBy('crop_name')->get();
        return view('admin.admin-market', compact('crops'));
    }

    public function getPrice(Request $request)
    {
    $request->validate([
        'crop' => 'required|string'
    ]);

    $price = app(CropPriceService::class)->getPrice($request->crop);

    if ($price !== null) {
        return response()->json(['price' => $price]);
    }

    return response()->json(['error' => 'Price not available.'], 404);
    }

    public function checkPriceForm(Request $request)
    {
        $request->validate([
            'crop' => 'required|string'
        ]);

        $price = app(CropPriceService::class)->getPrice($request->crop);

        if ($price !== null) {
            return redirect()->back()->with([
                'price' => $price,
                'crop' => $request->crop
            ]);
        }
        return redirect()->back()->with('error', 'Price not available.');
    }

}
