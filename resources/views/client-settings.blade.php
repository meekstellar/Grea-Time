@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    Клиенты
                </h1>
            </div>
        </div>
        </div>
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
                    <div сlass="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Список клиентов</h3>
                                </div>
                                @if(!$clients->isEmpty())
                                <div class="card-body p-0">
                                    <table class="table table-sm">
                                        <tbody>
                                            @foreach($clients as $client)
                                                <tr class="user_data" data-id="{{ $client->id }}">
                                                    <td class="pl-3" style="width: 40px; vertical-align: middle;"><img alt="{{ $client->name }}" class="avatar-small img-circle img-fluid" src="{{ (!empty($client->image) && File::exists('storage/'.$client->image) ? asset('storage/'.$client->image) : asset('vendor/adminlte/dist/img/no-usericon.svg')) }}"></td>
                                                    <td style="vertical-align: middle;">
                                                        <form id="u{{ $client->id }}" data-client_id="{{ $client->id }}" data-id="{{ $client->id }}">
                                                            <a href="#" class="b600 editClientClick data_name" data-toggle="modal" data-target="#popup__editClient">{{ $client->name }}</a>
                                                            <span hidden class="data_email">{{ $client->email }}</span>
                                                        </form>
                                                    </td>
                                                    <td style="width: 180px; text-align: right;" class="pr-3" style="vertical-align: middle;">
                                                        <form action="{{ route('deleteClient', ['id' => $client->id]) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $client->id }}" />
                                                            <button type="submit" class="btn btn-default btn-xs" name="deleteClient" onclick="return confirm('Действительно удалить?')">
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
                                    <p>Клиенты не найдены</p>
                                </div>
                                @endif
                            </div>

                            @include('components.workers.popup__editClientFromSettings')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
