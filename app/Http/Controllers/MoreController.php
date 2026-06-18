<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 use App\Models\Contact;

use Illuminate\Support\Facades\Validator;

class MoreController extends Controller
{
    public function contact(){
        return view('frontend.contact');
    }
    
    
   

public function storeContact(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'required|string|max:20',
        'content' => 'required|string',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $contact = new Contact();

    $contact->name    = $request->name;
    $contact->email   = $request->email;
    $contact->phone   = $request->phone;
    $contact->content = $request->content;

    $contact->save();

    flash(translate('Your query has been submitted successfully.'))->success();

    return redirect()->back();
}
    
      public function about(){
        return view('frontend.about');
    }
    
    
    public function download(){
        return view('frontend.download');
    }
}