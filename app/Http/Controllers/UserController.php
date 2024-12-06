<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
    {
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
        return User::all();
        }

    public function register(Request $request)
        {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email',  // Email should be unique
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Hash the password before storing it
        $validatedData['password'] = Hash::make($request->password);

        try {
            // Create the new user
            $user = User::create($validatedData);

            // Generate Sanctum token for the user
            $token = $user->createToken('User_token')->plainTextToken;

            // Return the response with token and user data
            return response()->json([
                "user" => $user,
                'message' => 'Successfully registered',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

            } catch (\Exception $e) {
            // Catch any exception that occurs during the user creation or token generation process
            return response()->json([
                'error' => 'User registration failed',
                'message' => $e->getMessage(),
            ], 500);  // Internal server error
            }
        }

    public function login(Request $request)
        {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to authenticate using the username and password
        if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(['message' => 'Invalid login credentials'], 401); // Unauthorized
            }


        $user = Auth::user();
        $token = $user->createToken('User_token')->plainTextToken;

        return response()->json([
            "user" => $user,
            'message' => 'Successfully logged in',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
        }

    public function store(Request $request)
        {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create($validatedData);

        return response()->json($user, 201);
        }

    public function logout(Request $request)
        {
        $request->user()->currentAccessToken()->delete(); // Revoke only the current token

        return response()->json(['message' => 'Logged out successfully']);
        }

    public function show(string $id)
        {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
            } else {
            return response()->json(['message' => 'Product not found'], 404);
            }
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
        {
        $user = User::find($id);

        if ($user) {
            $user->update($request->all());
            return response()->json($user);
            } else {
            return response()->json(['message' => 'User not found'], 404);
            }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
        {
        //
        }
    }
