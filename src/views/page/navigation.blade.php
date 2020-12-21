<ul class="sidebar-menu do-nicescrol">
    <li class="sidebar-header">MAIN NAVIGATION</li>
    @foreach(AdminNavigation::getItems() as $identifier => $item)
    <li>
        <a href="{{ !empty($item['route']) ? route($item['route']) : 'javascript:void(0);'}}" class="waves-effect">
            <i class="{{ $item['icon'] }}"></i>
            <span>{{ $item['label'] }}</span>
            @if(!empty($item['childrens']))
            <i class="fa fa-angle-left pull-right"></i>
            @endif
        </a>
        @if(!empty($item['childrens']))
        <ul class="sidebar-submenu">
            @foreach($item['childrens'] as $identifier => $childItem)
            <li>
                <a href="{{ !empty($childItem['route']) ? route($childItem['route']) : 'javascript:void(0);'}}">
                    <i class="fa fa-circle-o"></i> {{ $childItem['label'] }}
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach
</ul>
