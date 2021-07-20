<div>

    <div class="fade-in"> 
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">                
                    <div class="card-header"> 
                        <a href="{{url("$segment/user")}}" class="card-header-action">User Management</a>
                        <div class="card-header-actions">
                            <a class="btn btn-sm btn-primary" href="{{url("$segment/user/create")}}"> Create</a>
                            <button class="btn btn-sm btn-danger" type="button" id="delSelect" disabled> Delete</button>
                            @csrf
                        </div>                            
                    </div>
                    <div class="card-body">
                    <form action="{{url("$segment/user/search")}}" method="get">
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
                                <div class="col- lg-4 col-xs-12 mb-4">
                                    <label for="search">Search :</label>
                                    <div class="input-group">
                                        <input type="text" name="keyword" class="form-control" id="search" value="{{Request::get('keyword')}}" placeholder="Username">
                                        <span class="input-group-append">
                                            <button class="btn btn-secondary" type="submit">Search</button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="border-collapse: collapse !important">
                                <thead>
                                    <tr role="">
                                        <th width="5%" style="text-align:center;">#</th>
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="select" class="custom-control-input selectAll" id="selectAll">
                                                <label class="custom-control-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th width="40%">Username</th>
                                        <th>Date registered</th>
                                        <th width="10%">Role</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rows)
                                    @foreach($rows as $key => $row)
                                        <tr role="row" class="odd">
                                            <td style="width:5%; text-align:center;">{{$key+1}}</td>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="select" class="custom-control-input ChkBox" id="ChkBox{{$row->id}}" value="{{$row->id}}">
                                                    <label class="custom-control-label" for="ChkBox{{$row->id}}"></label>
                                                </div>
                                            </td>
                                            <td class="sorting_1">{{$row->name}}</td>
                                            <td>{{date('d-F-Y',strtotime($row->created_at))}}</td>
                                            <td>{{$row->role}}</td>
                                            <td>
                                                @switch($row->status)
                                                    @case('pending')
                                                        <span class="badge badge-warning">{{$row->status}}</span>
                                                        @break
                                                    @case('inactive')
                                                        <span class="badge badge-dark">{{$row->status}}</span>
                                                        @break
                                                    @case('active')
                                                        <span class="badge badge-success">{{$row->status}}</span>
                                                        @break
                                                    @default   
                                                        <span class="badge badge-danger">{{$row->status}}</span>                                                     
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{url("$segment/$controller/$row->id")}}" class="btn btn-success" title="Edit"><i class="far fa-edit"></i></a>
                                                <a href="{{url("$segment/$controller/reset/$row->id")}}" class="btn btn-info" title="Reset Password"><i class="fas fa-sync-alt"></i></a>
                                                <a href="javascript:" class="btn btn-danger deleteItem" data-id="{{$row->id}}" title="Delete"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
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
    