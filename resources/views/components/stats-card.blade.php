@props(['title', 'sub_title', 'number' ,'bg'])

<div class="card mb-3 widget-content @isset($bg) {{$bg}} @else bg-midnight-bloom @endisset">
    <div class="widget-content-wrapper text-white">
        <div class="widget-content-left">
            <div class="widget-heading">{{$title}}</div>
            <div class="widget-subheading">{{$sub_title}}</div>
        </div>
        <div class="widget-content-right">
            <div class="widget-numbers text-white"><span>{{$number}}</span></div>
        </div>
    </div>
</div>