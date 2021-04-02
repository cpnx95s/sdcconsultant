<div>
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">

                        <a href="{{url("$segment")}}" class="card-header-action">Vehicle Type</a>
                        <div class="card-header-actions">
                            <button class="btn btn-default btn-md" id="sort" data-text="Sort">Sort</button>
                            <a class="btn btn-md btn-success" href="{{url("$segment/create")}}"> Add</a>
                            <button class="btn btn-md btn-primary text-white" type="reset" id="delCopy" disabled> Copy</button>
                            <button class="btn btn-md btn-warning text-white" type="reset" id="delEdit" disabled> Edit</button>
                            <button class="btn btn-md btn-danger" type="reset" id="delSelect" disabled>Delete</button>
                        </div>
                    </div>
                    <div class="card-body">
                        @csrf
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-lg-4 col-xs-12 mb-4">
                                    <label for="search">Search :</label>
                                    <form action="{{route('trucktype.search')}}" method="get">
                                        <div class="input-group">
                                            <input type="text" name="keyword" class="form-control" id="search" value="{{Request::get('keyword')}}" placeholder="Vehicle Type">
                                            <span class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">Search</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                        <br class="d-block d-sm-none" />
                        <div class="table-responsive">
                            <table class="table table-striped no-footer table-res" id="sorted_table" style="border-collapse: collapse !important">
                                <thead>
                                    <tr role="">
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="select" class="custom-control-input selectAll" id="selectAll">
                                                <label class="custom-control-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th width="60%">Vehicle Type</th>
                                        <th width="20%">Created</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows)
                                    @foreach($rows as $key => $row)
                                    @php($data = \App\MenuModel::where('_id',$row->id)->get())
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
                                        <td data-label="Vehicle Type">
                                            {{$row->name}}
                                        </td>
                                        <td data-label="created">
                                            {{date('d-M-Y H:i:s',strtotime($row->created))}}
                                        </td>

                                        <td data-label="Action">
                                            <a href="{{url("$segment/$row->id")}}" class="btn btn-warning text-white" title="Edit"><i class="far fa-edit"></i></a>
                                            <a href="{{url("$segment/$row->id")}}" class="btn btn-primary" title="Copy"><i class="far fa-copy"></i></a>
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