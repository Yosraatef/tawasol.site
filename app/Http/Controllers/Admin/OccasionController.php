<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Occasions;
use App\OccasionsUser;
use App\Section;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Session;
use App\Notification;
use App\Repository\NotificationsRepository;
class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       

         $occasions = Occasions::paginate(10);   
        
         
         return view('admin.occasions.show',compact('occasions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $sections = Section::all();
        $users = User::all();
         return view('admin.occasions.create',compact('sections','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $rules = [

            'name_occasion' => 'required',   
            'name_owner' => 'required',   
            'date' => 'required',   
            'time' => 'required',   
            'address' => 'required',   
            'section_id' => 'required',   
            'user_id' => 'required', 
             
                 ];

        $this->validate($request , $rules);
       $data = $request->except(['user_id','section_id','lng','invitationUser_id','lat','image','is_accepted']);
                $invitationUser_ids =  $request->input('invitationUser_ids');
                $data['lng'] = $request->lng ;
                $data['lat'] = $request->lat ;
                $data['user_id'] = $request->user_id ;
                $data['section_id'] = $request->section_id ;
                $data['is_accepted'] = 1 ;
                if ($request->hasFile('image')) {
                    $filename = time() . '-' . $request->image->getClientOriginalName();
                    $request->image->move(public_path('pictures/occasions'), $filename);
                     $data['image']= $filename;
                }
                $oc = Occasions::create($data);
                
                if($invitationUser_ids){
                    foreach($invitationUser_ids as $tag)
                $oc->invitationUser()->attach($tag);    
                }
                
                 $getDeviceTokens = User::where('id', $oc->user_id)->get();
                    if($oc->is_public == 1){
                        $publicInvitation = User::all();
                        foreach($getDeviceTokens as $getDeviceToken){
                            $notification = Notification::create([
                              'user_id' => $oc->user_id,
                              'content' => 'تم  قبول  مناسبتك للنشر  للعامة'. $oc->name_occasion,
                              'section_id' => $getDeviceToken->section_id,
                              ]);
                               if (!empty($getDeviceToken->device_token)) {
                                  NotificationsRepository::pushNotification($getDeviceToken->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceToken->id, 'status' => ' تم قبول مناسيتك للعامة']);
                              }      
                        }
                      
                        foreach($publicInvitation as $publicInvt){
                               $notification1 = Notification::create([
                                  'user_id' => $publicInvt->id,
                                  'content' => 'مناسبة جديدة '. $oc->name_occasion,
                                  'section_id' => $oc->section_id,
                                  ]);
                                 if (!empty($publicInvt->device_token)) {
                                      NotificationsRepository::pushNotification($publicInvt->device_token, 'تعليق جديد', $notification->content, ['user_id' => $publicInvt->id, 'status' =>'مناسبة جديدة']);
                                  }
                          }
                            
                         
                    }elseif($oc->is_public == 0){
                       
                        $sectionInvitation = User::where('section_id' , $oc->section_id)->get();
                        // dd($sectionInvitation);
                        foreach($getDeviceTokens as $getDeviceToken){
                            $notification = Notification::create([
                              'user_id' => $oc->user_id,
                              'content' => 'تم  قبول  مناسبتك للنشر   لأعضاء  القسم'. $oc->name_occasion,
                              'section_id' => $getDeviceToken->section_id,
                              ]);
                           if(!empty($getDeviceToken->device_token)) {
                              NotificationsRepository::pushNotification($getDeviceToken->device_token, 'تعليق جديد', $notification->content, ['user_id' => $user->id, 'status' => '  تم قبول مناسبتك لاعضاء القسم  ']);
                          }     
                        }
                        
                        foreach($sectionInvitation as $secInvt){
                               $notification1 = Notification::create([
                                  'user_id' => $secInvt->id,
                                  'content' => 'مناسبة جديدة '. $oc->name_occasion,
                                  'section_id' => $oc->section_id,
                                  ]);
                                 if (!empty($publicInvt->device_token)) {
                                      NotificationsRepository::pushNotification($secInvt->device_token, 'تعليق جديد', $notification->content, ['user_id' => $secInvt->id, 'status' =>'مناسبة جديدة']);
                                  }
                          }
                       
                        
                    }elseif($oc->is_public == 2){
                         $occasionUser = OccasionsUser::where('occasions_id', $occasions->id )->pluck('user_id')->toArray();
                        
                            foreach($getDeviceTokens as $getDeviceToken){
                              $notification = Notification::create([
                                      'user_id' => $oc->user_id,
                                      'content' => 'تم  قبول  مناسبتك للنشر   لأعضاء  '. $oc->name_occasion,
                                      'section_id' => $getDeviceToken->section_id,
                                      ]);
                                   if(!empty($user->device_token)) {
                                      NotificationsRepository::pushNotification($getDeviceToken->device_token, 'تعليق جديد', $notification->content, ['user_id' => $getDeviceToken->id, 'status' => 'تم قبول مناسبتك للاعضاء المخصصين   ']);
                                  }
                                
                            }
                          foreach($occasionUser as $ocuser){
                               $user = User::where('id', $ocuser )->first();
                              $notification1 = Notification::create([
                              'user_id' => $ocuser,
                              'content' => 'مناسبة جديدة'. $oc->name_occasion,
                              'section_id' => $user->section_id,
                              ]);
                               if(!empty($user->device_token)) {
                                  NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->content, ['user_id' => $user->id, 'status' => 'تم قبول مناسبتك للاعضاء المخصصين   ']);
                              } 
                          }
                         
                }
        Session::flash('message','تم انشاء موضوع جديد ');
        return redirect()->route('occasions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $occasions = Occasions::where('id',$id)->first();
          $sections = Section::all();
          $users = User::all();
          $occasionUser = OccasionsUser::where('occasions_id', $id )->pluck('user_id')->toArray();
        //  dd($occasionUser);
        return view('admin.occasions.edit',compact('occasions','sections','users','occasionUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $rules = [
           
            'name_occasion' => 'required',   
            'name_owner' => 'required',   
            'date' => 'required',   
            'time' => 'required',   
            'section_id' => 'required',   
            'user_id' => 'required',
        ];
        $this->validate($request ,$rules );
        $occasions = Occasions::findOrFail($id);
         $invitationUser_ids = $request->input('invitationUser_ids');
        $occasions->name_occasion  = isset($request->name_occasion)? $request->name_occasion : $occasions->name_occasion ;
        $occasions->name_owner   = $request->name_owner;
        $occasions->date   = $request->date;
        $occasions->time   = $request->time;
        $occasions->address   = isset($request->address)? $request->address : $occasions->address ;
        $occasions->lng   = isset($request->lng)? $request->lng : $occasions->lng  ;
        $occasions->lat   = isset($request->lat)? $request->lat : $occasions->lat ;
        $occasions->section_id   = $request->section_id;
        $occasions->is_public   = $request->is_public;
        $occasions->user_id   = $request->user_id;
        if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/occasions'), $filename);
            $occasions->image = $filename;
        }
        $occasions->save(); 
        $occasions->invitationUser()->sync($invitationUser_ids);
        Session::put('message','تم تعديل   القسم');
        return redirect()->route('occasions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $occasions = Occasions::findOrFail($id);
        $occasions->delete();
        Session::flash('message','تم  المسح بنجاح');
        return redirect()->back();
    }
}