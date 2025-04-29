<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Models\City;
use App\Models\Country;
use App\Models\Zone;
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

////////////////////// Zones //////////////////////

    public function GetZones(){
        $zones = Zone::with(['city:id,name,country_id','country:id,name'])->get();
        $data = [
            'zones' => $zones->map(function ($zone) {
                return [
                    'id' => $zone->id,
                    'name' => $zone->name,
                    'city_id' => $zone->city_id,
                    'country_id' => $zone->country_id,
                    'city_name' => $zone->city->name,
                    'country_name' => $zone->country->name,
                ];
            }),
        ];
        return response()->json([$data],200);
    }

    public function addZone(Request $request){
        $Validation = Validator::make($request->all(),[
            'name' => 'required|unique:zones,name',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }
        $zone = Zone::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
        ]);
        if($zone){
            return response()->json([
                'message' => 'Zone Created Successfully',
            ],200);
        }
    }

    public function UpdateZone(Request $request,$id){
        $Validation = Validator::make($request->all(),[
            'name' => 'nullable|unique:zones,name,'.$id,
            'city_id' => 'nullable|exists:cities,id',
            'country_id' => 'nullable|exists:countries,id',
        ]);
        if($Validation->fails()){
            return response()->json($Validation->errors(),422);
        }
        $zone = Zone::findOrFail($id);
        $zone->update([
            'name' => $request->name?? $zone->name,
            'city_id' => $request->city_id?? $zone->city_id,
            'country_id' => $request->country_id?? $zone->country_id,
        ]);
        if($zone){
            return response()->json([
                'message' => 'Zone Updated Successfully',
            ],200);
        }
    }

    public function DeleteZone($id){
        $zone = Zone::find($id);
        $zone->delete();
        if($zone){
            return response()->json([
                'message' => 'Zone Deleted Successfully',
            ],200);
        }
    }
}
