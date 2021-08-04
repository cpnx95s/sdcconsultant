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
            <form id="signupForm" method="post" action="{{ url("$segment/truckplan/copy/{id}/create") }}" enctype="multipart/form-data" name="form1" onSubmit="JavaScript:return fncSubmit();">
                <div class="card">
                    <div class="card-header">
                        <span class="breadcrumb-item "><a href="{{ url("$segment") }}"> แผนรถ </a></span>
                        <span class="breadcrumb-item active">คัดลอก</span>
                        <div class="card-header-actions"><small class="text-muted"><a
                                    href="https://getbootstrap.com/docs/4.0/components/input-group/#custom-file-input">docs</a></small>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf


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

                                    <div class="form-group ">
                                        <label class="control-label " for="startdate">
                                            วันที่ใช้รถ
                                        </label>
                                        <input class="form-control" id="startdate" name="startdate" placeholder=""
                                            value="{{ $row->startdate }}" type="date" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label " for="pjname">
                                            ชื่อโปรเจค
                                        </label>
                                        <select id="country" name="category_id" class="form-control province" require>

                                            @foreach ($rows as $list)
                                                <option value="{{ $list->id }}" @if ($row->pjname == $list->id) selected @endif>{{ $list->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="tsptype">
                                            ประเภทการขนส่ง
                                        </label>
                                        <select id="state" name="state" class="form-control amphures"    require>
                                            <option   value="{{ $row->tsptype }}">  {{$row->showtsptypename->name }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="worktype">
                                            ประเภทงาน
                                        </label>
                                        <select class="select form-control" id="city" name="city">
                                            <option   value="{{ $row->worktype }}">  {{$row->worktype }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="splname">
                                            Subcontractor
                                        </label>
                                        <select id="splname" name="splname" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\SplnameModel::where('status','on')->get(); @endphp

                                            @if ($list)
                                                @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->splname == $list->id) selected @endif>{{ $list->name }}</option>
                                                @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="routecode" ">
                                            รหัสสายวิ่ง
                                        </label>
                                        <input class=" form-control" id="routecode" name="routecode" type="text"
                                            value="{{ $row->routecode }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="routename">
                                            ชื่อเส้นทางเดินรถ
                                        </label>
                                        <input class="form-control" id="routename" name="routename" type="text"
                                            value="{{ $row->routename }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="trucktype">
                                            ประเภทรถ
                                        </label>
                                        <select id="trucktype" name="trucktype" class="form-control">
                                            <option value="">กรุณาเลือก</option>
                                            @php $list = \App\TrucktypeModel::where('status','on')->get(); @endphp

                                            @if ($list)
                                                @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->trucktype == $list->id) selected @endif> {{ $list->name }} </option>
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

                                            @if ($list)
                                                @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->roundtrip == $list->id) selected @endif> {{ $list->name }} </option>
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

                                            @if ($list)
                                                @foreach ($list as $list)
                                                    <option value="{{ $list->id }}" @if ($row->hiringtype == $list->id) selected @endif> {{ $list->name }} </option>
                                                @endforeach

                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="trucknumb">
                                            เลขทะเบียนรถ
                                        </label>
                                        <input class="form-control" id="trucknumb" name="trucknumb" type="text"
                                            value="{{ $row->trucknumb }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="driver">
                                            พนักงานขับรถ
                                        </label>
                                        <input class="form-control" id="driver" name="driver" type="text"
                                            value="{{ $row->driver }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="telnumb">
                                            เบอร์โทร
                                        </label>
                                        <input class="form-control" id="telnumb" name="telnumb" type="text"
                                            value="{{ $row->telnumb }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="sbranch">
                                            สาขาต้นทาง
                                        </label>
                                        <input class="form-control" id="sbranch" name="sbranch" type="text"
                                            value="{{ $row->sbranch }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dntbranch">
                                            สาขาปลายทาง
                                        </label>
                                        <input class="form-control" id="dntbranch" name="dntbranch" type="text"
                                            value="{{ $row->dntbranch }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="truckrqtime">
                                            เวลาตามรถ
                                        </label>
                                        <input class="form-control" id="truckrqtime" name="truckrqtime" type="time"
                                            value="{{ $row->truckrqtime }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dpttime">
                                            เวลาปล่อยรถ
                                        </label>
                                        <input class="form-control" id="dpttime" name="dpttime" type="time"
                                            value="{{ $row->dpttime }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dnttime">
                                            เวลากำหนดถึงปลายทาง
                                        </label>
                                        <input class="form-control" id="dnttime" name="dnttime" type="time"
                                            value="{{ $row->dnttime }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="totalhour">
                                            เวลาที่กำหนด(ชั่วโมง)
                                        </label>
                                        <input class="form-control" id="totalhour" name="totalhour" type="text"
                                            value="{{ $row->totalhour }}" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="mntstaff">
                                            Monitor staff(KDR)
                                        </label>
                                        <input class="form-control" id="mntstaff" name="mntstaff" type="text"
                                            value="{{ $row->mntstaff }}" />
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label " for="remark">
                                            หมายเหตุ
                                        </label>
                                        <input class="form-control" id="remark" name="remark" type="text"
                                            value="{{ $row->remark }}" />
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label " for="statusplan">
                                            สถานะแผน
                                        </label>
                                        <select class="select form-control" id="statusplan" name="statusplan"
                                            onchange="fstatusplan()">
                                            <option value="Active" @if ($row->statusplan == 'Active') selected @endif>
                                                Active
                                            </option>
                                            <option value="Pending" @if ($row->statusplan == 'Pending') selected @endif>
                                                Pending
                                            </option>
                                            <option value="Cancel" @if ($row->statusplan == 'Cancel') selected @endif>
                                                Cancel
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group name=" cancelarea" id="cancelarea" ">
                                        <label class=" control-label " for=" ccremark">
                                        สาเหตุที่ยกเลิก
                                        </label>
                                        <input class="form-control" id="ccremark" name="ccremark" type="text"
                                            value="{{ $row->ccremark }}" />
                                    </div>

                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="author">
                                            ผู้สร้างรายการ
                                        </label> -->
                                    <input hidden class="form-control" id="author" name="author" type="text"
                                        value="{{ $row->author }}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="editor">
                                            ผู้แก้ไขรายการ
                                        </label> -->
                                    @php $username = Auth::user()->name; @endphp
                                    <input hidden class="form-control" id="editor" name="editor" type="text"
                                        value="{{ $username }}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="created">
                                            วันเวลาที่ทำรายการ
                                        </label> -->
                                    <input hidden class="form-control" id="created" name="created" type="text"
                                        placeholder="" value="{{ $row->created }}" />
                                    <!-- </div> -->
                                    <!-- <div class="form-group ">
                                        <label class="control-label " for="updated">
                                            วันเวลาที่แก้ไขรายการ
                                        </label> -->
                                    @php $date = date('Y-m-d H:i:s'); @endphp
                                    <input hidden class="form-control" id="updated" name="updated" type="text"
                                        placeholder="" value="{{ $date }}" />
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


    function fncSubmit()
{

	if(document.form1.startdate.value == "")
	{
        document.form1.startdate.focus();
        Swal.fire ('กรุณาเลือก วันที่ใช้รถ');
		return false;
	}
    if(document.form1.category_id.value == "")
	{
        document.form1.category_id.focus();
        Swal.fire('กรุณาเลือก ชื่อโปรเจค');
		return false;
	}
    if(document.form1.state.value == "")
	{
        document.form1.state.focus();
        Swal.fire('กรุณาเลือก ประเภทการขนส่ง');
		return false;
	}
    if(document.form1.city.value == "")
	{
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
    if(document.form1.routecode.value == "")
	{
        document.form1.routecode.focus();
        Swal.fire('กรุณากรอก รหัสสายวิ่ง');
		return false;
	}
    if(document.form1.routename.value == "")
	{
        document.form1.routename.focus();
        Swal.fire('กรุณากรอก ชื่อเส้นทางเดินรถ');
		return false;
	}
    if(document.form1.trucktype.value == "")
	{
        document.form1.trucktype.focus();
        Swal.fire('กรุณาเลือก ประเภทรถ');
		return false;
	}
    // if(document.form1.roundtrip.value == "")
	// {
    //     document.form1.roundtrip.focus();
    //     Swal.fire('กรุณาเลือก เที่ยวรถ');
	// 	return false;
	// }
    if(document.form1.hiringtype.value == "")
	{
        document.form1.hiringtype.focus();
        Swal.fire('กรุณาเลือก รูปแบบการว่าจ้าง');
		return false;
	}
    if(document.form1.trucknumb.value == "")
	{
        document.form1.trucknumb.focus();
        Swal.fire('กรุณากรอก เลขทะเบียนรถ');
		return false;
	}
    if(document.form1.driver.value == "")
	{
        document.form1.driver.focus();
        Swal.fire('กรุณากรอก พนักงานขับรถ');
		return false;
	}
    if(document.form1.telnumb.value == "")
	{
        document.form1.telnumb.focus();
        Swal.fire('กรุณากรอก เบอร์โทร');
		return false;
	}
    if(document.form1.sbranch.value == "")
	{
        document.form1.sbranch.focus();
        Swal.fire('กรุณากรอก สาขาต้นทาง');
		return false;
	}
    if(document.form1.truckrqtime.value == "")
	{
        document.form1.truckrqtime.focus();
        Swal.fire('กรุณากรอก เวลาตามรถ');
		return false;
	}
    if(document.form1.dpttime.value == "")
	{
        document.form1.dpttime.focus();
        Swal.fire('กรุณากรอก เวลาปล่อยรถ');
		return false;
	}
    if(document.form1.dnttime.value == "")
	{
        document.form1.dnttime.focus();
        Swal.fire('กรุณากรอก เวลากำหนดถึงปลายทาง');
		return false;
	}
    if(document.form1.totalhour.value == "")
	{
        document.form1.totalhour.focus();
        Swal.fire('กรุณากรอก  เวลาที่กำหนด(ชั่วโมง)');
		return false;
	}
    if(document.form1.mntstaff.value == "")
	{
        document.form1.mntstaff.focus();
        Swal.fire('กรุณากรอก Monitor staff(KDR)');
		return false;
	}
    // if(document.form1.remark.value == "")
	// {
    //     document.form1.remark.focus();
    //     Swal.fire('กรุณากรอก Monitor หมายเหตุ');
	// 	return false;
	// }
    if(document.form1.statusplan.value == "")
	{
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
