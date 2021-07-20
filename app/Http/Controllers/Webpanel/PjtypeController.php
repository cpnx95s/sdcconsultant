<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\PjtypeModel;
use App\GalleryModel;

class PjtypeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $segmentad = 'adminwebpanel';
    protected $controller = 'pjtype';
    protected $folder = 'pjtype';

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
        $data = PjtypeModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjtype.index",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjtype',
            'page' => 'index',
            'segment' => "$this->segment/pjtype",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/pjtype",
            'size' => $this->ImageSize(),
        ]);
    }

    public function cpcreate()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => "$this->segment/pjtype",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new PjtypeModel;
        $data->name = $request->name;
        $data->name2 = $request->name;
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            PjtypeModel::where('id', '!=', $data->id)->increment('sort');
           
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/pjtype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/pjtype/create")]);
        }
    }
    public function edit($id)
    {
        $row = PjtypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
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

    public function copy($id)
    {
        
        $row = PjtypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => $this->segment,
            'row' => $row,       
            'size' => $this->ImageSize(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = PjtypeModel::find($id);
        $data->name = $request->name;

        $data->updated = date('Y-m-d H:i:s');
      
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
        }
    }
    

    public function copystore(Request $request ,$id)
    {
        $data = PjtypeModel::find($id);
        $data = new PjtypeModel;
        $data->name = $request->name;
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjtypeModel::where('id', '!=', $data->id)->increment('sort');
            
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/pjtype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/pjtype/copy")]);
        }
    }
    public function destroy(Request $request)
    {
        $datas = PjtypeModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                PjtypeModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = PjtypeModel::destroy($data->id);
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
        $get = PjtypeModel::find($id);
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
        $data = PjtypeModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                PjtypeModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                PjtypeModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
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

    public function search(Request $request )
    {
        
        if(isset($_GET['keyword'])){
            $data = PjtypeModel::orderBy('created', 'DESC');
            $view = ($request->view) ? $request->view() : 10;
          
         
            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_pjtype')->where('name','LIKE','%'.$search_text.'%')->paginate(10);

            return view("$this->prefix.pages.pjtype.index",[
                'css'=> ['back-end/css/table-responsive.css'],        
                'js' => [
                    ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                    ["src"=>"back-end/js/table-dragger.min.js"],
                    ["src"=>'back-end/js/sweetalert2.all.min.js'],
                    ["type"=>"text/javascript","src"=>"back-end/build/pjtype.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'pjtype',
                'page' => 'index',
                'segment' => "$this->segment/pjtype",
                'rows' => $rows
            ]);
        }
    }
    public function createcopy(Request $request)
    {
     
        //บันทึก
        $sort = 2;
        $data = array();
        $created =  date('Y-m-d H:i:s');
        $updated = date('Y-m-d H:i:s');
        $status = "on";
     
        $data["created"] = $created;
        $data["status"] = $status;
        $data["updated"] = $updated;
        $data["name"] = $request->name;
        $data["name2"] = $request->name;
        $data["sort"] = $sort;
        DB::table('tb_pjtype')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
    
    }
    //////////////////////////////////////////////////////////////////////////////////////
    //////////                    super admin                        /////////////////////
    /////////////////////////////////////////////////////////////////////////////////////
    public function adminindex(Request $request)
    {
        $data = PjtypeModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjtype.adminindex",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjtype',
            'page' => 'index',
            'segment' => "$this->segmentad/pjtype",
            'rows' => $rows
        ]);
    }
    public function admincreate()
    {
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segmentad/pjtype",
            'size' => $this->ImageSize(),
        ]);
    }

    public function admincpcreate()
    {
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => "$this->segmentad/pjtype",
            'size' => $this->ImageSize(),
        ]);
    }
    public function adminstore(Request $request)
    {

        $data = new PjtypeModel;
        $data->name = $request->name;
        $data->name2 = $request->name;
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            PjtypeModel::where('id', '!=', $data->id)->increment('sort');
           
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/pjtype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/pjtype/create")]);
        }
    }
    public function adminedit($id)
    {
        $row = PjtypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segmentad,
            'row' => $row,
            'size' => $this->ImageSize(),
        ]);
    }

    public function admincopy($id)
    {
        
        $row = PjtypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjtype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => $this->segmentad,
            'row' => $row,       
            'size' => $this->ImageSize(),
        ]);
    }


    public function adminupdate(Request $request, $id)
    {
        $data = PjtypeModel::find($id);
        $data->name = $request->name;

        $data->updated = date('Y-m-d H:i:s');
      
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/$this->controller/" . $id)]);
        }
    }
    

    public function admincopystore(Request $request ,$id)
    {
        $data = PjtypeModel::find($id);
        $data = new PjtypeModel;
        $data->name = $request->name;
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjtypeModel::where('id', '!=', $data->id)->increment('sort');
            
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/pjtype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/pjtype/copy")]);
        }
    }
    public function admindestroy(Request $request)
    {
        $datas = PjtypeModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                PjtypeModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = PjtypeModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function adminstatus(Request $request, $id = null)
    {
        $get = PjtypeModel::find($id);
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
    public function admindragsort(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $data = PjtypeModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                PjtypeModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                PjtypeModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
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

    public function adminsearch(Request $request )
    {
        
        if(isset($_GET['keyword'])){
            $data = PjtypeModel::orderBy('created', 'DESC');
            $view = ($request->view) ? $request->view() : 10;
          
         
            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_pjtype')->where('name','LIKE','%'.$search_text.'%')->paginate(10);

            return view("$this->prefix.pages.pjtype.adminindex",[
                'css'=> ['back-end/css/table-responsive.css'],        
                'js' => [
                    ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                    ["src"=>"back-end/js/table-dragger.min.js"],
                    ["src"=>'back-end/js/sweetalert2.all.min.js'],
                    ["type"=>"text/javascript","src"=>"back-end/build/pjtype.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'pjtype',
                'page' => 'index',
                'segment' => "$this->segmentad/pjtype",
                'rows' => $rows
            ]);
        }
    }
    public function admincreatecopy(Request $request)
    {
     
        //บันทึก
        $sort = 2;
        $data = array();
        $created =  date('Y-m-d H:i:s');
        $updated = date('Y-m-d H:i:s');
        $status = "on";
     
        $data["created"] = $created;
        $data["status"] = $status;
        $data["updated"] = $updated;
        $data["name"] = $request->name;
        $data["name2"] = $request->name;
        $data["sort"] = $sort;
        DB::table('tb_pjtype')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/$this->controller")]);
    
    }
    }