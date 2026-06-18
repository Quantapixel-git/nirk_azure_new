<?php

namespace App\Http\Controllers\Auth;

use Cookie;
use Session;
use App\Models\Cart;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\OTPVerificationController;
use App\Utility\EmailUtility;




class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
             'phone' => 'required|digits_between:8,15|unique:users,phone',
             'referred_by_code' => 'nullable|exists:users,referral_code',
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1 && get_setting('recaptcha_customer_register') == 1 , ['required', new Recaptcha()], ['sometimes'])
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
{
    if(addon_is_activated('portfolio_system') && get_setting('customer_verification')){
        $data['verification_status'] = 0;
    }

    // ✅ Clean phone
    $phone = preg_replace('/\D+/', '', $data['phone']);

    // ✅ Email prefix (first 3 letters)
    $emailPrefix = isset($data['email']) ? substr($data['email'], 0, 3) : 'USR';

    // ✅ Generate UNIQUE referral code
    do {
        $random = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 3));

        $referral_code = strtoupper($emailPrefix)
            . substr($phone, 0, 2)
            . substr($phone, -2)
            . $random;

    } while (User::where('referral_code', $referral_code)->exists());

    
    // ✅ Create user (SINGLE LOGIC - CLEAN)
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'] ?? null,
        'phone' => $phone, // ✅ FIXED STORAGE
        'password' => Hash::make($data['password']),
        'verification_status' => $data['verification_status'] ?? 1,
        'referral_code' => $referral_code,
        'user_type' => 'customer',
          'is_active' => 2, // Pending Approval
    ]);

    // ✅ OTP (only if enabled)
    if (addon_is_activated('otp_system')) {
        $user->verification_code = rand(100000, 999999);
        $user->save();

        if(get_setting('customer_registration_verify') != '1'){
            $otpController = new OTPVerificationController;
            $otpController->send_code($user);
        }
    }

    // ✅ Cart logic (KEEP SAME)
    if(session('temp_user_id') != null){
        if(auth()->user()->user_type == 'customer'){
            Cart::where('temp_user_id', session('temp_user_id'))
                ->update([
                    'user_id' => auth()->user()->id,
                    'temp_user_id' => null
                ]);
        } else {
            Cart::where('temp_user_id', session('temp_user_id'))->delete();
        }
        Session::forget('temp_user_id');
    }

    // ✅ Referral Logic (KEEP SAME)
    if (!empty($data['referred_by_code'])) {
        $refUser = User::where('referral_code', $data['referred_by_code'])->first();
        if ($refUser) {
            $user->referred_by = $refUser->id;
            $user->save();
        }
    } elseif (Cookie::has('referral_code')) {
        $referral_code_cookie = Cookie::get('referral_code');
        $refUser = User::where('referral_code', $referral_code_cookie)->first();
        if ($refUser) {
            $user->referred_by = $refUser->id;
            $user->save();
        }
    }

    return $user;
}

    public function register(Request $request)
    {
        //dd($request->all());
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email or Phone already exists.'));
                return back();
                
            }
        }
        elseif (User::where('phone', '+'.$request->country_code.$request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        if($user->email != null){
            if(BusinessSetting::where('type', 'email_verification')->first()->value != 1 || get_setting('customer_registration_verify') === '1'){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                offerUserWelcomeCoupon();
                flash(translate('Registration successful.'))->success();
            }
            else {
                try {
                    EmailUtility::email_verification($user, 'customer');
                    flash(translate('Registration successful. Please verify your email.'))->success();
                } catch (\Throwable $e) {
                    dd($e);
                    $user->delete();
                    flash(translate('Registration failed. Please try again later.'))->error();
                }
            }

            // Account Opening Email to customer
            if ( $user != null && (get_email_template_data('registration_email_to_customer', 'status') == 1)) {
                try {
                    EmailUtility::customer_registration_email('registration_email_to_customer', $user, null);
                } catch (\Exception $e) {}
            }
        }

        if($user->phone != null){
            if(get_setting('email_verification') != 1 || get_setting('customer_registration_verify') === '1'){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                offerUserWelcomeCoupon();
                flash(translate('Registration successful.'))->success();
            }
        }

        // customer Account Opening Email to Admin
        if ( $user != null && (get_email_template_data('customer_reg_email_to_admin', 'status') == 1)) {
            try {
                EmailUtility::customer_registration_email('customer_reg_email_to_admin', $user, null);
            } catch (\Exception $e) {}
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        if ($user->email == null && $user->email_verified_at == null) {
            return redirect()->route('verification');
        }elseif(session('link') != null){
            return redirect(session('link'));
        }else {
            if(addon_is_activated('portfolio_system') && get_setting('customer_verification')){
                return redirect()->route('dashboard');
            }
            return redirect()->route('home');
        }
    }
}
