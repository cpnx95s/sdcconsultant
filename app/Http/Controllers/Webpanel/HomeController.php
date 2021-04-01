<?php

namespace App\Http\Controllers\Webpanel;

use App\Charts\splChart;
use App\Http\Controllers\Controller;
use App\SplnameModel;
use App\TruckplanModel;
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

        $DHLBigC = TruckplanModel::
                    where('statusplan', '=', 'Pending')
                    ->where('worktype', '=', 'งานเสริม')
                    ->where('pjname', '=', '19')
                    ->count();

        $DHLBigC2 = TruckplanModel::
                    where('statusplan', '=', 'Active')
                    ->where('worktype', '=', 'งานเสริม')
                    ->where('pjname', '=', '19')
                    ->count();

        $ttDHLBigC = $DHLBigC + $DHLBigC2;
        //dd($ttDHLBigC);

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
            'DHLBigC' => $DHLBigC,
            'DHLBigC2' => $DHLBigC2,
            'ttDHLBigC' => $ttDHLBigC,

        ], compact('results', 'chart', 'chart2'));
    }
}
