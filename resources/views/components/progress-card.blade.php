@props(['value', 'title', 'color', 'showCard' => 'true'])

<div
    class="card-shadow-@isset($color){{ $color }} @else success mb-3 @endisset  widget-chart widget-chart2 text-left card">
    <div class="widget-content @if ($showCard == 'false') p-2 @endif" style="min-width: 120px">
        <div class="widget-content-outer">
            <div class="widget-content-wrapper">
                <div class="widget-content-left pr-2 fsize-1">
                    <div
                        class="widget-numbers mt-0 fsize-2 text-@isset($color){{ $color }} @else success @endisset">
                        @isset($value)
                            {{ $value }}%
                        @else
                            0%
                        @endisset
                    </div>
                </div>
                <div class="widget-content-right w-100">
                    <div class="progress-bar-xs progress">
                        <div class="progress-bar  bg-@isset($color){{ $color }} @else success @endisset"
                            role="progressbar" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100"
                            style="width:@isset($value) {{ $value }}% @else 0% @endisset;">
                        </div>
                    </div>
                </div>
            </div>
            @if ($showCard == 'true')
                <div class="widget-content-left fsize-1">
                    <div class="text-muted opacity-6">
                        @isset($title)
                            {{ $title }}
                        @endisset
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
