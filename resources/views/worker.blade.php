@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    Часы работы - <b>{{ date('d M Y', time()) }}</b> <small><small>{{ date("H") }}:{{ date("i") }}</small></small>
                </h1>
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
            @if (session('error'))
                <div class="alert alert-dadger" role="alert">
                    {!! session('error') !!}
                </div>
            @endif

            @if(date('H')>=17 && date('H')<=23)

                <div class="row">
                  <div class="col-md-9 col-sm-12 col-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning"><i class="fas fa-pen-nib"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-number">Заполните данные</span>
                        <span class="info-box-text-">Вы можете устанавливать часы работы каждый день только между 17:00 и 23:59</span>
                      </div>                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning"><i class="fas fa-info"></i></span>
                      <div class="info-box-content">
                        <a href="#" class="info-box-number" data-toggle="modal" data-target="#popup__instructionForWorker" style="font-weight: normal; line-height: 120%;">Подсказка по разнесению времени</a>
                      </div>                      <!-- /.info-box-content -->
                    </div>                    <!-- /.info-box -->
                  </div>
                </div>

                @if(!empty($users['clients']) && count($users['clients']) > 0)
                    <form class="card card-primary card-outline" action="{{ route('saveWorker') }}" id="saveWorker" method="POST">
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
                                            <option value="{{ $h }}"@if(!empty($WorkerClientHoursArray[$client->id]['hours']) && $h == $WorkerClientHoursArray[$client->id]['hours']){{ 'selected' }}@endif>{{ $h }}</option>
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

                    </form>
                @else
                <div class="callout callout-warning">
                    <h5>Вам еще не назначены клиенты. Ожидайте</h5>
                </div>
                @endif
            @else

                <div class="row">
                  <div class="col-md-9 col-sm-12 col-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning"><i class="fas fa-times"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text-">Вы можете устанавливать часы работы каждый день только между 17:00 и 23:59. Ожидайте.
                            <br>Обратитесь к менеджеру, если вы не успели устанавить часы в указанное время.</span>
                      </div>                      <!-- /.info-box-content -->
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-12 col-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning"><i class="fas fa-info"></i></span>
                      <div class="info-box-content">
                        <a href="#" class="info-box-number" data-toggle="modal" data-target="#popup__instructionForWorker" style="font-weight: normal; line-height: 120%;">Подсказка по разнесению времени</a>
                      </div>                      <!-- /.info-box-content -->
                    </div>                    <!-- /.info-box -->
                  </div>
                </div>

            @endif

            @include('components/workers/popup__instructionForWorker')

            <div class="pt-3">
                <h4 class="pb-3">История за последние 30 дней:</h4>
                @if(count($WorkerClientHoursArray_Last) > 0)
                @php
                    $created_at = 0;
                @endphp
                @foreach($WorkerClientHoursArray_Last as $wcha)
                @if($created_at != date('d M Y', strtotime($wcha['created_at'])))
                @php
                    $created_at = date('d M Y', strtotime($wcha['created_at']));
                @endphp
                <div class="row">
                    <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">{{ date('d M Y', strtotime($wcha['created_at'])); }}</h3>
                    </div>

                    <div class="card-body p-0">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Клиенты</th>
                            <th style="width: 220px">Часы</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $k=1;
                        @endphp
                        @foreach($WorkerClientHoursArray_Last as $WCH)
                        @if(!empty($WCH['hours']) && date('d M Y', strtotime($WCH['created_at'])) == $created_at)
                        <tr>
                            <td>{{ $k }}.</td>
                            <td>{{ $WCH->client()->name }}</td>
                            <td>
                                {{ $WCH['hours'] }}
                            </td>
                        </tr>
                        @php
                            $k++;
                        @endphp
                        @endif
                        @endforeach
                    </tbody>
                    </table>
                    </div>

                    </div>

                    </div>
                </div>
                @endif
                @endforeach
                @else
                <p>Нет данных</p>
                <br>
                <br>
                @endif
            </div>
        </div>
    </section>

@endsection
