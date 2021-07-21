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
    protected $segmentad = 'adminwebpanel';
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
        $data = TruckplanModel::distinct()->orderBy('created', 'DESC');
        $worktype =TruckplanModel::select('worktype')->distinct()->get();
        $pjname =TruckplanModel::select('pjname')->distinct()->get();
        if ($request->view == 'all') {
            $rows = $data->distinct()->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->distinct()->paginate(10);
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
            'rows' => $rows,
            'worktype'=>$worktype,
            'pjname'=> $pjname
        ])->with('worktype',$worktype);

    }
    public function create()
    {
        $countries = DB::table("countries")->pluck("name","id");
        $rows= DB::table('tb_pjname')->get();


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
            'rows' => $rows,
            'countries'=> $countries,
            'segment' => "$this->segment/truckplan",
            'size' => $this->ImageSize(),
        ]) ;
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
        $createdaa =  $request->startdate;
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
        $data->tsptype = $request->state;
        $data->pjname = $request->category_id;
        $data->worktype = $request->city;
        $data->hiringtype = $request->hiringtype;


        //$data->pjtype = $request->pjtype;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype =$request->state;
        $data->pjname =$request->state;
        $data->worktype = $request->city;
        $data->hiringtype = $request->hiringtype;

        $data->sort = 1;
        $data->save();
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');
        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);

                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ( $createdd == 0) {

                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
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
        $countries = DB::table("countries")->pluck("name","id");
        $rows= DB::table('tb_pjname')->get();
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
            'rows' => $rows,
            'countries'=> $countries,

        ]);
    }

    public function copy($id)
    {

        $row = TruckplanModel::find($id);
        $rows= DB::table('tb_pjname')->get();
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
            'rows' => $rows,
            'size' => $this->ImageSize(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = TruckplanModel::find($id);
        $defaultpjname =  DB::table('tb_truckplan')->where('id', $id)->where('pjname', $request->pjname)->count();
        $datatsptype = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        $createdaa = $request->startdate;
       $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();
       $worktypeupdate =  DB::table('tb_truckplan')->where('id', $id)->where('worktype',$request->worktype)->count();
       $statusplanupdate =  DB::table('tb_truckplan')->where('id', $id)->where('statusplan',$request->statusplan)->count();
       $dateupdate =  DB::table('tb_truckplan')->where('id', $id)->where('startdate',$request->startdate)->count();
       $datedefault =  DB::table('tb_truckplan')->where('id', $id)->value('startdate' );
       $statusplandefault =  DB::table('tb_truckplan')->where('id', $id)->value('statusplan' );
       $datatsptype = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        $createdaa =  $request->startdate;
        $statusplan =  $request->statusplan;
        $worktype = $request->worktype;
        //$mytime = Carbon::now()->format('d-m-Y');

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
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;



        //$data->pjtype = $request->pjtype;
        $data->sort = 1;
        //$data->pjtype = $request->pjtype;
        if($defaultpjname == 1){
           $data->tsptype = $request->tsptype;
        }
        else if($defaultpjname == 0){
            $data->tsptype = $datatsptype;
         }
        $data->save();

        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');

      if ($dateupdate >= 1){

        if( $worktypeupdate >= 1){
           if($worktype  == "งานเสริม"){
            if( $statusplanupdate==0){
                if ($statusplan == "Pending") {

                    if  ($createdd ==0) {
                        DB::table('tb_gchart')->insert(
                            ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                        );

                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    } else {
                        DB::table('tb_gchart')->where('created', $createdaa)->decrement('full_fill', 1);
                        DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    }
                } else if ($statusplan == "Active") {
                    if ( $createdd == 0) {
                        DB::table('tb_gchart')->insert(
                            ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                        );
                      return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    } else {
                        DB::table('tb_gchart')->where('created', $createdaa)->decrement('on_process', 1);
                        DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);

                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                    }
            }
        }
    }
    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
    }
    else if( $worktypeupdate == 0){

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ($createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            }
        }
        else if($worktype == "งานหลัก"){
            if ($statusplandefault == "Pending") {
                if ($createdd == 0) {

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->decrement('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplandefault == "Active") {
                if ($createdd == 0) {


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
    else if ($dateupdate == 0){
       if( $worktypeupdate == 0){
        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ($createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
        }
        else if($worktype == "งานหลัก"){
            if ($statusplandefault == "Pending") {
                if ($createdd == 0) {
                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplandefault == "Active") {
                if ($createdd == 0) {

                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);

                }
            }
        }
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
    }
    else if( $worktypeupdate >= 1){
        if ($worktype == "งานเสริม"){
        if( $statusplanupdate==0){
            if ($statusplan == "Pending") {

                if  ($createdd ==0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );
                  return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                }
        }
    }
    if( $statusplanupdate >=1){
        if ($statusplan == "Pending") {

            if  ($createdd ==0) {
                DB::table('tb_gchart')->insert(
                    ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                );

                return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
            } else {
                DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
            }
        } else if ($statusplan == "Active") {
            if ( $createdd == 0) {
                DB::table('tb_gchart')->insert(
                    ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                );
              return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
            } else {
                DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);

                return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
            }
    }
}
    }
    else if ($worktype == "งานหลัก"){
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);

    }
    }

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

                    }
                    else  if($data->statusplan == "Active"){
                        $query = DB::table('tb_gchart')->where('created', $data->startdate)->decrement('full_fill', 1);

                    }
                }

            }
            if (@$query) {

                return response()->json(true);
            } else {

                return response()->json(false);
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
    {    $worktype =TruckplanModel::select('worktype')->distinct()->get();
        $pjname =TruckplanModel::select('pjname')->distinct()->get();

        if (isset($_GET['keyword'])) {
            $search_text = $_GET['keyword'];

            $spjname =  DB::table('tb_pjname')->where('name','like','%'.$search_text."%")->value('id');
            $stsptype =  DB::table('tb_tsptype')->where('name','like','%'.$search_text."%")->value('id');
            $strucktype =  DB::table('tb_trucktype')->where('name','like','%'.$search_text."%")->value('id');
            $sroundtrip =  DB::table('tb_roundtrip')->where('name','like','%'.$search_text."%")->value('id');
            $shiringtype =  DB::table('tb_hiringtype')->where('name','like','%'.$search_text."%")->value('id');
            $ssplname =  DB::table('tb_splname')->where('name','like','%'.$search_text."%")->value('id');
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
                ->orwhere('pjname', '=', $spjname)
                ->orwhere('tsptype', '=', $stsptype)
                ->orwhere('trucktype', '=', $strucktype)
                ->orwhere('roundtrip', '=', $sroundtrip)
                ->orwhere('hiringtype', '=', $shiringtype)
                ->orwhere('splname', '=', $ssplname)
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
                'rows' => $rows,
                'pjname' => $pjname,
                'worktype'=>$worktype
            ]);
        }
    }
    public function searchdate(Request $request)
    {



        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $worktype =TruckplanModel::select('worktype')->distinct()->get();
        $pjname =TruckplanModel::select('pjname')->distinct()->get();
        $worktypebox = $request->input('worktypebox');
        $pjnamebox = DB::table('tb_pjname')->where('name',$request->input('pjnamebox'))->value('id');
        if ($pjnamebox == "" && $worktypebox == "" ){
            $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->orderBy('startdate', 'DESC');
        }
         else if(isset($_GET['worktypebox']) && $pjnamebox == ""){
        $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->where('worktype', 'like',$worktypebox)
            ->orderBy('startdate', 'DESC');
        }
        else  if(isset($_GET['pjnamebox']) && $worktypebox == ""){
            $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->where('pjname', '=', $pjnamebox )
            ->orderBy('startdate', 'DESC');
        }
        else {
            $data = TruckplanModel::where('startdate', '>=', $fromDate)
                ->where('startdate', '<=', $toDate)
                ->where('worktype', '=',$worktypebox)
                ->where('pjname', '=', $pjnamebox )
                ->orderBy('startdate', 'DESC');
            }
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
            'rows' => $rows,
            'pjname' => $pjname,
            'worktype'=>$worktype
        ]);
    }
    public function searchbox(Request $request)
    {
        if (isset($_GET['box'])) {
            $search_text = $_GET['box'];
            $fromDate = $request->input('fromDate');
            $data = TruckplanModel::where('routename', 'like', '%' . $search_text . '%')

            ->distinct();

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
    public function createcopy(Request $request ,$id)
    {

        $defaultpjname =  DB::table('tb_truckplan')->where('id', $id)->where('pjname', $request->pjname)->count();
        $datatsptype = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        $createdaa =  $request->startdate;
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
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');

        $data->sort = 1;
        //$data->pjtype = $request->pjtype;
   if($request->tsptype == "1" || $request->tsptype == "2" ||$request->tsptype == "3" || $request->tsptype == "4"){
    $data->tsptype = $request->tsptype;

   }
   else{

           $data->tsptype = $datatsptype;
   }
        $data->save();

        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ($createdd == 0) {

                     DB::table('tb_gchart')->insert(
                        ['created' =>  $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
                } else {

                 DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                 return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);

                }
            }
            else if ($statusplan == "Active") {

                if ($createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa , 'on_process' => 0, 'full_fill' => 1]
                    );
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);

                } else {

                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);

                }

            }
        }
        else {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/truckplan")]);
        }
    }
    public function dorpdows(Request $request)
    {
        $id = 103;
        $statusplan = '2021-06-18';
        $createdaa = date('Y-m-d');
        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();
        $lise = DB::table('tb_pjname-pjtype')->get('pjname_id' );
        $dateupdate =  DB::table('tb_truckplan')->where('id', $id)->get('startdate' );
        dd($dateupdate);
        return view('test')->with('lise',$lise);
    }
    public function fetct(Request $request){
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

            $output.='<option name="output">'.$row->name.'</option>';

        }
       echo $output;


    }

    public function fetct2(Request $request){
        $id= $request->get('select');
        $result=array();
        $query=DB::table('tb_dropdown')
       ->join ('tb_dropdown2','tb_dropdown.name_id','=', 'tb_dropdown2.name_id')
       ->select('tb_dropdown2.name')
       ->where ('tb_dropdown.name_id',$id)
       ->groupBY('tb_dropdown2.name')
       ->get();
       $output2='<option value="">ประเภทงาน</option>';
       foreach ($query as $row){

           $output2.='<option name="output">'.$row->name.'</option>';

       }
      echo $output2;


   }
    public function test(Request $request){
        $list = TruckplanModel::find(explode(',', $request->id));
        $worktypebox = $request->input('worktypebox');
        $jo = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        dd($worktypebox);
        return view('test')->with('list', $list);
    }


    public function index1()
    {
        $countries = DB::table("countries")->pluck("name","id");
        return view('test',compact('countries'));
    }

    public function getStateList(Request $request)
    {
        $states = DB::table("states")
        ->where("country_id",$request->country_id)
        ->pluck("name","id");
        return response()->json($states);
    }

    public function getCityList(Request $request)
    {
        $cities = DB::table("cities")
        ->where("state_id",$request->state_id)
        ->pluck("name","id");
        return response()->json($cities);
    }

    /////////////////////////////////////////////////////////////////////////////////////
    //////////            super admin                                   /////////////////
    ////////////////////////////////////////////////////////////////////////////////////
    public function adminindex(Request $request)
    {
        $data = TruckplanModel::distinct()->orderBy('created', 'DESC');
        $worktype =TruckplanModel::select('worktype')->distinct()->get();
        $pjname =TruckplanModel::select('pjname')->distinct()->get();
        if ($request->view == 'all') {
            $rows = $data->distinct()->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->distinct()->paginate(10);
            $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
        }
        return view("$this->prefix.pages.truckplan.adminindex", [
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
            'segment' => "$this->segmentad/truckplan",
            'rows' => $rows,
            'worktype'=>$worktype,
            'pjname'=> $pjname
        ])->with('worktype',$worktype);

    }
    public function admincreate()
    {
        $countries = DB::table("countries")->pluck("name","id");
        $rows= DB::table('tb_pjname')->get();


        return view("$this->prefix.pages.$this->folder.adminindex", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/truckplan.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'rows' => $rows,
            'countries'=> $countries,
            'segment' => "$this->segmentad/truckplan",
            'size' => $this->ImageSize(),
        ]) ;
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
    public function adminstore(Request $request)
    {
        $dataworktype = DB::table('cities')->where('id',$request->city)->value('name');
        $createdaa =  $request->startdate;
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
        $data->tsptype = $request->state;
        $data->pjname = $request->category_id;
        $data->worktype = $request->city;
        $data->hiringtype = $request->hiringtype;


        //$data->pjtype = $request->pjtype;
        $data->trucktype = $request->trucktype;
        $data->roundtrip = $request->roundtrip;
        $data->splname = $request->splname;
        $data->tsptype =$request->state;
        $data->pjname =$request->state;
        $data->worktype = $request->city;
        $data->hiringtype = $request->hiringtype;

        $data->sort = 1;
        $data->save();
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');
        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);

                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ( $createdd == 0) {

                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            }
        } else {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
        }
    }


    public function adminedit($id)
    {
        $row = TruckplanModel::find($id);
        $rows= DB::table('tb_pjname')->get();
        return view("$this->prefix.pages.$this->folder.adminindex", [
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
            'segment' => $this->segmentad,
            'row' => $row,
            'rows' => $rows,

        ]);
    }

    public function admincopy($id)
    {

        $row = TruckplanModel::find($id);
        $rows= DB::table('tb_pjname')->get();
        return view("$this->prefix.pages.$this->folder.adminindex", [
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
            'segment' => $this->segmentad,
            'row' => $row,
            'rows' => $rows,
            'size' => $this->ImageSize(),
        ]);
    }


    public function adminupdate(Request $request, $id)
    {
        $data = TruckplanModel::find($id);
        $defaultpjname =  DB::table('tb_truckplan')->where('id', $id)->where('pjname', $request->pjname)->count();
        $datatsptype = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        $createdaa = $request->startdate;
       $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();
       $worktypeupdate =  DB::table('tb_truckplan')->where('id', $id)->where('worktype',$request->worktype)->count();
       $statusplanupdate =  DB::table('tb_truckplan')->where('id', $id)->where('statusplan',$request->statusplan)->count();
       $dateupdate =  DB::table('tb_truckplan')->where('id', $id)->where('startdate',$request->startdate)->count();
       $datedefault =  DB::table('tb_truckplan')->where('id', $id)->value('startdate' );
       $statusplandefault =  DB::table('tb_truckplan')->where('id', $id)->value('statusplan' );
       $datatsptype = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        $createdaa =  $request->startdate;
        $statusplan =  $request->statusplan;
        $worktype = $request->worktype;
        //$mytime = Carbon::now()->format('d-m-Y');

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
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;



        //$data->pjtype = $request->pjtype;
        $data->sort = 1;
        //$data->pjtype = $request->pjtype;
        if($defaultpjname == 1){
           $data->tsptype = $request->tsptype;
        }
        else if($defaultpjname == 0){
            $data->tsptype = $datatsptype;
         }
        $data->save();

        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');

      if ($dateupdate >= 1){

        if( $worktypeupdate >= 1){
           if($worktype  == "งานเสริม"){
            if( $statusplanupdate==0){
                if ($statusplan == "Pending") {

                    if  ($createdd ==0) {
                        DB::table('tb_gchart')->insert(
                            ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                        );

                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                    } else {
                        DB::table('tb_gchart')->where('created', $createdaa)->decrement('full_fill', 1);
                        DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                    }
                } else if ($statusplan == "Active") {
                    if ( $createdd == 0) {
                        DB::table('tb_gchart')->insert(
                            ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                        );
                      return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                    } else {
                        DB::table('tb_gchart')->where('created', $createdaa)->decrement('on_process', 1);
                        DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);

                        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                    }
            }
        }
    }
    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
    }
    else if( $worktypeupdate == 0){

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ($createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            }
        }
        else if($worktype == "งานหลัก"){
            if ($statusplandefault == "Pending") {
                if ($createdd == 0) {

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->decrement('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            } else if ($statusplandefault == "Active") {
                if ($createdd == 0) {


                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->decrement('full_fill', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            }
        }
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
    }
       else{

            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
        }
    }
    else if ($dateupdate == 0){
       if( $worktypeupdate == 0){
        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ($createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
        }
        else if($worktype == "งานหลัก"){
            if ($statusplandefault == "Pending") {
                if ($createdd == 0) {
                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            } else if ($statusplandefault == "Active") {
                if ($createdd == 0) {

                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {

                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);

                }
            }
        }
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
    }
    else if( $worktypeupdate >= 1){
        if ($worktype == "งานเสริม"){
        if( $statusplanupdate==0){
            if ($statusplan == "Pending") {

                if  ($createdd ==0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
            } else if ($statusplan == "Active") {
                if ( $createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                    );
                  return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {
                    DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);

                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                }
        }
    }
    if( $statusplanupdate >=1){
        if ($statusplan == "Pending") {

            if  ($createdd ==0) {
                DB::table('tb_gchart')->insert(
                    ['created' => $createdaa, 'on_process' => 1, 'full_fill' => 0]
                );

                return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
            } else {
                DB::table('tb_gchart')->where('created', $datedefault)->decrement('on_process', 1);
                DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);

                return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
            }
        } else if ($statusplan == "Active") {
            if ( $createdd == 0) {
                DB::table('tb_gchart')->insert(
                    ['created' => $createdaa, 'on_process' => 0, 'full_fill' => 1]
                );
              return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
            } else {
                DB::table('tb_gchart')->where('created', $datedefault)->decrement('full_fill', 1);
                DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);

                return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
            }
    }
}
    }
    else if ($worktype == "งานหลัก"){
        return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);

    }
    }

    }
}


    public function admincopystore(Request $request, $id)
    {
        $data = TruckplanModel::find($id);
        $data = new TruckplanModel;
        //$data->name = $request->name;
        $data->sort = 1;

        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');

        if ($data->save()) {
            TruckplanModel::where('id', '!=', $data->id)->increment('sort');

            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentad/truckplan/copy")]);
        }
    }
    public function admindestroy(Request $request)
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

                    }
                    else  if($data->statusplan == "Active"){
                        $query = DB::table('tb_gchart')->where('created', $data->startdate)->decrement('full_fill', 1);

                    }
                }

            }
            if (@$query) {

                return response()->json(true);
            } else {

                return response()->json(false);
            }
        }

    }

    public function adminstatus(Request $request, $id = null)
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
    public function admindragsort(Request $request)
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
    public function adminsearch(Request $request)
    {    $worktype =TruckplanModel::select('worktype')->distinct()->get();
        $pjname =TruckplanModel::select('pjname')->distinct()->get();

        if (isset($_GET['keyword'])) {
            $search_text = $_GET['keyword'];
            $fromDate = $request->input('fromDate');
            $fromDate = $request->input('fromDate');
            $spjname =  DB::table('tb_pjname')->where('name','like','%'.$search_text."%")->value('id');
            $stsptype =  DB::table('tb_tsptype')->where('name','like','%'.$search_text."%")->value('id');
            $strucktype =  DB::table('tb_trucktype')->where('name','like','%'.$search_text."%")->value('id');
            $sroundtrip =  DB::table('tb_roundtrip')->where('name','like','%'.$search_text."%")->value('id');
            $shiringtype =  DB::table('tb_hiringtype')->where('name','like','%'.$search_text."%")->value('id');
            $ssplname =  DB::table('tb_splname')->where('name','like','%'.$search_text."%")->value('id');
            $ssplname =  DB::table('tb_splname')->where('name','like','%'.$search_text."%")->value('id');
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
                ->orwhere('pjname', '=', $spjname)
                ->orwhere('tsptype', '=', $stsptype)
                ->orwhere('trucktype', '=', $strucktype)
                ->orwhere('roundtrip', '=', $sroundtrip)
                ->orwhere('hiringtype', '=', $shiringtype)
                ->orwhere('splname', '=', $ssplname)
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
            return view("$this->prefix.pages.truckplan.adminindex", [
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
                'segment' => "$this->segmentad/truckplan",
                'rows' => $rows,
                'pjname' => $pjname,
                'worktype'=>$worktype
            ]);
        }
    }
    public function adminsearchdate(Request $request)
    {



        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $worktype =TruckplanModel::select('worktype')->distinct()->get();
        $pjname =TruckplanModel::select('pjname')->distinct()->get();
        $worktypebox = $request->input('worktypebox');
        $pjnamebox = DB::table('tb_pjname')->where('name',$request->input('pjnamebox'))->value('id');

        if ($pjnamebox == "" && $worktypebox == "" ){
            $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->orderBy('startdate', 'DESC');
        }
         else if(isset($_GET['worktypebox']) && $pjnamebox == ""){
        $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->where('worktype', 'like',$worktypebox)
            ->orderBy('startdate', 'DESC');
        }
        else  if(isset($_GET['pjnamebox']) && $worktypebox == ""){
            $data = TruckplanModel::where('startdate', '>=', $fromDate)
            ->where('startdate', '<=', $toDate)
            ->where('pjname', '=', $pjnamebox )
            ->orderBy('startdate', 'DESC');
        }
        else {
            $data = TruckplanModel::where('startdate', '>=', $fromDate)
                ->where('startdate', '<=', $toDate)
                ->where('worktype', '=',$worktypebox)
                ->where('pjname', '=', $pjnamebox )
                ->orderBy('startdate', 'DESC');
            }
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
        }
        return view("$this->prefix.pages.truckplan.adminindex", [
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
            'segment' => "$this->segmentad/truckplan",
            'rows' => $rows,
            'pjname' => $pjname,
            'worktype'=>$worktype
        ]);
    }
    public function adminsearchbox(Request $request)
    {
        if (isset($_GET['box'])) {
            $search_text = $_GET['box'];
            $fromDate = $request->input('fromDate');
            $data = TruckplanModel::where('routename', 'like', '%' . $search_text . '%')

            ->distinct();

            $view = ($request->view) ? $request->view() : 10;
            if ($request->view == 'all') {
                $rows = $data->get();
            } else {
                $view = ($request->view) ? $request->view : 10;
                $rows = $data->paginate($view);
                $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
            }
            return view("$this->prefix.pages.truckplan.adminindex", [
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
                'segment' => "$this->segmentad/truckplan",
                'rows' => $rows
            ]);
        }
    }
    public function admincreatecopy(Request $request ,$id)
    {

        $defaultpjname =  DB::table('tb_truckplan')->where('id', $id)->where('pjname', $request->pjname)->count();
        $datatsptype = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        $createdaa =  $request->startdate;
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
        $data->pjname = $request->pjname;
        $data->worktype = $request->worktype;
        $data->hiringtype = $request->hiringtype;
        // $data->created = date('Y-m-d H:i:s.u');
        // $data->updated = date('Y-m-d H:i:s.u');

        $data->sort = 1;
        //$data->pjtype = $request->pjtype;
   if($request->tsptype == "1" || $request->tsptype == "2" ||$request->tsptype == "3" || $request->tsptype == "4"){
    $data->tsptype = $request->tsptype;

   }
   else{

           $data->tsptype = $datatsptype;
   }
        $data->save();

        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();

        if ($worktype == "งานเสริม") {

            if ($statusplan == "Pending") {
                if ($createdd == 0) {

                     DB::table('tb_gchart')->insert(
                        ['created' =>  $createdaa, 'on_process' => 1, 'full_fill' => 0]
                    );
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
                } else {

                 DB::table('tb_gchart')->where('created', $createdaa)->increment('on_process', 1);
                 return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);

                }
            }
            else if ($statusplan == "Active") {

                if ($createdd == 0) {
                    DB::table('tb_gchart')->insert(
                        ['created' => $createdaa , 'on_process' => 0, 'full_fill' => 1]
                    );
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);

                } else {

                    DB::table('tb_gchart')->where('created', $createdaa)->increment('full_fill', 1);
                    return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);

                }

            }
        }
        else {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentad/truckplan")]);
        }
    }
    public function admindorpdows(Request $request)
    {
        $id = 103;
        $statusplan = '2021-06-18';
        $createdaa = date('Y-m-d');
        $createdd =  DB::table('tb_gchart')->where('created', $createdaa)->count();
        $lise = DB::table('tb_pjname-pjtype')->get('pjname_id' );
        $dateupdate =  DB::table('tb_truckplan')->where('id', $id)->get('startdate' );
        dd($dateupdate);
        return view('test')->with('lise',$lise);
    }
    public function adminfetct(Request $request){
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

            $output.='<option name="output">'.$row->name.'</option>';

        }
       echo $output;


    }

    public function adminfetct2(Request $request){
        $id= $request->get('select');
        $result=array();
        $query=DB::table('tb_dropdown')
       ->join ('tb_dropdown2','tb_dropdown.name_id','=', 'tb_dropdown2.name_id')
       ->select('tb_dropdown2.name')
       ->where ('tb_dropdown.name_id',$id)
       ->groupBY('tb_dropdown2.name')
       ->get();
       $output2='<option value="">ประเภทงาน</option>';
       foreach ($query as $row){

           $output2.='<option name="output">'.$row->name.'</option>';

       }
      echo $output2;


   }
    public function admintest(Request $request){
        $datatsptype = DB::table('tb_tsptype')->where('name',$request->state)->value('id');
        $dataworktype = DB::table('cities')->where('id',$request->city)->value('name');
        $list = $request->city;
        
        $worktypebox = $request->input('worktypebox');
        $jo = DB::table('tb_tsptype')->where('name',$request->tsptype)->value('id');
        dd($dataworktype);
        return view('test')->with('list', $list);
    }


    public function adminindex1()
    {
        $countries = DB::table("countries")->pluck("name","id");
        return view('test',compact('countries'));
    }

    public function admingetStateList(Request $request)
    {
        $states = DB::table("states")
        ->where("country_id",$request->country_id)
        ->pluck("name","id");
        return response()->json($states);
    }

    public function admingetCityList(Request $request)
    {
        $cities = DB::table("cities")
        ->where("state_id",$request->state_id)
        ->pluck("name","id");
        return response()->json($cities);
    }
}
