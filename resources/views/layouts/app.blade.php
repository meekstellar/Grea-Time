@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

@section('adminlte_css_pre')
    <base href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/" />
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/plugins/daterangepicker/daterangepicker.css') }}">
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
    <div class="float-right">
        Version: {{ config('app.version', 'beta 0.1') }}
    </div>

    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('app.company_name', 'TimeSheet') }}
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script src="{{ asset('vendor/adminlte/dist/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>

    $(document).ready(function() {
        $('.select2').select2();

        @if(!empty($date_or_period))
            $('#reservation').daterangepicker();
            //Date range as a button
            var start = moment({!! '"'.$date_or_period[0].'"' !!}, "DD-MM-YYYY");
            var end = moment({!! (!empty($date_or_period[1]) ? '"'.$date_or_period[1].'"' : '"'.$date_or_period[0].'"') !!}, "DD-MM-YYYY");
            function cb(start, end) {
                if(start.format('D MMMM YYYY г.') != end.format('D MMMM YYYY г.')){
                    $('#reportrange span').html(start.format('D MMMM YYYY г.') + ' — ' + end.format('D MMMM YYYY г.'))
                    $('#reportrange input').val(start.format('DD-MM-YYYY') + '--' + end.format('DD-MM-YYYY'));
                } else {
                    $('#reportrange span').html(start.format('D MMMM YYYY г.'));
                    $('#reportrange input').val(start.format('DD-MM-YYYY'));
                }
            }
            $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last Week'   : [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                'This Week'   : [moment().startOf('week'), moment().endOf('week')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],

                //'Last 15 days of the last month'  : [moment().subtract(1, 'month').startOf('month').add('days', 15), moment().subtract(1, 'month').endOf('month')],
                //'Fitsr 15 days of this month'  : [moment().startOf('month'), moment().startOf('month').add('days', 14)],
                //'Last 15 days of this month'  : [moment().startOf('month').add('days', 15), moment().endOf('month')],

                },
                startDate: moment({!! '"'.$date_or_period[0].'"' !!}, "DD-MM-YYYY"),
                endDate  : moment({!! (!empty($date_or_period[1]) ? '"'.$date_or_period[1].'"' : '"'.$date_or_period[0].'"') !!}, "DD-MM-YYYY"),
                "alwaysShowCalendars": true
            },
            cb
            );
            $(document).on('click', '.ranges li', function (e) {
                $("#daterange-btn").focus();
            });
            $(document).on('click', '.applyBtn', function (e) {
                $('.preloader').css('height','100vh');
                $('.preloader img').css('display','inline');
                $('#FilterForm').submit();
            });
            $(document).on('submit', '#FilterForm', function (e) {
                $('.preloader').css('height','100vh');
                $('.preloader img').css('display','inline');
            });

        @endif
    });

</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}
    /*
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-weight: 600;
    }
    */

</style>
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endpush
