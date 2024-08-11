@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-7 pb-3 pb-sm-0">
                    <h1>
                        Cотрудники
                    </h1>
                </div>
                <div class="col-sm-5 text-right">
                    @if($selectCountDays == 1)
                        <button class="btn btn-info btn-sm mr-2 addClientHoursButton" data-toggle="modal" data-target="#addClientHours"><i class="far fa-clock"></i> &nbsp;Добавить часы работы</button>
                    @endif
                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addNewWorker"><i class="fas fa-user-tie" aria-hidden="true"></i> &nbsp;Новый сотрудник</a>
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

            @if(count($errors) > 0)
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Ошибка</h5>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                    </ul>
            </div>
            @endif

            <div class="row">
                <form class="col-md-4" action="{{ route('workers') }}" id="FilterForm" method="GET">
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
                                        <label><i class="fas fa-user-tie" aria-hidden="true"></i> Сотрудники:</label>
                                        <select name="w[]" class="select2" multiple="multiple" data-placeholder="Отображать всех сотрудников" style="width: 100%;">
                                            @if(!empty($users['workers']))
                                                @foreach($users['workers'] as $worker)
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
                                <button type="submit" class="btn btn-sm btn-primary">Применить</button>
                            </div>
                        </div>
                      </div>
                </form>
                <div class="col-md-8">

                    <div class="row">

                        @if(!empty($WorkerClient))
                            @foreach($WorkerClient->unique('worker_id') as $wc)
                                <div class="col-xl-6">
                                    <form id="u{{ $wc->worker_id }}" data-worker_id="{{ $wc->worker_id }}" class="card {{ (($selectCountDays == 7 && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') < 36 || in_array($selectCountDays, [28,29,30,31]) && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') < 150) ? 'few-days' : (($selectCountDays == 7 && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') > 44 || in_array($selectCountDays, [28,29,30,31]) && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') > 180) ? 'many-days' : 'bg-white')) }} d-flex flex-fill">
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <div class="col-9">
                                                    @if(!empty($wc->worker()->position))
                                                    <div class="text-muted pb-1" title="{{ $wc->worker()->position }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $wc->worker()->position }}
                                                    </div>
                                                    @endif
                                                    <h2 class="lead"><b>{{ $wc->worker()->name }}</b></h2>
                                                    @if(!empty($wc->worker()->phone) || !empty($wc->worker()->email))
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:{{ $wc->worker()->email }}">{{ $wc->worker()->email }}</a></li>
                                                        @if(!empty($wc->worker()->phone)){{--<li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:{{ $wc->worker()->phone }}">{{ $wc->worker()->phone }}</a></li>--}}@endif
                                                    </ul>
                                                    @endif
                                                </div>
                                                <div class="col-3 text-right">
                                                    <img alt="user-avatar" class="worker-avatar img-circle img-fluid" src="{{ (!empty($wc->worker()->image && File::exists('storage/'.$wc->worker()->image)) ? asset('storage/'.$wc->worker()->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            @if($selectCountDays == 1)
                                                @include('components/workers/user-data-day')
                                            @else
                                                @include('components/workers/user-data-period')
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    @if($selectCountDays == 1)
                                                    <button type="button" class="btn btn-default btn-xs addClientHoursButton" data-toggle="modal" data-target="#addClientHours" data-worker_id="{{ $wc->worker_id }}">
                                                        <i class="far fa-clock"></i> Добавить часы работы
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="text-right">
                                                        <span class="data-total"><i class="far fa-clock"></i> <span id="wc_{{ $wc->worker()->id }}">{{ $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') }}</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif

                        <form class="modal fade" id="addClientHours" action="{{ route('addClientHours') }}" method="POST">
                            @csrf
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="far fa-clock"></i> Добавить часы работы</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label><i class="nav-icon fas fa-user-tie "></i> Сотрудник</label>
                                                    <select required class="form-control select2" style="width: 100%;" name="worker_id" placeholder="Выбрать сотрудника">
                                                        @foreach($users['workers'] as $worker)
                                                        <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><i class="nav-icon fas fa-user-secret "></i> Клиент</label>
                                                    <select required class="form-control select2" style="width: 100%;" name="client_id">
                                                        @foreach($users['clients'] as $clients)
                                                        <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="col-6 col-lg-12">
                                                        <div class="form-group">
                                                            <label>Дата:</label>
                                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                                <input type="text" name="created_at" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="col-6 col-lg-12">
                                                        <div class="form-group">
                                                            <label><i class="far fa-clock"></i> Часы работы</label>
                                                            <select required class="form-control select2" name="hours" style="width: 100%;">
                                                                @for($h=0.5; $h<=16; $h=$h+0.5)
                                                                <option value="{{ $h }}">{{ $h }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
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

                        <form class="modal fade" id="addNewWorker" action="{{ route('addNewWorker') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-user-plus"></i> Добавление нового сотрудника</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Имя сотрудника</label>
                                                    <input required1 class="form-control" type="text" name="name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Должность</label>
                                                    <input class="form-control" type="text" name="position">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input required1 class="form-control" type="email" name="email">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="form-group">
                                                    <label>Пароль</label>
                                                    <input required1 class="form-control" type="text" name="password">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="form-group">
                                                    <label>Заработная плата</label>
                                                    <input required1 class="form-control" type="text" name="salary">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Фото</label>
                                                    <div class="custom-file-">
                                                        <input type="file" name="image" class="custom-file-input-" id="image">
                                                    </div>
                                                </div>
                                            </div>{{--
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="form-group">
                                                    <label>Телефон</label>
                                                    <input class="form-control" type="phone" name="phone">
                                                </div>
                                            </div>--}}
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
