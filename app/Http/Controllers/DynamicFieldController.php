<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DynamicField;
use Validator;

class DynamicFieldController extends Controller
{
    public function index(){
        return view('dynamic-field.index');
    }

    public function add(Request $request){
        if( $request->ajax() ){

            $rules = array(
                'first_name.*'  => 'required',
                'country.*'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $first_name = $request->first_name;
            $country = $request->country;

            for( $count = 0; $count < count($first_name); $count++ ){
                $data = array(
                    'first_name' => $first_name[$count],
                    'country' => $country[$count],
                );
                $insert_data[] = $data;
            }

            DynamicField::insert($insert_data);
            return response()->json([
                'success' => 'Data added Successfully',
            ]);



        }
    }
}


