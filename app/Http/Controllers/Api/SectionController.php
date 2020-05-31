<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
class SectionController extends Controller
{
    public function getAllSection()
    {
        $arr = array();
        $sections = Section::all();
        foreach($sections as $sec){
            array_push($arr, array(
                  "id"=> $sec->id,
                  "name" => $sec->name,
                  
                  
            ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
    }

   
}
