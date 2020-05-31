<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUs;
class CountactUSController extends Controller
{
    public function contactUS(Request $request)
    {
        $user = auth()->guard('api')->user();
        $validator= validator()->make($request->all(),[  
            'name' => 'required',   
            'message' => 'required',    
            
            ]);
            
           if($validator->fails()){
           
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
        }
        $data = $request->except(['user_id']);
        $data['user_id'] = $user->id ;
        $oc = ContactUs::create($data);
        return response()->json([ 'msg'=>'success' , 
                       'data' => [
                          "name" => $oc->name,
                          "message"=> $oc->message,
                          "user_id"=> $oc->user_id  ,

                        ] 
                        
                        ]);
     
    }

}
