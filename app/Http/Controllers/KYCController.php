<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userkyc;
use App\Models\User;
use Illuminate\Support\Facades\Auth;





class KYCController extends Controller
{
    public function index(Request $request)
{
    $userId = Auth::id();
    $kyc = Userkyc::firstOrCreate(
        ['user_id' => $userId],
        ['is_bank'=>2,'is_aadhar'=>2,'is_pan'=>2]
    );

    // Determine current step
    $currentStep = 1;

    if ($request->step) {
        $currentStep = (int)$request->step;
    } else {
        if ($kyc->is_bank == 1 && $kyc->is_aadhar == 2) $currentStep = 2;
        if ($kyc->is_bank == 1 && $kyc->is_aadhar == 1 && $kyc->is_pan == 2) $currentStep = 3;
    }

    // If all steps verified, update is_kyc
    if ($kyc->is_bank==1 && $kyc->is_aadhar==1 && $kyc->is_pan==1) {
        User::where('id',$userId)->update(['is_kyc'=>1]);
    }

    return view('frontend.kyc.index', compact('kyc','currentStep'));
}


public function agentIndex(Request $request)
{
    $user = Auth::user();

    if ($user->user_type != 'agent') {
        abort(403);
    }

    $userId = $user->id;

    $kyc = Userkyc::firstOrCreate(
        ['user_id' => $userId],
        [
            'is_bank' => 2,
            'is_aadhar' => 2,
            'is_pan' => 2
        ]
    );

    $currentStep = 1;

    if ($request->step) {
        $currentStep = (int)$request->step;
    } else {
        if ($kyc->is_bank == 1 && $kyc->is_aadhar == 2) {
            $currentStep = 2;
        }

        if (
            $kyc->is_bank == 1 &&
            $kyc->is_aadhar == 1 &&
            $kyc->is_pan == 2
        ) {
            $currentStep = 3;
        }
    }

    if (
        $kyc->is_bank == 1 &&
        $kyc->is_aadhar == 1 &&
        $kyc->is_pan == 1
    ) {

        User::where('id', $userId)
            ->update(['is_kyc' => 1]);

        return redirect()->route('agent.dashboard');
    }

    return view(
        'frontend.kyc.index',
        compact('kyc', 'currentStep')
    );
}
    // STEP 1 SAVE
  public function saveBank(Request $request)
{
    $request->validate([
        'bank_name'      => 'required',
        'bank_account'   => 'required',
        'bank_ifsc'      => 'required',
        'bank_holder'    => 'required',
        'phone'          => 'required',
        'bank_passbook'  => 'required|image',
    ]);

    $userId = Auth::id();

    $passbookFile = null;

    if ($request->hasFile('bank_passbook')) {
        $passbookFile = time().'_bank_'.$request->file('bank_passbook')->getClientOriginalName();

        $request->file('bank_passbook')->move(
            public_path('uploads/kyc/bank'),
            $passbookFile
        );
    }

    Userkyc::updateOrCreate(
        ['user_id' => $userId],
        [
            'bank_name'      => $request->bank_name,
            'bank_account'   => $request->bank_account,
            'bank_ifsc'      => $request->bank_ifsc,
            'bank_holder'    => $request->bank_holder,
            'phone'          => $request->phone,
            'bank_passbook'  => $passbookFile,
            'is_bank'        => 1,
        ]
    );

    return response()->json([
        'status'  => true,
        'message' => 'Bank details verified successfully'
    ]);
}

    // STEP 2 SAVE
    public function saveAadhar(Request $request)
{
    $request->validate([
        'aadhar'        => 'required|digits:12',
        'aadhar_front'  => 'required|image',
        'aadhar_back'   => 'required|image',
    ]);

    $userId = Auth::id();

    $frontImage = null;
    $backImage  = null;

    if ($request->hasFile('aadhar_front')) {

        $frontImage = time().'_aadhar_front_'.$request->file('aadhar_front')->getClientOriginalName();

        $request->file('aadhar_front')->move(
            public_path('uploads/kyc/aadhar'),
            $frontImage
        );
    }

    if ($request->hasFile('aadhar_back')) {

        $backImage = time().'_aadhar_back_'.$request->file('aadhar_back')->getClientOriginalName();

        $request->file('aadhar_back')->move(
            public_path('uploads/kyc/aadhar'),
            $backImage
        );
    }

    Userkyc::where('user_id', $userId)->update([
        'aadhar'        => $request->aadhar,
        'aadhar_front'  => $frontImage,
        'aadhar_back'   => $backImage,
        'is_aadhar'     => 1,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Aadhaar verified successfully'
    ]);
}

    // STEP 3 SAVE
  public function savePan(Request $request)
{
    $request->validate([
        'pan'        => 'required',
        'pan_front'  => 'required|image',
        'pan_back'   => 'required|image',
    ]);

    $userId = Auth::id();

    $frontImage = null;
    $backImage  = null;

    if ($request->hasFile('pan_front')) {

        $frontImage = time().'_pan_front_'.$request->file('pan_front')->getClientOriginalName();

        $request->file('pan_front')->move(
            public_path('uploads/kyc/pan'),
            $frontImage
        );
    }

    if ($request->hasFile('pan_back')) {

        $backImage = time().'_pan_back_'.$request->file('pan_back')->getClientOriginalName();

        $request->file('pan_back')->move(
            public_path('uploads/kyc/pan'),
            $backImage
        );
    }

    Userkyc::where('user_id', $userId)->update([
        'pan'        => $request->pan,
        'pan_front'  => $frontImage,
        'pan_back'   => $backImage,
        'is_pan'     => 1,
    ]);

    $kyc = Userkyc::where('user_id', $userId)->first();

    if (
        $kyc->is_bank == 1 &&
        $kyc->is_aadhar == 1 &&
        $kyc->is_pan == 1
    ) {

        User::where('id', $userId)->update([
            'is_kyc' => 1
        ]);

        $user = Auth::user();

        return response()->json([
            'status'   => true,
            'redirect' => $user->user_type == 'agent'
                ? route('agent.dashboard')
                : route('home'),
            'message'  => 'KYC completed successfully'
        ]);
    }

    return response()->json([
        'status'  => true,
        'message' => 'KYC completed successfully'
    ]);
}
}