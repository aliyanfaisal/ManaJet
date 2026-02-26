<div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer__inner justify-content-center text-center font-weight-bold">
            Built with &hearts; by Aliyan Faisal and Saira 
        </div>
    </div>
</div>
</div>
</div>
</div>
{{-- <script src="http://maps.google.com/maps/api/js?sensor=true"></script> --}}

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{asset('js/resource-control.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
@php
$token = Session::get("user_token");

@endphp
<script>
    const token = '{{$token}}'
</script>

@include('includes.js-functions')

@isset($use_bootstrap_js)
<script src="{{asset('js/bootstrap/bootstrap-js.js')}}"></script>
@endisset

@isset($use_chartjs)

<script src="{{asset("js/chartjs/chartjs-utils.js")}}"></script>
<script>
    const Utils = ChartUtils.init();
</script>
<script src="{{asset("js/chartjs/chartjs.js")}}"></script>
<script src="{{asset('js/chartjs/chartjs-piecelabel.js') }}"></script>
@endisset

@yield('js')

