<?php

namespace App\Http\Controllers\Webpanel;

use App\Charts\splChart;
use App\Http\Controllers\Controller;
use App\SplnameModel;
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

        $results = SplnameModel::pluck('score','name');
        //$results -> keys();
        //$results -> values();
        $chart = new splChart;
        $chart->labels($results -> keys());
        $chart->dataset('score', 'bar', $results -> values())->backgroundColor('#5bc0de');
        $chart->title('Score By Sub-contractor',$font_size = 24,$color = '#0275d8', $bold = true, $font_family = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif");

        
        $month = array('Jan', 'Feb', 'Mar', 'Apr', 'May');
        $data = array('1', '2', '3', '4', '5');

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
            
        ],compact('results','chart'));

        
    }
}
