<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Auth;
use App\User;
use App\Code;
use Hash;
use DB;
use Validator;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    public function codes(){
        $codes = Code::all();
        return response()->json([ 'msg'=>'success' , 'data' => $codes ]);
    }
     public function register(Request $request){
        
        $validator= validator()->make($request->all(),[
            'code_id'  => 'required|unique:users|exists:codes,id',
            'password'     => 'required|min:6',  
            'confirmpass'     => 'required|same:password',
            'section_id'     => 'required',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
                                }
        $user = new User;
        $user->code_id = $request->code_id;
        //$user->name = $request->name;
        //$user->phone = $request->phone;
        $user->device_token = $request->device_token;
        $user->password = Hash::make($request->password);
        $user->api_token = Str::random(60);
        $user->code = mt_rand(1000,9999);
        $user->section_id  = $request->section_id;
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/profile'), $filename);
            $user->image = $filename;
        }
        $user->save();
        if($user){
            $code = Code::where('id', $user->code_id )->first();
            $user->name = $code->name;
            $user->phone = $code->phone;
            $user->code_job = $code->code;
            $user->save();
        }
        
        
         $code = DB::table('codes')->where('id',$user->code_id)->value('code');
                        $name = DB::table('codes')->where('id',$user->code_id)->value('name');
                        $phone = DB::table('codes')->where('id',$user->code_id)->value('phone');
         try{
            //dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
          AuthController::sendSMS('Daily Event Verify Code :'.$user->code, $user->phone);
            // dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
        }catch(\Exception $e){}
        
        return response()->json([ 'msg'=>'success' , 
                       'data' => [
                      'api_token'      => $user->api_token,
                      'id'             => $user->id,
                      'code_jobe'     => $code,
                      'name'     => $name,
                      'phone'     => $phone,
                      'section_id'    => $user->section_id ,
                      'device_token'    => $user->device_token ,
                      'code'    => $user->code ,
                      'image'    => $user->image ,
                        ] 
                        
                        ]);
     
          
    }
    
     public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'code_id'  => 'required',
             'password'     => 'required|min:6',
        ]);
        if($validator->fails()){
            return response(['msg' =>false ,'data' => $validator->messages()]);
        }else {
            if (auth()->attempt(['code_id' =>$request->input('code_id'),'password' =>$request->input('password')])){
                $user = auth()->user();
                $user->device_token = $request->device_token;
                $user->save();
                     $code = DB::table('codes')->where('id',$user->code_id)->value('code');
                        $name = DB::table('codes')->where('id',$user->code_id)->value('name');
                        $phone = DB::table('codes')->where('id',$user->code_id)->value('phone');
                 return response()->json([ 'msg'=>'success' , 
                       'data' => [
                            'api_token'      => $user->api_token,
                            'id'             => $user->id,
                            'code_id'    => $code ,
                            'name'    =>  $name ,
                            'phone'    => $phone ,
                            'section_id'    => $user->section_id ,
                            'type'    => $user->type ,
                            'image'    => $user->image ,
                            'device_token'    => $user->device_token ,
                        ] 
                        
                        ]);
                //return response(['status' => 200 ,'user' => $user]);
            }else {
                return response(['msg' =>false ,'data' => 'معلومات خاطئة']);

            }
        }
    }//end login function
    
     public static function sendSMS($messageContent, $mobileNumber)
    {
        $user       = 'dailyevent';
        $password   = 'hamdy100200300';
        $sendername = 'MIZ-WORLD';
        $text       = urlencode($messageContent);
        $to         = $mobileNumber;
        // auth call
        $url        = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=full";
        
        //لارجاع القيمه json
        //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=json";
        // لارجاع القيمه xml
        //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E&return=xml";
        // لارجاع القيمه string 
        //$url = "http://www.oursms.net/api/sendsms.php?username=$user&password=$password&numbers=$to&message=$text&sender=$sendername&unicode=E";
        // Call API and get return message
        //fopen($url,"r");
        $ret = file_get_contents($url);
        return $ret;
    }
    
     public function activcodeuser(Request $request)
     {  
        $user = auth()->guard('api')->user();

        $useractive = User::where([['code',$request->code],['id', $user->id ]])->first();
        if($useractive)
        {   
            $useractive->is_active = 1 ;
             $useractive->code = null ;
             $useractive->save();
            return response()->json([ 'msg'=>'success' , 'data' => 'Corecct Code']);
        }
        else 
        {
            $errorarr = array();
            return response()->json([ 'msg'=>'false' , 'data' => 'false Code']);
        }
     }
     public function search(Request $request)
    {
         $arr = array();
        
         $search = Code::where('name','like','%'.$request['name'].'%')->get();
        
        foreach($search as $sh){
            $user = User::where('code_id', $sh->id )->first();
           
        array_push($arr, array(
              "id" => $user->id,
              "name"=> $sh->name,
              "code_job"=> $sh->code_job,
              "phone"=> $sh->phone ,
              "image"=>$user->image ,
             
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }

    public function setting(){
      $arr = array();
      $settings0 = Setting::where(['key'=>'aboutApp'])->value('value');
      $settings1 = Setting::where(['key'=>'aboutApp2'])->value('value');
      $settings2 = Setting::where(['key'=>'aboutApp3'])->value('value');
      $settings3 = Setting::where(['key'=>'conditions'])->value('value');
      $settings4 = Setting::where(['key'=>'who'])->value('value');
      //dd($settings); 
          array_push($arr, array(
               "splash–1"=>$settings0,
               "splash–2"=>$settings1,
               "splash–3"=>$settings2,
               "conditions"=>$settings3,
               "who"=>$settings4,
          ));
          return response()->json(['msg'=>'success','data'=>$arr]);
    }  
}