@props(['id' => '',"idx"=>'', "resource"=>"","resourceSingle"=>""])

@php
    $res=$resource.'.destroy'
@endphp
@if ($id != '' && $resource!="")
    <form class="d-none" action='{{ route($res, [$resourceSingle => $id]) }}' method='post' id="{{$idx}}">
        @csrf
        @method('delete') 
    </form>
@endif

