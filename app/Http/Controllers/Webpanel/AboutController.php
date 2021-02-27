<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use App\AboutModel;
use App\GalleryModel;

class AboutController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'about';
    protected $folder = 'about';

    public function ImageSize($find = null)
    {
        $arr = [
            // 'cover' => [
            //     'lg' => ['x' => 360, 'y' => 232.8],
                
            // ],
            'gallery' => [
                'lg' => ['x' => 1140, 'y' => 515.84],
                'md' => ['x' => 1140, 'y' => 515.84],
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
        $data = AboutModel::orderBy('sort');
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
                ["type" => "text/javascript", "src" => "back-end/build/about.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'about',
            'page' => 'index',
            'segment' => "$this->segment/about",
            'rows' => $rows
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => 'back-end/tinymce/tinymce.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/about.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'add',
            'segment' => "$this->segment/about",
            'size' => $this->ImageSize(),
        ]);
    }
    public function store(Request $request)
    {

        $data = new AboutModel;
        $data->word = $request->word;
        $data->company_name = $request->company_name;
        $data->short_detail = $request->short_detail;
        $data->detail = $request->detail;
        $data->status = 'on';
        $data->sort = 1;
        $data->created = date('Y-m-d H:i:s');
        $data->updated = date('Y-m-d H:i:s');
        // SEO
        // $data->seo_title = $request->seo_title;
        // $data->seo_description = $request->seo_description;
        // $data->seo_keywords = $request->seo_keywords;
        // End Seo
        $file = $request->image;
        if ($file) {
            $filename = date('dmY-His');
            $lg = Image::make($file->getRealPath());
            // $md = Image::make($file->getRealPath());
            // $sm = Image::make($file->getRealPath());

            $ext = explode("/", $lg->mime())[1];
            // $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
           
            // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $newLg = 'upload/about/' . $filename . '-.' . $ext;
            $newMd = 'upload/about/' . $filename . '-md.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
            Storage::disk('public')->put($newMd, $md);
            $data->image = $newLg;
        }
        if ($data->save()) {
            AboutModel::where('id', '!=', $data->id)->increment('sort');
            // gallery
            if ($request->gallery) {
                $gallery = $request->gallery;
                $gfilename = 'gallery-' . date('dmY-His');
                for ($i = 0; $i < count($gallery); $i++) {
                    $lg = Image::make($gallery[$i]->getRealPath());
                    $md = Image::make($gallery[$i]->getRealPath());
                    // $sm = Image::make($gallery[$i]->getRealPath());

                    $ext = explode("/", $lg->mime())[1];
                    $size = $this->ImageSize('gallery');

                    $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
                    
                    // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();

                    $newLg = 'upload/about/gallery/' . $gfilename . '-' . $i . '.' . $ext;
                    $newMd = 'upload/about/gallery/' . $gfilename . '-' . $i . '-md.' . $ext;
                    // $aboutm = 'upload/about/gallery/'.$gfilename.'-'.$i.'-sm.'.$ext;

                    Storage::disk('public')->put($newLg, $lg);
                    Storage::disk('public')->put($newMd, $md);
                    // Storage::disk('public')->put($aboutm, $sm);

                    GalleryModel::insert(['_id' => $data->id, 'type' => 'about', 'image' => $newMd, 'created' => date('Y-m-d H:i:s')]);
                }
            }
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/about")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/about/create")]);
        }
    }
    public function edit($id)
    {
        $row = AboutModel::find($id);
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ['src' => "back-end/tinymce/tinymce.min.js"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ["type" => "text/javascript", "src" => "back-end/build/about.js"],
            ],
            'prefix' => $this->prefix,
            'controller' => $this->controller,
            'folder' => $this->folder,
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => $row,
            'gallerys' => GalleryModel::where(['type' => 'about', '_id' => $id])->get(),
            'size' => $this->ImageSize(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = AboutModel::find($id);
        $data->word = $request->word;
        $data->company_name = $request->company_name;
        $data->short_detail = $request->short_detail;
        $data->detail = $request->detail;
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
            // $size = $this->ImageSize('cover');

            $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
            // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();
            $newLg = 'upload/about/' . $filename . '-.' . $ext;
            $newMd = 'upload/about/' . $filename . '-md.' . $ext;
            Storage::disk('public')->put($newLg, $lg);
            Storage::disk('public')->put($newMd, $md);
            $data->image = $newLg;
        }
        if ($request->gallery) {
            $gallery = $request->gallery;
            $gfilename = 'gallery-' . date('dmY-His');
            for ($i = 0; $i < count($gallery); $i++) {
                $lg = Image::make($gallery[$i]->getRealPath());
                $md = Image::make($gallery[$i]->getRealPath());
                // $sm = Image::make($gallery[$i]->getRealPath());

                $ext = explode("/", $lg->mime())[1];
                $size = $this->ImageSize('gallery');

                $lg->resize($size['lg']['x'], $size['lg']['y'])->stream();
                $md->resize($size['md']['x'], $size['md']['y'])->stream();
                // $sm->resize($size['sm']['x'],$size['sm']['y'])->stream();

                $newLg = 'upload/about/gallery/' . $gfilename . '-' . $i . '.' . $ext;
                $newMd = 'upload/about/gallery/' . $gfilename . '-' . $i . '-md.' . $ext;
                // $aboutm = 'upload/about/gallery/'.$gfilename.'-'.$i.'-sm.'.$ext;

                Storage::disk('public')->put($newLg, $lg);
                Storage::disk('public')->put($newMd, $md);
                // Storage::disk('public')->put($aboutm, $sm);

                GalleryModel::insert(['_id' => $data->id, 'type' => 'about', 'image' => $newMd, 'created' => date('Y-m-d H:i:s')]);
            }
        }
        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/$this->controller/1")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/$this->controller/1")]);
        }
    }

    public function destroy(Request $request)
    {
        $datas = AboutModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

                AboutModel::where('sort', '>', $data->sort)->decrement('sort');
                //destroy
                $query = AboutModel::destroy($data->id);
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
        $get = AboutModel::find($id);
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

        $get = AboutModel::find($request->id);
        if ($from != "" && $to != "") {
            if ($from > $to) {
                AboutModel::whereBetween('sort', [$to, $from])->whereNotIn("id", [$get->id])->increment('sort', 1);
            } else {
                AboutModel::whereBetween('sort', [$from, $to])->whereNotIn("id", [$get->id])->decrement('sort', 1);
            }
            $query = AboutModel::where('id', $get->id)->update(['sort' => $to]);
            return response()->json($query);
        }
        return response()->json(false);
    }
}
