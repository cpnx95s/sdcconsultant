<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\RoundtripModel;
use App\GalleryModel;
use App\Roundtrip;

class RoundtripController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $segmentad = 'adminwebpanel';
    protected $controller = 'roundtrip';
    protected $folder = 'roundtrip';

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
        $data = RoundtripModel::orderBy('created', 'DESC');
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
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'roundtrip',
            'page' => 'index',
            'segment' => "$this->segment/roundtrip",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/roundtrip",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new RoundtripModel;
        $data->name = $request->name;

        $data->status = 'on';
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            RoundtripModel::where('id', '!=', $data->id)->increment('sort');
          
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/roundtrip")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/roundtrip/create")]);
        }
    }
    public function edit($id)
    {
        $row = RoundtripModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
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
        $data = RoundtripModel::find($id);
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
        $datas = RoundtripModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                RoundtripModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = RoundtripModel::destroy($data->id);
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
        $get = RoundtripModel::find($id);
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

        $get = RoundtripModel::find($request->id);
        if ($from != "" && $to != "") {
            if ($from > $to) {
                RoundtripModel::whereBetween('sort', [$to, $from])->whereNotIn("id", [$get->id])->increment('sort', 1);
            } else {
                RoundtripModel::whereBetween('sort', [$from, $to])->whereNotIn("id", [$get->id])->decrement('sort', 1);
            }
            $query = RoundtripModel::where('id', $get->id)->update(['sort' => $to]);
            return response()->json($query);
        }
        return response()->json(false);
    }
    public function search(Request $request )
    {
        if(isset($_GET['keyword'])){
            $data = RoundtripModel::orderBy('created', 'DESC');
            $view = ($request->view) ? $request->view() : 10;

            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view]);

            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_roundtrip')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            return view("$this->prefix.pages.$this->folder.index", [
                'js' => [
                    ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                    ["src" => 'back-end/js/sweetalert2.all.min.js'],
                    ['src' => "back-end/js/table-dragger.min.js"],
                    ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'roundtrip',
                'page' => 'index',
                'segment' => "$this->segment/roundtrip",
                'rows' => $rows
            ]);
            
        }
    }
    public function copy($id)
    {
        $row = RoundtripModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
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
        DB::table('tb_roundtrip')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
    
    }
    //////////////////////////////////////////////////////////////////////
    ///////////               super admin       /////////////////////////
    ////////////////////////////////////////////////////////////////////
    
    public function adminindex(Request $request)
    {
        $data = RoundtripModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view]);
        }
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ['src' => "back-end/js/table-dragger.min.js"],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'roundtrip',
            'page' => 'index',
            'segment' => "$this->segmentad/roundtrip",
            'rows' => $rows
        ]);
    }
    public function admincreate()
    {
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segmentad/roundtrip",
            'size' => $this->ImageSize(),
        ]);
    }
    public function adminstore(Request $request)
    {

        $data = new RoundtripModel;
        $data->name = $request->name;

        $data->status = 'on';
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        
        if ($data->save()) {
            RoundtripModel::where('id', '!=', $data->id)->increment('sort');
          
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/roundtrip")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/roundtrip/create")]);
        }
    }
    public function adminedit($id)
    {
        $row = RoundtripModel::find($id);
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
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

    public function adminupdate(Request $request, $id)
    {
        $data = RoundtripModel::find($id);
        $data->name = $request->name;

        $data->updated = date('Y-m-d H:i:s');
       
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/$this->controller/" . $id)]);
        }
    }

    public function admindestroy(Request $request)
    {
        $datas = RoundtripModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                RoundtripModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = RoundtripModel::destroy($data->id);
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
        $get = RoundtripModel::find($id);
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

        $get = RoundtripModel::find($request->id);
        if ($from != "" && $to != "") {
            if ($from > $to) {
                RoundtripModel::whereBetween('sort', [$to, $from])->whereNotIn("id", [$get->id])->increment('sort', 1);
            } else {
                RoundtripModel::whereBetween('sort', [$from, $to])->whereNotIn("id", [$get->id])->decrement('sort', 1);
            }
            $query = RoundtripModel::where('id', $get->id)->update(['sort' => $to]);
            return response()->json($query);
        }
        return response()->json(false);
    }
    public function adminsearch(Request $request )
    {
        if(isset($_GET['keyword'])){
            $data = RoundtripModel::orderBy('created', 'DESC');
            $view = ($request->view) ? $request->view() : 10;

            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view]);

            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_roundtrip')->where('name','LIKE','%'.$search_text.'%')->paginate(10);
            return view("$this->prefix.pages.$this->folder.adminindex", [
                'js' => [
                    ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                    ["src" => 'back-end/js/sweetalert2.all.min.js'],
                    ['src' => "back-end/js/table-dragger.min.js"],
                    ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'roundtrip',
                'page' => 'index',
                'segment' => "$this->segmentad/roundtrip",
                'rows' => $rows
            ]);
            
        }
    }
    public function admincopy($id)
    {
        $row = RoundtripModel::find($id);
        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/roundtrip.js"],
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
        $data["sort"] = $sort;
        DB::table('tb_roundtrip')->insert($data);
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/$this->controller")]);
    
    }
}
