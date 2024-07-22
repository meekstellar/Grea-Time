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
                <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addNewClient"><i class="fas fa-user-tie" aria-hidden="true"></i> &nbsp;Новый клиент</a>
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
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label><i class="nav-icon fas fa-user-secret" aria-hidden="true"></i> Клиенты:</label>
                                        <select name="w[]" class="select2" multiple="multiple" data-placeholder="Отображать всех клиентов" style="width: 100%;">
                                            @if(!empty($users['clients']))
                                                @foreach($users['clients'] as $worker)
                                                    <option value="{{ $worker->id }}" @if(!empty(request()->w) && in_array($worker->id,request()->w)){{ 'selected' }}@endif>{{ $worker->name }}</option>
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

                        @if(!empty($WorkerClient))
                            @foreach($WorkerClient->unique('client_id') as $wc)
                                <div class="col-12">
                                    <form id="u{{ $wc->client_id }}" data-client_id="{{ $wc->client_id }}" class="card bg-white d-flex flex-fill">
                                        <div class="card-body pt-3">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <h2 class="lead"><b>{{ $wc->client()->name }}</b></h2>
                                                    @if(!empty($wc->client()->phone) || !empty($wc->client()->email))
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="fas fa-envelope"></i></span> <a href="mailto:{{ $wc->client()->email }}">{{ $wc->client()->email }}</a></li>
                                                        @if(!empty($wc->client()->phone))<li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:{{ $wc->client()->phone }}">{{ $wc->client()->phone }}</a></li>@endif
                                                        @if(!empty($wc->client()->address))<li class="small"><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> {{ $wc->client()->address }}</li>@endif
                                                    </ul>
                                                    @endif
                                                </div>
                                                <div class="col-4 text-right">
                                                    <img alt="user-avatar" class="client-avatar img-circle img-fluid" src="{{ asset($wc->client()->image) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-sm client-table">
                                                <tbody>
                                                    @php
                                                        $processed = [];
                                                    @endphp
                                                    @foreach($WorkerClient->where('client_id',$wc->client_id) as $wc_workers)
                                                        @if(!in_array($wc_workers->worker_id,$processed))
                                                        <tr>
                                                            <td style="width: 10px">{{ $loop->iteration }}.</td>
                                                            <td>{{ $wc_workers->worker()->name }} <span class="worker_positon">({{ $wc_workers->worker()->position }})</span></td>
                                                            <td style="width: 80px; text-align: right;">{{ $WorkerClient->where('client_id',$wc->client_id)->where('worker_id',$wc_workers->worker_id)->sum('hours') }}</td>
                                                        </tr>
                                                        @php
                                                            $processed[] = $wc_workers->worker_id;
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
                                                        @include('components/clients/card-footer-month')
                                                    @else
                                                        @include('components/clients/card-footer-week')
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif

                        <form class="modal fade" id="addNewClient" action="{{ route('addNewClient') }}" method="POST">
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
                                                    <label>Адрес</label>
                                                    <input class="form-control" type="text" name="address">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input required class="form-control" type="text" name="email">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Пароль</label>
                                                    <input required class="form-control" type="text" name="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Телефон</label>
                                                    <input class="form-control" type="text" name="phone">
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

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
