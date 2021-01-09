<li class="nav-item {{ $nav_item->key == $page ? 'active' : ''}}">
    <a class="nav-link" href="{{env('APP_URL')}}/admin/{{$nav_item->key}}">{{$nav_item->value}}</a>
</li>
