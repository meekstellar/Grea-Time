@if(!empty($WorkerClientHours))
    @foreach($WorkerClientHours->unique('worker_id') as $wc)
        @if($wc->worker()->active)
        @php
            $worker_ids__wrote_time[] = $wc->worker_id;
        @endphp
        <div class="col-xl-12 d-flex">
            <form id="u{{ $wc->worker_id }}" data-id="{{ $wc->worker_id }}" data-position="{{ $wc->worker()->position }}" data-salary="{{ $wc->worker()->get_current_salary(date("Y",time()), date("n",time())) }}" data-clientsids="@if(!empty($wc->get_connect_clients_id())){{ implode(',',$wc->get_connect_clients_id()) }}@endif" class="card {{ (($selectCountDays == 7 && $WorkerClientHours->where('worker_id',$wc->worker_id)->sum('hours') < 36 || in_array($selectCountDays, [28,29,30,31]) && $WorkerClientHours->where('worker_id',$wc->worker_id)->sum('hours') < 150) ? 'few-days' : (($selectCountDays == 7 && $WorkerClientHours->where('worker_id',$wc->worker_id)->sum('hours') > 44 || in_array($selectCountDays, [28,29,30,31]) && $WorkerClientHours->where('worker_id',$wc->worker_id)->sum('hours') > 180) ? 'many-days' : 'bg-white')) }} d-flex flex-fill">
                <div class="card-body pt-3" style="flex: none;">
                    <div class="row">
                        <div class="col-9">
                            @if(!empty($wc->worker()->position))
                            <div class="text-muted pb-1" title="{{ $wc->worker()->position }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $wc->worker()->position }}
                            </div>
                            @endif
                            <h2 class="lead"><a href="#" class="b600 editWorkerFromClientClick data_name" data-toggle="modal" data-target="#popup__editWorkerFromClient">{{ $wc->worker()->name }}</a></h2>
                            @if(!empty($wc->worker()->phone) || !empty($wc->worker()->email))
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="far fa-envelope"></i></span> <a href="mailto:{{ $wc->worker()->email }}" class="data_email">{{ $wc->worker()->email }}</a></li>
                                @if(!empty($wc->worker()->phone) && 2==3)<li class="small"><span class="fa-li"><i class="fas fa-phone"></i></span> <a href="tel:{{ $wc->worker()->phone }}">{{ $wc->worker()->phone }}</a></li>@endif
                            </ul>
                            @endif
                        </div>
                        <div class="col-3 text-right">
                            <img alt="{{ $wc->worker()->name }}" class="worker-avatar img-circle img-fluid" src="{{ (!empty($wc->worker()->image) && File::exists('storage/'.$wc->worker()->image) ? asset('storage/'.$wc->worker()->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}">
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
                            <button type="button" class="btn btn-default btn-xs addClientHoursButton" data-toggle="modal" data-target="#addClientHours" data-worker_id="{{ $wc->worker_id }}">
                                <i class="far fa-clock"></i> Добавить часы работы
                            </button>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <div class="text-right">
                                <span class="data-total"><i class="far fa-clock"></i> <span id="wc_{{ $wc->worker()->id }}">{{ $WorkerClientHours->where('worker_id',$wc->worker_id)->sum('hours') }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif
    @endforeach
@endif

@if((count($users['workers']) != count($worker_ids__wrote_time)) && $selectCountDays == 1 && !empty($users['workers']) && count($users['workers']) > 0)
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Пользователи, которые в этот день не указали часы работы</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-sm">
                <tbody>
                    @foreach($users['workers'] as $worker)
                        @if(!in_array($worker->id, $worker_ids__wrote_time))
                        <tr>
                            <td class="pl-3" style="width: 40px; vertical-align: middle;"><img alt="{{ $worker->name }}" class="avatar-small img-circle img-fluid" src="{{ (!empty($worker->image) && File::exists('storage/'.$worker->image) ? asset('storage/'.$worker->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}"></td>
                            <td style="vertical-align: middle;">
                                {{ $worker->name }}
                                @if(!empty($worker->position))
                                <span class="worker_positon" title="{{ $worker->position }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    ({{ $worker->position }})
                                </span>
                                @endif
                            </td>
                            <td style="width: 222px; text-align: right;" class="pr-3" style="vertical-align: middle;">
                                <form data-clientsids="@if(!empty($worker->get_connect_clients_id())){{ implode(',',$worker->get_connect_clients_id()) }}@endif">
                                    <button type="button" class="btn btn-default btn-xs addClientHoursButton" data-toggle="modal" data-target="#addClientHours" data-worker_id="{{ $worker->id }}">
                                        <i class="far fa-clock"></i> Добавить часы работы
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs add_rest_days" style="font-weight: bold; padding-left: 6px; padding-right: 6px;" title="Добавить отпуск" data-worker_id="{{ $worker->id }}" data-day="{{$date_or_period[0]}}">
                                        O
                                    </button>
                                    @if($worker->sent_mail_in_this_day($date_or_period[0]))
                                        <button type="button" class="btn btn-default btn-xs" title="Письмо отправлено" disabled style="cursor: default;" >
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-default btn-xs send_reminder" title="Отправить письмо" data-worker_id="{{ $worker->id }}" data-day="{{ $date_or_period[0] }}">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
