@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Restaurar Email') }}</div>

                <div class="card-body">
                    <form method="post" action="{{ $ruta }}"> <!--//url()->full() }}">-->
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Acción :') }}</label>

                            <div class="col-md-6">
                                Se va a reestablecer el correo: {{ $email }}<br> Para el usuario: {{ $nombre }}.
                                <br>
                                <button type="submit" class="btn btn-primary">
                                    Reestablecer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
