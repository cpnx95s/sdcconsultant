<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\PjdetailModel;
use App\GalleryModel;

class PjdetailController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'pjdetail';
    protected $folder = 'pjdetail';

    public function ImageSize($find = null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x' => 533, 'y' => 357.59],
            ],
            'gallery' => [
                'lg' => ['x' => 360, 'y' => 232.8],
            ],
        ];
        if ($find != null) {
            return $arr[$find];
        } else {
            return $arr;
        }
    }

    public function index(Request $request)
    {
        $data = PjdetailModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjdetail.index",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjdetail.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjdetail',
            'page' => 'index',
            'segment' => "$this->segment/pjdetail",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjdetail.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/pjdetail",
            'size' => $this->ImageSize(),
        ]);
    }

    public function cpcreate()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjdetail.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => "$this->segment/pjdetail",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new PjdetailModel;
        $data->pjname = $request->pjname;
        $data->cusname = $request->cusname;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
        $data->sort = 1;
        
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            PjdetailModel::where('id', '!=', $data->id)->increment('sort');
           
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/pjdetail")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/pjdetail/create")]);
        }
    }
    public function edit($id)
    {
        $row = PjdetailModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjdetail.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => $row,
        ]);
    }

    public function copy($id)
    {
        
        $row = PjdetailModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjdetail.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => $this->segment,
            'row' => $row,
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = PjdetailModel::find($id);
        $data->pjname = $request->pjname;
        $data->cusname = $request->cusname;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
        
        
        $data->updated = date('Y-m-d H:i:s');
      
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
        }
    }
  

    public function copystore(Request $request ,$id)
    {
        $data = PjdetailModel::find($id);
        $data = new PjdetailModel;
        $data->name = $request->name;
        $data->sort = 1;
       
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            PjdetailModel::where('id', '!=', $data->id)->increment('sort');
         
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/pjdetail")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/pjdetail/copy")]);
        }
    }
    public function destroy(Request $request)
    {
        $datas = PjdetailModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                PjdetailModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = PjdetailModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function status(Request $request, $id = null)
    {
        $get = PjdetailModel::find($id);
        if (@$get->id) {
            $status = ($get->status == 'off') ? 'on' : 'off';
            $get->status = $status;
            $get->save();
            if ($get->id) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        }
    }
    public function dragsort(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $data = PjdetailModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                PjdetailModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                PjdetailModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
            }
            $data->sort = $to;
            if($data->save()){
                return response()->json(true);
            }else{
                return response()->json(false);
            }
        }
        return response()->json(false);
    }
}
