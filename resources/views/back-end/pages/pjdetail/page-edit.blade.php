<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}"> รายละเอียดโปรเจ็ค </a></span>
                        <span class="breadcrumb-item active">แก้ไข</span>
                        <div class="card-header-actions"><small class="text-muted"><a href="https://getbootstrap.com/docs/4.0/components/input-group/#custom-file-input">docs</a></small></div>
                    </div>
                    <div class="card-body">
                        @csrf

                        {{-- <div class="row">
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <h6>Cover</h6>
                                                @if($row->image == "")
                                                <img src="" class="img-thumbnail" id="preview">
                                                @else
                                                <img src="{{$row->image}}" class="img-thumbnail" id="preview">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <small class="help-block">*รองรับไฟล์ <strong class="text-danger">(jpg, jpeg, png)</strong> เท่านั้น</small>
                                        <small class="text-danger">Auto Resize : {{$size['cover']['lg']['x']}} x {{$size['cover']['lg']['y']}} Pixel</small>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="image" id="image">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">รายละเอียดโปรเจ็ค </a></li>
                            </ul>
                            
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">                                                             
                                    <div class="row" style="margin-bottom:5px;">
                                        
                                       
                                            <div class="col-md-12">
                                            <label>รหัส</label><span style="color:red">*</span><br />
                                            <input id="codename" name="codename" type="text" class="form-control" value="{{$row->codename}}" autocomplete="off">
                                        
                                            <label>ชื่อโปรเจ็ค</label><span style="color:red">*</span><br />
                                        <select id="pjname" name="pjname" class="form-control">
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\PjnameModel::where('status','on')->get(); @endphp
                                                                                                       
                                                    @if($list)
                                                        @foreach($list as $list)
                                                        <option value="{{$list->id}}" @if($row->pjname == $list->id) selected @endif>{{$list->name}}</option>    
                                                        @endforeach
                                                        
                                                    @endif
                                                </select>
                                        <label>ชื่อลูกค้า</label><span style="color:red">*</span><br />
                                        <select id="cusname" name="cusname" class="form-control">
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\CusModel::where('status','on')->get(); @endphp
                                                                                                       
                                                    @if($list)
                                                        @foreach($list as $list)
                                                        <option value="{{$list->id}}" @if($row->cusname == $list->id) selected @endif>{{$list->name}}</option>    
                                                        @endforeach
                                                        
                                                    @endif
                                                </select>
                                        <label>ประเภทโปรเจ็ค</label><span style="color:red">*</span><br />
                                        <select id="pjtype" name="pjtype" class="form-control">
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\PjtypeModel::where('status','on')->get(); @endphp
                                                                                                       
                                                    @if($list)
                                                        @foreach($list as $list)
                                                        <option value="{{$list->id}}" @if($row->pjtype == $list->id) selected @endif>{{$list->name}}</option>     
                                                        @endforeach
                                                        
                                                    @endif
                                                </select></div>
                                        
    
    
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                         {{-- <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="border"><br>
                                            <div class="header">
                                                <div class="col-lg-12">
                                                    <strong style="font-size:18px">Gallery :</strong>
                                                    <a class="btn btn-primary btn-sm" href="javascript:" id="add_gallery">Add</a></div>
                                            </div>
                                            <div id="gallery" class="form-group col-lg-4 col-md-6 col-xs-12" style="display:none;">
                                                <br>
                                                <div class="clearfix"></div>
                                                <small class="help-block">*รองรับไฟล์ <strong class="text-danger">(jpg, jpeg, png)</strong> เท่านั้น</small>
                                                <small class="text-danger">Auto Resize : {{$size['gallery']['lg']['x']}} x {{$size['gallery']['lg']['y']}} px</small>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="gallery[]" id="galleryUpload" multiple="" onchange="readGallery()" accept="image/jpg,image/jpeg,image/png">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                    <span class="input-group-append">
                                                        <button class="btn btn-danger reset-upload" type="button">Reset</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-right pr-2 action-gallery" style="display:none;">
                                                <button type="button" class="btn btn-secondary btn-sm cancel" data-toggle="gallerImg" role="button" disabled>Cancel</button>
                                                <button type="button" class="btn btn-secondary btn-sm deleteGallerys" role="button" disabled>Delete</button>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row" id="galleryPreview">
                                                    @if($gallerys)
                                                    @foreach($gallerys as $i => $v)
                                                    <div class='col-lg-2 col-md-3 col-xs-6 p-2' id="gallery{{$v->id}}">
                                                        <div class='img-thumbnail p-2'>
                                                            <a href="javascript:" class="float-right btn-link" style="margin-bottom:5px;">
                                                                <i class="fas fa-times fa-lg deleteGallery" data-id="{{$v->id}}"></i>
                                                            </a>
                                                            <div class="float-left custom-control custom-checkbox">
                                                                <input type="checkbox" name="gallerImg" class="custom-control-input" id="gall{{$v->id}}" value="{{$v->id}}">
                                                                <label class="custom-control-label" for="gall{{$v->id}}"></label>
                                                            </div>
                                                            <div class="img-preview"><img class="img-fluid" src="{{url("$v->image")}}"></div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>  --}}

                        
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="signup">บันทึก</button>
                        <a class="btn btn-danger" href="{{url("$segment")}}">ยกเลิก</a>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>