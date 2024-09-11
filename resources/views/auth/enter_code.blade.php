@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 pt-4">


            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {!! session('status') !!}
                </div>
            @endif

            @if(count($errors) > 0)
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Ошибка</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card text-center">
                <div class="card-header">{!! __('Введите код из sms, который мы отправили на номер: <b><br>'.$userPhone_hide.'</b>') !!}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('code.store') }}">
                        @csrf

                        <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroup-sizing-lg">Код:</span>
                            </div>
                            <input type="text" class="form-control" name="code" style="font-size: 36px; display: inline-block; text-transform: uppercase; text-align: center; font-weight: bold;" aria-label="Large" aria-describedby="inputGroup-sizing-sm" autofocus>
                        </div>


                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Отправить') }}
                            </button>
                            <button type="submit" name="resend_sms" value="1" class="btn btn-default ml-2" onclick="return confirm('Учтите, что для получения нового кода по смс может потребваться некоторое время. Обычно до 30 секунд.');">
                                {{ __('Запросить новый код') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
