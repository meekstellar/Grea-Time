@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

@section('adminlte_css_pre')
    <link rel="stylesheet" href="/vendor/adminlte/dist/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/vendor/adminlte/dist/plugins/daterangepicker/daterangepicker.css">
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
    <div class="float-right">
        Version: {{ config('app.version', '1.0.0') }}
    </div>

    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('app.company_name', 'My company') }}
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script src="vendor/adminlte/dist/plugins/select2/js/select2.min.js"></script>
<script src="vendor/adminlte/dist/plugins/moment/moment.min.js"></script>
<script src="vendor/adminlte/dist/plugins/daterangepicker/daterangepicker.js"></script>
<script>

    $(document).ready(function() {
        $('.select2').select2();
        $('#reservation').daterangepicker()
    });

</script>
<!-- Select2 -->
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}
    /*
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-weight: 600;
    }
    */

</style>
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endpush
