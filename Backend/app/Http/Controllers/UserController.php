<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Validating inputs
        $data = $request->validated();
        
        // Creating User
        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"])
        ]);
        
        return response([ "token" => $user->createToken("access_token")->plainTextToken, "name" => $user->name]);
    }

    /**
     * Login user and generate token.
     */
    public function login(LoginUserRequest $request)
    {
        // Get Validated data
        $data = $request->validated();

        // Check if user input for logging
        $input = isset($data['email']) ? 'email' : 'name';
        
        // get user data
        $user = User::where($input, $request->input($input))->first();
        
        // Check for user authentication
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response(["message" => "User doesn't exist"],403);
        }

        return response([ "token" => $user->createToken("access_token")->plainTextToken, "name" => $user->name]);
    }

    /**
     * Check for user Auth.
    */
    public function auth(Request $request)
    {
        $user = $request->user();
        return response($user ? true : false); 
    }

    /**
     * Logout user and revoke token.
     */
    public function logout(Request $request)
    {
        $logout = $request->user()->tokens()->where('name', "access_token")->delete();
        return response($logout ? "Account logged out successfully" : "Couldn't logout this account"); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        return response(User::find($userId));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        // Validating inputs
        $data = $request->validated();
        
        // Creating User
        $user = User::find($request->user()->id)->update($data);

        return response("Account Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
