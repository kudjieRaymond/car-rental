<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;
use Validator;
use DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			return CarResource::collection(Car::with(['user', 'car_type'])->paginate(25));

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
						'color' => 'required|string|max:255',
						'car_type' => 'required|string',
						'available' => 'required|boolean',
						'reg_num' => 'required|string|unique:cars,reg_num',
			);
				
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails())
			{
				return response()->json(['error' => $validator->errors()], 401);
			}

	
			try {

				$car = Car::create([
					'name' => $request->name,
					'description' => $request->description,
					'color' => $request->color,
					'reg_num' => $request->reg_num,
					'available' => $request->available,
					'car_type_id' => $request->car_type,
					'created_by' => auth()->user()->id,
				]);
	
				return new CarResource($car);

			} catch (\Exception $e) {

				return response()->json(['error' => 'Car Record Could not be Created'], 401);
			}
			
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
			return new CarResource($car);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
			$rules = array (
				'name' => 'required|string|max:255',
				'color' => 'required|string|max:255',
				'car_type' => 'required|string',
				'available' => 'required|boolean',
				'reg_num' => 'required|string|unique:cars,reg_num,'.$car->id,
			);
			
				
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}

			try {
				
				$car->name = $request->name;
				$car->description = $request->description;
				$car->color =$request->color;
				$car->reg_num = $request->reg_num;
				$car->available = $request->available;
				$car->car_type_id = $request->car_type;
				$car->modified_by = auth()->user()->id;
				$car->update();

			return new CarResource($car);
				
			} catch (\Exception $e) {

				return response()->json(['error' => 'Car record Could not be updated'], 401);
			}

			
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
      $car->delete();

      return response()->json(null, 204);
    }
}
