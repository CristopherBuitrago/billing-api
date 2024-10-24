<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // register
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|max:50|unique:users',
            'password' => 'required|min:5|max:8|confirmed'
        ]);

        if ($validator) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $result = $user->save();

            if ($result) {
                return response()->json([
                    'message' => 'Registration successfully!',
                    'status' => 200
                ]);
            }

        }else {
            return response()->json([
                'message' => 'Something went wrong while auth',
                'error' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    }

    // login
    public function login(Request $request)
    {
        // get request data
        $data = $request->all();
        
        // validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        // check if validator fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'something went wrong while auth',
                'error' => $validator->errors(),
                'status' => 400
            ]);
        } else {
            
            $loginEmail = array(
                'email' => $data['email'],
                'password' => $data['password']
            );

            $loggedIn = false;
            
            $token = '';

            if ($log2 = Auth::attempt($loginEmail)) {
                $loggedIn = true;
                $token = $log2;
            }

            if ($loggedIn == false) {
                return response()->json([
                    'message' => 'Whoops, invalid Email/Password',
                    'error' => $validator->errors(),
                    'status' => 400
                ]);
            }
            
            $response = $this->respondWithToken($token);
            return response()->json([
                $response
            ]);
        }
    }

    // get user auth
    public function profile(){
        if (auth()->user()) {
            try {

                return response()->json([
                    'message' => 'This is your information!',
                    'data' => auth()->user()
                ]);
                
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 403
                ]);
            }
        } else {
            return response()->json([
                'message' => 'User is not authenticated!',
                'data' => auth()->user(),
                'status' => 302
            ]);
        }
    }

    private function respondWithToken($token){
        return response()->json([
            'message' => "You're logged in",
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expiry_in' => auth()->factory()->getTTL()*60
        ]);
    }
}
