<li class="nav-item {{ $key == $page ? 'active' : ''}}">
    <a class="nav-link" href="{{config('app.url')}}/admin/{{$key}}">{{$value}}</a>
</li>
