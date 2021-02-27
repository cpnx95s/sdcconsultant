<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\ContactModel;


class ContactController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'contact';
    protected $folder = 'contact';

    public function ImageSize($find=null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x'=>100,'y'=>100],
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
        $data = ContactModel::orderBy('sort');
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
                ["type" => "text/javascript", "src" => "back-end/build/contact.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'contact',
            'page' => 'index',
            'segment' => "$this->segment/contact",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/contact.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/contact",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new ContactModel;
        $data->address = $request->address;
        $data->tel = $request->tel;
        $data->company_name = $request->company_name;
        $data->email = $request->email;
        $data->line = $request->line;
        $data->map = $request->map;
        $data->fax = $request->fax;
        $data->facebook = $request->facebook;
        $data->twitter = $request->twitter;
        // SEO
        // $data->seo_title = $request->seo_title;
        // $data->seo_description = $request->seo_description;
        // $data->seo_keywords = $request->seo_keywords;
        // End Seo
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if ($file) {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());
            $md = Image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
            $newLg = 'upload/contact/' . $filename . '-.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
            
            $data->image = $newLg;
        }
        if ($data->save()) {
            ContactModel::where('id', '!=', $data->id)->increment('sort');
            // gallery
            if ($request->gallery) {
                $gallery = $request->gallery;
                $gfilename = 'gallery-' . date('dmY-His');
                for ($i = 0; $i < count($gallery); $i++) {
                    $lg = Image::make($gallery[$i]->getRealPath());
                    $md = Image::make($gallery[$i]->getRealPath());
                    $ext = explode("/", $lg->mime())[1];
                    $size = $this->ImageSize('gallery');

                    $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
                    // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();

                    $newLg = 'upload/contact/gallery/' . $gfilename . '-' . $i . '.' . $ext;

                    Storage::disk('public')->put($newLg, $lg);

                    GalleryModel::insert(['_id' => $data->id, 'type' => 'contact', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/contact")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/contact/create")]);
        }
    }
    
    public function edit()
    {
        $row = ContactModel::find(1);
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ['src'=>"back-end/tinymce/tinymce.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/contact.js"],
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

    public function update(Request $request)
    {
        $data = ContactModel::find(1);
        $data->address = $request->address;
        $data->tel = $request->tel;
        $data->email = $request->email;
        $data->line = $request->line;
        $data->map = $request->map;
        $data->fax = $request->fax;
        $data->facebook = $request->facebook;
        $data->twitter = $request->twitter;
        $data->sort = 1;
        //$data->map = $request->map;
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if($file)
        {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'],$size['lg']['y'])->stream();
            $newLg = 'upload/contact/'.$filename.'-.'.$ext;
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }
       
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segment/$this->controller/1")]);
        }else{
            return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/$this->controller/1")]);
        }
    }

    public function destroy(Request $request)
    {
        $datas = ContactModel::find(explode(',',$request->id));
        if(@$datas)
        {
            foreach($datas as $data)
            {
           
                ContactModel::where('sort','>',$data->sort)->decrement('sort');
                //destroy
                $query = ContactModel::destroy($data->id);
            }
        }
        if(@$query){
            return response()->json(true);
        }else{
            return response()->json(false);
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
