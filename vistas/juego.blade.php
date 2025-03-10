{{-- Usamos la vista app como plantilla --}}
@extends('app')

{{-- Sección aporta el título de la página --}}
@section('title', 'Introduce Jugada')

{{-- Sección muestra vista de juego para que el usuario elija una letra --}}
@section('navbar')
<li class="nav-item me-5">
    <a class="nav-link" aria-current="page" href="juego.php?botonnuevapartida">Nueva Partida</a>
</li>
@endsection

@section('usermenu')
@parent
@endsection

@section('content')
@php
$imgsHangman = ['Hangman-0.png', 'Hangman-1.png', 'Hangman-2.png', 'Hangman-3.png', 'Hangman-4.png', 'Hangman-5.png'];
@endphp

<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100px;">
        <h1 id='mensaje'>{{ $partida->esFin() ? ($partida->esPalabraDescubierta() ? "Enhorabuena!" : "Has perdido!") : "" }}</h1>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h1 id="palabra">{{ $partida->esFin() ? implode(" ", str_split($partida->getPalabraSecreta())) : implode(" ", str_split($partida->getPalabraDescubierta())) }}</h1>
            <form action="juego.php" method="POST">
                <div class="input-group mb-3">
                    <input type="text" id="letra" name="letra" autofocus class="form-control me-5 {{ ($partida->esFin()) ? "" : ((isset($error)) ? (($error) ? 'is-invalid' : 'is-valid') : '') }}" placeholder="Introduce una letra" {{ $partida->esFin() ? 'disabled' : '' }}>
                    <input class="btn btn-outline-secondary" type="submit" id="botonenviarjugada" name="botonenviarjugada" value="Enviar Jugada" {{ $partida->esFin() ? 'disabled' : '' }}>
                    @if(isset($error) && $error)
                    <div class="invalid-feedback">
                        La letra no es correcta o ya se ha introducido.
                    </div>
                    @endif
                </div>
            </form>
            <h3 class="mt-4 mb-2">Las letras introducidas hasta el momento son:</h3>
            <h3>{{ implode(" ", str_split($partida->getLetras())) }}</h3>
        </div>
        <div class="col-md-4">
            <img src="./assets/img/{{ $imgsHangman[$partida->getNumErrores()] }}" class="img-fluid" alt="Hangman Image">
        </div>
    </div>
</div>
@endsection


