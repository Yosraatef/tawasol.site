<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Code;
use App\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class CodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $codes = Code::paginate(15);
        
         return view('admin.codes.show',compact('codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //$sections = Section::all();
         return view('admin.codes.create');
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

            'name'     => 'required',
            'phone'     => 'required',
            'code'     => 'required|unique:codes',
           

            ];

        $this->validate($request , $rules);
         $code = new Code;
    
        $code->name  = $request->name;
        $code->phone  = $request->phone;
        $code->code  = $request->code;
        $code->save();

        
        //Session
        Session::flash('message' , 'تم  الاضافة بشكل ناجح');
        //redirect
        return redirect()->route('codes.index');
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
        $code = Code::where('id',$id)->first();
       // $sections = Section::all();
        return view('admin.codes.edit',compact('code'));
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
           'name'     => 'required',
            'phone'     => 'required',
            'code'     => 'required',
        ];
        $this->validate($request ,$rules );
        $code = Code::findOrFail($id);
         $code->name  = $request->name;
        $code->phone  = $request->phone;
        $code->code   = $request->code;
       
        $code->save();

        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('codes.index');
    }

   
    public function destroy($id)
    {
       $code = Code::findOrFail($id);

        $code->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}