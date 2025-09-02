@extends('layouts.main')

@section('titulo', 'Início')
@section('css', '/css/style.css')

@section('conteudo')

<div class="content">
    <h2> {{ $ticket->title }} </h2>
    <p>Local: {{ $ticket->location }}</p>
    <p>{{ \Carbon\Carbon::parse($ticket->event_date)->format('d/m/Y') }}</p>
</div>

@endsection

{{-- @section('js', '/js/ticket.js') --}}