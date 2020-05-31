<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Socialite;
use Auth;
use Exception;
use Hash;
use Validator;
use Illuminate\Support\Str;
class SocialAuthGoogleController extends Controller
{
    public function redirect()
    {
        
        $rdirect =  Socialite::driver('google')->stateless()->redirect();
     
        if($rdirect){
            return   response()->json(['msg' =>'success','data'=> ' Redirect our users to the Google']);   
        }else{
            return  response()->json(['msg' =>false,'data'=> 'Not Redirect our users to the Google']); 
        }
         
    }
    
    public function callback()
    {   
        
        $callback =  Socialite::driver('google')->stateless()->user();
     
        if($callback){
            return   response()->json(['msg' =>'success','data'=> ' Redirect our users to the Google']);   
        }else{
            return  response()->json(['msg' =>false,'data'=> 'Not Redirect our users to the Google']); 
        }
        //return Socialite::driver('facebook')->stateless()->user();
        //  try {
  
        //     $user = Socialite::driver('google')->user();
   
        //     $finduser = User::where('google_id', $user->id)->first();
   
        //     if($finduser){
   
        //         Auth::login($finduser);
  
        //       return response()->json([ 'msg'=>'success' , 'data' => ' exist User redirect to home page']);
   
        //     }else{
        //         $newUser = User::create([
        //             'name' => $user->name,
        //             'code_job' => $user->code_job,
        //             'phone' => $user->phone,
        //             'device_token' => $user->device_token,
        //             'password' => Hash::make($user->password),
        //             'api_token' => Str::random(60),
        //             'code' => rand(10,1000),
        //             'section_id'=> $user->section_id,
        //             'google_id'=> $user->id,
        //         ]);
  
        //         Auth::login($newUser);
   
        //         return response()->json([ 'msg'=>'success' , 'data' => ' new User create redirect to home page']);
        //     }
  
        // } catch (Exception $e) {
        //     return response()->json([ 'msg'=>false , 'data' => 'error']);
        // }
        
       
    }
}