<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@php
    $rtlLanguages = !empty($generalSettings['rtl_languages']) ? $generalSettings['rtl_languages'] : [];

    $isRtl =
        (in_array(mb_strtoupper(app()->getLocale()), $rtlLanguages) or
        !empty($generalSettings['rtl_layout']) and $generalSettings['rtl_layout'] == 1);
@endphp

<head>
    @include(getTemplate() . '.includes.metas')
    <title>
       Abajim
    </title>

    <!-- General CSS File -->
    <link href="/assets/default/css/font.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/toast/jquery.toast.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/simplebar/simplebar.css">
    <link rel="stylesheet" href="/assets/default/css/app.css">
    <link rel="stylesheet" href="/assets/default/css/panel.css">

    @if ($isRtl)
        <link rel="stylesheet" href="/assets/default/css/rtl-app.css">
    @endif

    @stack('styles_top')
    @stack('scripts_top')

    <style>
        {!! !empty(getCustomCssAndJs('css')) ? getCustomCssAndJs('css') : '' !!} {!! getThemeFontsSettings() !!} {!! getThemeColorsSettings() !!}
    </style>

    @if (!empty($generalSettings['preloading']) and $generalSettings['preloading'] == '1')
        @include('admin.includes.preloading')
    @endif

</head>

<body class="@if ($isRtl) rtl @endif">

    @php
        $isPanel = true;
    @endphp

    <div id="panel_app">
        <div style="z-index:9999999999999999!important">
            @include(getTemplate() . '.includes.navbarPannelEnfant')
        </div>
        <div class="d-flex justify-content-end">
            @if (!$authUser->isOrganization())
                @include(getTemplate() . '.panel.includes.sidebarEnfant')
            @endif
            <div class="panel-content" style="padding: 0px 0px!important;">
                @yield('content')
            </div>


            @include('web.default.includes.advertise_modal.index')
        </div>
        <!-- Template JS File -->
        <script src="/assets/default/js/app.js"></script>
        <script src="/assets/default/vendors/moment.min.js"></script>
        <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
        <script type="text/javascript" src="/assets/default/vendors/simplebar/simplebar.min.js"></script>

        <script>
            var deleteAlertTitle = '{{ trans('public.are_you_sure') }}';
            var deleteAlertHint = '{{ trans('public.deleteAlertHint') }}';
            var deleteAlertConfirm = '{{ trans('public.deleteAlertConfirm') }}';
            var deleteAlertCancel = '{{ trans('public.cancel') }}';
            var deleteAlertSuccess = '{{ trans('public.success') }}';
            var deleteAlertFail = '{{ trans('public.fail') }}';
            var deleteAlertFailHint = '{{ trans('public.deleteAlertFailHint') }}';
            var deleteAlertSuccessHint = '{{ trans('public.deleteAlertSuccessHint') }}';
            var forbiddenRequestToastTitleLang = '{{ trans('public.forbidden_request_toast_lang') }}';
            var forbiddenRequestToastMsgLang = '{{ trans('public.forbidden_request_toast_msg_lang') }}';
        </script>

        <!-- @if (session()->has('toast'))
<script>
    (function() {
        "use strict";

        $.toast({
            heading: '{{ session()->get('toast')['title'] ?? '' }}',
            text: '{{ session()->get('toast')['msg'] ?? '' }}',
            bgColor: '@if (session()->get('toast')['status'] == 'success') #43d477 @else #f63c3c @endif',
            textColor: 'white',
            hideAfter: 10000,
            position: 'bottom-right',
            icon: '{{ session()->get('toast')['status'] }}'
        });
    })(jQuery)
</script>
@endif -->

        @stack('styles_bottom')
        @stack('scripts_bottom')
        <!-- <script src="/assets/default/js//parts/main.min.js"></script> -->

        <script src="/assets/default/js/panel/public.min.js"></script>
        <!--
<script>
    @if (session()->has('registration_package_limited'))
        (function() {
            "use strict";

            handleLimitedAccountModal('{!! session()->get('registration_package_limited') !!}')
        })(jQuery)

        {{ session()->forget('registration_package_limited') }}
    @endif

    {!! !empty(getCustomCssAndJs('js')) ? getCustomCssAndJs('js') : '' !!}
    
</script> -->
</body>

</html>
