@extends('adminlte::page')

@section('title', "Event \"$event->title\"")

@section('content_header')
@stop

@section('content')
    <div class="container">
        <h1>{{ $event->title }}</h1>
        <p>{{ $event->text }}</p>
        <p>{{ $event->created_at }}</p>
        <hr>
        <h1>Participants</h1>
        <ul>
            @foreach($event->participants as $p)
                <li><a href="{{ route('admin.settings', $p->id) }}">{{ $p->name }} {{ $p->last_name }}</a></li>
            @endforeach
        </ul>

        @if($event->creator_id != Auth::user()->id)
            <form class="btn btn-group" enctype="multipart/form-data" method="post">
                @csrf
                @if($event->isInParticipants())
                    <button class="btn btn-outline-success" formaction="{{ route('event-join', $event->id) }}">Join</button>
                @else
                    <button class="btn btn-outline-danger" formaction="{{ route('event-leave', $event->id) }}">Leave</button>
                @endif
            </form>
        @endif
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @vite(['resources/js/app.js'])
@stop
