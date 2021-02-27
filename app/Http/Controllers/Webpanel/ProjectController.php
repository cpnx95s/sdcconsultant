<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\ProjectModel;
use App\GalleryModel;

class ProjectController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'project';
    protected $folder = 'project';

    public function ImageSize($find=null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x'=>590,'y'=>320],
                'md' => ['x'=>500,'y'=>500],
                'sm' => ['x'=>250,'y'=>250],
            ],
            'gallery' => [
                'lg' => ['x'=>350,'y'=>270],
                'md' => ['x'=>350,'y'=>270],
                'sm' => ['x'=>250,'y'=>250],
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
        $data = ProjectModel::orderBy('sort');
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
                ["type"=>"text/javascript","src"=>"back-end/build/project.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'project',
            'page' => 'index',
            'segment' => "$this->segment/project",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ['src'=>'back-end/tinymce/tinymce.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/project.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/project",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new ProjectModel;
        $data->name = $request->name;
        $data->category = $request->category;
        $data->detail = $request->detail;
        $data->status = 'on';
        $data->sort = 1;
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if($file)
        {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());
            $md = Image::make($file->getRealPath());
            // $sm = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
            $md->resize($size['md']['x'],$size['md']['y'])->stream();
            // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $newLg = 'upload/project/'.$filename.'-.'.$ext;
            $newMd = 'upload/project/'.$filename.'-md.'.$ext;
            Storage::disk('public')->put($newLg, $lg);
            Storage::disk('public')->put($newMd, $md);
            $data->image = $newLg;
        }
        if($data->save())
        {
            ProjectModel::where('id','!=',$data->id)->increment('sort');
            // gallery
            if($request->gallery)
            {
                $gallery = $request->gallery;
                $gfilename = 'gallery-'.date('dmY-His');
                for($i=0; $i<count($gallery); $i++)
                {
                    $lg = Image::make($gallery[$i]->getRealPath());
                    $md = Image::make($gallery[$i]->getRealPath());
                    // $sm = Image::make($gallery[$i]->getRealPath());

                    $ext = explode("/", $lg->mime())[1];
                    $size = $this->ImageSize('gallery');

                    $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
                    $md->resize($size['md']['x'],$size['md']['y'])->stream();
                    // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
                    
                    $newLg = 'upload/project/gallery/'.$gfilename.'-'.$i.'.'.$ext;
                    $newMd = 'upload/project/gallery/'.$gfilename.'-'.$i.'-md.'.$ext;
                    // $projectm = 'upload/project/gallery/'.$gfilename.'-'.$i.'-sm.'.$ext;
                    
                    Storage::disk('public')->put($newLg, $lg);
                    Storage::disk('public')->put($newMd, $md);
                    // Storage::disk('public')->put($projectm, $sm);

                    GalleryModel::insert(['_id' => $data->id,'type'=>'project','image'=>$newMd,'created'=>date('Y-m-d H:i:s')]);
                }
            }
            return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segment/project")]);
        }
        else
        {
                return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/project/create")]);
        }
                
    }
    public function edit($id)
    {
        $row = ProjectModel::find($id);
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ['src'=>"back-end/tinymce/tinymce.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/project.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => $row,
            'gallerys' => GalleryModel::where(['type'=>'project','_id'=>$id])->get(),
            'size' => $this->ImageSize(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = ProjectModel::find($id);
        $data->name = $request->name;
        $data->category = $request->category;
        $data->detail = $request->detail;
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if($file)
        {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());
            $md = Image::make($file->getRealPath());
            // $sm = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
            $md->resize($size['md']['x'],$size['md']['y'])->stream();
            // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $newLg = 'upload/project/'.$filename.'-.'.$ext;
            $newMd = 'upload/project/'.$filename.'-md.'.$ext;
            Storage::disk('public')->put($newLg, $lg);
            Storage::disk('public')->put($newMd, $md);
            $data->image = $newLg;
        }
        if($request->gallery)
        {
            $gallery = $request->gallery;
            $gfilename = 'gallery-'.date('dmY-His');
            for($i=0; $i<count($gallery); $i++)
            {
                $lg = Image::make($gallery[$i]->getRealPath());
                $md = Image::make($gallery[$i]->getRealPath());
                // $sm = Image::make($gallery[$i]->getRealPath());

                $ext = explode("/", $lg->mime())[1];
                $size = $this->ImageSize('gallery');

                $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
                $md->resize($size['md']['x'],$size['md']['y'])->stream();
                // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
                
                $newLg = 'upload/project/gallery/'.$gfilename.'-'.$i.'.'.$ext;
                $newMd = 'upload/project/gallery/'.$gfilename.'-'.$i.'-md.'.$ext;
                // $projectm = 'upload/project/gallery/'.$gfilename.'-'.$i.'-sm.'.$ext;
                
                Storage::disk('public')->put($newLg, $lg);
                Storage::disk('public')->put($newMd, $md);
                // Storage::disk('public')->put($projectm, $sm);

                GalleryModel::insert(['_id' => $data->id,'type'=>'project','image'=>$newMd,'created'=>date('Y-m-d H:i:s')]);
            }
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
        $datas = ProjectModel::find(explode(',',$request->id));
        if(@$datas)
        {
            foreach($datas as $data)
            {
           
                ProjectModel::where('sort','>',$data->sort)->decrement('sort');
                //destroy
                $query = ProjectModel::destroy($data->id);
            }
        }
        if(@$query){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function destroygallery(Request $request)
    {
        $datas = GalleryModel::find(explode(',',$request->id));
        if(@$datas)
        {
            foreach($datas as $data)
            {
                $query = GalleryModel::destroy($data->id);
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
        $get = ProjectModel::find($id);
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

        $get = SlideModel::find($request->id);
        if($from!="" && $to !="")
        {
            if($from > $to){
                SlideModel::whereBetween('sort', [$to, $from])->whereNotIn("id",[$get->id])->increment('sort', 1);
            }else{
                SlideModel::whereBetween('sort', [$from, $to])->whereNotIn("id",[$get->id])->decrement('sort', 1);
            }
            $query = SlideModel::where('id',$get->id)->update(['sort'=>$to]);
            return response()->json($query);
        }
        return response()->json(false);
        
    }
}
