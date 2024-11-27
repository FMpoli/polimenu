<ul>
    @foreach($menuItems as $item)
        <li>
            <a href="{{ url($item['route']) }}">{{ $item['name'] }}</a>
            <!-- Se ci sono children, li puoi visualizzare ricorsivamente -->
            @if(count($item['children']) > 0)
                <ul>
                    @foreach($item['children'] as $child)
                        <li>
                            <a href="{{ url($child['route']) }}">{{ $child['name'] }}</a>
                            <!-- Se ci sono ulteriori children, continua a nidificare -->
                            @if(count($child['children']) > 0)
                                <ul>
                                    @foreach($child['children'] as $subChild)
                                        <li><a href="{{ url($subChild['route']) }}">{{ $subChild['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
