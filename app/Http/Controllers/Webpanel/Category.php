<?php

namespace App\Http\Controllers\Webpanel;

use Illuminate\Routing\UrlGenerator as url;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\CategoryModel as Model;

class Category extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'category';

    public function imageSize($find=null)
    {
        $size = [
            'cover' => [
                'lg' => ['x'=>1110,'y'=>590],
                'md' => ['x'=>555,'y'=>295],
                'sm' => ['x'=>223,'y'=>192]
            ],
            'gallery' => [
                'lg' => ['x'=>223,'y'=>192],
                'md' => ['x'=>223,'y'=>192],
                'sm' => ['x'=>223,'y'=>192]
            ]
        ];
        switch ($find) {
            case 'cover': return $size['cover']; break;
            case 'gallery': return $size['gallery'];  break;
            default: return $size; break;
        }
    }
    public function index(Request $request, $type=null)
    {
        $keywords = $request->keywords;
        $data = Model::where('position','=','first')
            ->where('type',$type)
            ->when($keywords,function($query)use($keywords){ 
                $query->where('name_th','like',"%{$keywords}%"); 
            })->orderBy('sort');

        if($request->view=='all'){
            $rows = $data->get();
        }else{
            $view = ($request->view)? $request->view : 10 ;
            $rows = $data->paginate($view);
            $rows->appends(['view'=>$request->view,'page'=>$request->page,'keywords'=>$request->keywords]);
        }
        return view("$this->prefix.pages.category.index",[
            'css' => ['back-end/css/table-responsive.css'],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/category.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'category',
            'page' => 'index',
            'controller' => 'category',
            'segment' => "$this->segment/$this->controller/$type",
            'size' => $this->ImageSize(),
            'rows' => $rows
        ]);
    }

    public function create($type=null)
    {
        return view("$this->prefix.pages.category.index",[
            'css' => ["back-end/css/validate.css"],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],   
                ["type"=>"text/javascript","src"=>"back-end/build/treeview.js"],        
                ["type"=>"text/javascript","src"=>"back-end/build/logger.js"],        
                ["type"=>"text/javascript","src"=>"back-end/build/category.js"],
                
            ],
            'prefix' => $this->prefix,
            'folder' => 'category',
            'page' => 'add',
            'controller' => 'category',
            'segment' => "$this->segment/category/$type",
            'size' => $this->imageSize()
        ]);
    }
    public function position($find)
    {
        $arr = ['first','second','third','fourth','fifth','sixth','seventh','eighth','ninth','tenth'];
        foreach($arr as $i => $v)
        {
            if($v==$find){ return $arr[$i+1]; }
        }
        return null;

    }
    public function store(Request $request, $type=null)
    {

        $data = new Model;
        $data->name_th = $request->name_th;
        $data->name_en = $request->name_en;
        $data->type = $type;        
        $data->position = ($request->position==null)? 'first' : $this->position($request->position);
        $data->_id = $request->_id;
        $data->status = 'on';
        $data->sort = 1; 
        $data->created = date('Y-m-d H:i:s');
        if($request->image)
        {
            $file = $request->image;
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());
            $md = Image::make($file->getRealPath());
            //$sm = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');
            
            //$sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $md->resize($size['md']['x'],$size['md']['y'])->stream();
            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
            

            //$newSm = 'upload/category/'.$filename.'.'.$ext;
            $newMd = 'upload/category/'.$filename.'-md.'.$ext;
            $newLg = 'upload/category/'.$filename.'.'.$ext;

            //Storage::disk('public')->put($newSm, $sm);
            Storage::disk('public')->put($newMd, $md);
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }

        if($data->save())
        {
            //new sort
            if($request->position==null){
                Model::where('id','!=',$data->id)->increment('sort');
            }else{
                Model::where('id','!=',$data->id)->where(['position'=>$this->position($request->position),'_id'=>$request->_id,'type'=>$type])->increment('sort');
            }
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->segment/$this->controller/product")]);
        }else{
            return view("$this->prefix.alert.sweet.error",['url'=>$request->fullUrl()]);
        }
    }

    public function show($id, $type=null)
    {
        //
    }

    public function edit($type=null,$id=null)
    {
        return view("$this->prefix.pages.category.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/treeview.js"],        
                ["type"=>"text/javascript","src"=>"back-end/build/logger.js"],        
                ["type"=>"text/javascript","src"=>"back-end/build/category.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'category',
            'page' => 'edit',
            'controller' => 'category',
            'segment' => "$this->segment/$this->controller/$type",
            'size' => $this->imageSize(),
            'row' => Model::find($id)
        ]);
    }

    public function update(Request $request, $type=null, $id=null)
    {
        $data = Model::find($id);
        $data->name_th = $request->name_th;
        $data->name_en = $request->name_en;
        if($request->image)
        {
            $file = $request->image;
            Storage::disk('public')->delete($data->image);
            Storage::disk('public')->delete(str_replace('.','-md.',$data->image));

            $filename = date('dmY-His');
            
            //$sm = Image::make($file->getRealPath());
            $md = Image::make($file->getRealPath());
            $lg = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $md->resize($size['md']['x'],$size['md']['y'])->stream();
            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();

            //$newSm = 'upload/category/'.$filename.'-sm.'.$ext;
            $newMd = 'upload/category/'.$filename.'-md.'.$ext;
            $newLg = 'upload/category/'.$filename.'.'.$ext;

            // Storage::disk('public')->put($newSm, $sm);
            Storage::disk('public')->put($newMd, $md);
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }
        if($data->save())
        {
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->segment/$this->controller/$type")]);
        }else{
            return view("$this->prefix.alert.sweet.error");
        }
    }
    public function editSort(Request $request,$type=null)
    {
        return view("$this->prefix.pages.category.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>"back-end/js/table-dragger.min.js"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/category.js"],
            ],
            'prefix' => $this->prefix,            
            'folder' => 'category',            
            'page' => 'sort',
            'controller' => 'category',
            'segment' => '/category/insurance/',
            'row' => Model::find($request->id),
            'rows' => Model::where(['position'=>$this->position($request->position),'type'=>$type,'_id'=>$request->_id])->orderBy('sort')->get()
        ]);
    }
    public function editData(Request $request,$type=null)
    {
        return view("$this->prefix.pages.category.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],                
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/treeview.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/logger.js"],                
                ["type"=>"text/javascript","src"=>"back-end/build/category.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'category',
            'page' => 'edit',
            'controller' => 'category',
            'segment' => "$this->segment/$this->controller/product",
            'size' => $this->imageSize(),
            'parent' => Model::find($request->parent),
            'row' => Model::find($request->id)
        ]);
    }
    public function updateData(Request $request, $type=null)
    {
        $data = Model::find($request->id);
        $data->name_th = $request->name_th;
        $data->updated = date('Y-m-d H:i:s');
        if($request->image)
        {
            $file = $request->image;
            Storage::disk('public')->delete($data->image);
            Storage::disk('public')->delete(str_replace('.','-md.',$data->image));

            $filename = date('dmY-His');
            //$lg = Image::make($file->getRealPath());
            $sm = Image::make($file->getRealPath());

            $ext = explode("/", $sm->mime())[1];
            $size = $this->ImageSize('cover');

            $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            //$lg->resize($size['lg']['x'],$size['lg']['y'])->stream();

            $newSm = 'upload/category/'.$filename.'.'.$ext;
            //$newMd = 'upload/news/'.$filename.'-md.'.$ext;

            // Storage::disk('public')->put($newMd, $md);
            Storage::disk('public')->put($newSm, $sm);
            $data->image = $newSm;
        }
        if($data->save())
        {
            return view("$this->prefix.alert.sweet.success");
        }else{
            return view("$this->prefix.alert.sweet.error");
        }
    }

    public function status(Request $request,$type=null,$id=null)
    {
        $data = Model::find($id);
        $data->status = ($data->status=='off')?'on':'off';
        if($data->save()){ return response()->json(true); }else{ return response()->json(false); }
    }

    public function dragsort(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $data = Model::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                $query = Model::whereBetween('sort',[$to,$from])->whereNotIn('id',[$data->id]);
                if($request->position=='first'){
                    $query->where(['position'=>$request->position,'type'=>$request->type]);
                }else{
                    $query->where(['_id'=>$request->_id,'position'=>$request->position,'type'=>$request->type]);
                }
                $query->increment('sort');
            }else{
                Model::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->where(['_id'=>$request->_id,'position'=>$request->position,'type'=>$request->type])->decrement('sort');
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


    public function destroy(Request $request, $type=null)
    {
        $data = Model::find($request->id);
        if(count($data)>0)
        {
            foreach($data as $i => $v){
                Storage::disk('public')->delete($v->image);
                $query = Model::destroy($v->id);
                if($query){
                    //sort
                    Model::where('sort','>',$v->sort)->where(['position'=>$v->position,'_id'=>$v->_id,'type'=>$type])->decrement('sort');
                }
            }
        }
        if(@$query){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    public function destroyCat(Request $request)
    {
        switch ($request->position) {
            case 'second':
                $query = $this->destroyFrom2($request->id,$request->position,$request->_id,$request->type);
                break;
            case 'third':
                $query = $this->destroyFrom3($request->id,$request->position,$request->_id,$request->type);
                break;
            case 'fourth':
                $query = $this->destroyFrom4($request->id,$request->position,$request->_id,$request->type);
                break;
            case 'fifth':
                $query = $this->destroyFrom5($request->id,$request->position,$request->_id,$request->type);
                break;
            default:
                $query = false;
                break;
        }      
        return response()->json($query);
        
    }
    public function destroyFrom2($id,$position,$_id,$type)
    {
        $arr = ['first','second','third','fourth','fifth'];
        $data = Model::find($id);
        
        $third = Model::where(['position'=>$arr[2],'_id'=> $data->id,'type'=> $type])->get();
        foreach($third as $k => $c3)
        {
            $fourth = Model::where(['position'=>$arr[3],'_id'=> $c3->id,'type'=> $type])->get();
            foreach($fourth as $l => $c4)
            {
                $fifth = Model::where(['position'=>$arr[4],'_id'=> $c4->id,'type'=> $type])->get();
                foreach($fifth as $m => $c5)
                {
                    Model::destroy($c5->id);
                }
                Model::destroy($c4->id);
            }
            Model::destroy($c3->id);
        }
        $query = Model::destroy($data->id);
        if($query){
            @Storage::disk('public')->delete($data->image);
            Model::where('sort','>',$data->sort)->where(['position'=>$position,'_id'=>$_id,'type'=>$type])->decrement('sort');
            return true;
        }else{
            return false;
        }            
        
    }
    public function destroyFrom3($id,$position,$_id,$type)
    {
        $arr = ['first','second','third','fourth','fifth'];
        $data = Model::find($id);
       
        $fourth = Model::where(['position'=>$arr[3],'_id'=> $data->id,'type'=> $type])->get();
        foreach($fourth as $l => $c4)
        {
            $fifth = Model::where(['position'=>$arr[4],'_id'=> $c4->id,'type'=> $type])->get();
            foreach($fifth as $m => $c5)
            {
                Model::destroy($c5->id);
            }
            Model::destroy($c4->id);
        }
        $query = Model::destroy($data->id);
        if($query){
            @Storage::disk('public')->delete($data->image);
            Model::where('sort','>',$data->sort)->where(['position'=>$position,'_id'=>$_id,'type'=>$type])->decrement('sort');
            return true;
        }else{
            return false;
        }
        
    }
    public function destroyFrom4($id,$position,$_id,$type)
    {
        $arr = ['first','second','third','fourth','fifth'];
        $data = Model::find($id);

        $fifth = Model::where(['position'=>$arr[4],'_id'=> $data->id,'type'=> $type])->get();
        foreach($fifth as $m => $c5)
        {
            Model::destroy($c5->id);
        }
        $query = Model::destroy($data->id);
        if($query){
            @Storage::disk('public')->delete($data->image);
            Model::where('sort','>',$data->sort)->where(['position'=>$position,'_id'=>$_id,'type'=>$type])->decrement('sort');
            return true;
        }else{
            return false;
        }
        
    }
    public function destroy5($id,$position,$_id,$type)
    {
        $arr = ['first','second','third','fourth','fifth'];
        $data = Model::find($id);
        // Model::where('sort','>',$data->sort)->where(['position'=>$arr[4],'_id'=>$_id,'type'=>$type])->decrement('sort');
        $query = Model::destroy($data->id);
        if($query){
            @Storage::disk('public')->delete($data->image);
            Model::where('sort','>',$data->sort)->where(['position'=>$position,'_id'=>$_id,'type'=>$type])->decrement('sort');
            return true;
        }else{
            return false;
        }
        
    }
}
