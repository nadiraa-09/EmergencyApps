@if (Auth::user()->roleId == 1)
@include('layouts.menu.menusu')
@elseif (Auth::user()->roleId == 2)
@include('layouts.menu.menuadmin')
@elseif (Auth::user()->roleId == 3)
@include('layouts.menu.menuleader')
@endif