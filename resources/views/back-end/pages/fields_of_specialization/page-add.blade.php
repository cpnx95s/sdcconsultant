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
            <form id="formEดdit" method="post" action="" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}">Fields of Specialization</a></span>
                        <span class="breadcrumb-item active">Create Form</span>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">ภาษาไทย </a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">                               

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>ประเภท</label><span style="color:red">*</span><br />
                                            <select id="_id" name="_id" class="form-control">
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\Fields_categoryModel::where('status','on')->get(); @endphp
                                                   
                                                    {{-- @php $cc = \App\Fields_of_specializationModel::where('status','on')->get(); @endphp --}}
                                                    @if($list)
                                                        @foreach($list as $list)
                                                        <option value="{{$list->id}}"> {{$list->name}} </option>     
                                                        @endforeach
                                                        
                                                    @endif
                                                </select>
                                                
                                            {{-- 
                                                @if($cc)
                                                @foreach($cc as $cc)
                                                {{name}}
                                                @php $product = Fields_of_specializationModel::where('_id',$cc->id)->get(); @endphp
                                                @forea
                                                - subcate
                                            @endforeach --}}
                                        </div>
                                    </div>


                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>รายละเอียดหัวข้อย่อย</label><span style="color:red">*</span><br />
                                            <input id="list_detail" name="list_detail" type="text" class="form-control" value="" autocomplete="off">
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