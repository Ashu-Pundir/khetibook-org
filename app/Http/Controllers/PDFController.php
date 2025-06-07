<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function createPDF(){
        $user = Auth::user();
        if (!$user) {
            return back()->with('message', 'Authenticated user not found. Please log in.');
        }
        $crops = $user->crops;

        $pdf = Pdf::loadView('pdf.crops', compact(['crops', 'user']));
        // return view('pdf.crops', compact('crops'));
        return $pdf->download('crop_report.pdf');
    }


        public function alluserPDF(){
            $users = User::where('phone_number', '!=', '1122334466')->get();
            $pdf = pdf::loadView('admin.usersPdf', compact('users'));
            return $pdf->download('allusers.pdf');
        }


        public function userCropSummaryPdf(){
            $users = User::withCount('crops')->where('phone_number', '!=', '1122334466')->get();
            $pdf = pdf::loadView('pdf.allUserSummary', compact('users'));
            return $pdf->download('allCropSummary.pdf');
        }
    }
