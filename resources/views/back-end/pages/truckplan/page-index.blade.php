<div class="fade-in">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">

                    <a href="{{ url("$segment") }}" class="card-header-action">Vehicle Plan</a>
                    <div class="mt-2">
                        <!-- <button class="btn btn-default btn-md" id="sort" data-text="Sort">Sort</button> -->
                        <a class="btn btn-md btn-success" href="{{ url("$segment/create") }}"> Add</a>
                        {{-- <button class="btn btn-md btn-primary text-white" type="reset" id="delCopy" disabled>
                            Copy</button>
                        <button class="btn btn-md btn-warning text-white" type="reset" id="delEdit" disabled>
                            Edit</button> --}}
                        <button class="btn btn-md btn-danger" type="reset" id="delSelect" disabled>Delete</button>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <form action="{{ url("$segment/search") }}" method="get">
                        <div class="row">
                            <!-- <div class="col-lg-1">
                                    <div class="form-group">    
                                        <label for="view">ดู : </label> 
                                        @php($numrows = 10)
                                        <select name="view" id="view" class="form-control">
                                            <option value="5" @if (Request::get('view') == 10) selected @endif>5</option>
                                            @for ($i = 1; $i < 6; $i++)
                                            <option value="{{ $numrows = $numrows * 2 }}" @if (Request::get('view') == $numrows) selected @endif>{{ $numrows }}</option>
                                            @endfor
                                            <option value="all" @if (Request::get('view') == 'all') selected @endif>ทั้งหมด</option>
                                        </select>
                                    </div>
                                </div> -->
                            <!-- <div class="col-lg-4 col-xs-12 mb-4 ">
                                <label for="search">Search :</label>
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" id="search"
                                        value="{{ Request::get('keyword') }}" >
                                    <span class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">Search</button>
                                    </span>
                                </div>
                            </div> -->
                        </div>
                    </form>
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"
                        rel="stylesheet" />

                    <form action="{{ url("$segment/searchdate") }}" method="get">

                        <!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
                        <style>
                            table.GeneratedTable {
                            }
                            
                            table.GeneratedTable td, table.GeneratedTable th {
               
                              padding-right: 10px;
                              
                            }
                            
                            table.GeneratedTable thead {
                            
                            }
                            </style>

                        <!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
                        <table class="GeneratedTable table-borderless w-70 mb-4">
                            <thead>
                                <tr>
                                    <th scope="col">START DATE FROM</th>
                                    <th scope="col">START DATE TO</th>
                                    <th scope="col">WORK TYPE</th>
                                    <th scope="col">PROJECT NAME</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <input type="date" class="from-control" id="fromDate" name="fromDate"
                                            required /></td>
                                    <td> <input type="date" class="from-control input-sm" id="toDate" name="toDate"
                                            required /></td>
                                    <td class="dropdown">
                                        <select name="worktypebox" id="nameid" style="width: 200px">
                                            <option></option>



                                            @foreach ($worktype as $row)
                                                <option>{{ $row->worktype }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <span class="dropdown">
                                            <select name="pjnamebox" id="nameids" style="width: 200px">
                                                <option></option>
                                                @foreach ($pjname as $row)
                                                    <option>{{ $row->showpjname->name }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" type="submit">Search</button>
                                        <!-- <button class="btn btn-secondary" type="submit">คืนค่าค้นหา</button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Codes by Quackit.com -->

                            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

                            <script type="text/javascript">
                                $("#nameid").select2({
                                    placeholder: "Select a Name",
                                    allowClear: true
                                });
                                $("#nameids").select2({
                                    placeholder: "Select a Name",
                                    allowClear: true
                                });
                            </script>
                           

                    </form>


                    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

                </div>
                <br class="d-block d-sm-none" />
                <div class="table-responsive">
                    <table class="table table-striped no-footer table-res" id="sorted_table"
                        style="border-collapse: collapse !important">
                        <thead>
                            <tr role="">
                                <th scope="col" style="text-align:center;">#</th>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="select" class="custom-control-input selectAll"
                                            id="selectAll">
                                        <label class="custom-control-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th scope="col">ACTION</th>
                                <th scope="col">STARTDATE</th>
                                <th scope="col">WORK_TYPE</th>
                                <th scope="col">PROJECT_NAME</th>
                                <th scope="col">ROUTE_CODE</th>
                                <th scope="col">ROUTE_NAME</th>
                                <th scope="col">TRANSPORT_TYPE</th>
                                <th scope="col">VIHICLE_TYPE</th>
                                <th scope="col">TRIP_TYPE</th>
                                <th scope="col">SERVICE_TYPE</th>
                                <th scope="col">SUBCONTRACTOR</th>
                                <th scope="col">TRUCKNUMBER</th>
                                <th scope="col">DRIVER</th>
                                <th scope="col">TELEPHONE</th>
                                <th scope="col">START_ROUTE</th>
                                <th scope="col">DESTINATION_ROUTE</th>
                                <th scope="col">วันที่ตามรถ</th>
                                <th scope="col">เวลาตามรถ</th>
                                <th scope="col">วันที่ปล่อยรถ</th>
                                <th scope="col">เวลาปล่อยรถ</th>
                                <th scope="col">วันที่กำหนดถึงปลายทาง</th>
                                <th scope="col">เวลากำหนดถึงปลายทาง</th>
                                <th scope="col">TOTAL_HOUR</th>
                                <th scope="col">MONITOR_STAFF</th>
                                <th scope="col">REMARK</th>
                                <th scope="col">STATUS_PLAN</th>
                                <th scope="col">สาเหตุที่ยกเลิก</th>
                                <th scope="col">ผู้สร้างรายการ</th>
                                <th scope="col">ผู้แก้ไขรายการ</th>
                                <th scope="col">CREATED_DATE_TIME</th>
                                <th scope="col">UPDATED_DATE_TIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rows)
                                @foreach ($rows as $key => $row)
                                    @php($secondary = \App\MenuModel::where('_id', $row->id)->get())
                                    <tr role="row" class="odd" data-row="{{ $key + 1 }}"
                                        data-id="{{ $row->id }}">
                                        <td data-label="No.">
                                            <span class="no">{{ $key + 1 }}</span>
                                            <i class="fas fa-bars handle" style="display:none;"></i>
                                        </td>
                                        <td data-label="select">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="select" class="custom-control-input ChkBox"
                                                    id="ChkBox{{ $row->id }}" value="{{ $row->id }}">
                                                <label class="custom-control-label"
                                                    for="ChkBox{{ $row->id }}"></label>
                                            </div>
                                        </td>
                                        <!-- <td data-label="Action">
                                            <a href="{{ url("$segment/$row->id") }}" class="btn btn-warning text-white" title="Edit"><i class="far fa-edit"></i></a>
                                            <a href="{{ url("$segment/copy/$row->id") }}" class="btn btn-primary" title="Copy"><i class="far fa-copy"></i></a>
                                            <a href="javascript:" class="btn btn-danger deleteItem" data-id="{{ $row->id }}" title="Delete"><i class="far fa-trash-alt"></i></a>
                                        </td> -->
                                        <td data-label="Action">
                                            <a href="{{ url("$segment/$row->id") }}" class="text-warning"
                                                title="Edit"><i class="far fa-edit"></i></a>
                                            <a href="{{ url("$segment/copy/$row->id") }}" class="text-primary"
                                                title="Copy"><i class="far fa-copy"></i></a>
                                            <a href="javascript:" class="text-danger deleteItem"
                                                data-id="{{ $row->id }}" title="Delete"><i
                                                    class="far fa-trash-alt"></i></a>
                                        </td>

                                        <td data-label="วันที่ใช้รถ">
                                            {{ \Carbon\Carbon::parse($row->startdate)->format('d/m/Y') }}
                                            <!-- {{ $row->startdate }} -->
                                        </td>
                                        <td data-label="ประเภทงาน">
                                            {{ $row->worktype }}
                                        </td>
                                        <td data-label="ชื่อโปรเจค">
                                            {{ $row->showpjname->name ?? 'None' }}
                                        </td>
                                        <td data-label="รหัสสายวิ่ง">
                                            {{ $row->routecode }}
                                        </td>
                                        <td data-label="ชื่อเส้นทางเดินรถ">
                                            {{ $row->routename }}
                                        </td>
                                        <td data-label="ประเภทการขนส่ง">
                                            {{ $row->showtsptypename->name ?? 'None' }}
                                        </td>
                                        <td data-label="ประเภทรถ">
                                            {{ $row->showtrucktypename->name ?? 'None' }}
                                        </td>
                                        <td data-label="เที่ยวรถ">
                                            {{ $row->showroundtripname->name ?? 'None' }}
                                        </td>
                                        <td data-label="รูปแบบการว่าจ้าง">
                                            {{ $row->showhiringtypename->name ?? 'None' }}
                                        </td>
                                        <td data-label="Subcontractor">
                                            {{ $row->showsplname->name ?? 'None' }}
                                        </td>
                                        <td data-label="เลขทะเบียนรถ">
                                            {{ $row->trucknumb }}
                                        </td>
                                        <td data-label="พนักงานขับรถ">
                                            {{ $row->driver }}
                                        </td>
                                        <td data-label="เบอร์โทร">
                                            {{ $row->telnumb }}
                                        </td>
                                        <td data-label="สาขาต้นทาง">
                                            {{ $row->sbranch }}
                                        </td>
                                        <td data-label="สาขาปลายทาง">
                                            {{ $row->dntbranch }}
                                        </td>
                                        <td data-label="วันที่ตามรถ">
                                        {{ \Carbon\Carbon::parse($row->followdate)->format('d/m/Y') }}
                                        </td>
                                        <td data-label="เวลาตามรถ">
                                            {{ $row->truckrqtime }}
                                        </td>
                                        <td data-label="วันที่ปล่อยรถ">
                                        {{ \Carbon\Carbon::parse($row->releasedate)->format('d/m/Y') }}
                                        </td>
                                        <td data-label="เวลาปล่อยรถ">
                                            {{ $row->dpttime }}
                                        </td>
                                        <td data-label="วันที่กำหนดถึงปลายทาง">
                                        {{ \Carbon\Carbon::parse($row->destinationdate)->format('d/m/Y') }}
                                        </td>
                                        <td data-label="เวลากำหนดถึงปลายทาง">
                                            {{ $row->dnttime }}
                                        </td>
                                        <td data-label="เวลาที่กำหนด(ชั่วโมง)">
                                            {{ $row->totalhour }}
                                        </td>
                                        <td data-label="Monitor staff(KDR)">
                                            {{ $row->mntstaff }}
                                        </td>
                                        <td data-label="Remark">
                                            {{ $row->remark }}
                                        </td>
                                        <td data-label="สถานะแผน">
                                            {{ $row->statusplan }}
                                        </td>
                                        <td data-label="สาเหตุที่ยกเลิก">
                                            {{ $row->ccremark }}
                                        </td>
                                        <td data-label="ผู้สร้างรายการ">
                                            {{ $row->author }}
                                        </td>
                                        <td data-label="ผู้แก้ไขรายการ">
                                            {{ $row->editor }}
                                        </td>
                                        <td data-label="วันเวลาที่ทำรายการ">
                                            {{ date('d-M-Y H:i:s', strtotime($row->created)) }}
                                        </td>
                                        <td data-label="วันเวลาที่แก้ไขรายการ">
                                            {{ date('d-M-Y H:i:s', strtotime($row->updated)) }}
                                        </td>



                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    @if (Request::get('view') != 'all')
                        {{ $rows->appends(Request::all())->links() }} @endif
                </div>
            </div>
            <div class="card-footer">
                <strong>ทั้งหมด</strong> {{ $rows->count() }} @if (Request::get('view') != 'all'): <strong>จาก</strong> {{ $rows->firstItem() }} -
                    {{ $rows->lastItem() }} @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
<
