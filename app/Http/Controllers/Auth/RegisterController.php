<?php

namespace App\Http\Controllers\Auth;

use App\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PictureUpload;
use App\Providers\RouteServiceProvider;
use App\Events\NewUserHasRegisteredEvent;
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
    public $user;

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
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        # code...
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => "sometimes|file|image|max:10000"
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $image_url = request()->hasFile('avatar') ? PictureUpload::uploadImages($data) : null;
        
        return DB::transaction(function() use($data,$image_url){
            $user =  User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'verification_token' => Str::random(45),
            ]);

            if ($image_url) {
                $user->image()->create(['url'=>$image_url]);
            }
            return $user;
        });
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        $token = bin2hex($user->verification_token);
        event(new NewUserHasRegisteredEvent($user,  $token));
        if ($user != null) {
            return redirect('login')->with('success', 'please check your email from verification mail');
        }
        return back()->withErrors(['error' => 'sorry something went wrong']);
    }

    public function redirectTo()
    {
        return "/";
    }
}
