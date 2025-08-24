@extends('layouts.main')

@section('titulo', 'Início')
@section('css', '/css/ticket.css')

@section('conteudo')

<div>
    <h2> {{ $ticket->title }} </h2>
    <p>Local: {{ $ticket->location }}</p>
    <p>Data: {{ $ticket->event_date }}</p>
</div>

@endsection

{{-- @section('js', '/js/ticket.js') --}}