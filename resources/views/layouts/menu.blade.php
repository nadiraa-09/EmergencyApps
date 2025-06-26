@if (Auth::user()->roleId == 1)
@include('layouts.menu.menusu')
@elseif (Auth::user()->roleId == 2)
@include('layouts.menu.menuadmin')
@elseif (Auth::user()->roleId == 3 || Auth::user()->roleId == 4)
@include('layouts.menu.menuleader')
@elseif (Auth::user()->roleId == 5)
@include('layouts.menu.menudepthead')
@endif