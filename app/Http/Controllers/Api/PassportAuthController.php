<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{

    function register(Request $request){

        $data = $request->all();

        $validator = validator()->make($data,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            //'password_confirmation' => 'required|same:password',
        ]);

        if($validator->fails()){

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'data' => $data
            ], 400);

        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        event(new Registered($user));


        return response()->json([
            'success' => true,
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'data' => $data
        ]);



    }

    public function login(Request $request){


        $data = $request->all();

        $identifiant = ['email' => $data['email'], 'password' => $data['password']];


        if (auth()->attempt($identifiant)) {


            if (auth()->user()->hasVerifiedEmail()) {

                $token = auth()->user()->createToken('Personal Token')->accessToken;
                ///$token = auth()->user()->createToken(
                   // 'teste',
                   // ['*']
                //)->accessToken;

                return response()->json([
                    'success' => true,
                    'token' => $token,
                ]);

            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'Please verify your email before logging in.'
                ], 403);

            }

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);

        }




    }

    public function profile(){

        $data = auth()->user();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);


    }


    public function logout(){


        //auth()->user()->token()->delete();

        //auth()->user()->token()->revoke();




        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'

        ]);



    }


}
