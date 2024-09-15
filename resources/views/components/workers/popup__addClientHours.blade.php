<form class="modal fade" tabindex="-1" id="addClientHours" action="{{ route('addClientHours') }}" method="POST">
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
