<div class="c-sidebar-brand">
    <img class="c-sidebar-brand-minimized"><i class=" fas fa-toolbox fa-lg">&nbsp;</i>
    <h5 class="c-sidebar-brand-ful" style="margin-bottom:0px;">System Menu</h5>
</div>                
<ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{url("webpanel/")}}"><i class="c-sidebar-nav-icon fas fa-tachometer-alt fa-fw"></i>Dashboard<span class="badge badge-info">NEW</span></a></li>
    <li class="c-sidebar-nav-title">Management</li>
    @php($menu = \App\MenuModel::where(['position'=>'main','status'=>'on'])->orderBy('sort')->get())
    @foreach($menu as $i => $m)
        @php($second = \App\MenuModel::where('_id',$m->id)->get())  
        <li class="c-sidebar-nav-item @if($second) c-sidebar-nav-dropdown @endif">
            <a class="c-sidebar-nav-link @if(count($second)>0) c-sidebar-nav-dropdown-toggle @endif" href="webpanel{!!$m->url!!}"><i class="c-sidebar-nav-icon {!!$m->icon!!}"></i> {{$m->name}}</a>
            @if(count($second)>0)
                <ul class="c-sidebar-nav-dropdown-items ">
                    @foreach($second as $i => $s)
                    <li><a class="c-sidebar-nav-link" href="webpanel{{$s->url}}"><span class="c-sidebar-nav-icon"></span> {{$s->name}}</a></li>
                    @endforeach
                </ul>
            @endif
        </li>        
    @endforeach
   
</ul>
<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>