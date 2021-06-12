<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="GET" action="/webpanel/truckplan/copy/{id}/create" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}"> แผนรถ </a></span>
                        <span class="breadcrumb-item active">คัดลอก</span>
                        <div class="card-header-actions"><small class="text-muted"><a href="https://getbootstrap.com/docs/4.0/components/input-group/#custom-file-input">docs</a></small></div>
                    </div>
                    <div class="card-body">
                        @csrf
                       
                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">แผนรถ</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">

                                    <!-- <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>ชื่อ</label><span style="color:red">*</span><br />
                                            <input id="name" name="name" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div> -->

                                    <div class="form-group ">
                                        <label class="control-label " for="startdate">
                                            วันที่ใช้รถ
                                        </label>
                                        <input class="form-control" id="startdate" name="startdate" placeholder="" value="{{$row->startdate}}" type="date" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="worktype">
                                            ประเภทงาน
                                        </label>
                                        <select class="select form-control" id="worktype" name="worktype">
                                            <option value="" hidden>กรุณาเลือก</option>
                                            <option value="งานหลัก" @if($row->worktype=='งานหลัก') selected @endif>งานหลัก</option>
                                            <option value="งานเสริม" @if($row->worktype=='งานเสริม') selected @endif>งานเสริม</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="pjname">
                                            ชื่อโปรเจค
                                        </label>
                                        <select id="pjname" name="pjname" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\PjnameModel::where('status','on')->get(); @endphp

                                            @if($list)
                                            @foreach($list as $list)
                                            <option value="{{$list->id}}" @if($row->pjname == $list->id) selected @endif>{{$list->name}}</option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="splname">
                                            Subcontractor
                                        </label>
                                        <select id="splname" name="splname" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\SplnameModel::where('status','on')->get(); @endphp

                                            @if($list)
                                            @foreach($list as $list)
                                            <option value="{{$list->id}}" @if($row->splname == $list->id) selected @endif>{{$list->name}}</option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="routecode" ">
                                            รหัสสายวิ่ง
                                        </label>
                                        <input class=" form-control" id="routecode" name="routecode" type="text" value="{{$row->routecode}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="routename">
                                            ชื่อเส้นทางเดินรถ
                                        </label>
                                        <input class="form-control" id="routename" name="routename" type="text" value="{{$row->routename}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="tsptype">
                                            ประเภทการขนส่ง
                                        </label>
                                        <select id="tsptype" name="tsptype" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\TsptypeModel::where('status','on')->get(); @endphp

                                            @if($list)
                                            @foreach($list as $list)
                                            <option value="{{$list->id}}" @if($row->tsptype == $list->id) selected @endif> {{$list->name}} </option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="trucktype">
                                            ประเภทรถ
                                        </label>
                                        <select id="trucktype" name="trucktype" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\TrucktypeModel::where('status','on')->get(); @endphp

                                            @if($list)
                                            @foreach($list as $list)
                                            <option value="{{$list->id}}" @if($row->trucktype == $list->id) selected @endif> {{$list->name}} </option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="roundtrip">
                                            เที่ยวรถ
                                        </label>
                                        <select id="roundtrip" name="roundtrip" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\RoundtripModel ::where('status','on')->get(); @endphp

                                            @if($list)
                                            @foreach($list as $list)
                                            <option value="{{$list->id}}" @if($row->roundtrip == $list->id) selected @endif > {{$list->name}} </option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="hiringtype">
                                            รูปแบบการว่าจ้าง
                                        </label>
                                        <select id="hiringtype" name="hiringtype" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\HiringtypeModel ::where('status','on')->get(); @endphp

                                            @if($list)
                                            @foreach($list as $list)
                                            <option value="{{$list->id}}" @if($row->hiringtype == $list->id) selected @endif> {{$list->name}} </option>
                                            @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="trucknumb">
                                            เลขทะเบียนรถ
                                        </label>
                                        <input class="form-control" id="trucknumb" name="trucknumb" type="text" value="{{$row->trucknumb}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="driver">
                                            พนักงานขับรถ
                                        </label>
                                        <input class="form-control" id="driver" name="driver" type="text" value="{{$row->driver}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="telnumb">
                                            เบอร์โทร
                                        </label>
                                        <input class="form-control" id="telnumb" name="telnumb" type="text" value="{{$row->telnumb}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="sbranch">
                                            สาขาต้นทาง
                                        </label>
                                        <input class="form-control" id="sbranch" name="sbranch" type="text" value="{{$row->sbranch}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dntbranch">
                                            สาขาปลายทาง
                                        </label>
                                        <input class="form-control" id="dntbranch" name="dntbranch" type="text" value="{{$row->dntbranch}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="truckrqtime">
                                            เวลาตามรถ
                                        </label>
                                        <input class="form-control" id="truckrqtime" name="truckrqtime" type="time" value="{{$row->truckrqtime}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dpttime">
                                            เวลาปล่อยรถ
                                        </label>
                                        <input class="form-control" id="dpttime" name="dpttime" type="time" value="{{$row->dpttime}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dnttime">
                                            เวลากำหนดถึงปลายทาง
                                        </label>
                                        <input class="form-control" id="dnttime" name="dnttime" type="time" value="{{$row->dnttime}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="totalhour">
                                            เวลาที่กำหนด(ชั่วโมง)
                                        </label>
                                        <input class="form-control" id="totalhour" name="totalhour" type="text" value="{{$row->totalhour}}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="mntstaff">
                                            Monitor staff(KDR)
                                        </label>
                                        <input class="form-control" id="mntstaff" name="mntstaff" type="text" value="{{$row->mntstaff}}" />
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label " for="remark">
                                            หมายเหตุ
                                        </label>
                                        <input class="form-control" id="remark" name="remark" type="text" value="{{$row->remark}}" />
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label " for="statusplan">
                                            สถานะแผน
                                        </label>
                                        <select class="select form-control" id="statusplan" name="statusplan" onchange="fstatusplan()">
                                            <option value="Active" @if($row->statusplan=='Active') selected @endif>
                                                Active
                                            </option>
                                            <option value="Pending" @if($row->statusplan=='Pending') selected @endif>
                                                Pending
                                            </option>
                                            <option value="Cancel" @if($row->statusplan=='Cancel') selected @endif>
                                                Cancel
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group name="cancelarea" id="cancelarea" ">
                                        <label class="control-label " for="ccremark">
                                            สาเหตุที่ยกเลิก
                                        </label>
                                        <input class="form-control" id="ccremark" name="ccremark" type="text" value="{{$row->ccremark}}" />
                                    </div>
                                    
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="author">
                                            ผู้สร้างรายการ
                                        </label> -->
                                        <input hidden class="form-control" id="author" name="author" type="text" value="{{$row->author}}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="editor">
                                            ผู้แก้ไขรายการ
                                        </label> -->
                                        @php $username = Auth::user()->name; @endphp
                                        <input hidden class="form-control" id="editor" name="editor" type="text" value="{{$username}}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="created">
                                            วันเวลาที่ทำรายการ
                                        </label> -->
                                        <input hidden class="form-control" id="created" name="created" type="text" placeholder="" value="{{$row->created}}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="updated">
                                            วันเวลาที่แก้ไขรายการ
                                        </label> -->
                                        @php $date = date('Y-m-d H:i:s'); @endphp
                                        <input hidden class="form-control" id="updated" name="updated" type="text" placeholder="" value="{{$date}}" />
                                    <!-- </div> -->


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