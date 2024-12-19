@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    Клиенты
                </h1>
            </div>
            <div class="col-sm-5 text-right">
                <a href="#" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#addNewClient"><i class="fas fa-user-tie" aria-hidden="true"></i> &nbsp;Новый клиент</a>
                @if(!empty($WorkerClientHours) && count($WorkerClientHours) > 0)
                    <a href="{{ route('clients') }}?date_or_period={{ $date_or_period[0] }}@if(!empty($date_or_period[1]))--{{ $date_or_period[1] }}@endif{{ $url_w }}&export=pdf" class="btn btn-info export_to_pdf btn-sm"><i class="fas fa-file-pdf"></i> &nbsp;PDF</a>
                    <a href="{{ route('clients') }}?date_or_period={{ $date_or_period[0] }}@if(!empty($date_or_period[1]))--{{ $date_or_period[1] }}@endif{{ $url_w }}&export=xls" class="btn btn-info export_to_pdf btn-sm"><i class="fas fa-file-alt"></i> &nbsp;XLS</a>
                @endif
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {!! session('status') !!}
                </div>
            @endif
            <div class="row">
                <form class="col-md-4" action="{{ route('clients') }}" id="FilterForm" method="GET">
                    <div class="card card-primary card-outline sticky-top">
                        <div class="card-header">
                          <h5 class="card-title"><i class="fa fa-filter" aria-hidden="true"></i> Фильтр</h5>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><i class="far fa-calendar-alt"></i> Дата или период:</label>
                                        <div class="input-group" style="align-items: flex-start;">
                                            <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                                <i class="far fa-calendar-alt"></i> <span>{{ Date::parse($date_or_period[0])->format('j F Y') }}@if(!empty($date_or_period[1])) — {{ Date::parse($date_or_period[1])->format('j F Y') }}@endif</span>
                                                <i class="fas fa-caret-down"></i>
                                            </button>
                                            <div id="reportrange">
                                                <input type="hidden" name="date_or_period" value="{{ $date_or_period[0] }}@if(!empty($date_or_period[1]))--{{ $date_or_period[1] }}@endif" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="nav-icon fas fa-user-secret" aria-hidden="true"></i> Клиенты:</label>
                                        <select name="w[]" class="select2" multiple="multiple" data-placeholder="Отображать всех клиентов" style="width: 100%;">
                                            @if(!empty($users['clients']))
                                                @foreach($users['clients'] as $client)
                                                    <option value="{{ $client->id }}" @if(!empty(request()->w) && in_array($client->id,request()->w)){{ 'selected' }}@endif>{{ $client->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right mb-0">
                                <button type="submit" class="btn btn-primary">Применить</button>
                            </div>
                        </div>
                      </div>
                </form>
                <div class="col-md-8">

                    <div class="row">

                        @if(!empty($WorkerClientHours) && count($WorkerClientHours) > 0)
                            @foreach($WorkerClientHours->unique('client_id') as $wc)
                                @if($wc->client()->active)
                                    <div class="col-12">
                                        <form id="u{{ $wc->client_id }}" data-client_id="{{ $wc->client_id }}" data-id="{{ $wc->client_id }}" class="card bg-white d-flex flex-fill">
                                            <div class="card-body pt-3">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h2 class="lead mb-0"><a href="#" class="b600 editClientClick data_name" data-toggle="modal" data-target="#popup__editClient">{{ $wc->client()->name }}</a></h2>
                                                        @if(!empty($wc->client()->phone) || !empty($wc->client()->email))
                                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                                            <li class="small" style="display: none;"><span class="fa-li"><i class="fas fa-envelope"></i></span> <a href="mailto:{{ $wc->client()->email }}" class="data_email">{{ $wc->client()->email }}</a></li>
                                                            @if(!empty($wc->client()->phone) && 2==3)<li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:{{ $wc->client()->phone }}">{{ $wc->client()->phone }}</a></li>@endif
                                                            @if(!empty($wc->client()->address) && 2==3)<li class="small"><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> {{ $wc->client()->address }}</li>@endif
                                                        </ul>
                                                        @endif
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <img alt="Фото клиента" class="client-avatar img-circle img-fluid" src="{{ (!empty($wc->client()->image) && File::exists('storage/'.$wc->client()->image) ? asset('storage/'.$wc->client()->image) : asset('vendor/adminlte/dist/img/no-logo.jpg')) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <table class="table table-sm client-table">
                                                    <tbody>
                                                        @php
                                                            $processed = [];
                                                            $all_clients_hours = 0;
                                                            $k=1;
                                                        @endphp
                                                        @foreach($WorkerClientHours->where('client_id',$wc->client_id) as $wc_workers)
                                                            @if(!in_array($wc_workers->worker_id,$processed))
                                                            @php
                                                                $worker_salary = (!empty($WorkersSalaryArray[$wc_workers->worker_id][\Date::parse($wc_workers->created_at)->format('Y')][\Date::parse($wc_workers->created_at)->format('n')]) ? $WorkersSalaryArray[$wc_workers->worker_id][\Date::parse($wc_workers->created_at)->format('Y')][\Date::parse($wc_workers->created_at)->format('n')] : 0);
                                                            @endphp
                                                            <tr>
                                                                <td style="width: 10px">{{ $k }}.</td>
                                                                <td class="user_active_{{$wc_workers->worker()->active}}">{{ $wc_workers->worker()->name }} <span class="worker_positon">({{ $wc_workers->worker()->position }}@if(in_array($selectCountDays, [28,29,30,31]) && (auth()->user()->access_to_salary || auth()->user()->manager_important)), {{ $worker_salary }} ₽ / мес @endif)</span></td>
                                                                <td valign="middle" style="white-space: nowrap; width: 80px; text-align: left; @if(in_array($selectCountDays, [28,29,30,31]) && (auth()->user()->access_to_salary || auth()->user()->manager_important))font-size: .9rem;@endif">
                                                                    @php
                                                                        $clients_hours = $wchArray[$wc->client_id][$wc_workers->worker_id];
                                                                        $pay_per_one_hour = 0;
                                                                        if(!empty($worker_salary)){
                                                                            $pay_per_one_hour = $worker_salary/160;
                                                                        }
                                                                        $all_clients_hours += $clients_hours*$pay_per_one_hour;
                                                                    @endphp
                                                                    <i class="far fa-clock"></i>&nbsp;{{ $clients_hours }}&nbsp;ч.
                                                                </td>
                                                                @if(in_array($selectCountDays, [28,29,30,31]) && (auth()->user()->access_to_salary || auth()->user()->manager_important))
                                                                    <td style="width: 80px; text-align: right; white-space: nowrap;">{{ $clients_hours*$pay_per_one_hour }} {{ $currency }}</td>
                                                                @endif
                                                            </tr>
                                                            @php
                                                                $processed[] = $wc_workers->worker_id;
                                                                $k++;
                                                            @endphp
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </table>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-12">
                                                        @if(in_array($selectCountDays, [28,29,30,31]))
                                                            @php
                                                                $fee =  (!empty($wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)) ? $wc->client()->fee(\Date::parse($date_or_period[0])->format('Y') ,\Date::parse($date_or_period[0])->format('m')*1)->fee : 0);
                                                                $OPEX = $fee*0.35;
                                                                $profit = $fee - $OPEX - $all_clients_hours;
                                                                $marginality = (!empty($fee) ? round($profit*100/$fee,2) : 0);
                                                            @endphp
                                                            <table class="table table-sm client-table mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" style="border-top: 0">ИТОГО Себестоимость</td>
                                                                        <td style="border-top: 0; text-align: right; white-space: nowrap;"><span class="setedCostPrice">{{ $all_clients_hours }}</span> {{ $currency }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">OPEX (35%)</td>
                                                                        <td style="text-align: right; white-space: nowrap; white-space: nowrap;"><span class="setedOPEX">{{ round($OPEX,0) }}</span> {{ $currency }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">ГОНОРАР</td>
                                                                        <td style="text-align: right;"><a href="#" class="setFee-btn" data-toggle="modal" data-target="#setFee" data-client_id="{{ $wc->client_id }}"><i class="far fa-edit"></i></a> <span class="setedFee">{{ $fee }}</span> {{ $currency }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">ПРИБЫЛЬ</td>
                                                                        <td style="text-align: right; font-weight: bold; white-space: nowrap;"><span class="seted_profit">{{ round($profit,0) }}</span> {{ $currency }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2"><a href="#" class="show_clients_marginality" data-toggle="modal" data-target="#popup__clients_marginality" data-client_id="{{ $wc->client_id }}" data-client_name="{{ $wc->client()->name }}">МАРЖИНАЛЬНОСТЬ</a></td>
                                                                        <td style="text-align: right; font-weight: bold; white-space: nowrap;" class="marginality">{{ $marginality }}%</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            @if(\Date::parse($date_or_period[0])->format('d')*1 == 1)
                                                                @php
                                                                    $ClientsMarginality = App\Models\ClientsMarginality::updateOrCreate(
                                                                        ['client_id' => $wc->client_id, 'year' => \Date::parse($date_or_period[0])->format('Y'), 'month' => \Date::parse($date_or_period[0])->format('m')],
                                                                        ['marginality' => $marginality]
                                                                    );
                                                                @endphp
                                                            @endif
                                                        @else
                                                            <div class="text-right">
                                                                <span class="data-total"><i class="far fa-clock"></i> <span id="wc_{{ $wc->client()->id }}">{{ $WorkerClientHours->where('client_id',$wc->client_id)->sum('hours') }}</span>&nbsp;ч.</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endforeach
                        @else
                        <div class="card-body">
                            <div class="text-center">
                                <h3>Нет данных</h3>
                            </div>
                        </div>
                        @endif

                        <div class="modal fade" tabindex="-1" id="popup__clients_marginality">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-percentage"></i><b>Клиент</b> - маржинальность</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-sm" id="clients_marginality_table">
                                            <thead>
                                                <tr>
                                                    <th>Год</th>
                                                    <th>Месяц</th>
                                                    <th>Маржинальность</th>
                                                    <th style="width: 40px"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="modal fade" tabindex="-1" id="addNewClient" action="{{ route('addNewClient') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-user-plus"></i> Добавление нового клиента</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Имя клиента</label>
                                                    <input required class="form-control" type="text" name="name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input required class="form-control" type="email" name="email">
                                                </div>
                                            </div>
                                            <div class="col-lg-6" style="display: none;">
                                                <div class="form-group">
                                                    <label>Адрес</label>
                                                    <input class="form-control" type="text" name="address">
                                                </div>
                                            </div>
                                            <div class="col-lg-3" style="display: none;">
                                                <div class="form-group">
                                                    <label>Пароль</label>
                                                    <input class="form-control" type="text" name="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-3" style="display: none;">
                                                <div class="form-group">
                                                    <label>Телефон</label>
                                                    <input class="form-control" type="text" name="phone">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Логотип</label>
                                                    <div class="custom-file-">
                                                        <input type="file" name="image" class="custom-file-input-" id="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-primary">Добавить</button>
                                        <input type="hidden" value="{{ Request::fullUrl() }}" name="lastUrl" />
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form class="modal fade" tabindex="-1" id="popup__editClient" action="{{ route('editClient') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-edit"></i>Редактирование клиента</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Имя клиента</label>
                                                    <input required class="form-control" type="text" name="name">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input required class="form-control" type="email" name="email">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Текущей логотип</label>
                                                    <div class="pt-3">
                                                        <img src="{{ asset('vendor/adminlte/dist/img/no-logo.jpg') }}" width="120" class="user-logo-preview" alt="Логотип">
                                                    </div>
                                                    <label>
                                                        <input type="checkbox" value="1" name="delete_photo" /> Удалить этот логотип
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Загрузить новый логотип</label>
                                                    <div class="custom-file-">
                                                        <input type="file" name="image" class="custom-file-input-" id="image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" style="order: 1;" data-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-primary" style="order: 3;"><i class="far fa-save"></i> Сохранить</button>
                                        <button type="submit" class="btn btn-default" style="order: 2;" name="delete_user" value="1" onclick="return confirm('Действительно удалить этого клиента?');"><i class="fa fa-trash"></i> Удалить клиента</button>
                                        <input type="hidden" value="{{ Request::fullUrl() }}" name="lastUrl" />
                                        <input type="hidden" value="" name="id" />
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form class="modal fade" tabindex="-1" id="setFee" action="{{ route('setFee') }}" method="POST">
                            @csrf
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-dollar-sign"></i> Установить гонорар</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Гонорар за месяц</label>
                                                    <input required class="form-control text-center" type="text" name="fee">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-primary">Установить</button>
                                        <input type="hidden" value="{{ Request::fullUrl() }}" name="lastUrl" />
                                        <input type="hidden" value="0" name="client_id" />
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
