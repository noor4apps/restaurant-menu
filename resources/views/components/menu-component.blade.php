@props(['menu'])

<div>
    {{$menu->name}}

    @foreach($menu->children as $child)
        <div style="margin-left: 20px;">
            <x-menu-component :menu="$child"></x-menu-component>
        </div>
    @endforeach

</div>
