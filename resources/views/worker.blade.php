@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    Часы работы на клиентов
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
                    {!! session('status') !!}
                </div>
            @endif

            @if(!empty($users['clients']))
                <form class="card card-primary card-outline sticky-top" action="{{ route('saveWorker') }}" id="saveWorker" method="POST">
                    @csrf

                    <div class="card-body p-0">
                        <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Клиенты</th>
                                <th style="width: 220px">Часы работы</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users['clients'] as $client)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $client->name }}</td>
                                <td><input type="text" class="form-control" name="clients[{{ $client->id }}]" value="@if(!empty($WorkerClientArray[$client->id]['hours'])){{ $WorkerClientArray[$client->id]['hours'] }}@else{{ '0' }}@endif" placeholder="Время работы" /></td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="form-group text-right mb-0">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>

                </form>
            @endif

        </div>
    </section>

@endsection
