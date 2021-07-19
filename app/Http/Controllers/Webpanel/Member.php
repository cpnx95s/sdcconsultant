<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

use App\MemberModel;
use App\ProvincesModel;
use App\DistrictModel;
use App\SubdistrictModel;
use App\AddressModel;

class Member extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'member';
    protected $folder = 'member';

    public function imageSize($type=null)
    {
        $size =[
            'cover' => ['lg' => ['x'=>210,'y'=>209],'md' => ['x'=>555,'y'=>282.5],'sm' => ['x'=>277.5,'y'=>141.25]],
            'gallery' => ['lg' => ['x'=>800,'y'=>534],'md' => ['x'=>397,'y'=>265],'sm' => ['x'=>277.5,'y'=>141.25]]
        ];
        switch ($type) {
            case 'cover':
                return $size['cover'];
                break;
            case 'gallery':
                return $size['gallery'];
                break;
            default:
                return $size;
                break;
        }
    }

    public function index(Request $request)
    {
        $data = MemberModel::orderBy('id');
        if($request->view=='all')
        {
            $rows = $data->get();
        }else{
            $view = ($request->view)? $request->view : 10;
            $rows = $data->paginate($view);
        }
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/member.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'page' => 'index',
            'segment' => $this->segment,
            'rows' => $rows,
        ]);
    }

    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index",[
            'css' => ['back-end/css/table-responsive.css','back-end/css/validate.css'],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ['src'=>"back-end/tinymce/tinymce.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/member.js"],

            ],
            'prefix' => $this->prefix,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => $this->segment,
            'size'=>$this->imageSize()
        ]);
    }

    public function store(Request $request)
    {
        $data = new MemberModel;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->username = $request->username;
        $data->password = bcrypt($request->password);
        $data->status = 'on';
        $data->created_at = date('Y-m-d H:i:s');
        
        if($data->save())
        {
            if($request->address){
                for($i=0; $i<count($request->address); $i++ )
                {
                    $new = new AddressModel;
                    $new->_id = $data->id;
                    $new->address = $request->address[$i];
                    $new->provinces = $request->provinces[$i];
                    $new->district = $request->district[$i];
                    $new->subdistrict = $request->subdistrict[$i];
                    $new->postcode = $request->postcode[$i];
                    $new->save();
                }
            }
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->segment/member")]);
        }else{
            return view("$this->prefix.alert.sweet.error",['url'=>$request->fullUrl()]);
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $row = MemberModel::find($id);
        $address = AddressModel::where('_id',$row->id)->get();
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ['src'=>"back-end/tinymce/tinymce.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/member.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'size' => $this->imageSize(),
            'segment' => $this->segment,
            'row' => $row,
            'address' => $address
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = MemberModel::find($id);
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->updated_at = date('Y-m-d H:i:s');
        
        if($data->save()){
            $addressid = $request->address_id;
            if($addressid){
                for($i = 0 ; $i < count($addressid); $i++ )
                {
                    $addr = AddressModel::find($addressid[$i]);
                    $addr->address = $request->address[$i];
                    $addr->provinces = $request->provinces[$i];
                    $addr->district = $request->district[$i];
                    $addr->subdistrict	 = $request->subdistrict[$i];
                    $addr->postcode	 = $request->postcode[$i];
                    $addr->save();
                }
    
            }
            $start = ($addressid)?count($addressid):0;
            if($request->address){
                for($i=$start; $i<count($request->address); $i++ )
                {
                    $new = new AddressModel;
                    $new->_id = ($data->id);
                    $new->address = $request->address[$i];
                    $new->provinces = $request->provinces[$i];
                    $new->district = $request->district[$i];
                    $new->subdistrict = $request->subdistrict[$i];
                    $new->postcode = $request->postcode[$i];
                    $new->save();
                }
            
            }
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->segment/member")]);
        }else{
            return view("$this->prefix.alert.sweet.error",['url'=>$request->fullUrl()]);
        }
    }

    public function destroy(Request $request)
    {
        $datas = MemberModel::find($request->id);
        if(@$datas)
        {
            foreach($datas as $data)
            {
                $address = AddressModel::where('_id',$data->id)->get();
                foreach($address as $k => $g)
                {
                    AddressModel::destroy($g->id);
                }
                Storage::disk('public')->delete($data->image);
                //destroy
                $query = MemberModel::destroy($data->id);
            }
        }

        if(@$query){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function exist(Request $request)
    {
        $data = \App\MemberModel::where('username',$request->username)->count();
        if($data){ 
            return response()->json(false); 
        }else{ 
            return response()->json(true);
        }
    }

    public function checkUserOnReset(Request $request)
    {
        $data = \App\MemberModel::where('username','!=',$request->username)->count();
        if($data){ 
            // return response()->json(false); 
            $check = \App\MemberModel::where('username',$request->username)->count();
            if($check){
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else{ 
            return response()->json(true);
        }
    }

    public function getdistrict(Request $request)
    {
        
        $data = DistrictModel::where('_id',$request->id)->get();
        $text = '';
        if($data){
             foreach($data as $d){
                 $text .= '<option value="'.$d->id.'" >'.$d->name_th.'</option>';
             }
             return $text ;
        }
        return [];
        
    }


    public function getsubdistrict(Request $request)
    {
        $data = SubdistrictModel::where('_id',$request->id)->get();
        $text = '';
        if($data){
            foreach($data as $ds){
                $text .= '<option value="'.$ds->id.'" data-postcode="'.$ds->zipcode.'">'.$ds->name_th.'</option>';
            }
            return $text;
        }
        return [];
    }

    public function getprovinces()
    {
        $pro = ProvincesModel::get();
        $text = '';
        if($pro)
        {
            foreach($pro as $p){
                $text .= '<option value="'.$p->id.'" >'.$p->name_th.'</option>';
            }
            return $text;
        }
        return [];
    }

    public function reset($id)
    {
        return view("$this->prefix.pages.member.index",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
                'back-end/css/table-responsive.css','back-end/css/validate.css',
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/member.js"],
                
            ],
            'prefix' => $this->prefix,
            'folder' => 'member',
            'page' => 'reset',
            'segment' => $this->segment,
            'row' => MemberModel::find($id)
        ]);
    }

    public function onReset(Request $request,$id=null)
    {
        $data = \App\MemberModel::find($id);
        if($request->username){
            $data->username = $request->username;
        }
        $data->password = bcrypt($request->password);
        $data->updated_at = date('Y-m-d H:i:s');
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success",['url'=>$request->fullUrl()]);
        }else{
            return view("$this->prefix/alert/sweet/error",['url'=>$request->fullUrl()]);
        }
    }
}
