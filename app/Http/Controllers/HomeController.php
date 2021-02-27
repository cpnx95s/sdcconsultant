<?php

namespace App\Http\Controllers;

use App\AboutModel;
use App\GalleryModel;
use App\Fields_of_specializationModel;
use App\Our_experienceModel;
use App\ContactModel;
use App\Fields_categoryModel;
use App\ServicesModel;
use Illuminate\Http\Request;

use Faq;
use Session;


class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
           
            ]);
    }
    
    public function fields_of_specialization()
    {
        return view('fields_of_specialization', [
            'row'=>Fields_of_specializationModel::where('status','on')->orderby('sort','asc')->get(),
            'category' => Fields_categoryModel::where('status','on')->orderby('sort','asc')->get(),
            

            ]);
    }
    public function services()
    {
        return view('services', [
            'row' => ServicesModel::where('status','on')->orderby('sort','asc')->get(),
            ]);
    }
    public function our_experience()
    {
        return view('our_experience', [
            'row' => Our_experienceModel::where('status','on')->orderby('sort','asc')->get(),
            ]);
    }
    public function contact()
    {
        return view('contact', [
            'row' => ContactModel::find(1),
            ]);
    }
    public function about()
    {
        return view('about', [
            'row' => AboutModel::find(1),
            'gallery' => GalleryModel::where(['_id'=>1,'type'=>'about'])->get(),  
            ]);
    }
    public function experience_detail($id)
    {
        return view('experience-detail', [
           'row' => Our_experienceModel::find($id),
           'gallery' => GalleryModel::where(['_id'=>$id,'type'=>'our_experience'])->get(),  
            ]);
    }
    
        
}
