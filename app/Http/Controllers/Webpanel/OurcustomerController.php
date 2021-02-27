<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\OurcustomerModel;

class OurcustomerController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'ourcustomer';
    protected $folder = 'ourcustomer';

    public function ImageSize($find=null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x'=>220,'y'=>119],
            ],
        ];
        if($find!=null){
            return $arr[$find];
        }else{
            return $arr;
        }
    }

    public function index(Request $request)
    {
        $data = OurcustomerModel::orderBy('sort');
        $view = ($request->view)? $request->view() : 10;
        if($request->view=='all')
        {
            $rows = $data->get();
        }else{            
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view]);
        }
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ['src'=>"back-end/js/table-dragger.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/ourcustomer.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'ourcustomer',
            'page' => 'index',
            'segment' => "$this->segment/ourcustomer",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ['src'=>'back-end/tinymce/tinymce.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/ourcustomer.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/ourcustomer",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new OurcustomerModel;
        $data->name = $request->name;
        $data->link = $request->link;
        $data->status = 'on';
        $data->sort = 1;
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if($file)
        {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
            // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $newLg = 'upload/ourcustomer/'.$filename.'-.'.$ext;
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }
        if($data->save())
        {
            OurcustomerModel::where('id','!=',$data->id)->increment('sort');
            return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segment/ourcustomer")]);
        }
        else
        {
                return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/ourcustomer/create")]);
        }
                
    }
    public function edit($id)
    {
        $row = OurcustomerModel::find($id);
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ['src'=>"back-end/tinymce/tinymce.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/ourcustomer.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => $row,
            'size' => $this->ImageSize(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = OurcustomerModel::find($id);
        $data->name = $request->name;
        $data->link = $request->link;
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if($file)
        {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();

            $newLg = 'upload/ourcustomer/'.$filename.'-.'.$ext;
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segment/$this->controller")]);
        }else{
            return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/$this->controller/".$id)]);
        }
    }

    public function destroy(Request $request)
    {
        $datas = OurcustomerModel::find(explode(',',$request->id));
        if(@$datas)
        {
            foreach($datas as $data)
            {
           
                OurcustomerModel::where('sort','>',$data->sort)->decrement('sort');
                //destroy
                $query = OurcustomerModel::destroy($data->id);
            }
        }
        if(@$query){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function status(Request $request,$id=null)
    {
        $get = OurcustomerModel::find($id);
        if(@$get->id){
            $status = ($get->status=='off')? 'on' : 'off' ;
            $get->status = $status;
            $get->save();
            if($get->id){
                return response()->json(true);
            }else{
                return response()->json(false);
            }
        }
    }
    public function dragsort(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $get = OurcustomerModel::find($request->id);
        if($from!="" && $to !="")
        {
            if($from > $to){
                OurcustomerModel::whereBetween('sort', [$to, $from])->whereNotIn("id",[$get->id])->increment('sort', 1);
            }else{
                OurcustomerModel::whereBetween('sort', [$from, $to])->whereNotIn("id",[$get->id])->decrement('sort', 1);
            }
            $query = OurcustomerModel::where('id',$get->id)->update(['sort'=>$to]);
            return response()->json($query);
        }
        return response()->json(false);
        
    }
}
