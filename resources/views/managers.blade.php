@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    Администраторы
                </h1>
            </div>
            <div class="col-sm-5 text-right">
                <a href="#" class="btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#addNewManager"><i class="fas fa-user-tie" aria-hidden="true"></i> &nbsp;Новый администратор</a>
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
            <div class="row">

                <div class="col-md-12">

                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Список администраторов</h3>
                                </div>
                                @if(!empty($managers) && count($managers) > 0)
                                <div class="card-body p-0">
                                    <table class="table table-sm">
                                        <tbody>
                                            @foreach($managers as $manager)
                                                <tr class="user_data" data-id="{{ $manager->id }}">
                                                    <td class="pl-3" style="width: 40px; vertical-align: middle;"><img alt="{{ $manager->name }}" class="avatar-small img-circle img-fluid" src="{{ (!empty($manager->image) && File::exists('storage/'.$manager->image) ? asset('storage/'.$manager->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}"></td>
                                                    <td style="vertical-align: middle;">
                                                        <a href="#" class="editManagerClick data_name" data-access_to_salary="{{ $manager->access_to_salary }}" data-toggle="modal" data-target="#popup__editManager">{{ $manager->name }}</a>
                                                        <span class="ano" title="{{ $manager->email }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            (<span class="data_email">{{ $manager->email }}</span>, <span class="data_phone">{{ $manager->phone }}</span>)
                                                        </span>
                                                    </td>
                                                    <td style="width: 180px; text-align: right;" class="pr-3" style="vertical-align: middle;">
                                                        <form action="{{ route('removeManager') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $manager->id }}" />
                                                            <button type="submit" class="btn btn-default btn-xs" name="removeManager" onclick="return confirm('Действительно удалить?')">
                                                                <i class="fas fa-trash-alt" style="margin: 0;"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="card-body">
                                    <p>Администраторы не найдены</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <form class="modal fade" tabindex="-1" id="addNewManager" action="{{ route('addNewManager') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-user-plus"></i> Добавление нового администратора</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Имя администратора</label>
                                                    <input required class="form-control" type="text" name="name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input required class="form-control" type="email" name="email">
                                                </div>
                                            </div>
                                            <div class="col-lg-6" style="display: none;">
                                                <div class="form-group">
                                                    <label>Адрес</label>
                                                    <input class="form-control" type="text" name="address">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Пароль</label>
                                                    <input required class="form-control" type="text" name="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Телефон</label>
                                                    <input required class="form-control" type="text" name="phone">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Логотип</label>
                                                    <div class="custom-file-">
                                                        <input type="file" name="image" class="custom-file-input-" id="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" value="1" name="access_to_salary" /> Открыть доступ к зарплате
                                                    </label>
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

                        <form class="modal fade" tabindex="-1" id="popup__editManager" action="{{ route('editManager') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><i class="fas fa-edit"></i>Редактирование администратора</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Имя администратора</label>
                                                    <input required class="form-control" type="text" name="name">
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
                                                    <input class="form-control" type="text" name="password" placeholder="Новый пароль">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="form-group">
                                                    <label>Телефон</label>
                                                    <input required class="form-control" type="text" name="phone" placeholder="Телефон">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Текущее фото</label>
                                                    <div class="pt-3">
                                                        <img src="{{ asset('vendor/adminlte/dist/img/no-usericon.svg') }}" width="120" class="user-photo-preview" alt="Фото администратора">
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
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" value="1" name="access_to_salary" /> Открыть доступ к зарплате
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" style="order: 1;" data-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-primary" style="order: 3;"><i class="far fa-save"></i> Сохранить</button>
                                        <button type="submit" class="btn btn-default" style="order: 2;" name="delete_user" value="1" onclick="return confirm('Действительно удалить этого администратора?');"><i class="fa fa-trash"></i>Удалить администратора</button>
                                        <input type="hidden" value="{{ Request::fullUrl() }}" name="lastUrl" />
                                        <input type="hidden" value="" name="id" />
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
