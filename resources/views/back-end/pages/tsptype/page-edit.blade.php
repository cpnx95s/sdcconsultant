<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}"> Fields of Specialization </a></span>
                        <span class="breadcrumb-item active">Edit Form</span>
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
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">ภาษาไทย <span class="badge badge-success">TH</span></a></li>
                            </ul>
                            
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">                                                             
                                    <div class="row" style="margin-bottom:5px;">
                                        
                                       
                                            <div class="col-md-12">
                                                <label>ชื่อ</label><span style="color:red">*</span><br />
                                            <input id="name" name="name" type="text" class="form-control" value="{{$row->name}}" autocomplete="off">
                                            </div>
                                        
    
    
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                         
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h4><b>SEO Friendly :</b></h4>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Title :</label><br />
                                <input id="seo_title" name="seo_title" value="{{$row->seo_title}}" placeholder="<title></title>" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Meta Description : </label><br />
                                <input id="seo_description" name="seo_description" value="{{$row->seo_description}}" placeholder='<meta name="description">' class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Meta Keywords : </label><br />
                                <input id="seo_keywords" name="seo_keywords" value="{{$row->seo_keywords}}" placeholder='<meta name="Keywords">' class="form-control">
                            </div>
                        </div>
                        <!-- End SEO FRIENDLY -->

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="signup">Update</button>
                        <a class="btn btn-danger" href="{{url("$segment")}}">Cancel</a>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>