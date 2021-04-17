<?php

namespace App\Http\Controllers\Webpanel;

use App\Charts\splChart;
use App\Http\Controllers\Controller;
use App\SplnameModel;
use App\TruckplanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'home';
    protected $folder = 'home';
    public function index(Request $request)
    {
        return view("$this->prefix.pages.$this->folder.index", [
            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ['src' => "back-end/js/table-dragger.min.js"],
                ["type" => "text/javascript", "src" => "back-end/build/home.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'home',
            'page' => 'index',
            'segment' => "$this->segment",
        ]);
    }
    public function Chartjs()
    {
        $mytime = Carbon::now()->format('Y-m-d');
        //dd($mytime);
        $results = SplnameModel::pluck('score', 'name');
        //dd($results);
        $results2 = SplnameModel::pluck('sort');
        // /dd($results2);
        //$results -> keys();
        //$results -> values();
        $chart = new splChart;
        $chart->labels($results->keys());
        $chart->dataset('score', 'bar', $results->values())->backgroundColor('#5bc0de');
        $chart->title('Score By Sub-contractor', $font_size = 24, $color = '#0275d8', $bold = true, $font_family = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif");

        // $chart2 = new splChart;
        // $chart2->labels($results -> keys());
        // $chart2->dataset('score', 'line', $results -> values())->backgroundColor('#5bc0de');
        // $chart2->title('Score By Sub-contractor',$font_size = 24,$color = '#0275d8', $bold = true, $font_family = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif");

        $chart2 = new splChart();
        $chart2->labels($results->keys());
        $chart2->dataset('score', 'line', $results->values())
            ->options(['borderColor' => '#97d881']);

        $chart2->dataset('sort', 'line', $results2->values())
            ->options(['borderColor' => '#ff0000']);

        $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May');
        $data = array('1', '2', '3', '4', '5');

        
        //dd($ttDHLBigC);

        //Flash Express
        $FLH_LH_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '1') ->where('startdate', '=', $mytime)->count();
        $FLH_LH_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '1') ->where('startdate', '=', $mytime)->count();
        $FLH_LH_M =  $FLH_LH_M1 + $FLH_LH_M2;
        $FLH_LH_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '1') ->where('startdate', '=', $mytime)->count();
        $FLH_LH_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '1') ->where('startdate', '=', $mytime)->count();
        $FLH_LH_E =  $FLH_LH_E1 + $FLH_LH_E2;
        $FLH_Del_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '3') ->where('pjname', '=', '1') ->where('startdate', '=', $mytime)->count();
        $FLH_Del_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '3') ->where('pjname', '=', '1') ->where('startdate', '=', $mytime)->count();
        $FLH_Del_E = $FLH_Del_E1 + $FLH_Del_E2;


        //Kerry Express
        $KEY_LH_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '2') ->where('startdate', '=', $mytime)->count();
        $KEY_LH_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '2') ->where('startdate', '=', $mytime)->count();
        $KEY_LH_M = TruckplanModel:: where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '2') ->where('startdate', '=', $mytime)->count();
        $KEY_Del_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '3') ->where('pjname', '=', '2') ->where('startdate', '=', $mytime)->count();
        $KEY_Del_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '3') ->where('pjname', '=', '2') ->where('startdate', '=', $mytime)->count();
        $KEY_Del_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '3') ->where('pjname', '=', '2') ->where('startdate', '=', $mytime)->count();
                

        //Best Express
        $BES_LH_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '8') ->where('startdate', '=', $mytime)->count();
        $BES_LH_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '8') ->where('startdate', '=', $mytime)->count();
        $BES_LH_M = TruckplanModel::  where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '2') ->where('pjname', '=', '8') ->where('startdate', '=', $mytime)->count();                
        $BES_LH_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '8') ->where('startdate', '=', $mytime)->count();
        $BES_LH_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '8') ->where('startdate', '=', $mytime)->count();
        $BES_LH_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '8') ->where('startdate', '=', $mytime)->count();        
        
        //Shopee Express
        $SHOP_FM_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '1') ->where('pjname', '=', '10') ->where('startdate', '=', $mytime)->count();
        $SHOP_FM_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '1') ->where('pjname', '=', '10') ->where('startdate', '=', $mytime)->count();
        $SHOP_FM_M = TruckplanModel::  where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '1') ->where('pjname', '=', '10') ->where('startdate', '=', $mytime)->count();        
        $SHOP_FM_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '1') ->where('pjname', '=', '10') ->where('startdate', '=', $mytime)->count();
        $SHOP_FM_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '1') ->where('pjname', '=', '10') ->where('startdate', '=', $mytime)->count();
        $SHOP_FM_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '1') ->where('pjname', '=', '10') ->where('startdate', '=', $mytime)->count();        

        //CJ logistics
        $CJ_Del_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '3') ->where('pjname', '=', '3') ->where('startdate', '=', $mytime)->count();
        $CJ_Del_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '3') ->where('pjname', '=', '3') ->where('startdate', '=', $mytime)->count();
        $CJ_Del_M = TruckplanModel::  where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '3') ->where('pjname', '=', '3') ->where('startdate', '=', $mytime)->count();        

        //Lazada Express
        $LAZ_FM_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '1') ->where('pjname', '=', '7') ->where('startdate', '=', $mytime)->count();
        $LAZ_FM_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '1') ->where('pjname', '=', '7') ->where('startdate', '=', $mytime)->count();
        $LAZ_FM_M = TruckplanModel::  where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '1') ->where('pjname', '=', '7') ->where('startdate', '=', $mytime)->count();        

        //J&T Express
        $JT_LH_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '11') ->where('startdate', '=', $mytime)->count();
        $JT_LH_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '11') ->where('startdate', '=', $mytime)->count();
        $JT_LH_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '11') ->where('startdate', '=', $mytime)->count();
        
        //SCG Express
        $SCG_LH_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '19') ->where('startdate', '=', $mytime)->count();
        $SCG_LH_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '19') ->where('startdate', '=', $mytime)->count();
        $SCG_LH_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '19') ->where('startdate', '=', $mytime)->count();
        

        //DHL-Big C
        $DHLBigC_DC_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('pjname', '=', '19') ->where('startdate', '=', $mytime)->count();
        $DHLBigC_DC_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('pjname', '=', '19') ->where('startdate', '=', $mytime)->count();
        $DHLBigC_DC_E = $DHLBigC_DC_E1 + $DHLBigC_DC_E2;

        //TWD-CJ Mart
        $TWDCJ_DC_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '4') ->where('pjname', '=', '12') ->where('startdate', '=', $mytime)->count();
        $TWDCJ_DC_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '4') ->where('pjname', '=', '12') ->where('startdate', '=', $mytime)->count();
        $TWDCJ_DC_M = TruckplanModel::  where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '4') ->where('pjname', '=', '12') ->where('startdate', '=', $mytime)->count();        

        //NAEVILLE FOOD SERVICE
        $NEVFOOD_Del_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '3') ->where('pjname', '=', '4') ->where('startdate', '=', $mytime)->count();
        $NEVFOOD_Del_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '3') ->where('pjname', '=', '4') ->where('startdate', '=', $mytime)->count();
        $NEVFOOD_Del_M = TruckplanModel:: where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '3') ->where('pjname', '=', '4') ->where('startdate', '=', $mytime)->count();        

        //Office Mate
        $Office_DC_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '4') ->where('pjname', '=', '5') ->where('startdate', '=', $mytime)->count();
        $Office_DC_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '4') ->where('pjname', '=', '5') ->where('startdate', '=', $mytime)->count();
        $Office_DC_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '4') ->where('pjname', '=', '5') ->where('startdate', '=', $mytime)->count();
        
        //TFG
        $TFG_DC_M1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '4') ->where('pjname', '=', '14') ->where('startdate', '=', $mytime)->count();
        $TFG_DC_M2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '4') ->where('pjname', '=', '14') ->where('startdate', '=', $mytime)->count();
        $TFG_DC_M = TruckplanModel::  where('worktype', '=', 'งานหลัก') ->where('tsptype', '=', '4') ->where('pjname', '=', '14') ->where('startdate', '=', $mytime)->count();        

        //DHL - Makro

        //K-Line
        $KLine_LH_E1 = TruckplanModel:: where('statusplan', '=', 'Pending') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '15') ->where('startdate', '=', $mytime)->count();
        $KLine_LH_E2 = TruckplanModel:: where('statusplan', '=', 'Active') ->where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '15') ->where('startdate', '=', $mytime)->count();
        $KLine_LH_E = TruckplanModel::  where('worktype', '=', 'งานเสริม') ->where('tsptype', '=', '2') ->where('pjname', '=', '15') ->where('startdate', '=', $mytime)->count();        

        return view("$this->prefix.pages.$this->folder.index", [

            'js' => [
                ['type' => "text/javascript", 'src' => "back-end/js/jquery.min.js", 'class' => "view-script"],
                ["src" => 'back-end/js/sweetalert2.all.min.js'],
                ['src' => "back-end/js/table-dragger.min.js"],
                ["type" => "text/javascript", "src" => "back-end/build/home.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'home',
            'page' => 'index',
            'segment' => "$this->segment",
            'Month' => $month,
            'Data' => $data,
            'DHLBigC_DC_E1' => $DHLBigC_DC_E1,
            'DHLBigC_DC_E2' => $DHLBigC_DC_E2,
            'DHLBigC_DC_E' => $DHLBigC_DC_E,
            'FLH_LH_M1' => $FLH_LH_M1,
            'FLH_LH_M2' => $FLH_LH_M2,
            'FLH_LH_M' => $FLH_LH_M,
            'FLH_LH_E1' => $FLH_LH_E1, 
            'FLH_LH_E2' => $FLH_LH_E2, 
            'FLH_LH_E' => $FLH_LH_E,
            'FLH_Del_E1' => $FLH_Del_E1, 
            'FLH_Del_E2' => $FLH_Del_E2,
            'FLH_Del_E' => $FLH_Del_E,
            'BES_LH_M1' => $BES_LH_M1, 
            'BES_LH_M2' => $BES_LH_M2,
            'BES_LH_M' => $BES_LH_M,
            'BES_LH_E1' => $BES_LH_E1, 
            'BES_LH_E2' => $BES_LH_E2,
            'BES_LH_E' => $BES_LH_E,
            'KEY_LH_M1' => $KEY_LH_M1,
            'KEY_LH_M2' => $KEY_LH_M2,
            'KEY_LH_M' => $KEY_LH_M,
            'KEY_Del_E1' => $KEY_Del_E1,
            'KEY_Del_E2' => $KEY_Del_E2,
            'KEY_Del_E' => $KEY_Del_E,
            'SHOP_FM_M1' => $SHOP_FM_M1,
            'SHOP_FM_M2' => $SHOP_FM_M2,
            'SHOP_FM_M' => $SHOP_FM_M,
            'SHOP_FM_E1' => $SHOP_FM_E1,
            'SHOP_FM_E2' => $SHOP_FM_E2,
            'SHOP_FM_E' => $SHOP_FM_E,
            'CJ_Del_M1' => $CJ_Del_M1,
            'CJ_Del_M2' => $CJ_Del_M2,
            'CJ_Del_M' => $CJ_Del_M,
            'LAZ_FM_M1' => $LAZ_FM_M1,
            'LAZ_FM_M2' => $LAZ_FM_M2,
            'LAZ_FM_M' => $LAZ_FM_M,
            'JT_LH_E1' => $JT_LH_E1,
            'JT_LH_E2' => $JT_LH_E2,
            'JT_LH_E' => $JT_LH_E,
            'SCG_LH_E1' => $SCG_LH_E1,
            'SCG_LH_E2' => $SCG_LH_E2,
            'SCG_LH_E' => $SCG_LH_E,
            'TWDCJ_DC_M1' => $TWDCJ_DC_M1,
            'TWDCJ_DC_M2' => $TWDCJ_DC_M2,
            'TWDCJ_DC_M' => $TWDCJ_DC_M,
            'NEVFOOD_Del_M1' => $NEVFOOD_Del_M1,
            'NEVFOOD_Del_M2' => $NEVFOOD_Del_M2,
            'NEVFOOD_Del_M' => $NEVFOOD_Del_M,
            'Office_DC_E1' => $Office_DC_E1,
            'Office_DC_E2' => $Office_DC_E2,
            'Office_DC_E' => $Office_DC_E,
            'TFG_DC_M1' => $TFG_DC_M1,
            'TFG_DC_M2' => $TFG_DC_M2,
            'TFG_DC_M' => $TFG_DC_M,
            'KLine_LH_E1' => $KLine_LH_E1,
            'KLine_LH_E2' => $KLine_LH_E2,
            'KLine_LH_E' => $KLine_LH_E,
            'mytime' => $mytime,
            
        ], compact('results', 'chart', 'chart2'));
    }
}
