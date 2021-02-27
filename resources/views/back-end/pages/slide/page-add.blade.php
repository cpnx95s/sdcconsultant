<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="post" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}">Slide Mangement</a></span>
                        <span class="breadcrumb-item active">Create Form</span>
                        <div class="card-header-actions"><small class="text-muted"><a href="https://getbootstrap.com/docs/4.0/components/input-group/#custom-file-input">docs</a></small></div>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class=" col-lg-10 col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <h6>Desktop Version: <small class="text-danger">Auto resize {{$size['cover']['lg']['x']}} x {{$size['cover']['lg']['y']}} Pixel</small></h6>
                                        <img src="" class="img-thumbnail" id="preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="image">
                                    <label class="custom-file-label" for="image">Choose file</label>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4">
                                <b>ชื่อบนภาพสไลด์</b>
                                <input id="name" name="name" class="form-control" value="" placeholder="กรอกชื่อบนภาพสไลด์">
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="signup">Create</button>
                        <a class="btn btn-danger" href="{{url("$segment")}}">Cancel</a>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>