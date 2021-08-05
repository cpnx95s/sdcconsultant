<div class="c-sidebar-brand">
    <img class="c-sidebar-brand-minimized"><i class=" fas fa-toolbox fa-lg">&nbsp;</i>
    <h5 class="c-sidebar-brand-ful" style="margin-bottom:0px;">System Menu</h5>
</div>                
<ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{url("staffwebpanel/")}}"><i class="c-sidebar-nav-icon fas fa-tachometer-alt fa-fw"></i>Dashboard<span class="badge badge-info">NEW</span></a></li>
    <li class="c-sidebar-nav-title">Management</li>
    @php($menu = \App\MenuModel::where(['position'=>'main','status'=>'on'])->orderBy('sort')->get())
    @foreach($menu as $i => $m)
        @php($second = \App\MenuModel::where('_id',$m->id)->get())  
        <li class="c-sidebar-nav-item @if($second) c-sidebar-nav-dropdown @endif">
            <a class="c-sidebar-nav-link @if(count($second)>0) c-sidebar-nav-dropdown-toggle @endif" href="staffwebpanel{!!$m->url!!}"><i class="c-sidebar-nav-icon {!!$m->icon!!}"></i> {{$m->name}}</a>
            @if(count($second)>0)
                <ul class="c-sidebar-nav-dropdown-items ">
                    @foreach($second as $i => $s)
                    <li><a class="c-sidebar-nav-link" href="staffwebpanel{{$s->url}}"><span class="c-sidebar-nav-icon"></span> {{$s->name}}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>        
    @endforeach
    <li class="c-sidebar-nav-title">Administrator</li>
    @php($menu = \App\MenuModel::where(['position'=>'main','status'=>'off'])->orderBy('sort')->get())
    @foreach($menu as $i => $m)
        @php($second = \App\MenuModel::where('_id',$m->id)->get())  
        <li class="c-sidebar-nav-item @if($second) c-sidebar-nav-dropdown @endif">
            <a class="c-sidebar-nav-link @if(count($second)>0) c-sidebar-nav-dropdown-toggle @endif" href="adminwebpanel{!!$m->url!!}"><i class="c-sidebar-nav-icon {!!$m->icon!!}"></i> {{$m->name}}</a>
            @if(count($second)>0)
                <ul class="c-sidebar-nav-dropdown-items ">
                    @foreach($second as $i => $s)
                    <li><a class="c-sidebar-nav-link" href="adminwebpanel{{$s->url}}"><span class="c-sidebar-nav-icon"></span> {{$s->name}}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>        
    @endforeach
    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
        <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#"><i class="c-sidebar-nav-icon fas fa-sliders-h"></i> Setting</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="adminwebpanel/user"><span class="c-sidebar-nav-icon"></span> User</a></li>
        </ul>
    </li>
    <li class="c-sidebar-nav-divider"></li>
</ul>
<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>