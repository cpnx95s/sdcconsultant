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
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}">ชื่อโปรเจ็ค</a></span>
                        <span class="breadcrumb-item active">เพิ่ม</span>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">Project Name</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>ชื่อ</label>
                                            <input id="name" name="name" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>โค้ดเนม</label>
                                            <input id="codename" name="codename" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>ประเภทโปรเจ็ค</label>
                                            <select id="pjtype" name="pjtype" class="form-control">
                                                <option value="">กรุณาเลือก</option>
                                                @php $list = \App\PjtypeModel::where('status','on')->get(); @endphp

                                                @if($list)
                                                @foreach($list as $list)
                                                <option value="{{$list->id}}"> {{$list->name}} </option>
                                                @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="signup">บันทึก</button>
                        <a class="btn btn-danger" href="{{url("$segment")}}">ยกเลิก</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>