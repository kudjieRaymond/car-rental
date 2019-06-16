<?php

namespace App\Http\Controllers;

use App\CarType;
use Illuminate\Http\Request;
use App\Http\Resources\CarTypeResource;
use Validator;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			return CarTypeResource::collection(CarType::with('user')->paginate(25));
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			$rules = array ('name' => 'required|string|max:255|unique:car_types,name');
				
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}

			$car_type = CarType::create([
        'name' => $request->name,
				'description' => $request->description,
				'created_by' => auth()->user()->id,
			]);

			return new CarTypeResource($car_type);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CarType  $carType
     * @return \Illuminate\Http\Response
     */
    public function show(CarType $car_type)
    {
			return new CarTypeResource($car_type);
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CarType  $carType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarType $car_type)
    {
			$rules = array ('name' => 'required|string|max:255|unique:car_types,name,'.$car_type->id);
				
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}
				
			$car_type->update($request->only(['name', 'description']));
			
			return new CarTypeResource($car_type);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarType  $carType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarType $car_type)
    {
			$car_type->delete();

      return response()->json(null, 204);
    }
}
