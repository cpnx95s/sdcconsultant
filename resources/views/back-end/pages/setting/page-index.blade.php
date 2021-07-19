<div>
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{url("$segment")}}" class="card-header-action">ตั้งค่าหน้า / Setting Page</a>
                        <div class="card-header-actions">
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="view">View : </label>
                                        @php($numrows=10)
                                        <select name="view" id="view" class="form-control">
                                            <option value="10">10</option>
                                            @for($i=1; $i<6; $i++) <option value="{{$numrows = $numrows*2}}" @if(Request::get('rows')==$numrows) selected @endif>{{$numrows}}</option>
                                                @endfor
                                                <option value="all">All</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4 col-xs-12">
                                        <label for="search">Keyword :</label>
                                        <div class="input-group">                                        
                                            <input type="text" name="keyword" class="form-control" id="search" value="{{Request::get('keyword')}}" placeholder="Name of Menu">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">Search</button>
                                </span>
                            </div>

                    </div> --}}
                </div>
                </form>
                <div>
                    <br>
                </div>
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped no-footer" id="sort_table" role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                        <thead>
                            <tr role="">
                                <th width="5%" style="text-align:center;">#</th>
                                <th width="5%">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="select" class="custom-control-input selectAll" id="selectAll">
                                        <label class="custom-control-label" for="selectAll"></label>
                                    </div>
                                </th>
                                <th width="50%">Comment</th>
                                <th width="15%">วันที่อัพเดต</th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($rows)
                            @foreach($rows as $key => $row)
                            <tr role="row" class="odd" data-row="{{$key+1}}" data-id="{{$row->id}}">
                                <td style="width:5%; text-align:center;"><span class="no">{{$key+1}}</span> <i class="fas fa-bars handle d-none"></i></td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="select" class="custom-control-input ChkBox" id="ChkBox{{$row->id}}" value="{{$row->id}}">
                                        <label class="custom-control-label" for="ChkBox{{$row->id}}"></label>
                                    </div>
                                </td>
                                <td>{{$row->comment}}</td>
                                <td>{{date('d-M-Y H:i:s',strtotime($row->updated))}}</td>
                                <td>
                                    <a href="{{url("$segment/$row->id")}}" class="btn btn-warning" title="Edit"><i style="color:white;" class="far fa-edit"></i></a>
                                    <a href="javascript:" class="btn btn-danger deleteItem" data-id="{{$row->id}}" title="Delete"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{$rows->links()}}
                </div>
            </div>
            <div class="card-footer">
                <strong>ทั้งหมด</strong> {{$rows->count()}} : <strong>จาก</strong> {{$rows->firstItem()}} - {{$rows->lastItem()}}
            </div>
        </div>
    </div>
</div>
</div>
</div>