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
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}">การบริการ / Service</a></span>
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
                                        <div class="col-md-12">
                                            <label>ชื่อบริษัท</label><span style="color:red">*</span><br />
                                            <input id="company_name" name="company_name" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>ที่อยู่</label><span style="color:red">*</span><br />
                                            <input id="address" name="address" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>เบอร์โทรศัพท์</label><span style="color:red">*</span><br />
                                            <input id="tel" name="tel" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>Fax</label><span style="color:red">*</span><br />
                                            <input id="fax" name="fax" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>อีเมล</label><span style="color:red">*</span><br />
                                            <input id="้email" name="email" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>Line</label><span style="color:red">*</span><br />
                                            <input id="line" name="line" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>facebook</label><span style="color:red">*</span><br />
                                            <input id="facebook" name="facebook" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>twitter</label><span style="color:red">*</span><br />
                                            <input id="twitter" name="twitter" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>
                                     <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>แผนที่</label><span style="color:red">*</span><br />
                                            <input id="map" name="map" placeholder="กรุณาระบุแผนที่" value="" class="form-control">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="border"><br>
                                            <div class="header">
                                                <div class="col-lg-12">
                                                    <strong style="font-size:18px">Gallery :</strong>
                                                    <a class="btn btn-primary btn-sm" href="javascript:" id="add_gallery">Add</a></div>
                                            </div>
                                            {{-- <div id="gallery" class="form-group col-lg-4 col-md-6 col-xs-12" style="display:none;">
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
                                                </div>
                                            </div> --}}
                                            <br>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- SEO FRIENDLY SYSTEM -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h4><b>SEO Friendly :</b></h4>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Title :</label><br />
                                <input id="seo_title" name="seo_title" value="" placeholder="<title></title>" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Meta Description : </label><br />
                                <input id="seo_description" name="seo_description" value="" placeholder='<meta name="description">' class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Meta Keywords : </label><br />
                                <input id="seo_keywords" name="seo_keywords" value="" placeholder='<meta name="Keywords">' class="form-control">
                            </div>
                        </div>
                        <!-- End SEO FRIENDLY -->

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