<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\Fields_of_specializationModel;
use App\GalleryModel;

class Fields_of_specializationController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'fields_of_specialization';
    protected $folder = 'fields_of_specialization';

    public function ImageSize($find = null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x' => 500 , 'y' => 500],
            ],
            'gallery' => [
                'lg' => ['x' => 664, 'y' => 460],
                'md' => ['x' => 664, 'y' => 460],
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
        $data = Fields_of_specializationModel::orderBy('sort');
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
                ["type" => "text/javascript", "src" => "back-end/build/fields_of_specialization.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'fields_of_specialization',
            'page' => 'index',
            'segment' => "$this->segment/fields_of_specialization",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/fields_of_specialization.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/fields_of_specialization",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new Fields_of_specializationModel;
        $data->_id = $request->_id;
        $data->list_detail = $request->list_detail;
        $data->status = 'on';
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
            $md = Image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
            $newLg = 'upload/fields_of_specialization/' . $filename . '-.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
            
            $data->image = $newLg;
        }
        if ($data->save()) {
            Fields_of_specializationModel::where('id', '!=', $data->id)->increment('sort');
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

                    $newLg = 'upload/fields_of_specialization/gallery/' . $gfilename . '-' . $i . '.' . $ext;

                    Storage::disk('public')->put($newLg, $lg);

                    GalleryModel::insert(['_id' => $data->id, 'type' => 'fields_of_specialization', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/fields_of_specialization")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/fields_of_specialization/create")]);
        }
    }
    public function edit($id)
    {
        $row = Fields_of_specializationModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/fields_of_specialization.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => $row,
            'gallerys' => GalleryModel::where(['type' => 'fields_of_specialization', '_id' => $id])->get(),
            'size' => $this->ImageSize(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Fields_of_specializationModel::find($id);
        $data->_id = $request->_id;
        $data->list_detail = $request->list_detail;
     
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
            $md = Image::make($file->getRealPath());
            // $sm = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();

            $newLg = 'upload/fields_of_specialization/' . $filename . '-.' . $ext;
            $newMd = 'upload/portfolio/' . $filename . '-md.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
        
            $data->image = $newLg;
        }
        if ($request->gallery) {
            $gallery = $request->gallery;
            $gfilename = 'gallery-' . date('dmY-His');
            for ($i = 0; $i < count($gallery); $i++) {
                $lg = Image::make($gallery[$i]->getRealPath());
                $md = Image::make($gallery[$i]->getRealPath());
                $ext = explode("/", $lg->mime())[1];
                $size = $this->ImageSize('gallery');

                $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
                $md->resize($size['md']['x'], $size['md']['y'])->stream();
                
                $newLg = 'upload/fields_of_specialization/gallery/' . $gfilename . '-' . $i . '.' . $ext;
                $newMd = 'upload/portfolio/gallery/' . $gfilename . '-' . $i . '-md.' . $ext;
                
                Storage::disk('public')->put($newLg, $lg);
                Storage::disk('public')->put($newMd, $md);
                
                GalleryModel::insert(['_id' => $data->id, 'type' => 'fields_of_specialization', 'image' => $newLg, 'created' => date('Y-m-d H:i:s')]);
            }
        }
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/" . $id)]);
        }
    }

    public function destroy(Request $request)
    {
        $datas = Fields_of_specializationModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                Fields_of_specializationModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = Fields_of_specializationModel::destroy($data->id);
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
        $get = Fields_of_specializationModel::find($id);
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

        $get = Fields_of_specializationModel::find($request->id);
        if ($from != "" && $to != "") {
            if ($from > $to) {
                Fields_of_specializationModel::whereBetween('sort', [$to, $from])->whereNotIn("id", [$get->id])->increment('sort', 1);
            } else {
                Fields_of_specializationModel::whereBetween('sort', [$from, $to])->whereNotIn("id", [$get->id])->decrement('sort', 1);
            }
            $query = Fields_of_specializationModel::where('id', $get->id)->update(['sort' => $to]);
            return response()->json($query);
        }
        return response()->json(false);
    }
}
