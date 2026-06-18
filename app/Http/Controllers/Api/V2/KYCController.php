<?php

namespace App\Http\Controllers\Api\V2;



use App\Models\Userkyc;
use App\Models\User;
use Illuminate\Http\Request;



class KYCController extends Controller
{

    // ================================
    // CHECK KYC STATUS API
    // ================================
    public function checkkycstatus(Request $request)
    {
        try {

            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            $user = User::find($request->user_id);

            if ($user->is_kyc == 1) {

                return response()->json([
                    'result' => true,
                    'kyc_status' => 1,
                    'message' => 'KYC Verified',
                ]);

            } else {

                return response()->json([
                    'result' => true,
                    'kyc_status' => 2,
                    'message' => 'KYC Not Verified',
                ]);
            }

        } catch (\Exception $e) {

            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


    // ================================
    // STORE KYC STEP WISE API
    // ================================
  public function storekyc(Request $request)
{
    try {

        /*
        |--------------------------------------------------------------------------
        | ✅ Validate Request
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'user_id'      => 'required|exists:users,id',

            'bank_name'    => 'required',
            'bank_account' => 'required',
            'bank_ifsc'    => 'required',
            'bank_holder'  => 'required',
            'phone'        => 'required',

            'aadhar'       => 'required',

            'pan'          => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | ✅ Check User Type = customer
        |--------------------------------------------------------------------------
        */

        $user = User::where('id', $request->user_id)
                    ->where('user_type', 'customer')
                    ->first();

        if (!$user) {

            return response()->json([
                'result'  => false,
                'message' => 'Invalid customer user',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ✅ Check User Already KYC Verified
        |--------------------------------------------------------------------------
        */

        $existingKyc = Userkyc::where('user_id', $request->user_id)
                            ->first();

        if (
            $existingKyc &&
            $existingKyc->is_bank == 1 &&
            $existingKyc->is_aadhar == 1 &&
            $existingKyc->is_pan == 1 &&
            $user->is_kyc == 1
        ) {

            return response()->json([
                'result'  => false,
                'message' => 'KYC already submitted and verified'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ✅ Create Or Update KYC
        |--------------------------------------------------------------------------
        */

        $kyc = Userkyc::updateOrCreate(

            ['user_id' => $request->user_id],

            [

                // ✅ Bank Details
                'bank_name'    => $request->bank_name,
                'bank_account' => $request->bank_account,
                'bank_ifsc'    => $request->bank_ifsc,
                'bank_holder'  => $request->bank_holder,
                'phone'        => $request->phone,

                // ✅ Aadhar
                'aadhar'       => $request->aadhar,

                // ✅ PAN
                'pan'          => $request->pan,

                // ✅ Status
                'is_bank'      => 1,
                'is_aadhar'    => 1,
                'is_pan'       => 1,

            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ✅ Update User is_kyc = 1
        |--------------------------------------------------------------------------
        */

        User::where('id', $request->user_id)->update([
            'is_kyc' => 1
        ]);

        /*
        |--------------------------------------------------------------------------
        | ✅ Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'result'  => true,
            'message' => 'KYC Submitted Successfully',

            'data' => [

                'user_id'      => $kyc->user_id,

                'bank_name'    => $kyc->bank_name,
                'bank_account' => $kyc->bank_account,
                'bank_ifsc'    => $kyc->bank_ifsc,
                'bank_holder'  => $kyc->bank_holder,
                'phone'        => $kyc->phone,

                'aadhar'       => $kyc->aadhar,
                'pan'          => $kyc->pan,

                'is_bank'      => $kyc->is_bank,
                'is_aadhar'    => $kyc->is_aadhar,
                'is_pan'       => $kyc->is_pan,

                'is_kyc'       => 1,

            ]

        ]);

    } catch (\Exception $e) {

        return response()->json([

            'result'  => false,
            'message' => $e->getMessage(),

        ]);
    }
}
}