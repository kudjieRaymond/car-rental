<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			return UserResource::collection(User::paginate(25));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$rules = array (
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users,email',
				'address' => 'required|string',
				'phone_number' =>'required|unique:users',
				'access' =>'required',
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
					'access' =>$request->access,
			]);

			return  new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
