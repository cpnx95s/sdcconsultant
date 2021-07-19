<?php

namespace App\Http\Controllers\Webpanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserModel;

class User extends Controller
{
    protected $prefix = 'back-end';
    protected $segment = 'adminwebpanel';
    protected $segmentst = 'staffuser';
    public function index()
    {
        return view("$this->prefix.pages.user.index",[            
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.slim.min.js",'class'=>"view-script"],
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/user.js"],
            ],
            'prefix' => $this->prefix,
            'segment' => $this->segment,
     
            'folder' => 'user',
            'page' => 'index',
            'controller' => 'user',
            'rows' => UserModel::paginate(10)
        ]);
    }
    public function edit(Request $request,$id)
    {
        return view("$this->prefix.pages.user.index",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/user-manage-validate.js"],
                
            ],
            'prefix' => $this->prefix,
            'folder' => 'user',
            'page' => 'edit',
            'segment' => $this->segment,
            'row' => UserModel::find($id)
        ]);
    }
    public function create()
    {
        return view("$this->prefix.pages.user.index",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/user-manage-validate.js"],
                
            ],
            'prefix' => $this->prefix,
            'segment' => $this->segment,
            'folder' => 'user',
            'page' => 'add',
            
        ]);
    }
    public function reset($id)
    {
        return view("$this->prefix.pages.user.index",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/user-manage-validate.js"],
                
            ],
            'prefix' => $this->prefix,
            'folder' => 'user',
            'page' => 'reset',
            'segment' => $this->segment,
            'row' => UserModel::find($id)
        ]);
    }
    public function onReset(Request $request,$id=null)
    {
        $data = \App\UserModel::find($id);
        if($request->username){
            $data->username = $request->username;
        }
        $data->password = bcrypt($request->password);
        $data->updated_at = date('Y-m-d H:i:s');
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segment/user")]);
        }else{
            return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segment/user/reset")]);
        }
    }
    public function store(Request $request)
    {
        $data = new UserModel;
        $data->role = $request->role;
        $data->status = $request->status;
        $data->name = $request->name;
        $data->email = $request->username;
        $data->password = bcrypt($request->password);
        $data->created_at = date('Y-m-d H:i:s');
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/user")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/user/create")]);
        }
    }
    public function update(Request $request, $id=null)
    {
        $data = UserModel::find($id);
        $data->role = $request->role;
        $data->status = $request->status;
        $data->name = $request->name;
        $data->updated_at = date('Y-m-d H:i:s');

        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segment/user")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segment/user/" . $id)]);
        }
    }
    public function destroy(Request $request)
    {
        $datas = UserModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {
                $query = UserModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function dragsort(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $data = UserModel::find($request->id);

        if($from!="" && $to !="")
        {
            if($from > $to){
                UserModel::whereBetween('sort', [$to, $from])->whereNotIn('id',[$data->id])->increment('sort');
            }else{
                UserModel::whereBetween('sort', [$from, $to])->whereNotIn('id',[$data->id])->decrement('sort');
            }
            $data->sort = $to;
            if($data->save()){
                return response()->json(true);
            }else{
                return response()->json(false);
            }
        }
        return response()->json(false);
    }
    public function exist(Request $request)
    {
        $data = \App\UserModel::where('email',$request->username)->count();
        if($data){ 
            return response()->json(false); 
        }else{ 
            return response()->json(true);
        }
    }
    public function checkUserOnReset(Request $request)
    {
        $data = \App\UserModel::where('email','!=',$request->username)->count();
        if($data){ 
            // return response()->json(false); 
            $check = \App\UserModel::where('email',$request->username)->count();
            if($check){
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else{ 
            return response()->json(true);
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    ///////     admin                                     ////////////////////////
    /////////////////////////////////////////////////////////////////////////////
    public function staffindex()
    {
        return view("$this->prefix.pages.user.staffindex",[            
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.slim.min.js",'class'=>"view-script"],
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["src"=>'back-end/js/sweetalert2.all.min.js'],
                ["type"=>"text/javascript","src"=>"back-end/build/user.js"],
            ],
            'prefix' => $this->prefix,
            'segment' => $this->segmentst,
            'folder' => 'user',
            'page' => 'index',
            'controller' => 'user',
            'rows' => UserModel::paginate(10)
        ]);
    }
    public function staffedit(Request $request,$id)
    {
        return view("$this->prefix.pages.user.staffindex",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/user-manage-validate.js"],
                
            ],
            'prefix' => $this->prefix,
            'folder' => 'user',
            'page' => 'edit',
            'segment' => $this->segmentst,
            'row' => UserModel::find($id)
        ]);
    }
    public function staffcreate()
    {
        return view("$this->prefix.pages.user.staffindex",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/user-manage-validate.js"],
                
            ],
            'prefix' => $this->prefix,
            'segment' => $this->segmentst,
            'folder' => 'user',
            'page' => 'add',
            
        ]);
    }
    public function staffreset($id)
    {
        return view("$this->prefix.pages.user.staffindex",[
            'css'=> [
                "back-end/css/select2.min.css",
                "back-end/css/select2-coreui.min.css",
                "back-end/css/bootstrap-select.min.css",
            ],
            'js' => [
                ['type'=>"text/javascript",'src'=>"back-end/js/jquery.min.js",'class'=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/js/select2.min.js","clas"=>"view-script"],
                ["type"=>"text/javascript","src"=>"back-end/jquery-validation-1.19.1/dist/jquery.validate.min.js"],
                ["src"=>"back-end/js/bootstrap-select.min.js"],
                ["type"=>"text/javascript","src"=>"back-end/build/user-manage-validate.js"],
                
            ],
            'prefix' => $this->prefix,
            'folder' => 'user',
            'page' => 'reset',
            'segment' => $this->segmentst,
            'row' => UserModel::find($id)
        ]);
    }
    public function staffonReset(Request $request,$id=null)
    {
        $data = \App\UserModel::find($id);
        if($request->username){
            $data->username = $request->username;
        }
        $data->password = bcrypt($request->password);
        $data->updated_at = date('Y-m-d H:i:s');
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success",['url'=>url("$this->segmentst/user")]);
        }else{
            return view("$this->prefix/alert/sweet/error",['url'=>url("$this->segmentst/user/reset")]);
        }
    }
    public function staffstore(Request $request)
    {
        $data = new UserModel;
        $data->role = $request->role;
        $data->status = $request->status;
        $data->name = $request->name;
        $data->email = $request->username;
        $data->password = bcrypt($request->password);
        $data->created_at = date('Y-m-d H:i:s');
        if($data->save())
        {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentst/user")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentst/user/create")]);
        }
    }
    public function staffupdate(Request $request, $id=null)
    {
        $data = UserModel::find($id);
        $data->role = $request->role;
        $data->status = $request->status;
        $data->name = $request->name;
        $data->updated_at = date('Y-m-d H:i:s');

        if ($data->save()) {
            return view("$this->prefix/alert/sweet/success", ['url' => url("$this->segmentst/user")]);
        } else {
            return view("$this->prefix/alert/sweet/error", ['url' => url("$this->segmentst/user/" . $id)]);
        }
    }
    public function staffdestroy(Request $request)
    {
        $datas = UserModel::find(explode(',', $request->id));
        if (@$datas) {
            foreach ($datas as $data) {

              
                $query = UserModel::destroy($data->id);
            }
        }
        if (@$query) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function staffexist(Request $request)
    {
        $data = \App\UserModel::where('email',$request->username)->count();
        if($data){ 
            return response()->json(false); 
        }else{ 
            return response()->json(true);
        }
    }
    public function staffcheckUserOnReset(Request $request)
    {
        $data = \App\UserModel::where('email','!=',$request->username)->count();
        if($data){ 
            // return response()->json(false); 
            $check = \App\UserModel::where('email',$request->username)->count();
            if($check){
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else{ 
            return response()->json(true);
        }
    }
}
