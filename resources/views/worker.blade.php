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
            <div class="alert alert-danger" role="alert">
                <h3>Страница в разработке</h3>
            </div>
        </div>
    </section>

@endsection
