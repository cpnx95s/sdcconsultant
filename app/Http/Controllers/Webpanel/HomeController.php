<?php

namespace App\Http\Controllers\Webpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'webpanel';
    protected $controller = 'home';
    protected $folder = 'home';
    public function index(Request $request)
    {
        return view("$this->prefix.pages.$this->folder.index",[
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ['src'=>"back-end/js/table-dragger.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/home.js"],
            ],
            'prefix' => $this->prefix,
            'folder' => 'home',
            'page' => 'index',
            'segment' => "$this->segment",
        ]);
    }
}
