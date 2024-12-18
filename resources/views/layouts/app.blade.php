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
        Created by <a href="https://psweb.dev" target="_blank">{{ config('app.version', 'psweb.dev') }}</a>
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

        $('#reservationdate').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        $('#reservation').daterangepicker();

        setTimeout(function() {
            $('.alert-success').slideUp();
        }, 6000);

        // Edit managers
        $(document).on('click', '.editManagerClick', function (e) {
            var _this_user_data = $(this).closest('.user_data');
            $('#popup__editManager [name="name"]').val(_this_user_data.find('.data_name').text());
            $('#popup__editManager [name="email"]').val(_this_user_data.find('.data_email').text());
            $('#popup__editManager [name="phone"]').val(_this_user_data.find('.data_phone').text());
            $('#popup__editManager .user-photo-preview').attr('src',_this_user_data.find('.avatar-small').attr('src'));
            $('#popup__editManager [name="id"]').val(_this_user_data.data('id'));
            if($(this).data('access_to_salary')){
                $('#popup__editManager [name="access_to_salary"]').prop('checked', true);
            } else {
                $('#popup__editManager [name="access_to_salary"]').prop('checked', false);
            }
        });

        @if(!empty($date_or_period))
            let date_or_period = ["{!! $date_or_period[0] !!}", "{!! (!empty($date_or_period[1]) ? $date_or_period[1] : $date_or_period[0]) !!}"];
            //console.log(date_or_period);
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
                //'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'This Week'   : [moment().startOf('week'), moment().endOf('week')],
                'Last Week'   : [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                '1 month ago'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                '2 months ago'  : [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')],
                '3 months ago'  : [moment().subtract(3, 'month').startOf('month'), moment().subtract(3, 'month').endOf('month')],
                '4 months ago'  : [moment().subtract(4, 'month').startOf('month'), moment().subtract(4, 'month').endOf('month')],
                '5 months ago'  : [moment().subtract(5, 'month').startOf('month'), moment().subtract(5, 'month').endOf('month')],
                '6 months ago'  : [moment().subtract(6, 'month').startOf('month'), moment().subtract(6, 'month').endOf('month')],

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
                var worker_id = $(this).closest('form').data('id');
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
                            if(newHours == 0){
                                _this.closest('tr').slideUp();
                            }
                        } else {
                            console.log('error');
                        }
                    },
                    error: function (data) {
                        console.log('error');
                    }
                });

            });

            $(document).on('click', '.show_clients_marginality', function (e) {
                var _this = $(this);
                var client_id = _this.data('client_id');
                $('#popup__clients_marginality h4 b').text(_this.data('client_name'));
                var data = {
                    'client_id' : client_id,
                };
                $.ajax({
                    url: "{{ route('show_clients_marginality') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        if (data) {

                            var table = $('#clients_marginality_table');
                            table.empty();

                            var colors = ['bg-danger','bg-warning',' bg-primary','bg-success'];

                            var row = $('<tr>');
                                    row.append('<th>Год</td>');
                                    row.append('<th>Месяц</th>');
                                    row.append('<th>Маржинальность</th>');
                                    row.append('<th style="width: 40px"></th>');
                                    table.append(row);
                            var k = 0;
                            $.each(JSON.parse(data), function (index, value) {

                                let date = new Date();
                                date.setMonth(value.month - 1); // Встановлюємо потрібний місяць

                                let options = { month: 'long' };

                                var row = $('<tr>');
                                    row.append('<td>' + value.year + '</td>');
                                    row.append('<td style="min-width: 100px; text-transform: capitalize;">' + date.toLocaleDateString('ru-RU', options) + '</td>');
                                    row.append('<td style="width: 100%;"class="align-middle"><div class="progress progress-xs"><div class="progress-bar '+colors[k]+'" style="width: ' + value.marginality + '%"></div></div></td>');
                                    row.append('<td><span class="badge '+colors[k]+'">' + value.marginality + '%</span></td>');
                                    table.append(row);
                                    k++;
                                    if(k >= colors.length){
                                        k = 0;
                                    }
                                });

                        } else {
                            console.log('error1');
                        }
                    },
                    error: function (data) {
                        console.log('error2');
                    }
                });

            });

            $(document).on('click', '.addClientHoursButton', function (e) {
                var _this = $(this);
                var created_at = '{{$date_or_period[0]}}';

                var _thisForm = $(this).closest('form');
                var clients_ids = (_thisForm.data('clientsids') || '').toString().split(',');
                if (clients_ids.length === 1 && clients_ids[0] === '') {
                    clients_ids = [];
                }
                $.ajax({
                    url: '/get-clients',
                    type: 'POST',
                    data: {
                        client_ids: clients_ids,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            // Clear select
                            $('#addClientHours [name="client_id"]').empty();

                            // Add options for select
                            $.each(response.clients, function (index, client) {
                                $('#addClientHours [name="client_id"]').append(
                                    $('<option></option>').val(client.id).text(client.name)
                                );
                            });
                        } else {
                            console.log('Ошибка:', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Ошибка запроса:', error);
                    }
                });

                if($(this).data('worker_id')){
                    var worker_id = $(this).data('worker_id');
                    $('#addClientHours [name="worker_id"]').val(worker_id).trigger('change');
                } else {
                    $('#addClientHours [name="worker_id"]').val($('#addClientHours [name="worker_id"] option:first').val()).trigger('change');
                }
                $('#addClientHours [name="created_at"]').val(created_at);
            });

            // Автоматичне підтягування зарплати за потрібний місяць
            $(document).on('change', '#popup__editWorkerFromClient select[name="year"], #popup__editWorkerFromClient select[name="month"]', function (e) {
                var worker_id = $(this).closest('form').find('input[name="id"]').val();
                var newYear = $('#popup__editWorkerFromClient select[name="year"]').val();
                var newMonth = $('#popup__editWorkerFromClient select[name="month"]').val();
                $.ajax({
                    url: '/get-salary',
                    type: 'POST',
                    data: {
                        worker_id: worker_id,
                        year: newYear,
                        month: newMonth,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#popup__editWorkerFromClient input[name="salary"]').val(response.salary);
                        } else {
                            console.log('Ошибка:', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('Ошибка запроса:', error);
                    }
                });
            });

            $(document).on('click', '.setFee-btn', function (e) {
                $('#setFee').find('[name="client_id"]').val($(this).data('client_id'));
                $('#setFee').find('[name="fee"]').val($(this).next('.setedFee').text());
            });

            $(document).on('submit', '#setFee', function (e) {
                e.preventDefault();
                var _this = $(this);
                var client_id = $(this).find('[name="client_id"]').val();
                var fee = $(this).find('[name="fee"]').val();
                var profit = parseFloat(fee-fee*0.35-$('#u'+client_id).find('.setedCostPrice').text()*1).toFixed(0);
                var marginality = parseFloat(profit*100/fee).toFixed(2);
                var data = {
                    'client_id' : client_id,
                    'fee' : fee*1,
                    'year' : {{ Date::parse($date_or_period[0])->format('Y')*1 }},
                    'month' : {{ Date::parse($date_or_period[0])->format('m')*1 }},
                    'marginality' : marginality*1,
                };
                //console.log(data);
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
                            $('#u'+client_id).find('.seted_profit').text(profit);
                            $('#u'+client_id).find('.marginality').text(marginality+'%');

                        } else {
                            console.log('error1');
                        }
                    },
                    error: function (data) {
                        console.log('error2');
                    }
                });

            });

            // Edit Workers
            $(document).on('click', '.editWorkerFromClientClick', function (e) {

                var _thisForm = $(this).closest('form');
                var clients_ids = (_thisForm.data('clientsids') || '').toString().split(',');
                if (clients_ids.length === 1 && clients_ids[0] === '') {
                    clients_ids = [];
                }
                $('.cwe').attr('checked', false);
                for(var i = 0; i < clients_ids.length; i++){
                    $('#cwe_'+clients_ids[i]).attr('checked', true);
                    //console.log('#cwe_'+clients_ids[i]);
                }

                $('#popup__editWorkerFromClient [name="name"]').val(_thisForm.find('.data_name').text());
                $('#popup__editWorkerFromClient [name="email"]').val(_thisForm.find('.data_email').text());
                $('#popup__editWorkerFromClient .user-photo-preview').attr('src',_thisForm.find('.worker-avatar').attr('src'));
                $('#popup__editWorkerFromClient [name="position"]').val(_thisForm.data('position'));
                $('#popup__editWorkerFromClient [name="id"]').val(_thisForm.data('id'));
                $('#popup__editWorkerFromClient [name="password"]').val('');
                $('#popup__editWorkerFromClient [name="salary"]').val(_thisForm.data('salary'));

                setTimeout(function() {
                    $('#popup__editWorkerFromClient select[name="year"]').val($('#popup__editWorkerFromClient select[name="year"]').data('default_year')).attr('selected', 'selected').change();
                    $('#popup__editWorkerFromClient select[name="month"]').val($('#popup__editWorkerFromClient select[name="month"]').data('default_month')).attr('selected', 'selected').change();
                }, 10);
            });

            // Edit Clients
            $(document).on('click', '.editClientClick', function (e) {
                var _thisForm = $(this).closest('form');
                $('#popup__editClient [name="name"]').val(_thisForm.find('.data_name').text());
                $('#popup__editClient [name="email"]').val(_thisForm.find('.data_email').text());
                $('#popup__editClient .user-logo-preview').attr('src',_thisForm.find('.client-avatar').attr('src'));
                $('#popup__editClient [name="id"]').val(_thisForm.data('id'));
            });

            // Send Reminfer
            $(document).on('click', '.send_reminder', function (e) {
                var _this = $(this);
                var worker_id = $(this).data('worker_id');
                var day = $(this).data('day');
                var data = {
                    'worker_id' : worker_id,
                    'day' : day
                };

                _this.removeClass('send_reminder');
                _this.prop('title', 'Ожидайте');
                _this.html('<i class="fas fa-ban"></i>');
                _this.prop('disabled', true);
                _this.css('cursor', 'wait');
                _this.css('color', '');
                $.ajax({
                    url: "{{ route('send.reminder') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        if (data.status) {
                            _this.removeClass('send_reminder');
                            _this.prop('title', 'Письмо отправлено');
                            toastr.success('Письмо отправлено.')
                            _this.html('<i class="fas fa-check"></i>');
                            _this.css('cursor', 'default');
                            _this.prop('disabled', true);
                            _this.css('color', '');
                        } else {
                            _this.addClass('send_reminder');
                            _this.prop('title', 'Ошибка. Попробуйте еще раз.');
                            toastr.error('Ошибка. Попробуйте еще раз.')
                            _this.html('<i class="fas fa-envelope"></i>');
                            _this.css('cursor', '');
                            _this.css('color', '#c44343');
                            _this.prop('disabled', false);
                        }
                    },
                    error: function (data) {
                        _this.addClass('send_reminder');
                        _this.prop('title', 'Ошибка. Попробуйте еще раз.');
                        toastr.error('Ошибка. Попробуйте еще раз.')
                        _this.html('<i class="fas fa-envelope"></i>');
                        _this.css('cursor', '');
                        _this.css('color', '#c44343');
                        _this.prop('disabled', false);
                    }
                });

            });

            // Add Rest Day
            $(document).on('click', '.add_rest_days', function (e) {
                var _this = $(this);
                var worker_id = $(this).data('worker_id');
                var day = $(this).data('day');
                var data = {
                    'worker_id' : worker_id,
                    'day' : day
                };

                _this.removeClass('add_rest_days');
                _this.prop('title', 'Ожидайте');
                _this.html('<i class="fas fa-ban"></i>');
                _this.prop('disabled', true);
                _this.css('cursor', 'wait');
                _this.css('color', '');
                $.ajax({
                    url: "{{ route('addRestDay') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        if (data.status) {
                            _this.removeClass('add_rest_days');
                            _this.prop('title', 'Отпуск установлен');
                            toastr.success(data.message)
                            _this.html('<i class="fas fa-check"></i>');
                            _this.css('cursor', 'default');
                            _this.prop('disabled', true);
                            _this.css('color', '');
                        } else {
                            _this.addClass('add_rest_days');
                            _this.prop('title', 'Ошибка. Попробуйте еще раз.');
                            toastr.error('Ошибка. Попробуйте еще раз.')
                            _this.html('O');
                            _this.css('cursor', '');
                            _this.css('color', '#c44343');
                            _this.prop('disabled', false);
                        }
                    },
                    error: function (data) {
                        _this.addClass('add_rest_days');
                        _this.prop('title', 'Ошибка. Попробуйте еще раз.');
                        toastr.error('Ошибка. Попробуйте еще раз.')
                        _this.html('O');
                        _this.css('cursor', '');
                        _this.css('color', '#c44343');
                        _this.prop('disabled', false);
                    }
                });

            });

        @endif

    });

    @if (request()->is('worker', 'workers'))
    var refresh_time_out = 10; //хв
    @endif

</script>
@vite(['resources/js/app.js'])
@endpush

{{-- Add common CSS customizations --}}

@push('css')
@vite(['resources/sass/app.scss'])
@endpush
