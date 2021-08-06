<script src="{{ asset('back-end/build/jquery10.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form id="signupForm" method="post" action="" enctype="multipart/form-data" name="form1" onSubmit="JavaScript:return fncSubmit();">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{ url("$segment") }}"> แผนรถ </a></span>
                        <span class="breadcrumb-item active">แก้ไข</span>
                        <div class="card-header-actions"><small class="text-muted"><a
                                    href="https://getbootstrap.com/docs/4.0/components/input-group/#custom-file-input">docs</a></small>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab"
                                        aria-controls="th">แผนรถ</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="th" role="tabpanel">

                                    <!-- <div class="row" style="margin-bottom:5px;">
                                        <div class="col-md-12">
                                            <label>ชื่อ</label><span style="color:red">*</span><br />
                                            <input id="name" name="name" type="text" class="form-control" value="" autocomplete="off">
                                        </div>
                                    </div> -->

                                    <div class="form-row d-flex justify-content-between">
                                        <div class="col-md-2">
                                            <div class="form-group date">
                                                <label class="control-label " for="startdate">
                                                    วันที่ใช้รถ
                                                </label>
                                                <input class="form-control " id="startdate" name="startdate" placeholder="" type="date" value="{{ $row->startdate }}" type="date" require />

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group ">
                                                <label class="control-label " for="statusplan">
                                                    สถานะแผน
                                                </label>
                                                <select class="select form-control" id="statusplan" name="statusplan" onchange="fstatusplan()">
                                                    <option value="Active">
                                                        Active
                                                    </option>
                                                    <option value="Pending">
                                                        Pending
                                                    </option>
                                                    <option value="Cancel">
                                                        Cancel
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" name="cancelarea" id="cancelarea">
                                        <label id="cancelarea" class="control-label " for="ccremark">
                                            สาเหตุที่ยกเลิก
                                        </label>
                                        <input class="form-control" name="ccremark" type="text" />
                                    </div>
                                    <input hidden class="form-control" id="author" name="author" type="text" require value="{{ Auth::user()->name }}" />
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="pjname">
                                                    ชื่อโปรเจค
                                                </label>
                                                <select id="country" name="category_id" class="form-control province">
                                                    <option value="" selected disabled>กรุณาเลือก</option>
                                                    @foreach ($rows as $list)
                                                    <option value="{{ $list->id }}" @if ($row->pjname == $list->id) selected @endif>{{ $list->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="tsptype">
                                                    ประเภทการขนส่ง
                                                </label>
                                                <select id="state" name="state" class="form-control amphures" require>
                                                    <option value="{{ $row->tsptype }}"> {{$row->showtsptypename->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label" for="worktype">
                                                    ประเภทงาน
                                                </label>
                                                <select id="city" name="city" class="select form-control" require>
                                                    <option value="{{ $row->worktype }}"> {{$row->worktype }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="routecode">
                                                    รหัสสายวิ่ง
                                                </label>
                                                <input class="form-control" id="routecode" name="routecode" type="text" value="{{ $row->routecode }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group ">
                                                <label class="control-label " for="routename">
                                                    ชื่อเส้นทางเดินรถ
                                                </label>
                                                <input class="form-control" id="routename" name="routename" type="text" value="{{ $row->routename }}" require />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="trucktype">
                                                    ประเภทรถ
                                                </label>
                                                <select id="trucktype" name="trucktype" class="form-control" require>
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\TrucktypeModel::where('status','on')->get(); @endphp

                                                    @if ($list)
                                                    @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->trucktype == $list->id) selected @endif> {{ $list->name }} </option>
                                                    @endforeach

                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="roundtrip">
                                                    เที่ยวรถ
                                                </label>
                                                <select id="roundtrip" name="roundtrip" class="form-control" require>
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\RoundtripModel ::where('status','on')->get(); @endphp

                                                    @if ($list)
                                                    @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->roundtrip == $list->id) selected @endif> {{ $list->name }} </option>
                                                    @endforeach

                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="hiringtype">
                                                    รูปแบบการว่าจ้าง
                                                </label>
                                                <select id="hiringtype" name="hiringtype" class="form-control" onchange="fstatusplan2()" require>
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\HiringtypeModel ::where('status','on')->get(); @endphp

                                                    @if ($list)
                                                    @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->hiringtype == $list->id) selected @endif> {{ $list->name }} </option>
                                                    @endforeach

                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label class="control-label " for="splname">
                                                    Subcontractor
                                                </label>
                                                <select id="splname" name="splname" class="form-control" require>
                                                    <option value="">กรุณาเลือก</option>
                                                    @php $list = \App\SplnameModel::where('status','on')->get(); @endphp

                                                    @if ($list)
                                                    @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->splname == $list->id) selected @endif>{{ $list->name }}</option>
                                                    @endforeach

                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="trucknumb">
                                                    เลขทะเบียนรถ
                                                </label>
                                                <input class="form-control" id="trucknumb" name="trucknumb" type="text" value="{{ $row->trucknumb }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="driver">
                                                    พนักงานขับรถ
                                                </label>
                                                <input class="form-control" id="driver" name="driver" type="text"  value="{{ $row->driver }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="telnumb">
                                                    เบอร์โทร
                                                </label>
                                                <input class="form-control" id="telnumb" name="telnumb" type="text" value="{{ $row->telnumb }}" require />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="sbranch">
                                                    สาขาต้นทาง
                                                </label>
                                                <input class="form-control" id="sbranch" name="sbranch" type="text" value="{{ $row->sbranch }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="dntbranch">
                                                    สาขาปลายทาง
                                                </label>
                                                <input class="form-control" id="dntbranch" name="dntbranch" type="text" value="{{ $row->dntbranch }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="totalhour">
                                                    เวลาที่กำหนด(ชั่วโมง)
                                                </label>
                                                <input class="form-control" id="totalhour" name="totalhour" type="text" value="{{ $row->totalhour }}" require />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group ">
                                                <label class="control-label " for="truckrqdate">
                                                    วันที่ตามรถ
                                                </label>
                                                <input class="form-control" id="truckrqdate" name="truckrqdate" type="date" value="{{ $row->followdate }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group ">
                                                <label class="control-label " for="truckrqtime">
                                                    เวลาตามรถ
                                                </label>
                                                <select class="select form-control" id="truckrqtime" name="truckrqtime" >
                                                    <option  value="{{ $row->truckrqtime }}">
                                                    {{ $row->truckrqtime }}
                                                    </option>
                                                    <option value="00:00:00">
                                                        00:00
                                                    </option>
                                                    <option value="00:30:00">
                                                        00:30
                                                    </option>
                                                    <option value="01:00:00">
                                                        01:00
                                                    </option>
                                                    <option value="01:30:00">
                                                        01:30
                                                    </option>
                                                    <option value="02:00:00">
                                                        02:00
                                                    </option>
                                                    <option value="02:30:00">
                                                        02:30
                                                    </option>
                                                    <option value="03:00:00">
                                                        03:00
                                                    </option>
                                                    <option value="03:30:00">
                                                        03:30
                                                    </option>
                                                    <option value="04:00:00">
                                                        04:00
                                                    </option>
                                                    <option value="04:30:00">
                                                        04:30
                                                    </option>
                                                    <option value="05:00:00">
                                                        05:00
                                                    </option>
                                                    <option value="05:30:00">
                                                        05:30
                                                    </option>
                                                    <option value="06:00:00">
                                                        06:00
                                                    </option>
                                                    <option value="06:30:00">
                                                        06:30
                                                    </option>
                                                    <option value="07:00:00">
                                                        07:00
                                                    </option>
                                                    <option value="07:30:00">
                                                        07:30
                                                    </option>
                                                    <option value="08:00:00">
                                                        08:00
                                                    </option>
                                                    <option value="08:30:00">
                                                        08:30
                                                    </option>
                                                    <option value="09:00:00">
                                                        09:00
                                                    </option>
                                                    <option value="09:30:00">
                                                        09:30
                                                    </option>
                                                    <option value="10:00:00">
                                                        10:00
                                                    </option>
                                                    <option value="10:30:00">
                                                        10:30
                                                    </option>
                                                    <option value="11:00:00">
                                                        11:00
                                                    </option>
                                                    <option value="11:30:00">
                                                        11:30
                                                    </option>
                                                    <option value="12:00:00">
                                                        12:00
                                                    </option>
                                                    <option value="12:30:00">
                                                        12:30
                                                    </option>
                                                    <option value="13:00:00">
                                                        13:00
                                                    </option>
                                                    <option value="13:30:00">
                                                        13:30
                                                    </option>
                                                    <option value="14:00:00">
                                                        14:00
                                                    </option>
                                                    <option value="14:30:00">
                                                        14:30
                                                    </option>
                                                    <option value="15:00:00">
                                                        15:00
                                                    </option>
                                                    <option value="15:30:00">
                                                        15:30
                                                    </option>
                                                    <option value="16:00:00">
                                                        16:00
                                                    </option>
                                                    <option value="16:30:00">
                                                        16:30
                                                    </option>
                                                    <option value="17:00:00">
                                                        17:00
                                                    </option>
                                                    <option value="17:30:00">
                                                        17:30
                                                    </option>
                                                    <option value="18:00:00">
                                                        18:00
                                                    </option>
                                                    <option value="18:30:00">
                                                        18:30
                                                    </option>
                                                    <option value="19:00:00">
                                                        19:00
                                                    </option>
                                                    <option value="19:30:00">
                                                        19:30
                                                    </option>
                                                    <option value="20:00:00">
                                                        20:00
                                                    </option>
                                                    <option value="20:30:00">
                                                        20:30
                                                    </option>
                                                    <option value="21:00:00">
                                                        21:00
                                                    </option>
                                                    <option value="21:30:00">
                                                        21:30
                                                    </option>
                                                    <option value="22:00:00">
                                                        22:00
                                                    </option>
                                                    <option value="22:30:00">
                                                        22:30
                                                    </option>
                                                    <option value="23:00:00">
                                                        23:00
                                                    </option>
                                                    <option value="23:30:00">
                                                        23:30
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group ">
                                                <label class="control-label " for="dptdate">
                                                    วันปล่อยรถ
                                                </label>
                                                <input class="form-control" id="dptdate" name="dptdate" type="date" value="{{ $row->releasedate }}" require />
                                            </div>
                                        </div>
                                      <div class="col-md-6 col-sm-6">
                                            <div class="form-group ">
                                                <label class="control-label " for="dpttime">
                                                    เวลาปล่อยรถ
                                                </label>
                                                <select class="select form-control" id="dpttime" name="dpttime">
                                                    <option value="{{$row ->dpttime}}">
                                                    {{$row ->dpttime}}
                                                    </option>
                                                    <option value="00:00:00">
                                                        00:00
                                                    </option>
                                                    <option value="00:30:00">
                                                        00:30
                                                    </option>
                                                    <option value="01:00:00">
                                                        01:00
                                                    </option>
                                                    <option value="01:30:00">
                                                        01:30
                                                    </option>
                                                    <option value="02:00:00">
                                                        02:00
                                                    </option>
                                                    <option value="02:30:00">
                                                        02:30
                                                    </option>
                                                    <option value="03:00:00">
                                                        03:00
                                                    </option>
                                                    <option value="03:30:00">
                                                        03:30
                                                    </option>
                                                    <option value="04:00:00">
                                                        04:00
                                                    </option>
                                                    <option value="04:30:00">
                                                        04:30
                                                    </option>
                                                    <option value="05:00:00">
                                                        05:00
                                                    </option>
                                                    <option value="05:30:00">
                                                        05:30
                                                    </option>
                                                    <option value="06:00:00">
                                                        06:00
                                                    </option>
                                                    <option value="06:30:00">
                                                        06:30
                                                    </option>
                                                    <option value="07:00:00">
                                                        07:00
                                                    </option>
                                                    <option value="07:30:00">
                                                        07:30
                                                    </option>
                                                    <option value="08:00:00">
                                                        08:00
                                                    </option>
                                                    <option value="08:30:00">
                                                        08:30
                                                    </option>
                                                    <option value="09:00:00">
                                                        09:00
                                                    </option>
                                                    <option value="09:30:00">
                                                        09:30
                                                    </option>
                                                    <option value="10:00:00">
                                                        10:00
                                                    </option>
                                                    <option value="10:30:00">
                                                        10:30
                                                    </option>
                                                    <option value="11:00:00">
                                                        11:00
                                                    </option>
                                                    <option value="11:30:00">
                                                        11:30
                                                    </option>
                                                    <option value="12:00:00">
                                                        12:00
                                                    </option>
                                                    <option value="12:30:00">
                                                        12:30
                                                    </option>
                                                    <option value="13:00:00">
                                                        13:00
                                                    </option>
                                                    <option value="13:30:00">
                                                        13:30
                                                    </option>
                                                    <option value="14:00:00">
                                                        14:00
                                                    </option>
                                                    <option value="14:30:00">
                                                        14:30
                                                    </option>
                                                    <option value="15:00:00">
                                                        15:00
                                                    </option>
                                                    <option value="15:30:00">
                                                        15:30
                                                    </option>
                                                    <option value="16:00:00">
                                                        16:00
                                                    </option>
                                                    <option value="16:30:00">
                                                        16:30
                                                    </option>
                                                    <option value="17:00:00">
                                                        17:00
                                                    </option>
                                                    <option value="17:30:00">
                                                        17:30
                                                    </option>
                                                    <option value="18:00:00">
                                                        18:00
                                                    </option>
                                                    <option value="18:30:00">
                                                        18:30
                                                    </option>
                                                    <option value="19:00:00">
                                                        19:00
                                                    </option>
                                                    <option value="19:30:00">
                                                        19:30
                                                    </option>
                                                    <option value="20:00:00">
                                                        20:00
                                                    </option>
                                                    <option value="20:30:00">
                                                        20:30
                                                    </option>
                                                    <option value="21:00:00">
                                                        21:00
                                                    </option>
                                                    <option value="21:30:00">
                                                        21:30
                                                    </option>
                                                    <option value="22:00:00">
                                                        22:00
                                                    </option>
                                                    <option value="22:30:00">
                                                        22:30
                                                    </option>
                                                    <option value="23:00:00">
                                                        23:00
                                                    </option>
                                                    <option value="23:30:00">
                                                        23:30
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group ">
                                                <label class="control-label " for="dntdate">
                                                    วันกำหนดถึงปลายทาง
                                                </label>
                                                <input class="form-control" id="dntdate" name="dntdate" type="date" value="{{ $row->destinationdate }}" require />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group ">
                                                <label class="control-label " for="dnttime">
                                                    เวลากำหนดถึงปลายทาง
                                                </label>
                                                <select class="select form-control" id="dnttime" name="dnttime">
                                                    <option  value="{{ $row->dnttime }}">
                                                    {{ $row->dnttime }}
                                                    </option>
                                                    <option value="00:00:00">
                                                        00:00
                                                    </option>
                                                    <option value="00:30:00">
                                                        00:30
                                                    </option>
                                                    <option value="01:00:00">
                                                        01:00
                                                    </option>
                                                    <option value="01:30:00">
                                                        01:30
                                                    </option>
                                                    <option value="02:00:00">
                                                        02:00
                                                    </option>
                                                    <option value="02:30:00">
                                                        02:30
                                                    </option>
                                                    <option value="03:00:00">
                                                        03:00
                                                    </option>
                                                    <option value="03:30:00">
                                                        03:30
                                                    </option>
                                                    <option value="04:00:00">
                                                        04:00
                                                    </option>
                                                    <option value="04:30:00">
                                                        04:30
                                                    </option>
                                                    <option value="05:00:00">
                                                        05:00
                                                    </option>
                                                    <option value="05:30:00">
                                                        05:30
                                                    </option>
                                                    <option value="06:00:00">
                                                        06:00
                                                    </option>
                                                    <option value="06:30:00">
                                                        06:30
                                                    </option>
                                                    <option value="07:00:00">
                                                        07:00
                                                    </option>
                                                    <option value="07:30:00">
                                                        07:30
                                                    </option>
                                                    <option value="08:00:00">
                                                        08:00
                                                    </option>
                                                    <option value="08:30:00">
                                                        08:30
                                                    </option>
                                                    <option value="09:00:00">
                                                        09:00
                                                    </option>
                                                    <option value="09:30:00">
                                                        09:30
                                                    </option>
                                                    <option value="10:00:00">
                                                        10:00
                                                    </option>
                                                    <option value="10:30:00">
                                                        10:30
                                                    </option>
                                                    <option value="11:00:00">
                                                        11:00
                                                    </option>
                                                    <option value="11:30:00">
                                                        11:30
                                                    </option>
                                                    <option value="12:00:00">
                                                        12:00
                                                    </option>
                                                    <option value="12:30:00">
                                                        12:30
                                                    </option>
                                                    <option value="13:00:00">
                                                        13:00
                                                    </option>
                                                    <option value="13:30:00">
                                                        13:30
                                                    </option>
                                                    <option value="14:00:00">
                                                        14:00
                                                    </option>
                                                    <option value="14:30:00">
                                                        14:30
                                                    </option>
                                                    <option value="15:00:00">
                                                        15:00
                                                    </option>
                                                    <option value="15:30:00">
                                                        15:30
                                                    </option>
                                                    <option value="16:00:00">
                                                        16:00
                                                    </option>
                                                    <option value="16:30:00">
                                                        16:30
                                                    </option>
                                                    <option value="17:00:00">
                                                        17:00
                                                    </option>
                                                    <option value="17:30:00">
                                                        17:30
                                                    </option>
                                                    <option value="18:00:00">
                                                        18:00
                                                    </option>
                                                    <option value="18:30:00">
                                                        18:30
                                                    </option>
                                                    <option value="19:00:00">
                                                        19:00
                                                    </option>
                                                    <option value="19:30:00">
                                                        19:30
                                                    </option>
                                                    <option value="20:00:00">
                                                        20:00
                                                    </option>
                                                    <option value="20:30:00">
                                                        20:30
                                                    </option>
                                                    <option value="21:00:00">
                                                        21:00
                                                    </option>
                                                    <option value="21:30:00">
                                                        21:30
                                                    </option>
                                                    <option value="22:00:00">
                                                        22:00
                                                    </option>
                                                    <option value="22:30:00">
                                                        22:30
                                                    </option>
                                                    <option value="23:00:00">
                                                        23:00
                                                    </option>
                                                    <option value="23:30:00">
                                                        23:30
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label class="control-label " for="mntstaff">
                                                    Monitor staff(KDR)
                                                </label>
                                                <input class="form-control" id="mntstaff" name="mntstaff" type="text" value="{{ $row->mntstaff }}" require />
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group ">
                                                <label class="control-label " for="remark">
                                                    หมายเหตุ
                                                </label>
                                                <input class="form-control" id="remark" name="remark" type="text" value="{{ $row->remark }}"  />
                                            </div>
                                        </div>
                                    </div>




                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="author">
                                            ผู้สร้างรายการ
                                        </label> -->
                                    <input hidden class="form-control" id="author" name="author" type="text" value="{{ $row->author }}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="editor">
                                            ผู้แก้ไขรายการ
                                        </label> -->
                                    @php $username = Auth::user()->name; @endphp
                                    <input hidden class="form-control" id="editor" name="editor" type="text" value="{{ $username }}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="created">
                                            วันเวลาที่ทำรายการ
                                        </label> -->
                                    <input hidden class="form-control" id="created" name="created" type="text" placeholder="" value="{{ $row->created }}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="updated">
                                            วันเวลาที่แก้ไขรายการ
                                        </label> -->
                                    @php $date = date('Y-m-d H:i:s'); @endphp
                                    <input hidden class="form-control" id="updated" name="updated" type="text" placeholder="" value="{{ $date }}" />
                                    <!-- </div> -->


                                </div>
                            </div>
                        </div>




                        <script type=text/javascript>
                            $('#country').change(function() {
                                var countryID = $(this).val();
                                if (countryID) {
                                    $.ajax({
                                        type: "GET",
                                        url: "{{ url('get-state-list') }}?country_id=" + countryID,
                                        success: function(res) {
                                            if (res) {
                                                $("#state").empty();
                                                $("#state").append('<option></option>');
                                                $.each(res, function(key, value) {
                                                    $("#state").append('<option value="' + key + '">' + value +
                                                        '</option>');
                                                });

                                            } else {
                                                $("#state").empty();
                                            }
                                        }
                                    });
                                } else {
                                    $("#state").empty();
                                    $("#city").empty();
                                }
                            });
                            $('#state').on('change', function() {
                                var stateID = $(this).val();
                                if (stateID) {
                                    $.ajax({
                                        type: "GET",
                                        url: "{{ url('get-city-list') }}?state_id=" + stateID,
                                        success: function(res) {
                                            if (res) {
                                                $("#city").empty();
                                                $.each(res, function(key, value) {
                                                    $("#city").append('<option value="' + value + '">' + value +
                                                        '</option>');
                                                });

                                            } else {
                                                $("#city").empty();
                                            }
                                        }
                                    });
                                } else {
                                    $("#city").empty();
                                }

                            });



    function fncSubmit() {

if (document.form1.startdate.value == "") {
    document.form1.startdate.focus();
    Swal.fire('กรุณาเลือก วันที่ใช้รถ');
    return false;
}
if (document.form1.category_id.value == "") {
    document.form1.category_id.focus();
    Swal.fire('กรุณาเลือก ชื่อโปรเจค');
    return false;
}
if (document.form1.state.value == "") {
    document.form1.state.focus();
    Swal.fire('กรุณาเลือก ประเภทการขนส่ง');
    return false;
}
if (document.form1.city.value == "") {
    document.form1.city.focus();
    Swal.fire('กรุณาเลือก ประเภทงาน');
    return false;
}
// if(document.form1.splname.value == "")
// {
//     document.form1.splname.focus();
//     Swal.fire('กรุณาเลือก Subcontractor');
// 	return false;
// }
// if (document.form1.routecode.value == "") {
//     document.form1.routecode.focus();
//     Swal.fire('กรุณากรอก รหัสสายวิ่ง');
//     return false;
// }
if (document.form1.routename.value == "") {
    document.form1.routename.focus();
    Swal.fire('กรุณากรอก ชื่อเส้นทางเดินรถ');
    return false;
}
if (document.form1.trucktype.value == "") {
    document.form1.trucktype.focus();
    Swal.fire('กรุณาเลือก ประเภทรถ');
    return false;
}
if(document.form1.roundtrip.value == "")
{
    document.form1.roundtrip.focus();
    Swal.fire('กรุณาเลือก เที่ยวรถ');
    return false;
}
if (document.form1.hiringtype.value == "") {
    document.form1.hiringtype.focus();
    Swal.fire('กรุณาเลือก รูปแบบการว่าจ้าง');
    return false;
}
if (document.form1.trucknumb.value == "") {
    document.form1.trucknumb.focus();
    Swal.fire('กรุณากรอก เลขทะเบียนรถ');
    return false;
}
// if (document.form1.driver.value == "") {
//     document.form1.driver.focus();
//     Swal.fire('กรุณากรอก พนักงานขับรถ');
//     return false;
// }
// if (document.form1.telnumb.value == "") {
//     document.form1.telnumb.focus();
//     Swal.fire('กรุณากรอก เบอร์โทร');
//     return false;
// }
// if (document.form1.sbranch.value == "") {
//     document.form1.sbranch.focus();
//     Swal.fire('กรุณากรอก สาขาต้นทาง');
//     return false;
// }
// if (document.form1.truckrqtime.value == "") {
//     document.form1.truckrqtime.focus();
//     Swal.fire('กรุณากรอก เวลาตามรถ');
//     return false;
// }
// if (document.form1.dpttime.value == "") {
//     document.form1.dpttime.focus();
//     Swal.fire('กรุณากรอก เวลาปล่อยรถ');
//     return false;
// }
// if (document.form1.dnttime.value == "") {
//     document.form1.dnttime.focus();
//     Swal.fire('กรุณากรอก เวลากำหนดถึงปลายทาง');
//     return false;
// }
// if (document.form1.totalhour.value == "") {
//     document.form1.totalhour.focus();
//     Swal.fire('กรุณากรอก  เวลาที่กำหนด(ชั่วโมง)');
//     return false;
// }
// if (document.form1.mntstaff.value == "") {
//     document.form1.mntstaff.focus();
//     Swal.fire('กรุณากรอก Monitor staff(KDR)');
//     return false;
// }
// if(document.form1.remark.value == "")
// {
//     document.form1.remark.focus();
//     Swal.fire('กรุณากรอก Monitor หมายเหตุ');
// 	return false;
// }
if (document.form1.statusplan.value == "") {
    document.form1.statusplan.focus();
    Swal.fire('กรุณากรอก สถานะแผน');
    return false;
}
// if(document.form1.ccremark.value == "")
// {
//     document.form1.ccremark.focus();
//     Swal.fire('กรุณากรอก สาเหตุที่ยกเลิก');
// 	return false;
// }
document.form1.submit();
}
</script>

                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" type="submit" name="signup">บันทึก</button>
                        <a class="btn btn-danger" href="{{ url("$segment") }}">ยกเลิก</a>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
