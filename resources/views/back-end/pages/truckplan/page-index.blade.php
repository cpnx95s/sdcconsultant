<div>
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">

                        <a href="{{url("$segment")}}" class="card-header-action">จัดการแผนรถ</a>
                        <div class="card-header-actions">
                            <button class="btn btn-default btn-md" id="sort" data-text="Sort">เรียง</button>
                            <a class="btn btn-md btn-success" href="{{url("$segment/create")}}"> เพิ่ม</a>
                            <button class="btn btn-md btn-primary text-white" type="reset" id="delCopy" disabled> คัดลอก</button>
                            <button class="btn btn-md btn-warning text-white" type="reset" id="delEdit" disabled> แก้ไข</button>
                            <button class="btn btn-md btn-danger" type="reset" id="delSelect" disabled> ลบ</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        <form action="" method="get">
                            <div class="row">
                                <!-- <div class="col-lg-1">
                                    <div class="form-group">    
                                        <label for="view">ดู : </label> 
                                        @php($numrows=10)
                                        <select name="view" id="view" class="form-control">
                                            <option value="5" @if(Request::get('view')==10) selected @endif>5</option>
                                            @for($i=1; $i<6; $i++)
                                            <option value="{{$numrows = $numrows*2}}" @if(Request::get('view')==$numrows) selected @endif>{{$numrows}}</option>
                                            @endfor
                                            <option value="all" @if(Request::get('view')=='all') selected @endif>ทั้งหมด</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-lg-4 col-xs-12 mb-4">
                                    <label for="search">ค้นหา :</label>
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control" id="search" value="{{Request::get('keyword')}}" placeholder="ชื่อแผนรถ">
                                        <span class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">ค้นหา</button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <br class="d-block d-sm-none" />
                        <div class="table-responsive">
                            <table class="table table-striped no-footer table-res" id="sorted_table" style="border-collapse: collapse !important">
                                <thead>
                                    <tr role="">
                                        <th scope="col" style="text-align:center;">#</th>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="select" class="custom-control-input selectAll" id="selectAll">
                                                <label class="custom-control-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th scope="col">วันที่ใช้รถ</th>
                                        <th scope="col">ประเภทงาน</th>
                                        <th scope="col">ชื่อโปรเจค</th>
                                        <th scope="col">รหัสสายวิ่ง</th>
                                        <th scope="col">ชื่อเส้นทางเดินรถ</th>
                                        <th scope="col">ประเภทการขนส่ง</th>
                                        <th scope="col">ประเภทรถ</th>
                                        <th scope="col">เที่ยวรถ</th>
                                        <th scope="col">รูปแบบการว่าจ้าง</th>
                                        <th scope="col">ซัพพลายเออร์</th>
                                        <th scope="col">เลขทะเบียนรถ</th>
                                        <th scope="col">พนักงานขับรถ</th>
                                        <th scope="col">เบอร์โทร</th>
                                        <th scope="col">สาขาต้นทาง</th>
                                        <th scope="col">สาขาปลายทาง</th>
                                        <th scope="col">เวลาตามรถ</th>
                                        <th scope="col">เวลาปล่อยรถ</th>
                                        <th scope="col">เวลากำหนดถึงปลายทาง</th>
                                        <th scope="col">เวลาที่กำหนด(ชั่วโมง)</th>
                                        <th scope="col">Monitor staff(KDR)</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">สถานะแผน</th>
                                        <th scope="col">สาเหตุที่ยกเลิก</th>
                                        <th scope="col">ผู้สร้างรายการ</th>
                                        <th scope="col">ผู้แก้ไขรายการ</th>
                                        <th scope="col">วันเวลาที่ทำรายการ</th>
                                        <th scope="col">วันเวลาที่แก้ไขรายการ</th>
                                        <th scope="col">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows)
                                    @foreach($rows as $key => $row)
                                    @php($secondary = \App\MenuModel::where('_id',$row->id)->get())
                                    <tr role="row" class="odd" data-row="{{$key+1}}" data-id="{{$row->id}}">
                                        <td data-label="No.">
                                            <span class="no">{{$key+1}}</span>
                                            <i class="fas fa-bars handle" style="display:none;"></i>
                                        </td>
                                        <td data-label="select">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="select" class="custom-control-input ChkBox" id="ChkBox{{$row->id}}" value="{{$row->id}}">
                                                <label class="custom-control-label" for="ChkBox{{$row->id}}"></label>
                                            </div>
                                        </td>
                                        <td data-label="วันที่ใช้รถ">
                                            {{$row->startdate}}
                                        </td>
                                        <td data-label="ประเภทงาน">
                                            {{$row->worktype}}
                                        </td>
                                        <td data-label="ชื่อโปรเจค">
                                            {{$row->showpjname->name}}
                                        </td>
                                        <td data-label="รหัสสายวิ่ง">
                                            {{$row->routecode}}
                                        </td>
                                        <td data-label="ชื่อเส้นทางเดินรถ">
                                            {{$row->routename}}
                                        </td>
                                        <td data-label="ประเภทการขนส่ง">
                                            {{$row->showtsptypename->name}}
                                        </td>
                                        <td data-label="ประเภทรถ">
                                            {{$row->showtrucktypename->name}}
                                        </td>
                                        <td data-label="เที่ยวรถ">
                                            {{$row->showroundtripname->name}}
                                        </td>
                                        <td data-label="รูปแบบการว่าจ้าง">
                                            {{$row->showhiringtypename->name}}
                                        </td>
                                        <td data-label="ชื่อซัพพลายเออร์">
                                            {{$row->showsplname->name}}
                                        </td>
                                        <td data-label="เลขทะเบียนรถ">
                                            {{$row->trucknumb}}
                                        </td>
                                        <td data-label="พนักงานขับรถ">
                                            {{$row->driver}}
                                        </td>
                                        <td data-label="เบอร์โทร">
                                            {{$row->totalhour}}
                                        </td>
                                        <td data-label="สาขาต้นทาง">
                                            {{$row->sbranch}}
                                        </td>
                                        <td data-label="สาขาปลายทาง">
                                            {{$row->dntbranch}}
                                        </td>
                                        <td data-label="เวลาตามรถ">
                                            {{$row->truckrqtime}}
                                        </td>
                                        <td data-label="เวลาปล่อยรถ">
                                            {{$row->dpttime}}
                                        </td>
                                        <td data-label="เวลากำหนดถึงปลายทาง">
                                            {{$row->dnttime}}
                                        </td>
                                        <td data-label="เวลาที่กำหนด(ชั่วโมง)">
                                            {{$row->totalhour}}
                                        </td>
                                        <td data-label="Monitor staff(KDR)">
                                            {{$row->mntstaff}}
                                        </td>
                                        <td data-label="Remark">
                                            {{$row->remark}}
                                        </td>
                                        <td data-label="สถานะแผน">
                                            {{$row->statusplan}}
                                        </td>
                                        <td data-label="สาเหตุที่ยกเลิก">
                                            {{$row->ccremark}}
                                        </td>
                                        <td data-label="ผู้สร้างรายการ">
                                            {{$row->author}}
                                        </td>
                                        <td data-label="ผู้แก้ไขรายการ">
                                            {{$row->editor}}
                                        </td>
                                        <td data-label="วันเวลาที่ทำรายการ">
                                            {{date('d-M-Y H:i:s',strtotime($row->created))}}
                                        </td>
                                        <td data-label="วันเวลาที่แก้ไขรายการ">
                                            {{date('d-M-Y H:i:s',strtotime($row->updated))}}
                                        </td>


                                        <td data-label="จัดการ">
                                            <a href="{{url("$segment/$row->id")}}" class="btn btn-warning text-white" title="Edit"><i class="far fa-edit"></i></a>
                                            <a href="{{url("$segment/copy/$row->id")}}" class="btn btn-primary" title="Copy"><i class="far fa-copy"></i></a>
                                            <a href="javascript:" class="btn btn-danger deleteItem" data-id="{{$row->id}}" title="Delete"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if(Request::get('view')!='all') {{$rows->links()}} @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <strong>ทั้งหมด</strong> {{$rows->count()}} @if(Request::get('view')!='all'): <strong>จาก</strong> {{$rows->firstItem()}} - {{$rows->lastItem()}} @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>