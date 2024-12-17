<form class="modal fade" tabindex="-1" id="popup__editWorkerFromClient" action="{{ route('editWorkerFromClient') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-edit"></i>Редактирование сотрудника</h4>
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
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Пароль</label>
                            <input class="form-control" type="text" name="password" placeholder="Новый пароль">
                        </div>
                    </div>
                    @if(auth()->user()->access_to_salary || auth()->user()->manager_important)
                        <div class="col-6 col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label>Год</label>
                                <select required class="form-control" style="width: 100%;" name="year" placeholder="Год" data-default_year="{{$default_year}}">
                                    @foreach($yearsSalary as $year)
                                    <option value="{{ $year }}" @if($default_year == $year) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label>Месяц</label>
                                <select required class="form-control" style="width: 100%;" name="month" placeholder="Месяц" data-default_month="{{$default_month}}">
                                    <option value="1" @if($default_month == 1) selected @endif>Январь</option>
                                    <option value="2" @if($default_month == 2) selected @endif>Февраль</option>
                                    <option value="3" @if($default_month == 3) selected @endif>Март</option>
                                    <option value="4" @if($default_month == 4) selected @endif>апрель</option>
                                    <option value="5" @if($default_month == 5) selected @endif>Май</option>
                                    <option value="6" @if($default_month == 6) selected @endif>Июнь</option>
                                    <option value="7" @if($default_month == 7) selected @endif>Июль</option>
                                    <option value="8" @if($default_month == 8) selected @endif>Август</option>
                                    <option value="9" @if($default_month == 9) selected @endif>Сентябрь</option>
                                    <option value="10" @if($default_month == 10) selected @endif>Октябрь</option>
                                    <option value="11" @if($default_month == 11) selected @endif>Ноябрь</option>
                                    <option value="12" @if($default_month == 12) selected @endif>Декабрь</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label>Заработная плата</label>
                                <input required class="form-control" type="text" name="salary" value="0">
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Текущее фото</label>
                            <div class="pt-3">
                                <img src="{{ asset('vendor/adminlte/dist/img/no-usericon.svg') }}" width="120" class="user-photo-preview" alt="Фото сотрудника">
                            </div>
                            <label>
                                <input type="checkbox" value="1" name="delete_photo" /> Удалить это фото
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Загрузить новое фото</label>
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
            <div class="modal-footer justify-content-start  ">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Назначить клиентов</label>
                            @foreach($users['clients'] as $clients)
                            <div class="form-check">
                                <input class="form-check-input cwe" id="cwe_{{ $clients->id }}" type="checkbox" name="client_worker_connect[{{ $clients->id }}]" valie="1">
                                <label class="form-check-label cwe" for="cwe_{{ $clients->id }}">{{ $clients->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" style="order: 1;" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary" style="order: 3;"><i class="far fa-save"></i> Сохранить</button>
                <button type="submit" class="btn btn-default" style="order: 2;" name="delete_user" value="1" onclick="return confirm('Действительно удалить этого сотрудника?');"><i class="fa fa-trash"></i> Удалить сотрудника</button>
                <input type="hidden" value="{{ Request::fullUrl() }}" name="lastUrl" />
                <input type="hidden" value="" name="id" />
            </div>
        </div>
    </div>
</form>
