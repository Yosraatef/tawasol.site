<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Occasions;
use App\Notification;
class NotificationController extends Controller
{
     public function notificationFromUserToManger(){
      $user = auth()->guard('api')->user();
      $occasions = Occasions::where([['user_id',$user->id]])->get();
       foreach($occasions as $oc){
       	$admin = Admin::where([['section_id', $oc->id],['is_manger', 1]])->first();
          if($oc->check_manger == 0){
            
             $notification = Notification::create([
                  'user_id' => $admin->id,
                  'content' =>'تم  انشاء  حدث  جديد  من  قبل '. $user->name,
                  'section_id' => $user->section_id,
                  ]);
          
               if (!empty($user->device_token)) {
                  
                  NotificationsRepository::pushNotification($admin->device_token, 'تعليق جديد', $notification->content, ['user_id' => $admin->id, 'status' => 'الفاتورة على وشك الانتهاء']);
              }
              return response()->json(['msg'=>'success','data' =>$notification]);
               
          } else {
           echo 'Coupon is Expired';
          }

        }

    }

}
