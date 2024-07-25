@extends('layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-7 pb-3 pb-sm-0">
                <h1>
                    {{ Auth::user()->name }}
                </h1>
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

            @if(!empty($users['clients']))
                @foreach($users['clients'] as $worker)
            <div class="row">
                <div class="col-md-9">
                    {{ $worker->name }}
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" value="" placeholder="Время работы" />
                </div>
            </div>
                @endforeach
            @endif

        </div>
    </section>

@endsection
