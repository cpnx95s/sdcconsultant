<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\SplnameModel;
use App\GalleryModel;

class SplnameController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'splname';
    protected $folder = 'splname';

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
        $data = splnameModel::orderBy('sort');
        $view = ($request->view) ? $request->view() : 10;
        if ($request->view == 'all') {
            $rows = $data->get();
        } else {
            $view = ($request->view) ? $request->view : 10;
            $rows = $data->paginate($view);
            $rows->appends(['view' => $request->view, 'page' => $request->page, 'search' => $request->search]);
        }
        return view("$this->prefix.pages.splname.index", [
            'css' => ['back-end/css/table-responsive.css'],
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => "back-end/js/table-dragger.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/splname.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'splname',
            'page' => 'index',
            'segment' => "$this->segment/splname",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/splname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/splname",
            'size' => $this->ImageSize(),
        ]);
    }

    public function cloning()
    {
        $row = splnameModel::find($id);

        $row->load('name');

        $newModel = $row->replicate();
        $newModel->push();

        foreach ($row->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                unset($item->id);
                $newModel->{$relation}()->create($item->toArray());
            }
        }
        
    }
    public function store(Request $request)
    {

        $data = new splnameModel;
        $data->name = $request->name;
        $data->score = $request->score;
        $data->sort = 1;
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

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
            $newLg = 'upload/splname/' . $filename . '-.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }
        if ($data->save()) {
            splnameModel::where('id', '!=', $data->id)->increment('sort');
            // gallery
            if ($request->gallery) {
                $gallery = $request->gallery;
                $gfilename = 'gallery-' . date('dmY-His');
                for ($i = 0; $i < count($gallery); $i++) {
                    $lg = Image::make($gallery[$i]->getRealPath());

                    $ext = explode("/", $lg->mime())[1];
                    $size = $this->ImageSize('gallery');

                    $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
                    // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();

                    $newLg = 'upload/splname/gallery/' . $gfilename . '-' . $i . '.' . $ext;

                    Storage::disk('public')->put($newLg, $lg);

                    GalleryModel::insert(['_id' => $data->id, 'type' => 'splname', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/splname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/splname/create")]);
        }
    }
    public function edit($id)
    {
        $row = splnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/splname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => $row,
            'gallerys' => GalleryModel::where(['type' => 'splname', '_id' => $id])->get(),
            'size' => $this->ImageSize(),
        ]);
    }

    public function copy($id)
    {

        $row = splnameModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/splname.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'copy',
            'segment' => $this->segment,
            'row' => $row,
            'gallerys' => GalleryModel::where(['type' => 'splname', '_id' => $id])->get(),
            'size' => $this->ImageSize(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = splnameModel::find($id);
        $data->name = $request->name;
        $data->score = $request->score;

        // SEO
        // $data->seo_title = $request->seo_title;
        // $data->seo_description = $request->seo_description;
        // $data->seo_keywords = $request->seo_keywords;
        // End Seo
        $data->updated = date('Y-m-d H:i:s');
        $file = $request->image;
        if ($file) {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());

            // $sm = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();

            $newLg = 'upload/splname/' . $filename . '-.' . $ext;

            Storage::disk('public')->put($newLg, $lg);

            $data->image = $newLg;
        }
        if ($request->gallery) {
            $gallery = $request->gallery;
            $gfilename = 'gallery-' . date('dmY-His');
            for ($i = 0; $i < count($gallery); $i++) {
                $lg = Image::make($gallery[$i]->getRealPath());

                $ext = explode("/", $lg->mime())[1];
                $size = $this->ImageSize('gallery');

                $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();

                $newLg = 'upload/splname/gallery/' . $gfilename . '-' . $i . '.' . $ext;

                Storage::disk('public')->put($newLg, $lg);

                GalleryModel::insert(['_id' => $data->id, 'type' => 'splname', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
            }
        }
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
        }
    }
    // public function cpupdate(Request $request, $id)
    // {
    //     $data = splnameModel::find($id);
    //     $data->name = $request->name;

    //     // SEO
    //     // $data->seo_title = $request->seo_title;
    //     // $data->seo_description = $request->seo_description;
    //     // $data->seo_keywords = $request->seo_keywords;
    //     // End Seo
    //     $data->updated = date('Y-m-d H:i:s');
    //     $file = $request->image;
    //     if ($file) {
    //         $filename = date('dmY-His');
    //         $lg = Image::make($file->getRealPath());

    //         // $sm = Image::make($file->getRealPath());

    //         $ext = explode("/", $lg->mime())[1];
    //         $size = $this->ImageSize('cover');

    //         $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();

    //         $newLg = 'upload/splname/' . $filename . '-.' . $ext;

    //         Storage::disk('public')->put($newLg, $lg);

    //         $data->image = $newLg;
    //     }
    //     if ($request->gallery) {
    //         $gallery = $request->gallery;
    //         $gfilename = 'gallery-' . date('dmY-His');
    //         for ($i = 0; $i < count($gallery); $i++) {
    //             $lg = Image::make($gallery[$i]->getRealPath());

    //             $ext = explode("/", $lg->mime())[1];
    //             $size = $this->ImageSize('gallery');

    //             $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();

    //             $newLg = 'upload/splname/gallery/' . $gfilename . '-' . $i . '.' . $ext;

    //             Storage::disk('public')->put($newLg, $lg);

    //             GalleryModel::insert(['_id' => $data->id, 'type' => 'splname', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
    //         }
    //     }
    //     if ($data->save()) {
    //         return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
    //     } else {
    //         return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
    //     }
    // }

    public function copystore(Request $request, $id)
    {
        $data = splnameModel::find($id);
        $data = new splnameModel;
        $data->name = $request->name;
        $data->sort = 1;
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

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
            $newLg = 'upload/splname/' . $filename . '-.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
            $data->image = $newLg;
        }
        if ($data->save()) {
            splnameModel::where('id', '!=', $data->id)->increment('sort');
            // gallery
            if ($request->gallery) {
                $gallery = $request->gallery;
                $gfilename = 'gallery-' . date('dmY-His');
                for ($i = 0; $i < count($gallery); $i++) {
                    $lg = Image::make($gallery[$i]->getRealPath());

                    $ext = explode("/", $lg->mime())[1];
                    $size = $this->ImageSize('gallery');

                    $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
                    // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();

                    $newLg = 'upload/splname/gallery/' . $gfilename . '-' . $i . '.' . $ext;

                    Storage::disk('public')->put($newLg, $lg);

                    GalleryModel::insert(['_id' => $data->id, 'type' => 'splname', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/splname")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/splname/copy")]);
        }
    }
    public function destroy(Request $request)
    {
        $datas = splnameModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                splnameModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = splnameModel::destroy($data->id);
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
        $get = splnameModel::find($id);
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
        $data = splnameModel::find($request->id);

        if ($from != "" && $to != "") {
            if ($from > $to) {
                splnameModel::whereBetween('sort', [$to, $from])->whereNotIn('id', [$data->id])->increment('sort');
            } else {
                splnameModel::whereBetween('sort', [$from, $to])->whereNotIn('id', [$data->id])->decrement('sort');
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
            $data = PjtypeModel::orderBy('sort');
            $view = ($request->view) ? $request->view() : 10;
          
         
            $search_text = $_GET['keyword'];
            $rows = DB::table('tb_pjtype')->where('name','LIKE','%'.$search_text.'%')->paginate(10);

            return view("$this->prefix.pages.pjtype.index",[
                'css'=> ['back-end/css/table-responsive.css'],        
                'js' => [
                    ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                    ["src"=>"back-end/js/table-dragger.min.js"],
                    ["src"=>'back-end/js/sweetalert2.all.min.js'],
                    ["type"=>"text/javascript","src"=>"back-end/build/pjtype.js"],
                ],
                'prefix' => $this->prefix,
                'folder' => 'pjtype',
                'page' => 'index',
                'segment' => "$this->segment/pjtype",
                'rows' => $rows
            ]);
        }
    }
}
