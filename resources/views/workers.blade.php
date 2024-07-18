@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    Cотрудники
                </h1>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <form class="col-12" action="{{ route('workers') }}" id="FilterForm" method="GET">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                          <h5 class="card-title"><i class="fa fa-filter" aria-hidden="true"></i> Фильтр</h5>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group" style="align-items: flex-start;">
                                    <button type="button" class="btn btn-default float-right" id="daterange-btn">
                                        <i class="far fa-calendar-alt"></i> Выберите дату или период
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                    <div id="reportrange">
                                        <span>{{ Date::parse($date_or_period[0])->format('j F Y') }}@if(!empty($date_or_period[1])) — {{ Date::parse($date_or_period[1])->format('j F Y') }}@endif</span>
                                        <input type="hidden" name="date_or_period" value="{{ $date_or_period[0] }}@if(!empty($date_or_period[1]))--{{ $date_or_period[1] }}@endif" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><i class="fa fa-users" aria-hidden="true"></i> Сотрудники:</label>
                                <select name="w[]" class="select2" multiple="multiple" data-placeholder="Выберите сотрудника" style="width: 100%;">
                                    @if(!empty($WorkerClient))
                                        @foreach($WorkerClient->unique('worker_id') as $wc)
                                        <option value="{{ $wc->worker()->id }}" @if(!empty(request()->w) && in_array($wc->worker()->id,request()->w)){{ 'selected' }}@endif>{{ $wc->worker()->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group text-right mb-0">
                                <button type="submit" class="btn btn-info">Применить</button>
                            </div>
                        </div>
                      </div>
                </form>
                <div class="col-12">

                    <div class="row">

                        @if(!empty($WorkerClient))
                            @foreach($WorkerClient->unique('worker_id') as $wc)
                                <div class="col-xl-4 col-lg-6">
                                    <form class="card {{ (($selectCountDays == 7 && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') < 36 || in_array($selectCountDays, [28,29,30,31]) && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') < 150) ? 'few-days' : (($selectCountDays == 7 && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') > 44 || in_array($selectCountDays, [28,29,30,31]) && $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') > 180) ? 'many-days' : 'bg-white')) }} d-flex flex-fill">
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="text-muted pb-1">
                                                        {{ $wc->worker()->position }}
                                                    </div>
                                                    <h2 class="lead"><b>{{ $wc->worker()->name }}</b></h2>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:+80012122352">+(800) 121-223-22</a></li>
                                                        <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:{{ $wc->worker()->email }}">{{ $wc->worker()->email }}</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-4 text-center"><img alt="user-avatar" class="user-avatar img-circle img-fluid" src="{{ asset($wc->worker()->image) }}"></div>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            @if($selectCountDays == 1)
                                                @include('components/user-data-days-edit')
                                            @else
                                                @include('components/user-data-days-view')
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <span class="data-total"><i class="far fa-clock"></i> {{ $WorkerClient->where('worker_id',$wc->worker_id)->sum('hours') }}</span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
