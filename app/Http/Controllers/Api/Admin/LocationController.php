<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    use Image;


//////////////////////////// Country ///////////////////////////////////


    public function GetCountry(){
        $countries = Country::all();
        $data =[
            'countries' => $countries,
        ];
        return response()->json($data,200);
    }

    public function addCountry(Request $request){
        $Validation = Validator::make($request->all(),[
            'name' => 'required|unique:countries,name',
            'flag' => 'required|string'
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }
        $country = Country::create([
            'name' => $request->name,
            'flag' => $this->storeBase64Image($request->flag, 'countries/flags'),
        ]);
        if($country){
            return response()->json([
                'message' => 'Country Created Successfully',
                'country' => $country
            ],200);
        }
    }

    public function UpdateCountry(Request $request,$id){
        $Validation = Validator::make($request->all(),[
            'name' => 'nullable|unique:countries,name,'.$request->id,
            'flag' => 'nullable|string'
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }
        $country = Country::findOrFail($id);
        $country->update([
            'name' => $request->name?? $country->name,
            'flag' => $this->update_image($request, $country->flag, 'flag', 'countries/flags')?? $country->flag,
        ]);
        if($country){
            return response()->json([
                'message' => 'Country Updated Successfully',
                'country' => $country
            ],200);
        }
    }

    public function DeleteCountry($id){
        $country = Country::find($id);
        $country->delete();
        if($country){
            return response()->json([
                'message' => 'Country Deleted Successfully',
            ],200);
        }
    }

////////////////////////////// City //////////////////////////////////


    public function GetCity(){
        $cities = City::with('country')->get();
        $data = $cities->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
                'country_id' => $city->country_id,
                'country_name' => $city->country->name,
            ];
        });
        return response()->json(['cities'=>$data],200);
    }

    public function addCity(Request $request){
        $Validation = Validator::make($request->all(),[
            'name' => 'required|unique:cities,name',
            'country_id' => 'required|exists:countries,id',
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }
        $city = City::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
        ]);
        if($city){
            return response()->json([
                'message' => 'City Created Successfully',
                'city' => $city
            ],200);
        }
    }

    public function UpdateCity(Request $request,$id){
        $Validation = Validator::make($request->all(),[
            'name' => 'nullable|unique:cities,name,'.$id,
            'country_id' => 'nullable|exists:countries,id',
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }
        $city = City::findOrFail($id);
        $city->update([
            'name' => $request->name?? $city->name,
            'country_id' => $request->country_id?? $city->country_id,
        ]);
        if($city){
            return response()->json([
                'message' => 'City Updated Successfully',
                'city' => $city
            ],200);
        }
    }

    public function DeleteCity($id){
        $city = City::find($id);
        $city->delete();
        if($city){
            return response()->json([
                'message' => 'City Deleted Successfully',
            ],200);
        }
    }
}
