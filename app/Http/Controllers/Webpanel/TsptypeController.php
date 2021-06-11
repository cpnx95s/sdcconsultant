<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\TsptypeModel;
use App\GalleryModel;

class TsptypeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'tsptype';
    protected $folder = 'tsptype';

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
        $data = TsptypeModel::orderBy('sort');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view]);
        }
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ['src' => "back-end/js/table-dragger.min.js"],
                ["type" => "text/javascript", "src" => "back-end/build/tsptype.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'tsptype',
            'page' => 'index',
            'segment' => "$this->segment/tsptype",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/tsptype.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/tsptype",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new TsptypeModel;
        $data->name = $request->name;
        // $data->short_detail = $request->short_detail;
        // $data->detail = $request->detail;
        $data->status = 'on';
        $data->sort = 1;
       
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            TsptypeModel::where('id', '!=', $data->id)->increment('sort');
          
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/tsptype")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/tsptype/create")]);
        }
    }
    public function edit($id)
    {
        $row = TsptypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/tsptype.js"],
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
        $data = TsptypeModel::find($id);
        $data->name = $request->name;
        // $data->short_detail = $request->short_detail;
        // $data->detail = $request->detail;
        
        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
        }
    }

    public function destroy(Request $request)
    {
        $datas = TsptypeModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                TsptypeModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = TsptypeModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function destroygallery(Request $request)
    {
        $datas = GalleryModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                $query = GalleryModel::destroy($data->id);
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
        $get = TsptypeModel::find($id);
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

        $get = TsptypeModel::find($request->id);
        if ($from != "" && $to != "") {
            if ($from > $to) {
                TsptypeModel::whereBetween('sort', [$to, $from])->whereNotIn("id", [$get->id])->increment('sort', 1);
            } else {
                TsptypeModel::whereBetween('sort', [$from, $to])->whereNotIn("id", [$get->id])->decrement('sort', 1);
            }
            $query = TsptypeModel::where('id', $get->id)->update(['sort' => $to]);
            return response()->json($query);
        }
        return response()->json(false);
    }
    public function search(Request $request )
    {
        if(isset($_GET['keyword'])){
            $data = TsptypeModel::orderBy('sort');
            $view = ($request->view) ? $request->view() : 10;

            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view]);

            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_tsptype')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            return  view("$this->prefix.pages.$this->folder.index", [
                'js' => [
                    ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                    ["src" => 'back-end/js/sweetalert2.all.min.js'],
                    ['src' => "back-end/js/table-dragger.min.js"],
                    ["type" => "text/javascript", "src" => "back-end/build/tsptype.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'tsptype',
                'page' => 'index',
                'segment' => "$this->segment/tsptype",
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
        DB::table('tb_tsptype')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
    
    }
    public function copy($id)
    {
        $row = TsptypeModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/tsptype.js"],
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
   
}
