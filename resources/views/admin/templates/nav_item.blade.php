<li class="nav-item {{ $key == $page ? 'active' : ''}}">
    <a class="nav-link" href="{{env('APP_URL')}}/admin/{{$key}}">{{$value}}</a>
</li>
