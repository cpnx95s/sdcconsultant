<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\SlideModel;


class Slide extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'slide';
    protected $folder = 'slide';

    public function imageSize($find=null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x' =>1900,'y' => 690],
            ],
            'gallery' => [
                'lg' => ['x' =>1900,'y' => 690],
            ]
        ];
        if($find==null)
        {
           return $arr; 
        }else{
            switch ($find) {
                case 'cover': return $arr['cover']; break;
                case 'gallery': return $arr['gallery']; break;
                default: return []; break;
            }
        }
    }
    public function index(Request $request)
    {
        $data = SlideModel::orderBy('sort');
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
                ["type"=>"text/javascript","src"=>"back-end/build/slide.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'slide',
            'page' => 'index',
            'segment' => "$this->segment/slide",
            'rows' => $rows
        ]);
    }
    public function show($id=null)
    {

        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/build/slide.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'size' => $this->imageSize(),
            'segment' => "$this->segment/slide",
            'row' => SlideModel::find($id)
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/build/slide.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/slide",
            'size' => $this->imageSize(),
        ]);
    }
    public function store(Request $request)
    {
        $group = $request->group;
        
        $filename = 'slide_'.date('dmY-His');
        $file = $request->image;
        if ($file) { 

            $lg = Image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'],$size['cover']['lg']['y'])->stream();
            $newLG = 'upload/slide/'.$filename.'.'.$ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            if($store)
            {
                $data = new SlideModel;
                $data->image = $newLG;
                $data->name = $request->name;
                $data->status = 'on';
                $data->sort = 1;
                $data->created = date('y-m-d H:i:s');
                if($data->save())
                {
                    SlideModel::where('id','!=',$data->id)->increment('sort');
                    return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segment/slide")]);
                }else{
                    return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/slide/create")]);
                }
            }else{
                return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/slide/create")]);
            }
        }
        
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $data = SlideModel::find($id);
        if ($data->id) {

            $file = $request->image;
            // $mobile = $request->image_m;
            $size = $this->imageSize();
            if ($file) { 

                if($data->image)
                {
                    Storage::disk('public')->delete($data->image);
                }

                $lg = Image::make($file->getRealPath());
                $ext = explode("/", $lg->mime())[1];
                $lg->resize($size['cover']['lg']['x'],$size['cover']['lg']['y'])->stream();
                $put = Storage::disk('public')->put($data->image, $lg);
            }
            $data->name = $request->name;
            $data->updated = date('Y-m-d H:i:s');
            
        }

        if($data->save())
        {
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->segment/slide")]);
        }else{
            return view("$this->prefix.alert.sweet.error",['url'=>$request->fullUrl()]);
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
    public function status(Request $request,$id=null)
    {
        $get = SlideModel::find($id);
        if($get)
        {
            $status = ($get->status=='off')? 'on' : 'off' ;
            $get->status = $status;
            $get->save();
            if($get->id){
                return response()->json(true);
            }else{
                return response()->json(false);
            }
        }
        return response()->json(false);
    }
    
    public function destroy(Request $request)
    {
        $datas = SlideModel::find(explode(',',$request->id));
        if(@$datas)
        {
            foreach($datas as $data)
            {
                Storage::disk('public')->delete($data->image);
                //update sort
                SlideModel::where('sort','>',$data->sort)->decrement('sort');
                //destroy
                $query = SlideModel::destroy($data->id);
            }
        }

        if(@$query){
            return response()->json(true);
        }else{
            return response()->json(false);
        }

    }
       

}
