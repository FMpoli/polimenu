<ul>
    @foreach($menuItems as $item)
        <li>
            <a href="{{ url($item['url']) }}">{{ $item['name'] }}</a>

        </li>
    @endforeach
</ul>
