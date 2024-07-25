@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    Часы работы - <b>{{ date('d M Y', time()) }}</b> <small><small>{{ date("H:i") }}</small></small>
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

            @if(date('H')>=1 && date('H')<=23)

                <div class="callout callout-success">
                    <h5>Заполните данные</h5>
                    <p>Вы можете устанавливать часы работы каждый день между 17:00 и 23:59</p>
                </div>

                @if(!empty($users['clients']))
                    <form class="card card-primary card-outline sticky-top" action="{{ route('saveWorker') }}" id="saveWorker" method="POST">
                        @csrf

                        <div class="card-body p-0">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Клиенты</th>
                                    <th style="width: 220px">Часы</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users['clients'] as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $client->name }}</td>
                                    <td>
                                        <select class="form-control" name="clients[{{ $client->id }}]">
                                            @for($h=0; $h<=16; $h=$h+0.5)
                                            <option value="{{ $h }}"@if(!empty($WorkerClientArray[$client->id]['hours']) && $h == $WorkerClientArray[$client->id]['hours']){{ 'selected' }}@endif>{{ $h }}</option>
                                            @endfor
                                        </select>
                                    </td>
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
            @else
                <div class="callout callout-warning">
                    <h5>Доступ закрыт</h5>
                    <p>Вы можете устанавливать часы работы каждый день между 17:00 и 23:59. Ожтидайте.
                    <br>Обратитесь к менеджеру, если вы не успели это сделать в указанное время.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
