<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;

class DropdownController extends Controller
{
    function index(){
        $list= DB::table('tb_pjname')->get();
        return view('province')->with('list', $list);
    }
    function fetct(Request $request){
         $id= $request->get('select');
         $result=array();
         $query=DB::table('tb_pjname')
        ->join ('tb_dropdown','tb_pjname.id','=', 'tb_dropdown.name_id')
        ->select('tb_dropdown.name')
        ->where ('tb_pjname.id',$id)
        ->groupBY('tb_dropdown.name')
        ->get();
        $output='<option value="">ประเภทการขนส่ง</option>';
        foreach ($query as $row){
            $output.='<option value=""'.$row->name.'">'.$row->name.'</option>';
        }
        echo $output;
        }
}
