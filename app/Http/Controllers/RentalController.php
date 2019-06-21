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
use DB ;
class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
			return RentalResource::collection(Rental::with()->paginate(25));
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
				'start_date' => 'required|date',
				'end_date' => 'required|date',
				'client_id' => 'required',
				'cars' =>'required|array' ,
			);
				
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}

		 
		 	if(!$user = User::find($request->client_id)){

				return response()->json(['error' =>"User Not Found"]);
			 }
			DB::beginTransaction();  

			try{
				$rental = new Rental();
				$rental->start_date = $request->start_date;
				$rental->end_date = $request->end_date;
				$rental->client_id = $user->id;
				$rental->created_by = auth()->user()->id;
				$rental->code = "GH-".time();
				$rental->save();

				$rental->cars()->attach($request->cars);

				DB::commit();

				return new RentalResource($rental);
				
			} catch (\Exception $e) {

				DB::rollback();

				return response()->json(['error' => 'Car Rental record not Created'], 401);
			}
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
    public function update(Request $request, Rental $rental)
    {
			$rules = array (
				'start_date' => 'required|date',
				'end_date' => 'required|date',
				'client_id' =>'required',
				'cars' =>'required|array' ,
			);
	
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}

			/*if(!$car = Car::find($request->car_id)){

				return response()->json(['error' =>"Car Not Found"]);
		 	}*/
		 
			 if(!$user = User::find($request->client_id))
			 {
				return response()->json(['error' =>"User Not Found"]);
				}
				 
			DB::beginTransaction();  

			try{
				$data = [];
				foreach($request->cars as $key=>$value) 
				{
					$data[$key] = ["returned" => $value];
				}

				$rental->start_date = $request->start_date;
				$rental->end_date = $request->end_date;
				$rental->client_id = $user->id;
				$rental->modified_by = auth()->user()->id;
				$rental->update();

				$rental->cars()->sync($data);

				DB::commit();

				return new RentalResource($rental);
				
			} catch (\Exception $e) {

				DB::rollback();

				return response()->json(['error' => ' Rental record  not Updated'], 401);
			}
		}
		
		 /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_individual_car(Request $request, Rental $rental, Car $car)
    {
			$rules = array ('returned' =>'required|boolean');
	
			$validator = Validator::make($request->all(), $rules);

			if ($validator-> fails()){

				return response()->json(['error' => $validator->errors()], 401);
			}
			 
			DB::beginTransaction();  

			try{
			
				$rental->cars()->updateExistingPivot($car->id, ['returned'=>$request->returned]);

				DB::commit();

				return new RentalResource($rental);
				
			} catch (\Exception $e) {

				DB::rollback();

				return response()->json(['error' => ' Car Rental record  not Updated'], 401);
			}
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
