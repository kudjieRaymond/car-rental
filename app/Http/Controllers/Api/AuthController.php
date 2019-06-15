<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Traits\FileUploadTrait;

class AuthController extends Controller
{
	use FileUploadTrait;

	public function register(Request $request)
	{
		$rules = array (
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
						'address' => 'required|string',
						'phone_number' =>'required|unique:users',
						'avatar' =>'file|image|mimes:jpeg,jpg,bmp,png,webp|max:2048',

        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator-> fails()){

			return response()->json(['error' => $validator->errors()], 401);
		}
		//upload directory
			$upload_folder ="files/user_files/avatars";
			$request = $this->saveFiles($request , $upload_folder);

			$user = User::create([
					 'email'    => $request->email,
					 'password' => $request->password,
					 'name' =>$request->name,
					 'address'=>$request->address,
					 'avatar'=>$request->avatar,
					 'phone_number'=>$request->phone_number,
			 ]);

			$token = auth()->login($user);

			return $this->respondWithToken($token);
	}

	public function login()
	{
			$credentials = request(['email', 'password']);

			if (! $token = auth()->attempt($credentials)) {
					return response()->json(['error' => 'Unauthorized'], 401);
			}

			return $this->respondWithToken($token);
	}

	public function logout()
	{
			auth()->logout();

			return response()->json(['message' => 'Successfully logged out']);
	}

	protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
