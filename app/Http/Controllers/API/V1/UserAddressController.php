<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\User;

class UserAddressController extends Controller
{
     //Create User Address
    public function createUserAddress(Request $request){
    	try{

    		$inputs = $request->all();
    		$validator = ( new UserAddress )->validateUserAddress( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $user = User::where('api_key', $request->api_key)->select('id')->first();
            if($user){ 
         
                   $inputs = $inputs + [    
                                        'user_id' => $user->id,
                                        'created_by' => $user->id,];
                (new UserAddress)->store($inputs);
                $message = "Address created successfully";
                return apiResponseAppmsg(true, 200, $message, null, null);
			}	 

    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

      //All User Address
    public function myAddress(Request $request){
        try{

            $user = User::where('api_key', $request->api_key)->select('id')->first();
            if($request->api_key){
            if($user){

            $data = \DB::table('user_addresses')
            ->join('countries', 'user_addresses.country', '=', 'countries.id')
            ->select('user_addresses.id', 'user_addresses.name', 'user_addresses.mobile',
             'user_addresses.address', 'user_addresses.company_name', 'user_addresses.city', 'user_addresses.state', 'user_addresses.pincode', 'countries.country_name', 'user_addresses.country')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    
            return apiResponseApp(true, 200, null, null, $data);
        
           } else {
                $message = "login Required";
                return apiResponseAppmsg(true, 200, $message, null, null);
           }
        } else {
                $message = "login Required";
                return apiResponseAppmsg(true, 200, $message, null, null);
       }

        }
        catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }


    public function updateUserAddress(Request $request){
        try{
    		$inputs = $request->all();
    		$validator = ( new UserAddress )->validateAddressID( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $user = User::where('api_key', $request->api_key)->select('id')->first();
            if($request->api_key){
                if($user){  
                    $inputs = $inputs + ['updated_by' => $user->id];
                    (new UserAddress)->store($inputs, $inputs['id']);
                    $message = "Address Updated successfully";
                    return apiResponseAppmsg(true, 200, $message, null, null);  
                }
            } else {
                $message = "login Required";
                return apiResponseAppmsg(true, 200, $message, null, null);
           }
        } catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }


    public function deleteUserAddress(Request $request){
        try{
                $user = User::where('api_key', $request->api_key)->select('id')->first();
                if($request->api_key){
                    if($user){  

                    \DB::table('user_addresses')->where('id', $request->id)->where('user_id', $user->id)->delete();

                    } else {
                $message = "login Required";
                return apiResponseAppmsg(true, 200, $message, null, null);
               }
                }

                $message = "Address deleted successfully";
                return apiResponseAppmsg(true, 200, $message, null, null);

        } catch(Illuminate\Database\QueryException $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    public function country(){
      $data = \DB::table('countries')->select('id', 'country_name as name')->get();
       return apiResponseApp(true, 200, null, null, $data);
    }



}
