
@if (Session::has('message'))
<div class="alert alert-@if (null !== Session::get('result')){{ Session::get('result') }} @else{{'warning'}}@endif">
    {!!session()->get("message")!!}
</div>
@endif