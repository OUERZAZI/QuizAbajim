@php
    $currentStep = empty($currentStep) ? 1 : $currentStep;
@endphp

<div class="webinar-progress d-block d-lg-flex align-items-center p-15 m-20 panel-shadow bg-white rounded-sm">
    @foreach ($progressSteps as $key => $step)
        @if ($step['access'])
            <div class="progress-item d-flex align-items-center">
                <a href="@if (!empty($organization_id)) /panel/manage/{{ $user_type ?? 'instructors' }}/{{ $user->id }}/edit/step/{{ $key }} @else /panel/setting/step/{{ $key }} @endif"
                    class="progress-icon p-10 d-flex align-items-center justify-content-center rounded-circle {{ $key == $currentStep ? 'active' : '' }}"
                    data-toggle="tooltip" data-placement="top" title="{{ trans($step['lang']) }}">
                    <img src="/assets/default/img/icons/{{ $step['icon'] }}.svg" class="img-cover" alt="">
                </a>
                <div class="ml-10 {{ $key == $currentStep ? '' : 'd-lg-none' }}">
                    <h4 class="font-16 text-secondary font-weight-bold">{{ trans($step['lang']) }}</h4>
                </div>
            </div>
        @endif
    @endforeach
</div>
