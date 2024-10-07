@extends('adminlte::auth.login')

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
    .card-footer {
        display: none;
    }
</style>
@vite(['resources/sass/app.scss'])
@endpush

@push('js')
<script>

    setTimeout(function() {
        location.reload();
    }, 1000*300);

</script>
@endpush
