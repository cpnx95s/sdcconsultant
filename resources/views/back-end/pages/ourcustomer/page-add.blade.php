<style>
    .img-preview {
        width: 100%;
        max-height: 145px;
        overflow: hidden;
    }

    .img-preview>img {
        height: 100%;
    }

    .img-thumbnail {
        text-align: center;
    }
</style>

<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="formEdit" method="post" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}">ลูกค้าของเรา / Customer</a></span>
                        <span class="breadcrumb-item active">Create Form</span>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <h6>Cover</h6>
                                                <img src="" class="img-thumbnail" id="preview">
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
                        </div>

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">ภาษาไทย </a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-6">
                                            <label>ชื่อลูกค้า</label><span style="color:red">*</span><br />
                                            <input id="name" name="name" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-6">
                                            <label>เว็บลูกค้า</label><br />
                                            <input id="link" name="link" type="text" class="form-control" value="" autocomplete="off" placeholder="ลิงค์เว็บลูกค้า ไม่จำเป็นต้องใส่ ตัวอย่าง (https:://www.ชื่อเว็บ.com)">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="signup">Create</button>
                        <a class="btn btn-danger" href="{{url("$segment")}}">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>