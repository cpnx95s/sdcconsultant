<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use App\TruckplanModel;
use App\GalleryModel;

class TruckplanController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'truckplan';
    protected $folder = 'truckplan';
    protected $dateFormat = 'Y-m-d H:i';

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
        $data = TruckplanModel::orderBy('created', 'DESC');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
        }
        return view("$this->prefix.pages.truckplan.index", [
            'css' => ['back-end/css/table-responsive.css'],
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => "back-end/js/table-dragger.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'truckplan',
            'page' => 'index',
            'segment' => "$this->segment/truckplan",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/truckplan",
            'size' => $this->ImageSize(),
        ]);
    }

    // public function cloning()
    // {
    //     $row = TruckplanModel::find($id);

    //     $row->load('name');

    //     $newModel = $row->replicate();
    //     $newModel->push();

    //     foreach ($row->getRelations() as $relation => $items) {
    //         foreach ($items as $item) {
    //             unset($item->id);
    //             $newModel->{$relation}()->create($item->toArray());
    //         }
    //     }

    // }
    public function store(Request $request)
    {
        $createdaa =  date('Y-m-d');
        $statusplan =  $request->statusplan;
        $worktype = $request->worktype;
        //$mytime = Carbon::now()->format('d-m-Y');
        $data = new TruckplanModel;
        $data->startdate = $request->startdate;
        $data->routecode = $request->routecode;
        $data->routename = $request->routename;
        $data->trucknumb = $request->trucknumb;
        $data->driver = $request->driver;
        $data->telnumb = $request->telnumb;
        $data->sbranch = $request->sbranch;
        $data->dntbranch = $request->dntbranch;
        $data->truckrqtime = $request->truckrqtime;
        $data->dpttime = $request->dpttime;
        $data->dnttime = $request->dnttime;
        $data->totalhour = $request->totalhour;
        $data->mntstaff = $request->mntstaff;
        $data->remark = $request->remark;
        $data->statusplan = $request->statusplan;
        $data->ccremark = $request->ccremark;
        $data->author = $request->author;
        $data->editor = $request->editor;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype = $request->tsptype;
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;


        //$data->pjtype = $request->pjtype;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype = $request->tsptype;
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;

        $data->sort = 1;
        $data->save();
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');
        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->get();

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if (!$createdd) {
                    DB::table('tb_gchart')->insert(
                        ['created' => date('Y-m-d'), 'on_process' => 0, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if (!$createdd) {
                    DB::table('tb_gchart')->insert(
                        ['created' => date('Y-m-d'), 'on_process' => 0, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            }
        } else {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
        }
    }


    public function edit($id)
    {
        $row = TruckplanModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
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

        $row = TruckplanModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
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
        $createdaa =  date('Y-m-d');
        $statusplan =  $request->statusplan;
        $worktype = $request->worktype;
        //$mytime = Carbon::now()->format('d-m-Y');
        $data =  TruckplanModel::find($id);
        $data->startdate = $request->startdate;
        $data->routecode = $request->routecode;
        $data->routename = $request->routename;
        $data->trucknumb = $request->trucknumb;
        $data->driver = $request->driver;
        $data->telnumb = $request->telnumb;
        $data->sbranch = $request->sbranch;
        $data->dntbranch = $request->dntbranch;
        $data->truckrqtime = $request->truckrqtime;
        $data->dpttime = $request->dpttime;
        $data->dnttime = $request->dnttime;
        $data->totalhour = $request->totalhour;
        $data->mntstaff = $request->mntstaff;
        $data->remark = $request->remark;
        $data->statusplan = $request->statusplan;
        $data->ccremark = $request->ccremark;
        $data->author = $request->author;
        $data->editor = $request->editor;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype = $request->tsptype;
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;


$createdd =  DB::table('tb_gchart')->where('created', $createdaa)->get();
$worktypeupdate =  DB::table('tb_truckplan')->where('id', $id)->where('worktype',$request->worktype)->get();
$statusplanupdate =  DB::table('tb_truckplan')->where('id', $id)->where('statusplan',$request->statusplan)->get();
$data->save();
        //$data->pjtype = $request->pjtype;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype = $request->tsptype;
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;

        $data->sort = 1;
        
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');
     
      
        if(  $worktypeupdate){
           
            if( !$statusplanupdate){
                if ($statusplan == "Pending") {

                    if (!$createdd) {
                        DB::table('tb_gchart')->insert(
                            ['created' => date('Y-m-d'), 'on_process' => 1, 'full_fill' => 0]
                        );
                      
                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    } else {
                        DB::table('tb_gchart')->where('created', $createdaa)->decrement('full_fill', 1);
                        DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                        
                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    }
                } else if ($statusplan == "Active") {
                    if (!$createdd) {
                        DB::table('tb_gchart')->insert(
                            ['created' => date('Y-m-d'), 'on_process' => 0, 'full_fill' => 1]
                        );
                      return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    } else {
                        DB::table('tb_gchart')->where('created', $createdaa)->decrement('on_process', 1);
                        DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                      
                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    }
            }
        }
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
    }
    else if( !$worktypeupdate){

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if (!$createdd) {
                    DB::table('tb_gchart')->insert(
                        ['created' => date('Y-m-d'), 'on_process' => 1, 'full_fill' => 0]
                    );
                    
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                   
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if (!$createdd) {
                    DB::table('tb_gchart')->insert(
                        ['created' => date('Y-m-d'), 'on_process' => 0, 'full_fill' => 1]
                    );
                   
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                 
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            }
        } 
        else if($worktype == "งานหลัก"){
            if ($statusplan == "Pending") {
                if (!$createdd) {
                    
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->decrement('on_process', 1);
            
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if (!$createdd) {

                   
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->decrement('full_fill', 1);
                  
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            }
        }
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
    }
       else{
       
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
        }
    }



    
    public function copystore(Request $request, $id)
    {
        $data = TruckplanModel::find($id);
        $data = new TruckplanModel;
        //$data->name = $request->name;
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');

        if ($data->save()) {
            TruckplanModel::where('id', '!=', $data->id)->increment('sort');

            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/truckplan/copy")]);
        }
    }
    public function destroy(Request $request)
    {
    
        $datas = TruckplanModel::find(explode(',', $request->id));
       
        
        
        if (@$datas) {
            foreach ($datas as $data) {

                TruckplanModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = TruckplanModel::destroy($data->id);

                if($data->worktype == "งานเสริม"){
                    if($data->statusplan == "Pending"){
                         $query = DB::table('tb_gchart')->where('created', $data->startdate)->decrement('on_process', 1);
                    if (@$query) {
          
                        return response()->json(true);
                    } else {
                        
                        return response()->json(false);
                    }
                    }
                    else  if($data->statusplan == "Active"){
                        $query = DB::table('tb_gchart')->where('created', $data->startdate)->decrement('full_fill', 1);
                        if (@$query) {
          
                            return response()->json(true);
                        } else {
                            
                            return response()->json(false);
                        }
                    }
                }
                else{
                    if (@$query) {
          
                        return response()->json(true);
                    } else {
                        
                        return response()->json(false);
                    }

                }
            }
        }
        
    }

    public function status(Request $request, $id = null)
    {
        $get = TruckplanModel::find($id);
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
        $data = TruckplanModel::find($request->id);

        if ($from != "" && $to != "") {
            if ($from > $to) {
                TruckplanModel::whereBetween('sort', [$to, $from])->whereNotIn('id', [$data->id])->increment('sort');
            } else {
                TruckplanModel::whereBetween('sort', [$from, $to])->whereNotIn('id', [$data->id])->decrement('sort');
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
    public function search(Request $request)
    {

        if (isset($_GET['keyword'])) {
            $search_text = $_GET['keyword'];
            $fromDate = $request->input('fromDate');
            $data = TruckplanModel::where('routename', 'like', '%' . $search_text . '%')

                ->orwhere('routecode', 'like', '%' . $search_text . '%')
                ->orwhere('statusplan', 'like', '%' . $search_text . '%')
                ->orwhere('pjname', 'like', '%' . $search_text . '%')
                ->orwhere('tsptype', 'like', '%' . $search_text . '%')
                ->orwhere('trucktype', 'like', '%' . $search_text . '%')
                ->orwhere('roundtrip', 'like', '%' . $search_text . '%')
                ->orwhere('hiringtype', 'like', '%' . $search_text . '%')
                ->orwhere('splname', 'like', '%' . $search_text . '%')
                ->orwhere('trucknumb', 'like', '%' . $search_text . '%')
                ->orwhere('driver', 'like', '%' . $search_text . '%')
                ->orwhere('telnumb', 'like', '%' . $search_text . '%')
                ->orwhere('sbranch', 'like', '%' . $search_text . '%')
                ->orwhere('dntbranch', 'like', '%' . $search_text . '%')
                ->orwhere('totalhour', 'like', '%' . $search_text . '%')
                ->orwhere('mntstaff', 'like', '%' . $search_text . '%')
                ->orwhere('remark', 'like', '%' . $search_text . '%')
                ->orwhere('ccremark', 'like', '%' . $search_text . '%')
                ->orwhere('sbranch', 'like', '%' . $search_text . '%')
                ->orwhere('author', 'like', '%' . $search_text . '%')
                ->orwhere('editor', 'like', '%' . $search_text . '%')
                ->orwhere('sort', 'like', '%' . $search_text . '%')
                ->orwhere('worktype', 'like', '%' . $search_text . '%')
                ->orderBy('created', 'DESC');

            $view = ($request->view) ? $request->view() : 10;
            if ($request->view == 'all') {
                $rows = $data->get();
            } else {
                $view = ($request->view) ? $request->view : 10;
                $rows = $data->paginate($view);
                $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
            }
            return view("$this->prefix.pages.truckplan.index", [
                'css' => ['back-end/css/table-responsive.css'],
                'js' => [
                    ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                    ["src" => "back-end/js/table-dragger.min.js"],
                    ["src" => 'back-end/js/sweetalert2.all.min.js'],
                    ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'truckplan',
                'page' => 'index',
                'segment' => "$this->segment/truckplan",
                'rows' => $rows
            ]);
        }
    }
    public function searchdate(Request $request)
    {



        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $other = $request->input('box');
        $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->where('routename', 'like', '%' . $other . '%')
            ->orderBy('created', 'DESC');

        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
        }
        return view("$this->prefix.pages.truckplan.index", [
            'css' => ['back-end/css/table-responsive.css'],
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => "back-end/js/table-dragger.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'truckplan',
            'page' => 'index',
            'segment' => "$this->segment/truckplan",
            'rows' => $rows
        ]);
    }
    public function searchbox(Request $request)
    {
        if (isset($_GET['box'])) {
            $search_text = $_GET['box'];
            $fromDate = $request->input('fromDate');
            $data = TruckplanModel::where('routename', 'like', '%' . $search_text . '%')

                ->orwhere('routecode', 'like', '%' . $search_text . '%')
                ->orwhere('statusplan', 'like', '%' . $search_text . '%')
                ->orwhere('pjname', 'like', '%' . $search_text . '%')
                ->orwhere('tsptype', 'like', '%' . $search_text . '%')
                ->orwhere('trucktype', 'like', '%' . $search_text . '%')
                ->orwhere('roundtrip', 'like', '%' . $search_text . '%')
                ->orwhere('hiringtype', 'like', '%' . $search_text . '%')
                ->orwhere('splname', 'like', '%' . $search_text . '%')
                ->orwhere('trucknumb', 'like', '%' . $search_text . '%')
                ->orwhere('driver', 'like', '%' . $search_text . '%')
                ->orwhere('telnumb', 'like', '%' . $search_text . '%')
                ->orwhere('sbranch', 'like', '%' . $search_text . '%')
                ->orwhere('dntbranch', 'like', '%' . $search_text . '%')
                ->orwhere('totalhour', 'like', '%' . $search_text . '%')
                ->orwhere('mntstaff', 'like', '%' . $search_text . '%')
                ->orwhere('remark', 'like', '%' . $search_text . '%')
                ->orwhere('ccremark', 'like', '%' . $search_text . '%')
                ->orwhere('sbranch', 'like', '%' . $search_text . '%')
                ->orwhere('author', 'like', '%' . $search_text . '%')
                ->orwhere('editor', 'like', '%' . $search_text . '%')
                ->orwhere('sort', 'like', '%' . $search_text . '%')
                ->orwhere('worktype', 'like', '%' . $search_text . '%')
                ->orderBy('created', 'DESC');

            $view = ($request->view) ? $request->view() : 10;
            if ($request->view == 'all') {
                $rows = $data->get();
            } else {
                $view = ($request->view) ? $request->view : 10;
                $rows = $data->paginate($view);
                $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
            }
            return view("$this->prefix.pages.truckplan.index", [
                'css' => ['back-end/css/table-responsive.css'],
                'js' => [
                    ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                    ["src" => "back-end/js/table-dragger.min.js"],
                    ["src" => 'back-end/js/sweetalert2.all.min.js'],
                    ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'truckplan',
                'page' => 'index',
                'segment' => "$this->segment/truckplan",
                'rows' => $rows
            ]);
        }
    }
    public function createcopy(Request $request)
    {
        $createdaa =  date('Y-m-d');
        $statusplan =  $request->statusplan;
        $worktype = $request->worktype;
        //$mytime = Carbon::now()->format('d-m-Y');
        $data = new TruckplanModel;
        $data->startdate = $request->startdate;
        $data->routecode = $request->routecode;
        $data->routename = $request->routename;
        $data->trucknumb = $request->trucknumb;
        $data->driver = $request->driver;
        $data->telnumb = $request->telnumb;
        $data->sbranch = $request->sbranch;
        $data->dntbranch = $request->dntbranch;
        $data->truckrqtime = $request->truckrqtime;
        $data->dpttime = $request->dpttime;
        $data->dnttime = $request->dnttime;
        $data->totalhour = $request->totalhour;
        $data->mntstaff = $request->mntstaff;
        $data->remark = $request->remark;
        $data->statusplan = $request->statusplan;
        $data->ccremark = $request->ccremark;
        $data->author = $request->author;
        $data->editor = $request->editor;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype = $request->tsptype;
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;


        //$data->pjtype = $request->pjtype;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype = $request->tsptype;
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;

        $data->sort = 1;
        $data->save();
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');
        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->get();

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if (!$createdd) {
                    DB::table('tb_gchart')->insert(
                        ['created' => date('Y-m-d'), 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if (!$createdd) {
                    DB::table('tb_gchart')->insert(
                        ['created' => date('Y-m-d'), 'on_process' => 0, 'full_fill' => 1]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            }
        } else {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
        }
    }
}
