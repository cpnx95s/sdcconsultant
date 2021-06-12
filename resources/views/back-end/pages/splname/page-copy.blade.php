<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="GET" action="/webpanel/splname/copy/{id}/create" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}"> Subcontractor </a></span>
                        <span class="breadcrumb-item active">คัดลอก</span>
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
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">ภาษาไทย </a></li>
                            </ul>
                            
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">                                                             
                                    <div class="row" style="margin-bottom:5px;">
                                            <div class="col-md-12">
                                                <label>ชื่อ</label><span style="color:red">*</span><br />
                                            <input id="name" name="name" type="text" class="form-control" value="{{$row->name}}" autocomplete="off">
                                            </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="worktype">
                                            Score
                                        </label>
                                        <select class="select form-control" id="score" name="score">
                                            <option value="" hidden>กรุณาเลือก</option>
                                            <option value="4" @if($row->score == '4') selected @endif>A</option>
                                            <option value="3.5" @if($row->score == '3.5') selected @endif>B+</option>
                                            <option value="3" @if($row->score == '3') selected @endif>B</option>
                                            <option value="2.5" @if($row->score == '2.5') selected @endif>C+</option>
                                            <option value="2" @if($row->score == '2') selected @endif>C</option>
                                            <option value="1.5" @if($row->score == '1.5') selected @endif>D+</option>
                                            <option value="1" @if($row->score == '1') selected @endif>D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                         
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