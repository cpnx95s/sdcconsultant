<?php

namespace App\Http\Controllers\Webpanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\GalleryModel;
use App\VideoModel;

class Home extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    public function index()
    {
        return view("$this->prefix.pages.home.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["src"=>'back-end/build/home.js'],
            ],
            'prefix' => $this->prefix,
            'controller' => 'home',
            'folder' => 'home',
            'page' => 'edit',
            'segment' => "$this->segment/home",
            'row' => \App\HomeModel::find(1),
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.home.index",[
            'prefix' => $this->prefix,
            'controller' => 'home',
            'folder' => 'home',
            'page' => 'add',
            'segment' => "$this->segment/home",
        ]);
    }
    public function edit($id)
    {
        return view("$this->prefix.pages.home.index",[
            'prefix' => $this->prefix,
            'controller' => 'home',
            'folder' => 'home',
            'page' => 'edit',
            'segment' => "$this->segment/home",
            'row' => GalleryModel::find($id)
        ]);
    }
    public function store(Request $request)
    {
        
    }
    public function update(Request $request, $id=null)
    {

        $data = \App\HomeModel::find($request->id);
        $data->detail_th = $request->detail_th;
        $data->detail_en = $request->detail_en;
        $data->address_th = $request->address_th;
        $data->address_en = $request->address_en;
        $data->working = $request->working;
        $data->fax = $request->fax;
        $data->telephone = $request->telephone;
        $data->email = $request->email;
        $data->facebook = $request->facebook;
        $data->instagram = $request->instagram;
        $data->line = $request->line;
        $data->map = $request->map;
        if($data->save())
        {
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->segment/home")]);
        }else{
            return view("$this->prefix.alert.sweet.error",['url'=>url("$this->segment/home")]);
        }

    }
    public function status(Request $request)
    {
        $data = GalleryModel::find($request->id);
        if(@$data->id)
        {
            $data->status = ($data->status==0)? 1 : 0 ;;
            if($data->save()){ return response()->json(true); }else{ return response()->json(false); }

        }else{  return response()->json(false); }
    }
    public function destroy(Request $request)
    {
        $data = GalleryModel::find($request->id);
        $destroy = Storage::disk('public')->delete($data->image);
        if($destroy)
        {
            GalleryModel::destroy($data->id);
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }

    public function updateVideo(Request $request)
    {
        $data = VideoModel::where('type','home')->first();
        $data->key = $request->key;
        if($data->save())
        {
            return view("$this->prefix.alert.sweet.success",['url'=>url("$this->prefix/home")]);
        }else{
            return view("$this->prefix.alert.sweet.error",['url'=>url("$this->prefix/home")]);

        }
    }
    public function actionReport1(){
        $connection = Yii::$app->db;
        $data = $connection->createCommand('
            SELECT year(t.DATETIME_DISCH) as yy,
            month(t.DATETIME_DISCH) as mm,
            COUNT(t.AN) as cnt
            FROM admission t
            GROUP BY yy,mm
            ORDER BY yy,mm
            ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        foreach($data as $d){
            $yy[] = $d['yy'];
            $mm[] = $d['yy'].'-'.$d['mm'];
            $cnt[] = $d['cnt']*1;//นำไปคูณ 1 ป้องกันเป็น string
        }
        
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$data,
            'sort'=>[
                'attributes'=>['yy','mm','cnt']
            ],
        ]);
        return $this->render('report1',[
            'dataProvider'=>$dataProvider,
            'yy'=>$yy,'mm'=>$mm,'cnt'=>$cnt,
        ]);
    }
}
