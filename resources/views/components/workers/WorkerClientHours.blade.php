@if(!empty($workers))
    @foreach($workers as $worker)
        @php
            $clientHours = $worker->clientHours->sum('hours');
        @endphp
        <div class="col-xl-12 d-flex">
            <form id="u{{ $worker->id }}" data-id="{{ $worker->id }}" data-position="{{ $worker->position }}"
                  data-salary="{{ $worker->salary }}"
                  data-clientsids="{{ $worker->clients->pluck('client_id')->implode(',') }}"
                  class="card {{ (($selectCountDays == 7 && $clientHours < 36 || in_array($selectCountDays, [28,29,30,31]) && $clientHours < 150) ? 'few-days' : (($selectCountDays == 7 && $clientHours > 44 || in_array($selectCountDays, [28,29,30,31]) && $clientHours > 180) ? 'many-days' : 'bg-white')) }} d-flex flex-fill">
                <div class="card-body pt-3" style="flex: none;">
                    <div class="row">
                        <div class="col-9">
                            @if(!empty($worker->position))
                                <div class="text-muted pb-1" title="{{ $worker->position }}"
                                     style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $worker->position }}
                                </div>
                            @endif
                            <h2 class="lead">
                                <a href="#" class="b600 editWorkerFromClientClick data_name"
                                   data-toggle="modal"
                                   data-target="#popup__editWorkerFromClient">{{ $worker->name }}</a>
                            </h2>
                            @if(!empty($worker->phone) || !empty($worker->email))
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a
                                            href="mailto:{{ $worker->email }}"
                                            class="data_email">{{ $worker->email }}</a></li>
                                    @if(!empty($worker->phone) && 2==3)
                                        <li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a
                                                href="tel:{{ $worker->phone }}">{{ $worker->phone }}</a></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                        <div class="col-3 text-right">
                            <img alt="{{ $worker->name }}" class="worker-avatar img-circle img-fluid"
                                 src="{{ (!empty($worker->image) && File::exists('storage/'.$worker->image) ? asset('storage/'.$worker->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" style="flex: 100%;">
                    @if($selectCountDays == 1)
                        @include('components/workers/user-data-day')
                    @else
                        @include('components/workers/user-data-period')
                    @endif
                </div>
                <div class="card-footer" style="flex: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            @if($selectCountDays == 1)
                                <button type="button" class="btn btn-default btn-xs addClientHoursButton"
                                        data-toggle="modal" data-target="#addClientHours"
                                        data-worker_id="{{ $worker->id }}">
                                    <i class="far fa-clock"></i> Добавить часы работы
                                </button>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <div class="text-right">
                                <span class="data-total"><i class="far fa-clock"></i> <span
                                        id="wc_{{ $worker->id }}">{{ $clientHours }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
@endif

@if(!$workersWithoutTime->isEmpty() && $selectCountDays == 1)
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Пользователи, которые в этот день не указали часы работы</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <tbody>
                    @foreach($workersWithoutTime as $worker)
                        <tr>
                            <td class="pl-3" style="width: 40px; vertical-align: middle;"><img
                                    alt="{{ $worker->name }}" class="avatar-small img-circle img-fluid"
                                    src="{{ (!empty($worker->image) && File::exists('storage/'.$worker->image) ? asset('storage/'.$worker->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}">
                            </td>
                            <td style="vertical-align: middle;">
                                <form
                                    data-id="{{ $worker->id }}"
                                    data-position="{{ $worker->position }}"
                                    data-salary="{{ $worker->salary }}"
                                    data-clientsids="{{ $worker->clients->pluck('client_id')->implode(',') }}"
                                    class="worker-form">
                                    <a href="#" class="b600 editWorkerFromClientClick data_name"
                                       data-toggle="modal"
                                       data-target="#popup__editWorkerFromClient">{{ $worker->name }}</a>
                                    @if(!empty($worker->position))
                                        <span class="worker_positon" title="{{ $worker->position }}"
                                              style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            ({{ $worker->position }})
                                        </span>
                                    @endif
                                    <span class="data_email" hidden>{{ $worker->email }}</span>
                                </form>
                            </td>
                            <td style="width: 222px; text-align: right; vertical-align: middle" class="pr-3">
                                <form
                                    data-id="{{ $worker->id }}"
                                    data-position="{{ $worker->position }}"
                                    data-salary="{{ $worker->salary }}"
                                    data-clientsids="{{ $worker->clients->pluck('client_id')->implode(',') }}">
                                    <button type="button" class="btn btn-default btn-xs addClientHoursButton"
                                            data-toggle="modal" data-target="#addClientHours"
                                            data-worker_id="{{ $worker->id }}">
                                        <i class="far fa-clock"></i> Добавить часы работы
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs add_rest_days"
                                            style="font-weight: bold; padding-left: 6px; padding-right: 6px;"
                                            title="Добавить отпуск" data-worker_id="{{ $worker->id }}"
                                            data-day="{{$date_or_period[0]}}">
                                        O
                                    </button>
                                    @if($worker->sent_mail_in_this_day($date_or_period[0]))
                                        <button type="button" class="btn btn-default btn-xs"
                                                title="Письмо отправлено" disabled style="cursor: default;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-default btn-xs send_reminder"
                                                title="Отправить письмо" data-worker_id="{{ $worker->id }}"
                                                data-day="{{ $date_or_period[0] }}">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
