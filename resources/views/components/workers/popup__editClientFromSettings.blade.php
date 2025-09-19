<form class="modal fade" tabindex="-1" id="popup__editClient" action="{{ route('editClient') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-edit"></i>Редактирование клиента</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Имя клиента</label>
                            <input required class="form-control" type="text" name="name">
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
                            <label>Текущей логотип</label>
                            <div class="pt-3">
                                <img src="{{ asset('vendor/adminlte/dist/img/no-logo.jpg') }}" width="120" class="user-logo-preview" alt="Логотип">
                            </div>
                            <label>
                                <input type="checkbox" value="1" name="delete_photo" /> Удалить этот логотип
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="form-group">
                            <label>Загрузить новый логотип</label>
                            <div class="custom-file-">
                                <input type="file" name="image" class="custom-file-input-" id="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" style="order: 1;" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary" style="order: 3;"><i class="far fa-save"></i> Сохранить</button>
                <button type="submit" class="btn btn-default" style="order: 2;" name="delete_user" value="1" onclick="return confirm('Действительно удалить этого клиента?');"><i class="fa fa-trash"></i> Удалить клиента</button>
                <input type="hidden" value="{{ Request::fullUrl() }}" name="lastUrl" />
                <input type="hidden" value="" name="id" />
            </div>
        </div>
    </div>
</form>
