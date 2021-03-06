<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="GET" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}"> รายละเอียดโปรเจ็ค </a></span>
                        <span class="breadcrumb-item active">คัดลอก</span>
                        <div class="card-header-actions"><small class="text-muted"><a href="https://getbootstrap.com/docs/4.0/components/input-group/#custom-file-input">docs</a></small></div>
                    </div>
                    <div class="card-body">
                        @csrf

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">รายละเอียดโปรเจ็ค </a></li>
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
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary" type="submit" name="copy">บันทึก</a>
                        <a class="btn btn-danger" href="{{url("$segment")}}">ยกเลิก</a>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>