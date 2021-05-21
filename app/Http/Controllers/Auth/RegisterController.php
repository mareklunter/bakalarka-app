<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // if we are not guest -> we are already registered - redirect to home page
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
            'name'          => ['required', 'string', 'max:50'],
            'address'       => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'phone'         => ['required', 'string', 'max:20'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    // protected function create(array $data)
    // {
        // $user = User::create([
        //     'name'      => $data['name'],
        //     'address'   => $data['address'],
        //     'email'     => $data['email'],
        //     'phone'     => $data['phone'],
        //     'password'  => Hash::make($data['password']),
        //     'verification_code' => sha1(time())
        // ]);

    //     $user = new User();
    //     $user->name = $data['name'];
    //     $user->email = $data['email'];
    //     $user->password = Hash::make($data['password']);
    //     $user->phone = $data['phone'];
    //     $user->address = $data['address'];
    //     $user->verification_code = sha1(time());
    //     $user->save();

    //     if($user != null){
    //         MailController::sendSignupEmail($user->name, $user->email, $user->verification_code);
    //         return redirect()->back()->with(session()->flash('alert-success', 'Your account has been created. Please check email for verification link.'));
    //     }

    //     return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
    // }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->verification_code = sha1(time());
        $user->save();

        if($user != null){
            MailController::sendSignupEmail($user->name, $user->email, $user->verification_code);
            return redirect()->back()->with(session()->flash('alert-success', 'Pre úspešné dokončenie registrácie si skontrolujte svoj email pre verifikáciu. Ak Vám neprišiel žiaden email, pozrite sa do spamu.'));
        }

        return redirect()->back()->with(session()->flash('alert-danger', 'Nastala chyba, registrácia neprebehla úspešne.'));
    }

    public function verifyUser(Request $request){
        $verification_code = $request->code;
        $user = User::where(['verification_code' => $verification_code])->first();
        if($user != null){
            $user->is_verified = true;
            $user->save();
            return redirect()->route('login')->with(session()->flash('alert-success', 'Tvoj email je verifikovaný. Môžeš sa prihlásiť.'));
        }

        return redirect()->route('login')->with(session()->flash('alert-danger', 'Neplatný verifikažný kód.'));
    }
}
