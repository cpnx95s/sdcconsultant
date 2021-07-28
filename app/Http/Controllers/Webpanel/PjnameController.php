<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\PjnameModel;
use App\GalleryModel;

class PjnameController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $segmentst = 'staffwebpanel';
    protected $segmentad = 'adminwebpanel';
    protected $controller = 'pjname';
    protected $folder = 'pjname'; 

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
        $data = PjnameModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjname.index",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjname',
            'page' => 'index',
            'segment' => "$this->segment/pjname",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/pjname",
            'size' => $this->ImageSize(),
        ]);
    }

    public function cpcreate()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => "$this->segment/pjname",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new PjnameModel;
        $data->name = $request->name;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
        $data->sort = 1;
        
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjnameModel::where('id', '!=', $data->id)->increment('sort');
           
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/pjname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/pjname/create")]);
        }
    }
    public function edit($id)
    {
        $row = PjnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
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
        
        $row = PjnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
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
        $data = PjnameModel::find($id);
        $data->name = $request->name;
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
        $data = PjnameModel::find($id);
        $data = new PjnameModel;
        $data->name = $request->name;
        $data->sort = 1;
      
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjnameModel::where('id', '!=', $data->id)->increment('sort');
            
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/pjname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/pjname/copy")]);
        }
    }
    public function destroy(Request $request)
    {
        $datas = PjnameModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                PjnameModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = PjnameModel::destroy($data->id);
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
        $get = PjnameModel::find($id);
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
        $data = PjnameModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                PjnameModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                PjnameModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
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
        //     $data = PjnameModel::orderBy('created', 'DESC');
        //     $view = ($request->view) ? $request->view() : 10;
          
             $search_text = $_GET['keyword'];
         
        //     $data = PjnameModel::orderBy('created', 'DESC');
        //     $view = ($request->view) ? $request->view() : 10;
        //     $rows = $data->paginate($view);
        //     $rows->appends(['view' => $request->view]);
        //     $rows = DB::table('tb_pjname')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            
        //      return view("$this->prefix.pages.pjname.index",
        //      [
        //     'css'=> ['back-end/css/table-responsive.css'],        
        //     'js' => [
        //         ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
        //         ["src"=>"back-end/js/table-dragger.min.js"],
        //         ["src"=>'back-end/js/sweetalert2.all.min.js'],
        //         ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
        //     ],
        //     'prefix' => $this->prefix,
        //     'folder' => 'pjname',
        //     'page' => 'index',
        //     'segment' => "$this->segment/pjname",
        //     'rows' => $rows
        // ]);
            
        $spjtype = DB::table('tb_pjtype')->where('name', 'like', '%'.$search_text.'%')->value('id');
        $data = PjnameModel::where('name', 'like', '%'.$search_text.'%')
                            ->orwhere('pjtype','=',$spjtype)
                            ->orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjname.index",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjname',
            'page' => 'index',
            'segment' => "$this->segment/pjname",
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
        $data["codename"] = $request->codename;
        $data["pjtype"] = $request->pjtype;
        $data["sort"] = $sort;
        DB::table('tb_pjname')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
    
    }
    /////////////////////////////////////////////////////////////////////////////////////
    ///////////                  super admin                               /////////////
    ///////////////////////////////////////////////////////////////////////////////////
    public function adminindex(Request $request)
    {  
        $data = PjnameModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjname.adminindex",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjname',
            'page' => 'index',
            'segment' => "$this->segmentad/pjname",
            'rows' => $rows,
           
        ]);
    }
    public function admincreate()
    {
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segmentad/pjname",
            'size' => $this->ImageSize(),
        ]);
    }

    public function admincpcreate()
    {
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => "$this->segmentad/pjname",
            'size' => $this->ImageSize(),
        ]);
    }
    public function adminstore(Request $request)
    {

        $data = new PjnameModel;
        $data->name = $request->name;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
        $data->sort = 1;
        
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjnameModel::where('id', '!=', $data->id)->increment('sort');
           
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/pjname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/pjname/create")]);
        }
    }
    public function adminedit($id)
    {
        $row = PjnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
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
        
        $row = PjnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
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
        $data = PjnameModel::find($id);
        $data->name = $request->name;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
       
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/$this->controller/" . $id)]);
        }
    }
    

    public function admincopystore(Request $request ,$id)
    {
        $data = PjnameModel::find($id);
        $data = new PjnameModel;
        $data->name = $request->name;
        $data->sort = 1;
      
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjnameModel::where('id', '!=', $data->id)->increment('sort');
            
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/pjname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/pjname/copy")]);
        }
    }
    public function admindestroy(Request $request)
    {
        $datas = PjnameModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                PjnameModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = PjnameModel::destroy($data->id);
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
        $get = PjnameModel::find($id);
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
        $data = PjnameModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                PjnameModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                PjnameModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
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
        //     $data = PjnameModel::orderBy('created', 'DESC');
        //     $view = ($request->view) ? $request->view() : 10;
          
             $search_text = $_GET['keyword'];
         
        //     $data = PjnameModel::orderBy('created', 'DESC');
        //     $view = ($request->view) ? $request->view() : 10;
        //     $rows = $data->paginate($view);
        //     $rows->appends(['view' => $request->view]);
        //     $rows = DB::table('tb_pjname')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            
        //      return view("$this->prefix.pages.pjname.index",
        //      [
        //     'css'=> ['back-end/css/table-responsive.css'],        
        //     'js' => [
        //         ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
        //         ["src"=>"back-end/js/table-dragger.min.js"],
        //         ["src"=>'back-end/js/sweetalert2.all.min.js'],
        //         ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
        //     ],
        //     'prefix' => $this->prefix,
        //     'folder' => 'pjname',
        //     'page' => 'index',
        //     'segment' => "$this->segment/pjname",
        //     'rows' => $rows
        // ]);
            
        $spjtype = DB::table('tb_pjtype')->where('name', 'like', '%'.$search_text.'%')->value('id');
        $data = PjnameModel::where('name', 'like', '%'.$search_text.'%')
                            ->orwhere('codename', 'like', '%'.$search_text.'%')
                            ->orwhere('pjtype','=',$spjtype)
                            ->orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjname.adminindex",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjname',
            'page' => 'index',
            'segment' => "$this->segmentad/pjname",
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
        $data["codename"] = $request->codename;
        $data["pjtype"] = $request->pjtype;
        $data["sort"] = $sort;
        DB::table('tb_pjname')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/$this->controller")]);
    
    }
    //////////////////////////////////////////////////////////////////////////////
    ////////////////           admin                   //////////////////////////
    ///////////////////////////////////////////////////////////////////////////
    public function staffindex(Request $request)
    {
        $data = PjnameModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjname.staffindex",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjname',
            'page' => 'index',
            'segment' => "$this->segmentst/pjname",
            'rows' => $rows
        ]);
    }
    public function staffcreate()
    {
        return view("$this->prefix.pages.$this->folder.staffindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segmentst/pjname",
            'size' => $this->ImageSize(),
        ]);
    }

    public function staffcpcreate()
    {
        return view("$this->prefix.pages.$this->folder.staffindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => "$this->segmentst/pjname",
            'size' => $this->ImageSize(),
        ]);
    }
    public function staffstore(Request $request)
    {

        $data = new PjnameModel;
        $data->name = $request->name;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
        $data->sort = 1;
        
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjnameModel::where('id', '!=', $data->id)->increment('sort');
           
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentst/pjname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentst/pjname/create")]);
        }
    }
    public function staffedit($id)
    {
        $row = PjnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.staffindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segmentst,
            'row' => $row,
           
            'size' => $this->ImageSize(),
        ]);
    }

    public function staffcopy($id)
    {
        
        $row = PjnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.staffindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => $this->segmentst,
            'row' => $row,
            'size' => $this->ImageSize(),
        ]);
    }


    public function staffupdate(Request $request, $id)
    {
        $data = PjnameModel::find($id);
        $data->name = $request->name;
        $data->pjtype = $request->pjtype;
        $data->codename = $request->codename;
       
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentst/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentst/$this->controller/" . $id)]);
        }
    }
    

    public function staffcopystore(Request $request ,$id)
    {
        $data = PjnameModel::find($id);
        $data = new PjnameModel;
        $data->name = $request->name;
        $data->sort = 1;
      
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            PjnameModel::where('id', '!=', $data->id)->increment('sort');
            
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentst/pjname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentst/pjname/copy")]);
        }
    }
    public function staffdestroy(Request $request)
    {
        $datas = PjnameModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                PjnameModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = PjnameModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function staffstatus(Request $request, $id = null)
    {
        $get = PjnameModel::find($id);
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
    public function staffdragsort(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $data = PjnameModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                PjnameModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                PjnameModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
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

    public function staffsearch(Request $request )
    {
        
        if(isset($_GET['keyword'])){
        //     $data = PjnameModel::orderBy('created', 'DESC');
        //     $view = ($request->view) ? $request->view() : 10;
          
             $search_text = $_GET['keyword'];
         
        //     $data = PjnameModel::orderBy('created', 'DESC');
        //     $view = ($request->view) ? $request->view() : 10;
        //     $rows = $data->paginate($view);
        //     $rows->appends(['view' => $request->view]);
        //     $rows = DB::table('tb_pjname')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            
        //      return view("$this->prefix.pages.pjname.index",
        //      [
        //     'css'=> ['back-end/css/table-responsive.css'],        
        //     'js' => [
        //         ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
        //         ["src"=>"back-end/js/table-dragger.min.js"],
        //         ["src"=>'back-end/js/sweetalert2.all.min.js'],
        //         ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
        //     ],
        //     'prefix' => $this->prefix,
        //     'folder' => 'pjname',
        //     'page' => 'index',
        //     'segment' => "$this->segment/pjname",
        //     'rows' => $rows
        // ]);
            
        $spjtype = DB::table('tb_pjtype')->where('name', 'like', '%'.$search_text.'%')->value('id');
        $data = PjnameModel::where('name', 'like', '%'.$search_text.'%')
                            ->orwhere('pjtype','=',$spjtype)
                            ->orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'search'=>$request->search]);
        }
        return view("$this->prefix.pages.pjname.staffindex",[
            'css'=> ['back-end/css/table-responsive.css'],        
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/pjname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'pjname',
            'page' => 'index',
            'segment' => "$this->segmentst/pjname",
            'rows' => $rows
        ]);

        }
    }
    public function staffcreatecopy(Request $request)
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
        $data["codename"] = $request->codename;
        $data["pjtype"] = $request->pjtype;
        $data["sort"] = $sort;
        DB::table('tb_pjname')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentst/$this->controller")]);
    
    }

}
