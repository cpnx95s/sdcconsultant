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
                        <span class="breadcrumb-item "><a href="{{url("$segment")}}">ชื่อแผนรถ</a></span>
                        <span class="breadcrumb-item active">เพิ่ม</span>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="nav-tabs-boxed">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#th" role="tab" aria-controls="th">ชื่อแผนรถ</a></li>
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
                                        <input class="form-control" id="startdate" name="startdate" placeholder="MM/DD/YYYY" type="datetime-local" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="worktype">
                                            ประเภทงาน
                                        </label>
                                        <select class="select form-control" id="worktype" name="worktype">
                                            <option value="งานหลัก">
                                                งานหลัก
                                            </option>
                                            <option value="งานเสริม">
                                                งานเสริม
                                            </option>
                                            <option selected="selected" value="">
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                    <label class="control-label " for="pjname">
                                            ชื่อโปรเจค
                                        </label>
                                        <select class="select form-control" id="tsptype" name="tsptype">
                                            <option value="First Choice">
                                                First Choice
                                            </option>
                                            <option value="Second Choice">
                                                Second Choice
                                            </option>
                                            <option value="Third Choice">
                                                Third Choice
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="routecode">
                                            รหัสสายวิ่ง
                                        </label>
                                        <input class="form-control" id="routecode" name="routecode" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="routename">
                                            ชื่อเส้นทางเดินรถ
                                        </label>
                                        <input class="form-control" id="routename" name="routename" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="tsptype">
                                            ประเภทการขนส่ง
                                        </label>
                                        <select class="select form-control" id="tsptype" name="tsptype">
                                            <option value="First Choice">
                                                First Choice
                                            </option>
                                            <option value="Second Choice">
                                                Second Choice
                                            </option>
                                            <option value="Third Choice">
                                                Third Choice
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="trucktype">
                                            ประเภทรถ
                                        </label>
                                        <select class="select form-control" id="trucktype" name="trucktype">
                                            <option value="First Choice">
                                                First Choice
                                            </option>
                                            <option value="Second Choice">
                                                Second Choice
                                            </option>
                                            <option value="Third Choice">
                                                Third Choice
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="roundtrip">
                                            เที่ยวรถ
                                        </label>
                                        <select class="select form-control" id="roundtrip" name="roundtrip">
                                            <option value="First Choice">
                                                First Choice
                                            </option>
                                            <option value="Second Choice">
                                                Second Choice
                                            </option>
                                            <option value="Third Choice">
                                                Third Choice
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="hiringtype">
                                            รูปแบบการว่าจ้าง
                                        </label>
                                        <select class="select form-control" id="hiringtype" name="hiringtype">
                                            <option value="First Choice">
                                                First Choice
                                            </option>
                                            <option value="Second Choice">
                                                Second Choice
                                            </option>
                                            <option value="Third Choice">
                                                Third Choice
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="name3">
                                            เลขทะเบียนรถ
                                        </label>
                                        <input class="form-control" id="name3" name="name3" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="driverd">
                                            พนักงานขับรถ
                                        </label>
                                        <input class="form-control" id="driverd" name="driverd" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="name5">
                                            เบอร์โทร
                                        </label>
                                        <input class="form-control" id="name5" name="name5" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="sbranch">
                                            สาขาต้นทาง
                                        </label>
                                        <input class="form-control" id="sbranch" name="sbranch" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dntbranch">
                                            สาขาปลายทาง
                                        </label>
                                        <input class="form-control" id="dntbranch" name="dntbranch" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="truckrqtime">
                                            เวลาตามรถ
                                        </label>
                                        <input class="form-control" id="truckrqtime" name="truckrqtime" type="time" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dpttime">
                                            เวลาปล่อยรถ
                                        </label>
                                        <input class="form-control" id="dpttime" name="dpttime" type="time" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="dnttime">
                                            เวลากำหนดถึงปลายทาง
                                        </label>
                                        <input class="form-control" id="dnttime" name="dnttime" type="time" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="totaltime">
                                            เวลาที่กำหนด(ชั่วโมง)
                                        </label>
                                        <input class="form-control" id="totaltime" name="totaltime" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="mntstaff">
                                            Monitor staff(KDR)
                                        </label>
                                        <input class="form-control" id="mntstaff" name="mntstaff" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="remark">
                                            หมายเหตุ
                                        </label>
                                        <input class="form-control" id="remark" name="remark" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="statusplan">
                                            สถานะแผน
                                        </label>
                                        <select class="select form-control" id="statusplan" name="statusplan">
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
                                    <div class="form-group ">
                                        <label class="control-label " for="ccremark">
                                            สาเหตุที่ยกเลิก
                                        </label>
                                        <input class="form-control" id="ccremark" name="ccremark" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="author">
                                            ผู้สร้างรายการ
                                        </label>
                                        <input class="form-control" id="author" name="author" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="editor">
                                            ผู้แก้ไขรายการ
                                        </label>
                                        <input class="form-control" id="editor" name="editor" type="text" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="created">
                                            วันเวลาที่ทำรายการ
                                        </label>
                                        <input class="form-control" id="created" name="created" placeholder="MM/DD/YYYY" type="datetime-local" />
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label " for="updated">
                                            วันเวลาที่แก้ไขรายการ
                                        </label>
                                        <input class="form-control" id="updated" name="updated" placeholder="MM/DD/YYYY" type="datetime-local" />
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