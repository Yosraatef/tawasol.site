<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Occasions;
use App\Admin;
use DB;
use App\User;
use App\OccasionsUser;
use App\Notification;
use App\Repository\NotificationsRepository;
class OccasionController extends Controller
{
    public function index(Request $request)
    {
        $arr = array();
        //$user = auth()->guard('api')->user();
        $occasions = Occasions::all();
         $ocPrivet = Occasions::where('is_public',2)->get();
       
       
       // dd($occasionUser);
        foreach($occasions as $oc){
            $occasionUser = OccasionsUser::where('occasions_id', $oc->id )->get();
            array_push($arr, array(
                
                  "id" => $oc->id,
                  "name_occasion" => $oc->name_occasion,
                  "name_owner"=> $oc->name_owner,
                  "date"=>  $oc->date,
                  "time"=>$oc->time,
                  "address"=>$oc->address,
                  "lng"=>$oc->lng,
                  "lat"=>$oc->lat,
                  "is_public"=>$oc->is_public,
                  "is_accepted"=>$oc->is_accepted,
                  "section_id"=>$oc->section_id ,
                  "user_id"=> $oc->user_id  ,
                  "image"=> $oc->image  ,
                  "usersInvtPrivet" => $occasionUser,
            ));
            }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
    }
    public function getPublicOcassions()
    {
        $arr = array();
        
        $occasions = Occasions::where('is_public' , 1)->get();
        
        foreach($occasions as $oc){
            array_push($arr, array(
                  "id" => $oc->id,
                  "name_occasion" => $oc->name_occasion,
                  "name_owner"=> $oc->name_owner,
                  "date"=>  $oc->date,
                  "time"=>$oc->time,
                  "lng"=>$oc->lng,
                  "lat"=>$oc->lat,
                  "is_public"=>$oc->is_public,
                  "section_id"=>$oc->section_id ,
                  "user_id"=> $oc->user_id  ,
                  "image"=> $oc->image  ,
            ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
    }
    public function getPrivtOcassionsSection(Request $request)
    {
        $arr = array();
        $occasions = Occasions::where([['is_public' , 0] , ['section_id' , $request->section_id ]] )->get();
        
        foreach($occasions as $oc){
            array_push($arr, array(
                  "name_occasion" => $oc->name_occasion,
                  "name_owner"=> $oc->name_owner,
                  "date"=>  $oc->date,
                  "time"=>$oc->time,
                  "lng"=>$oc->lng,
                  "lat"=>$oc->lat,
                  "is_public"=>$oc->is_public,
                  "section_id"=>$oc->section_id ,
                  "user_id"=> $oc->user_id  ,
                  "image"=> $oc->image  ,
            ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
    }

    public function getPrivtOcassionsOfficer(Request $request)
    {
        $arr = array();
       
        $occasions = OccasionsUser::where('occasions_id' , $request->occasions_id )->get();
        
        foreach($occasions as $oc){
            array_push($arr, array(
            
                  "user_id"=> $oc->user_id  ,
                  "image"=> $oc->image  ,
            ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $occasions ]);
    }

  public function getRejectedOcassions()
    {
        $arr = array();
        
        $occasions = Occasions::where('is_public' , 3 )->get();
        
        foreach($occasions as $oc){
            array_push($arr, array(
                  "name_occasion" => $oc->name_occasion,
                  "name_owner"=> $oc->name_owner,
                  "date"=>  $oc->date,
                  "time"=>$oc->time,
                  "lng"=>$oc->lng,
                  "lat"=>$oc->lat,
                  "is_public"=>$oc->is_public,
                  "section_id"=>$oc->section_id ,
                  "user_id"=> $oc->user_id  ,
                  "image"=> $oc->image  ,
            ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
    }
   
    public function store(Request $request)
    {     
        $user = auth()->guard('api')->user();
        
        $validator= validator()->make($request->all(),[
            'name_occasion' => 'required',   
            'name_owner' => 'required',   
            'date' => 'required',   
            'time' => 'required',   
            'address' => 'required',   
            'section_id' => 'required', 
            'is_public' => 'required', 
            'check_manger' => 'required', 
            ]);
            
           if($validator->fails()){
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
            }
            $data = $request->except(['user_id','section_id','invitationUser_id','image','lng','lat']);
                $invitationUser_ids =  $request->input('invitationUser_ids');
                 $data['lng'] = isset($request->lng)? $request->lng : ' '  ;
                 $data['lat'] = isset($request->lat)? $request->lat : ' '   ;
               // $data['user_id'] = $user->id ;
                $data['user_id'] = $request->user_id ;
                $data['section_id'] = $request->section_id ;
                if ($request->hasFile('image')) {
                    $filename = time() . '-' . $request->image->getClientOriginalName();
                    $request->image->move(public_path('pictures/occasions'), $filename);
                     $data['image']= $filename;
                }
                $oc = Occasions::create($data);
                
                if($oc->is_public == 2){
                    if($invitationUser_ids){
                    foreach($invitationUser_ids as $tag)
                    $oc->invitationUser()->attach($tag);    
                    }    
                }
                
                
                if($oc->check_manger == 0){
                    
                  $admin = User::where([['section_id', $oc->section_id],['type', 2]])->first();
                 // dd($admin);
                  if($admin){
                    $notification = Notification::create([
                  'user_id' => $admin->id,
                  'content' =>' تم انشاء حدث جديد من قبل  '. $oc->user->name,
                  'section_id' => $admin->section_id,
                  'occasion_id' => $oc->id,
                  ]);
                
                    if (!empty($admin->device_token)) {
                      
                      NotificationsRepository::pushNotification($admin->device_token, 'تعليق جديد', $notification->content, ['user_id' => $admin->id, 'status' => 'تم انشاء حدث جديد  ' , 'occasion_id' => $oc->id ]);
                   }
        
                   return response()->json([ 'msg'=>'success' , 
                       'data' => [
                         "occasions" => $oc,
                          "notification" => $notification,
                        ] 
                        
                        ]);    
                  }else{
                      return response()->json([ 'msg'=>'success' , 'data' => 'no admin to this section'
                        ]);
                  }
                  
               
                } else {
                //   dd( $oc->is_accepted );
                //   $oc->is_accepted = 1 ;
                //   $oc->save();
                $getDeviceTokens = User::where('id', $oc->user_id)->first();
                //dd($getDeviceTokens);
                    if($oc->is_public == 1){
                        $publicInvitation = User::where('type',0)->get();
                       
                       // foreach($getDeviceTokens as $getDeviceToken){
                            $notification = Notification::create([
                              'user_id' => $oc->user_id,
                              'content' => ' تم قبول مناسبتك للنشر للعامة  '. $oc->name_occasion,
                              'section_id' => $user->section_id,
                              'occasion_id' => $oc->id,
                              ]);
                              if(!empty($oc->user->device_token)) {
                                      NotificationsRepository::pushNotification($oc->user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $notification->user_id, 'status' => 'تم قبول مناسبتك  للعامة   ','occasion_id'=> $oc->id]);
                                  }   
                       // }
                      
                        foreach($publicInvitation as $publicInvt){
                               $notification1 = Notification::create([
                                  'user_id' => $publicInvt->id,
                                  'content' => ' مناسبة جديدة '. $oc->name_occasion,
                                  'section_id' => $oc->section_id,
                                  'occasion_id' => $oc->id,
                                  ]);
                                 if (!empty($publicInvt->device_token)) {
                                      NotificationsRepository::pushNotification($publicInvt->device_token, 'تعليق جديد', $notification->content, ['user_id' => $publicInvt->id, 'status' =>' مناسبة جديدة','occasion_id'=> $oc->id]);
                                  }
                          }
                            
                          return response()->json([ 'msg'=>'success' , 
                                   'data' => [
                                     "occasions" => $oc,
                                      "notification" => $notification,
                                      "notification1" => $notification1,
                                    ] 
                                    
                                    ]);
                    }elseif($oc->is_public == 0){
                       
                        $sectionInvitation = User::where([['section_id' , $oc->section_id],['type',0]])->get();
                       // dd($sectionInvitation);
                        //foreach($getDeviceTokens as $getDeviceToken){
                            $notification = Notification::create([
                              'user_id' => $user->id,
                              'content' => ' تم قبول مناسبتك للنشر لاعضاء القسم  '. $oc->name_occasion,
                              'section_id' => $oc->section_id,
                              'occasion_id' => $oc->id,
                              ]);
                           if(!empty($user->device_token)) {
                              NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $user->id, 'status' => '  تم قبول مناسبتك لاعضاء القسم  ', 'occasion_id'=> $oc->id ]);
                          }     
                        //}
                       // dd($notification);
                        foreach($sectionInvitation as $secInvt){
                            
                               $notification1 = Notification::create([
                                  'user_id' => $secInvt->id,
                                  'content' => ' مناسبة جديدة '. $oc->name_occasion,
                                  'section_id' => $oc->section_id,
                                  'occasion_id' => $oc->id,
                                  ]);
                                 if (!empty($secInvt->device_token)) {
                                      NotificationsRepository::pushNotification($secInvt->device_token, 'تعليق جديد', $notification->content, ['user_id' => $secInvt->id, 'status' =>'مناسبة جديدة', 'occasion_id' => $oc->id ]);
                                  }
                          }
                       
                          return response()->json([ 'msg'=>'success' , 
                                   'data' => [
                                      "occasions" => $oc,
                                      "notification" => $notification,
                                      //"occasionNotification" => $notification->occasions,
                                      
                                      "notification1" => $notification1,
                                     // "occasionsNotification1" => $notification1->occasions,
                                    ] 
                                    
                                    ]);
                    }elseif($oc->is_public == 2){
                         $occasionUser = OccasionsUser::where('occasions_id', $oc->id )->pluck('user_id')->toArray();
                        //dd($occasionUser);
                          //  foreach($getDeviceTokens as $getDeviceToken){
                              $notification = Notification::create([
                                      'user_id' => $oc->user_id,
                                      'content' => ' تم قبول مناسبتك للنشر لاعضاء مخصصين '. $oc->name_occasion,
                                      'section_id' => $getDeviceTokens->section_id,
                                      'occasion_id' => $oc->id,
                                      ]);
                                   if(!empty($getDeviceTokens->device_token)) {
                                      NotificationsRepository::pushNotification($getDeviceTokens->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceTokens->id, 'status' => 'تم قبول مناسبتك للاعضاء المخصصين   ' , 'occasion_id' => $oc->id ]);
                                  }
                                
                           // }
                          foreach($occasionUser as $ocuser){
                              //dd($ocuser);
                               $user = User::where('id', $ocuser )->first();
                              $notification1 = Notification::create([
                              'user_id' => $ocuser,
                              'content' => ' مناسبة جديدة '. $oc->name_occasion,
                              'section_id' => $oc->section_id,
                              'occasion_id' => $oc->id,
                              ]);
                               if(!empty($user->device_token)) {
                                  NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $user->id, 'status' => 'تم قبول مناسبتك للاعضاء المخصصين   ' , 'occasion_id' => $oc->id ]);
                              } 
                          }
                          return response()->json([ 'msg'=>'success' , 
                                   'data' => [
                                      "occasions" => $oc,
                                       "notification" => $notification,
                                       "notification1" => $notification1,
                                    ] 
                                    
                                    ]);
                }
                }

    }
    public function headDecision(Request $request)
    {
        $user = auth()->guard('api')->user();
        $validator= validator()->make($request->all(),[
            'is_public' => 'required', 
            'is_accepted' => 'required', 
            ]);
            
           if($validator->fails()){
           
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
        }

        $occasions = Occasions::where(['id' => $request->id])->first();
        //dd($occasions->user_id);
        $getDeviceTokens = User::where('id', $occasions->user_id)->first();
        //dd($getDeviceTokens);
        if(is_null($occasions)){
            return response()->json(['msg'=>false ,'data'=>'not found recourd']);
        }
        
        $invitationUser_ids = $request->input('invitationUser_ids');
        $occasions->name_occasion  = isset($request->name_occasion)? $request->name_occasion : $occasions->name_occasion  ;
        $occasions->name_owner   =   isset($request->name_owner)? $request->name_owner : $occasions->name_owner ;
        $occasions->date   =         isset($request->date)? $request->date : $occasions->date ;
        $occasions->time   =         isset($request->time)? $request->time : $occasions->time ;
        $occasions->address   =      isset($request->address)? $request->address : $occasions->address ;
        $occasions->lng   =          isset($request->lng)? $request->lng : $occasions->lng ;
        $occasions->lat   =          isset($request->lat)? $request->lat : $occasions->lat ;
        $occasions->section_id   =   isset($request->section_id)? $request->section_id : $occasions->section_id ;
        $occasions->is_public   =    isset($request->is_public)? $request->is_public : $occasions->is_public ;
        $occasions->user_id    =     isset($request->user_id)? $request->user_id : $occasions->user_id ;
        $occasions->is_accepted   =  isset($request->is_accepted)? $request->is_accepted : $occasions->is_accepted;
        $occasions->check_manger   = 1;
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/occasions'), $filename);
            $occasions->image = $filename;
        }
        $occasions->save(); 
        
        $occasions->invitationUser()->sync($invitationUser_ids);
        if($occasions->is_accepted == 1 ){
                if($occasions->is_public == 1){
            $publicInvitation = User::all();
           // foreach($getDeviceTokens as $getDeviceToken){
                $notification = Notification::create([
                  'user_id' => $occasions->user_id,
                  'content' => ' تم قبول مناسبتك للنشر للعامة '. $occasions->name_occasion,
                  'section_id' => $getDeviceTokens->section_id,
                  'occasion_id' => $occasions->id,
                  ]);
                   if (!empty($occasions->user->device_token)) {
                      NotificationsRepository::pushNotification($occasions->user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $user->id, 'status' => ' تم قبول مناسيتك للعامة' , 'occasion_id' => $occasions->id ]);
                  }      
           // }
          
            foreach($publicInvitation as $publicInvt){
                   $notification1 = Notification::create([
                      'user_id' => $publicInvt->id,
                      'content' => ' مناسبة جديدة '. $occasions->name_occasion,
                      'section_id' => $occasions->section_id,
                      'occasion_id' => $occasions->id,
                      ]);
                     if (!empty($publicInvt->device_token)) {
                          NotificationsRepository::pushNotification($publicInvt->device_token, 'تعليق جديد', $notification->content, ['user_id' => $publicInvt->id, 'status' =>'مناسبة جديدة' , 'occasion_id' => $occasions->id]);
                      }
              }
                
              return response()->json([ 'msg'=>'success' , 
                       'data' => [
                         "occasions" => $occasions,
                          "notification" => $notification,
                          "notification1" => $notification1,
                        ] 
                        
                        ]);
                }elseif($occasions->is_public == 0){
                   
                    $sectionInvitation = User::where('section_id' , $occasions->section_id)->get();
                    // dd($sectionInvitation);
                   // foreach($getDeviceTokens as $getDeviceToken){
                        $notification = Notification::create([
                          'user_id' => $occasions->user_id,
                          'content' => ' تم قبول مناسبتك للنشر لاعضاء القسم '. $occasions->name_occasion,
                          'section_id' => $getDeviceTokens->section_id,
                          'occasion_id' => $occasions->id,
                          ]);
                       if(!empty($getDeviceToken->device_token)) {
                          NotificationsRepository::pushNotification($getDeviceTokens->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceTokens->id, 'status' => '  تم قبول مناسبتك لاعضاء القسم  ' , 'occasion_id' => $occasions->id ]);
                      }     
                  //  }
                    
                    foreach($sectionInvitation as $secInvt){
                           $notification1 = Notification::create([
                              'user_id' => $secInvt->id,
                              'content' => ' مناسبة جديدة '. $occasions->name_occasion,
                              'section_id' => $occasions->section_id,
                              'occasion_id' => $occasions->id,
                              ]);
                             if (!empty($publicInvt->device_token)) {
                                  NotificationsRepository::pushNotification($secInvt->device_token, 'تعليق جديد', $notification->content, ['user_id' => $secInvt->id, 'status' =>'مناسبة جديدة' , 'occasion_id' => $occasions->id ]);
                              }
                      }
                   
                      return response()->json([ 'msg'=>'success' , 
                               'data' => [
                                  "occasions" => $occasions,
                                  "notification" => $notification,
                                  "notification1" => $notification1,
                                ] 
                                
                                ]);
                }elseif($occasions->is_public == 2){
                     $occasionUser = OccasionsUser::where('occasions_id', $occasions->id )->pluck('user_id')->toArray();
                    
                        //foreach($getDeviceTokens as $getDeviceToken){
                          $notification = Notification::create([
                                  'user_id' => $occasions->user_id,
                                  'content' => ' تم قبول مناسبتك للنشر لاعضاء مخصصين '. $occasions->name_occasion,
                                  'section_id' => $getDeviceTokens->section_id,
                                  'occasion_id' => $occasions->id,
                                  ]);
                               if(!empty($user->device_token)) {
                                  NotificationsRepository::pushNotification($getDeviceTokens->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceTokens->id, 'status' => 'تم قبول مناسبتك للاعضاء المخصصين   ' , 'occasion_id' => $occasions->id ]);
                              }
                            
                        //}
                      foreach($occasionUser as $ocuser){
                           $user = User::where('id', $ocuser )->first();
                          $notification1 = Notification::create([
                          'user_id' => $ocuser,
                          'content' => ' مناسبة جديدة '. $occasions->name_occasion,
                          'section_id' => $user->section_id,
                          'occasion_id' => $occasions->id,
                          ]);
                           if(!empty($user->device_token)) {
                              NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $user->id, 'status' => 'تم قبول مناسبتك للاعضاء المخصصين   ' , 'occasion_id' => $occasions->id ]);
                          } 
                      }
                      return response()->json([ 'msg'=>'success' , 
                               'data' => [
                                  "occasions" => $occasions,
                                   "notification" => $notification,
                                   "notification1" => $notification1,
                                ] 
                                
                                ]);
                }
                
           
        
        }elseif($occasions->is_accepted == 0){
            if($occasions->is_public == 3){
              //  foreach($getDeviceTokens as $getDeviceToken){
                $notification = Notification::create([
                  'user_id' => $occasions->user_id,
                  'content' => ' تم رفض المناسبة الخاصة بك '. $occasions->name_occasion,
                  'section_id' => $getDeviceTokens->section_id,
                  'occasion_id' => $occasions->id,
                  ]);
               if(!empty($user->device_token)) {
                  NotificationsRepository::pushNotification($getDeviceTokens->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceTokens->id, 'status' => 'تم رفض المناسبه الخاصة بك   ' , 'occasion_id' => $occasions->id ]);
              }
           // }
          
              return response()->json([ 'msg'=>'success' , 
                       'data' => [
                          "occasions" => $occasions,
                           "notification" => $notification,
                        ] 
                        
                        ]);
            }
             
        }elseif($occasions->is_accepted == 2 ){
            if($occasions->is_public == 4){
          //   foreach($getDeviceTokens as $getDeviceToken){
                $notification = Notification::create([
                  'user_id' => $occasions->user_id,
                  'content' => '  مناسبتك قيد الانتظار '. $occasions->name_occasion,
                  'section_id' => $getDeviceTokens->section_id,
                  'occasion_id' => $occasions->id,
                  ]);
               if(!empty($user->device_token)) {
                  NotificationsRepository::pushNotification($getDeviceTokens->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceTokens->id, 'status' => 'مناسبتك قيد الانتظار   ' , 'occasion_id' => $occasions->id ]);
              }
           // }
          
              return response()->json([ 'msg'=>'success' , 
                       'data' => [
                          "occasions" => $occasions,
                           "notification" => $notification,
                        ] 
                        
                        ]);
            }
        }
       
        
    }
    public function getOccasionsId(Request $request)
    {
       // dd($request->id);
        $occasions = Occasions::where([ ['id', $request->id]])->first();
     
    
        return response()->json(['msg'=>'success','data' => $occasions]);
    }
//  public function getComments(Request $request)
//     {
//       // dd($request->id);
//         $occasions = Occasions::where([ ['id', $request->id]])->first();
//         $comments = Notification::where([['is_comment', 1], ['occasion_id', $occasions->id]])->first();
     
    
//         return response()->json(['msg'=>'success','data' => $comments]);
//     }
    public function update(Request $request)
    {
        
        $user = auth()->guard('api')->user();
        $validator= validator()->make($request->all(),[
           'name_occasion' => 'required',   
            'name_owner' => 'required',   
            'date' => 'required',   
            'time' => 'required',   
            'address' => 'required',   
            'section_id' => 'required', 
            'is_public' => 'required', 
            ]);
            
           if($validator->fails()){
           
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
        }
        $occasions = Occasions::where(['user_id'=>$user->id , 'id' => $request->id])->first();
        if(is_null($occasions)){
            return response()->json(['msg'=>false ,'data'=>'not found recourd']);
        }
        $invitationUser_ids = $request->input('invitationUser_ids');
        $occasions->name_occasion  = $request->name_occasion;
        $occasions->name_owner   = $request->name_owner;
        $occasions->date   = $request->date;
        $occasions->time   = $request->time;
        $occasions->address   = $request->address;
        $occasions->lng   = $request->lng;
        $occasions->lat   = $request->lat;
        $occasions->section_id   = $request->section_id;
        $occasions->is_public   = $request->is_public;
        $occasions->user_id   = $user->id;
        $occasions->check_manger   = 0 ;
        if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/occasions'), $filename);
            $occasions->image = $filename;
        }
        $occasions->save(); 
        $occasions->invitationUser()->sync($invitationUser_ids);
        
         $admin = Admin::where([['section_id', $occasions->section_id],['is_manger', 0]])->first();
         $notification = Notification::create([
                  'user_id' => $admin->id,
                  'content' => 'تم  تعديل  بيانات المناسبه  '. $occasions->name_occasion,
                  'section_id' => $occasions->section_id,
                  'occasion_id' => $occasions->id,
                  ]);
         if(!empty($user->device_token)) {
                  NotificationsRepository::pushNotification($admin->device_token, 'تعليق جديد', $notification->content, ['user_id' => $admin->id, 'status' => 'طلب تعديل مناسبة   ' , 'occasion_id' => $occasions->id ]);
              }
        return response()->json([ 'msg'=>'success' , 
                       'data' => [
                          "id" => $occasions->id,
                          "name_occasion" => $occasions->name_occasion,
                          "name_owner"=> $occasions->name_owner,
                          "date"=>  $occasions->date,
                          "time"=>$occasions->time,
                          "address"=>$occasions->address,
                          "lng"=>$occasions->lng,
                          "lat"=>$occasions->lat,
                          "is_public"=>$occasions->is_public,
                          "section_id"=>$occasions->section_id ,
                          "image" =>$occasions->image,
                          "user_id"=> $occasions->user_id ,
                          "invitationUser" => $occasions->invitationUser(),
                        ] 
                        
                        ]);
    }
     public function sendComment(Request $request){
         
        $user = auth()->guard('api')->user();
       $occasions = Occasions::where([ ['id', $request->id]])->first();
      // dd($occasions);
       $name = DB::table('codes')->where('id',$user->code_id)->value('name');
       //dd($name);
       //$userSendCom = User::where([ ['id', $request->user_id]])->first();
      // dd($occasions);
       if($occasions)
        $notification = Notification::create([
                  'user_id' => $user->id,
                  'content' =>  $request->content,
                  'section_id' => $occasions->section_id,
                  'occasion_id' => $occasions->id,
                  'is_comment' => 1 ,
                  ]);
        $content = ' ارسل ' . $name . ' ' . $notification->content ;
         if(!empty($occasions->user->device_token)) {
                  NotificationsRepository::pushNotification($occasions->user->device_token, 'تعليق جديد', $content, ['user_id' =>  $occasions->user_id, 'status' => 'تعليق جديد     ' , 'occasion_id' => $occasions->id ]);
              }
        return response()->json([ 'msg'=>'success' , 'data' => [
            "occasions" => $occasions,
            "name" => $name,
            "notification" => $notification ,
                
            ] ]);
    }
    
    public function ocid(Request $request){
        
       $occasions = Occasions::where('id', $request->id)->first();
     //  dd($occasions);
        return response()->json([ 'msg'=>'success' , 'data' => $occasions ]);
    }
    public function getComments(Request $request){
        $user = auth()->guard('api')->user(); 
       $arr = array();
       $occasions = Occasions::where('id', $request->id)->first();
       $comments = Notification::where('occasion_id', $occasions->id)->where('is_comment',1)->get();
       foreach($comments as $comment)
       {
             $codeid = User::where('id',$comment->user_id)->value('code_id');
            //dd($codeid);
            $name = DB::table('codes')->where('id',$codeid )->value('name');
            // dd($name);
           $userimage = User::where('id',$comment->user_id)->value('image');
           array_push($arr,array(
               "id"=>$comment->id,
               "content"=>$comment->content,
               "user_id"=>$comment->user_id,
               "username"=>$name,
               "userimage"=>$userimage,
               "section_id"=>$comment->section_id,
               "occasion_id"=>$comment->occasion_id,
               "is_comment"=>$comment->is_comment,
               "created_at"=>$comment->created_at->diffForHumans(),
               "updated_at"=>$comment->updated_at->diffForHumans(),
               
               
               ));
       }
     //  dd($occasions);
        return response()->json([ 'msg'=>'success' , 'data' => $arr ]);
    }
    public function getAuthNotification(){
        $user = auth()->guard('api')->user();
        $notification = Notification::where('user_id',$user->id)->get();
         return response()->json([ 'msg'=>'success' , 'data' => [
            "notification" => $notification,
            ] ]);
        
    }
    
    public function destroy(Request $request){
        
        $occasions = Occasions::where([ ['id', $request->id]])->first();
        if(is_null($occasions)){
    		return response()->json(['msg'=>'not found recourd' , 'data' => 404]);
    	}
    	$occasions->delete();
       //dd($occasions);
      
        
        return response()->json([ 'msg'=>'deleted' , 'data' => 402 ]);
    }
   public function destroyNotfy(Request $request){
        
        $noty = Notification::where([ ['id', $request->id]])->first();
        if(is_null($noty)){
    		return response()->json(['msg'=>'not found recourd' , 'data' => 404]);
    	}
    	$noty->delete();
       //dd($occasions);
      
        
        return response()->json([ 'msg'=>'deleted' , 'data' => 402 ]);
    }
}