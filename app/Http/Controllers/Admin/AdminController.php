<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Code;
use App\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
    }

   
 public function store(Request $request){

      //validate

        $rules = [

            'email'     => 'required|email',
            'password'  => 'required|min:6'

            ];

        $this->validate($request , $rules);


        $credentials = $request->only('email','password');

        if(! Auth::guard('admin')->attempt($credentials)){

            return back()->withErrors([
                'message' => 'Wrong credentials please try Again '
            ]);

        }

        //Session
        Session::flash('message' , 'تم تسجيل الدخول بشكل ناجح');


        //redirect
        return redirect()->route('admin.users');

    }
    public function show_users(){

        $users = User::all();
        $sections = Section::all();
         $codes = Code::all();
        return view('admin.admins.index' , compact('users','sections','codes'));


    }
    public function store_users(Request $request){
        
        $rules = [
            
            'code_id'     => 'required|unique:users|exists:codes,id',
            'password'  => 'required|min:6',
        ];

        $this->validate($request , $rules);
         $admin = new User;
    
        // $admin->name  = $request->name;
        $admin->email   = $request->email;
        $admin->password   = bcrypt($request->password);
        $admin->type   = isset($request->type)? $request->type : 1   ;
        $admin->code_id    = $request->code_id  ;
        $admin->api_token   = Str::random(60);
        $admin->section_id   = $request->section_id;
       $images = $request['image'];
            
         if($images)
        {
            $img_name = rand(0, 999) . '.' . $images->getClientOriginalExtension();
            $images->move(public_path('pictures/profile'), $img_name);
          
        $admin->image = $img_name;
        	}
        //dd($request->image);
         $admin->save();
            if($admin){
            $code = Code::where('id', $admin->code_id )->first();
            $admin->name = $code->name;
            $admin->phone = $code->phone;
            $admin->code_job = $code->code;
            $admin->save();
        }
        Session::flash('message' , 'تم تسجيل الشخص في لوحة التحكم');
        return redirect()->route('admin.users');

    }
    public function edit_users($id){
        $user = Admin::findOrFail($id);
        $sections = Section::all();
        $codes = Code::all();
        return view('admin.admins.edit',compact('user','sections','codes'));
    }


    public function update_users(Request $request , $id){

      $admin = User::findOrFail($id);
       $rules = [
            
            'code_id'     => 'required|exists:codes,id',
            'password'  => 'required|min:6'
        ];
        $this->validate($request ,$rules );

        
        $admin->name  = $request->name;
        $admin->email   = $request->email;
        $admin->password   = bcrypt($request->password);
        $admin->type   = 2  ;
       $admin->code_id  = $request->code_id;
        $admin->api_token   = Str::random(60);
        $admin->section_id   = $request->section_id;
       $images = $request['image'];
            
         if($images)
        {
            $img_name = rand(0, 999) . '.' . $images->getClientOriginalExtension();
            $images->move(public_path('pictures/profile'), $img_name);
          
        $admin->image = $img_name;
        	}
        //dd($request->image);
         $admin->save();
        if($admin){
            $code = Code::where('id', $admin->code_id )->first();
            $admin->name = $code->name;
            $admin->phone = $code->phone;
            $admin->code_job = $code->code;
            $admin->save();
        }
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('admin.users');

    }

    public function delete_users($id){

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        Session::flash('message','You have been Logged Out ');
        return redirect()->route('admin.login');
    }
   
   
}