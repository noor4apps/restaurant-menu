
@foreach($menus as $menu)
    <x-menu-component :menu="$menu"></x-menu-component>
@endforeach
{{--
// controller
$menus = \App\Models\Menu::with('children')->root()->get();
// model
public function children()
{
return $this->hasMany(self::class, 'menu_id', 'id')->with('children');
}
public function scopeRoot($query)
{
$query->whereNull('menu_id');
}
--}}

{{--
@foreach($menus as $menu)
    <div>
        {{$menu->name}}

        @foreach($menu->children as $child)
            <div style="margin-left: 20px;">
                {{$child->name}}

                @foreach($child->children as $subChild)
                    <div style="margin-left: 20px;">
                        {{$subChild->name}}

                        @foreach($subChild->children as $subSubChild)
                            <div style="margin-left: 20px;">
                                {{$subSubChild->name}}
                            </div>
                        @endforeach

                    </div>
                @endforeach

            </div>
        @endforeach

    </div>
@endforeach
--}}
