<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Admin;
class ProfileController extends Controller
{
    public function profileUser(Request $request)
    {
        $arr = array();
        $user = User::where('id',$request->id)->get();
      
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $user]);
    }

    public function profileAdmin(Request $request)
    {  
        $arr = array();
        $user = auth()->guard('api')->user();
        $admin = Admin::where('id',$request->id)->first();
    
     
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $admin]);
    }

   public function editUser(Request $request )
    {
       
        // $validator= validator()->make($request->all(),[
        //     'name' => 'required',   
        //     'phone' => 'required',   
        //     'code_job' => 'required',   
        //     ]);
            
        //   if($validator->fails()){
           
        //     return response()->json(['msg' =>false,'data'=>$validator->errors()]);
        // }

        $user = User::where([ 'id' => $request->id])->first();
        if(is_null($user)){
            return response()->json(['msg'=>false ,'data'=>'not found recourd']);
        }
        $user->name  = $request->name;
        $user->phone   = $request->phone;
        $user->code_job   = $request->code_job;
        $user->password   = bcrypt($request->password);
        $user->is_active   = 1 ;
        $user->section_id    = $request->section_id ;
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/profile'), $filename);
            $user->image = $filename;
        }
        if($user){
            $user->save(); 
        }
        return response()->json([ 'msg'=>'success' , 'data' => $user ]);
    }
}