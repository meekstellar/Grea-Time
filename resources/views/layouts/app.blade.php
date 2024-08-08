@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

@section('adminlte_css_pre')
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#00c2f3">
    <meta name="theme-color" content="#ffffff">

    <base href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/" />
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/adminlte/dist/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
            {{ config('app.company_name', 'Grea-Time') }}
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script src="{{ asset('vendor/adminlte/dist/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script>

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2').select2({closeOnSelect:false});

        setTimeout(function() {
            $('.alert-success').slideUp();
        }, 4000);


        @if(!empty($date_or_period))

            $('#reservationdate').datetimepicker({
                format: 'DD-MM-YYYY'
            });

            $('#reservation').daterangepicker();
            //Date range as a button
            var start = moment({!! '"'.$date_or_period[0].'"' !!}, "DD-MM-YYYY");
            var end = moment({!! (!empty($date_or_period[1]) ? '"'.$date_or_period[1].'"' : '"'.$date_or_period[0].'"') !!}, "DD-MM-YYYY");
            function cb(start, end) {
                if(start.format('D MMMM YYYY г.') != end.format('D MMMM YYYY г.')){
                    $('#daterange-btn span').html(start.format('D MMMM YYYY г.') + ' — ' + end.format('D MMMM YYYY г.'))
                    $('#reportrange input').val(start.format('DD-MM-YYYY') + '--' + end.format('DD-MM-YYYY'));
                } else {
                    $('#daterange-btn span').html(start.format('D MMMM YYYY г.'));
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

            // Change work_hours_of_day
            $(document).on('change', '[name=work_hours_of_day]', function (e) {
                var _this = $(this);
                var worker_id = $(this).closest('form').data('worker_id');
                var wc_id = $(this).data('wc_id');
                var newHours = $(this).val()*1;
                var oldHours = $('#work_hours_of_day_'+wc_id).val()*1;
                var totalHours = 0;
                var data = {
                    'wc_id' : wc_id,
                    'newHours' : newHours
                };
                $.ajax({
                    url: "{{ route('changeClientsHours') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        if (data.status) {
                            _this.closest('form').find('[name="work_hours_of_day"]').each(function() {
                                totalHours += $(this).val()*1;
                            });
                            toastr.success(data.messages)
                            $('#wc_'+worker_id).html(totalHours);
                        } else {
                            console.log('error');
                        }
                    },
                    error: function (data) {
                        console.log('error');
                    }
                });

            });

            $(document).on('click', '.addClientHoursButton', function (e) {
                var _this = $(this);
                var created_at = '{{$date_or_period[0]}}';
                if($(this).data('worker_id')){
                    var worker_id = $(this).data('worker_id');
                    $('#addClientHours [name="worker_id"]').val(worker_id).trigger('change');
                } else {
                    $('#addClientHours [name="worker_id"]').val($('#addClientHours [name="worker_id"] option:first').val()).trigger('change');
                }
                $('#addClientHours [name="created_at"]').val(created_at);
            });

            $(document).on('click', '.setFee-btn', function (e) {
                $('#setFee').find('[name="client_id"]').val($(this).data('client_id'));
            });

            $(document).on('submit', '#setFee', function (e) {
                e.preventDefault();
                var _this = $(this);
                var client_id = $(this).find('[name="client_id"]').val();
                var fee = $(this).find('[name="fee"]').val();
                var profit = 0;
                var data = {
                    'client_id' : client_id,
                    'fee' : fee*1,
                    'year' : {{ Date::parse($date_or_period[0])->format('Y')*1 }},
                    'month' : {{ Date::parse($date_or_period[0])->format('m')*1 }},
                };
                console.log(data);
                $.ajax({
                    url: "{{ route('setFee') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        if (data.status) {

                            $('.modal-close').trigger('click');
                            toastr.success(data.messages);
                            $('#u'+client_id).find('.setedFee').text(fee);
                            $('#u'+client_id).find('.setedOPEX').text(parseFloat(fee*0.35).toFixed(0));
                            profit = parseFloat(fee-fee*0.35-$('#u'+client_id).find('.setedCostPrice').text()*1).toFixed(0);
                            $('#u'+client_id).find('.seted_profit').text(profit);
                            $('#u'+client_id).find('.marginality').text(parseFloat(profit*100/fee).toFixed(2)+'%');

                        } else {
                            console.log('error1');
                        }
                    },
                    error: function (data) {
                        console.log('error2');
                    }
                });

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
