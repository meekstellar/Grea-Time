@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-3 pb-3 pb-sm-0">
                    <h1>
                        Cотрудники
                    </h1>
                </div>
                <div class="col-sm-9 text-right">
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
        <div class="container-fluid pb-4">

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
                <div class="col-md-4">

                    @include('components/workers/FilterForm')

                </div>
                <div class="col-md-8">

                    <div class="row">

                        @include('components/workers/WorkerClientHours')

                        @include('components/workers/popup__addClientHours')

                        @include('components/workers/popup__addNewWorker')

                        @include('components/workers/popup__editWorkerFromClient')

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
