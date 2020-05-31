<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Section;
use App\Code;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        
         return view('admin.users.show',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $sections = Section::all();
        $codes = Code::all();
         return view('admin.users.create', compact('sections','codes'));
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

           
            'password' => 'required|min:6',
            'code_id'     => 'required|unique:users|exists:codes,id',
            

            ];

        $this->validate($request , $rules);
         $user = new User;
    
        // $user->name  = $request->name;
        // $user->phone  = $request->phone;
        $user->code_id  = $request->code_id;
        $user->is_active  = 1 ;
        $user->password   = bcrypt($request->password);
        $user->api_token   = Str::random(60);
        $user->section_id   = $request->section_id;
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
        //Session
        Session::flash('message' , 'تم تسجيل الدخول بشكل ناجح');
        //redirect
        return redirect()->route('users.index');
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
        $user = User::where('id',$id)->first();
        $sections = Section::all();
        $codes = Code::all();
        return view('admin.users.edit',compact('user','sections','codes'));
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
           
            'password' => 'required|min:6',
           
            'code_id'     => 'required|exists:codes,id',
        ];
        $this->validate($request ,$rules );
        $user = User::findOrFail($id);
        //  $user->name  = $request->name;
        // $user->phone  = $request->phone;
        $user->code_id  = $request->code_id;
        $user->is_active  = 1 ;
        $user->password   = bcrypt($request->password);
        $user->api_token   = Str::random(60);
        $user->section_id   = $request->section_id;
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
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('users.index');
    }

   
    public function destroy($id)
    {
       $user = User::findOrFail($id);

        $user->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}