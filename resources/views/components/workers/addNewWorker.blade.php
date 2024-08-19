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
                            <input required class="form-control" type="text" name="name">
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
                            <input required class="form-control" type="email" name="email">
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label>Пароль</label>
                            <input required class="form-control" type="text" name="password">
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group">
                            <label>Заработная плата</label>
                            <input required class="form-control" type="text" name="salary">
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
            <div class="modal-footer" style="justify-content: flex-start;">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Назначить клиентов</label>
                            @foreach($users['clients'] as $clients)
                            <div class="form-check">
                                <input class="form-check-input" id="cw_{{ $clients->id }}" type="checkbox" name="client_worker_connect[{{ $clients->id }}]" valie="1">
                                <label class="form-check-label" for="cw_{{ $clients->id }}">{{ $clients->name }} - {{ $clients->id }}</label>
                            </div>
                            @endforeach
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
