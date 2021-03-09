<div>
    <div class="fade-in"> 
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">                
                    <div class="card-header"> 
                        
                        <a href="{{url("$segment")}}" class="card-header-action">จัดการประเภทรถ</a>
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
                        <form  action="" method="get">                            
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
                                        <input type="text" name="keyword" class="form-control" id="search" value="{{Request::get('keyword')}}" placeholder="ชื่อประเภทรถ">
                                        <span class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">ค้นหา</button>
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                        <br class="d-block d-sm-none"/>
                        <div class="table-responsive">
                            <table  class="table table-striped no-footer table-res" id="sorted_table" style="border-collapse: collapse !important">
                                <thead>
                                    <tr role="">
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="select" class="custom-control-input selectAll" id="selectAll">
                                                <label class="custom-control-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th width="60%">ชื่อประเภทรถ</th>
                                        <th width="20%">วันที่สร้าง</th>
                                        <th width="20%">จัดการ</th>
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
                                            <td data-label="ชื่อประเภทรถ">
                                                {{$row->name}}
                                            </td>
                                            <td data-label="created">
                                                {{date('d-M-Y H:i:s',strtotime($row->created))}}
                                            </td>
                                            
                                            <td data-label="Action">
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
    