<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\TrucktypeModel;
use App\GalleryModel;

class TrucktypeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'trucktype';
    protected $folder = 'trucktype';

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
        $data = TrucktypeModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
        }
        return view("$this->prefix.pages.trucktype.index", [
            'css' => ['back-end/css/table-responsive.css'],
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => "back-end/js/table-dragger.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/trucktype.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'trucktype',
            'page' => 'index',
            'segment' => "$this->segment/trucktype",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/trucktype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/trucktype",
            'size' => $this->ImageSize(),
        ]);
    }

    
    public function store(Request $request)
    {

        $data = new TrucktypeModel;
        $data->name = $request->name;
        $data->sort = 1;
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        if ($data->save()) {
            TrucktypeModel::where('id', '!=', $data->id)->increment('sort');
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/trucktype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/trucktype/create")]);
        }
    }
    public function edit($id)
    {
        $row = TrucktypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/trucktype.js"],
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

        $row = TrucktypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/trucktype.js"],
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

    public function clone(Request $request, $id)
    {
        //$data = TrucktypeModel::find($id);
        $data = new TrucktypeModel;
        $data->id = "NULL";
        $data->name = $request->name;
        $data->sort = 1;
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');

        if ($data->save()) {
            TrucktypeModel::where('id', '!=', $data->id)->increment('sort');
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/trucktype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/trucktype/copy")]);
        }
    }

    public function update(Request $request, $id)
    {
        $data = TrucktypeModel::find($id);
        $data->name = $request->name;
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
        }
    }
    


    public function destroy(Request $request)
    {
        $datas = TrucktypeModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                TrucktypeModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = TrucktypeModel::destroy($data->id);
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
        $get = TrucktypeModel::find($id);
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
        $data = TrucktypeModel::find($request->id);

        if ($from != "" && $to != "") {
            if ($from > $to) {
                TrucktypeModel::whereBetween('sort', [$to, $from])->whereNotIn('id', [$data->id])->increment('sort');
            } else {
                TrucktypeModel::whereBetween('sort', [$from, $to])->whereNotIn('id', [$data->id])->decrement('sort');
            }
            $data->sort = $to;
            if ($data->save()) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        }
        return response()->json(false);
    }
    public function search(Request $request )
    {
        if(isset($_GET['keyword'])){
            $data = TrucktypeModel::orderBy('created', 'DESC');
            $view = ($request->view) ? $request->view() : 10;

            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view]);

            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_trucktype')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            return view("$this->prefix.pages.trucktype.index", [
                'css' => ['back-end/css/table-responsive.css'],
                'js' => [
                    ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                    ["src" => "back-end/js/table-dragger.min.js"],
                    ["src" => 'back-end/js/sweetalert2.all.min.js'],
                    ["type" => "text/javascript", "src" => "back-end/build/trucktype.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'trucktype',
                'page' => 'index',
                'segment' => "$this->segment/trucktype",
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
        $data["sort"] = $sort;
        DB::table('tb_trucktype')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
    
    }
}
