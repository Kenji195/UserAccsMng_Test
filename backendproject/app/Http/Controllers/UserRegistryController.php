<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\UserRegistry;
use Illuminate\Support\Facades\Log;


class UserRegistryController extends Controller
{
    protected function respondWithToken($token) 
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 6000
        ]);
    }
    
    public function register(Request $request) 
    {
        if (UserRegistry::where('username', $request->username)->exists()) {
            return response()->json([
                'message' => 'There is already a registry with that Username',
                'code' => 400
            ], 400);
        }
        if (UserRegistry::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'There is already a registry with that Email',
                'code' => 400
            ], 400);
        }
  
        $userRegistry = new UserRegistry;
        $userRegistry->username = request()->username;
        $userRegistry->email = request()->email;
        $userRegistry->password = bcrypt(request()->password);
        $userRegistry->save();
        
        $token = auth()->login($userRegistry);

        return $this->respondWithToken($token);
    }

    public function login(Request $request) 
    {
        \Log::info('Login request received:', $request->all());

        $userRegistry = UserRegistry::where('email', $request->email)->first();

        if (!$userRegistry || !Hash::check($request->password, $userRegistry->password)) {
            \Log::error('Login attempt failed:', ['email' => $request->email]);
            return response()->json(['message' => 'Wrong credentials', 'code' => 401], 401);
        }

        \Log::info('Login successful:', ['email' => $request->email]);
        
        $token = auth()->login($userRegistry);

        return $this->respondWithToken($token);
    }

    public function loginOld1(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Wrong credentials', 'code' => 401], 401);
        }

        return $this->respondWithToken($token);
    }

    public function loginOld2(Request $request) {
        if (UserRegistry::where('email', $request->email)->exists()) {
            $userRegistry = UserRegistry::where('email', $request->email)->first();
            if (strcmp($userRegistry->password, $request->password) == 0) {
                return response()->json([
                'message' => 'Welcome!',
                'code' => 200
                ], 200);
            }
            else {
                return response()->json([
                'message' => 'Wrong credentials',
                'code' => 400
                ], 400);
            }
        }
        else {
            return response()->json([
            'message' => 'Wrong credentials',
            'code' => 400
            ], 400);
        }
    }
    

    public function meOld()
    {
        return response()->json(auth()->user());
    }
    public function me()
    {
        $user = auth()->user();
        Log::info('Authenticated user:', ['user' => $user]);
        return response()->json($user);
    }
    
    

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    
    public function logout()
    {
        auth()->logout();
  
        return response()->json(['message' => 'Successfully logged out']);
    }
    


    //----------------------------------------------------------------



    public function allUsers() {
        $userRegistries = UserRegistry::select('id', 'username', 'email')->get();
        return response()->json([
            'userRegistries' => $userRegistries,
            'message' => 'User registries',
            'code' => 200
        ]);
    }


    public function getUser($id) {
        $userRegistry = UserRegistry::find($id);
        return response()->json($userRegistry);
    }


    public function insertUser(Request $request) {
        if (UserRegistry::where('username', $request->username)->exists()) {
            return response()->json([
                'message' => 'There is already a registry with that Username',
                'code' => 400
            ], 400);
        }
        if (UserRegistry::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'There is already a registry with that Email',
                'code' => 400
            ], 400);
        }
        
        $userRegistry = new UserRegistry();
        $userRegistry->username = $request->username;
        $userRegistry->email = $request->email;
        $userRegistry->password = bcrypt($request->password);
        $userRegistry->save();
    
        return response()->json([
            'message' => 'New user was registered!',
            'code' => 200
        ]);
    }


    public function editUser($id, Request $request) {
        $userRegistry = UserRegistry::where('id', $id)->first();

        if (!$userRegistry) {
            return response()->json([
                'message' => 'User registry does not exist',
                'code' => 400
            ]);
        }
        else {
            $userRegistry->username = $request->username;
            $userRegistry->email = $request->email;
            //$userRegistry->password = bcrypt($request->password);
            $userRegistry->save();
        
            return response()->json([
                'message' => 'User registry was updated!',
                'code' => 200
            ]);
        }
    }


    public function deleteUser($id) {
        $userRegistry = UserRegistry::find($id);
        if ($userRegistry) {
            $userRegistry->delete();
            return response()->json([
                'message' => 'User registry deleted',
                'code' => 200
            ]);
        }
        else {
            return response()->json([
            'message' => "There is no user registry with ID $id",
            'code' => 400
            ]);
        }
    }


}
