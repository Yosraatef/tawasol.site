<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Setting;
class SettingController extends Controller
{
    private $keys = array("aboutApp","aboutApp2","aboutApp3","conditions","who");
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {

        $settings = Setting::whereIn('key',$this->keys)->get(["key","value"]);
        $settings_data=array();
        foreach ($settings as $item){
            $settings_data[$item->key]=$item->value;
        }
        return view('admin.settings.create',compact('settings_data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
// dd($request->all());
        foreach ($this->keys as $key) {
            // dd($key);
            if($request->has($key) && !is_null($request->$key)){
              Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->$key]
                );  
            } 
            }

        Session::flash('message','تم انشاء اعدادت جديدة');
        return redirect()->route('settings.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
            }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
