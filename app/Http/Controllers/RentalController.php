<?php

namespace App\Http\Controllers;

use App\Rental;
use Illuminate\Http\Request;
use App\Car;
use App\CarType;
use App\User;
use App\Http\Resources\RentalResource;
use Carbon\Carbon;
use Validator;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Car $car, User $user)
    {
			$rules = array (
				'start_date' => 'required|date',
				'end_date' => 'required|date',
			);
				
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}

			$rental = new Rental();
			$rental->start_date = $request->start_date;
			$rental->end_date = $request->end_date;
			$rental->client_id = $user->id;
			$rental->car_id = $car->id;
			$rental->created_by = auth()->user()->id;
			$rental->code = $car->reg_num."/". time();
			$rental->save();

			return new RentalResource($rental);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
			return new RentalResource($rental);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
