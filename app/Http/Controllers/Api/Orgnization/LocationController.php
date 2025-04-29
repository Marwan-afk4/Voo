<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Zone;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function GetCountry(){
        $countries = Country::all();
        $data =[
            'countries' => $countries,
        ];
        return response()->json($data,200);
    }

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
}
