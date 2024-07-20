<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRegistry;

class UserRegistryController extends Controller
{
    public function allUsers() {
        $userRegistries = UserRegistry::all();
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
        $userRegistry->password = $request->password;
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
            $userRegistry->password = $request->password;
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
