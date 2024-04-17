@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <form method="post" action="{{ route('update-profile') }}" enctype="multipart/form-data">
        @csrf
        <div class="container">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif(isset($message))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
                    <x-adminlte-input name="login" label="Login" placeholder="username" label-class="text-lightblue" value="{{ $user->login }}">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-user text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-12">
                    <x-adminlte-input name="password" label="Password" placeholder="Password" label-class="text-lightblue"/>
                </div>
            </div>
            <div class="d-inline-flex w-100">
                <div class="col-lg-12 col-sm-12 col-md-6 col-xl-6 p-0">
                    <x-adminlte-input name="name" label="Name" placeholder="{{ fake()->name() }}" label-class="text-lightblue" value="{!! $user->name !!}"/>
                </div>
                <div class="col-lg-12 col-sm-12 col-md-6 col-xl-6 p-0">
                    <x-adminlte-input name="last_name" label="Last name" placeholder="{{ fake()->lastName() }}" label-class="text-lightblue" value="{!! $user->last_name !!}"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12">
                    <x-adminlte-input-date name="birth_at" :config="$config" placeholder="Choose a date..."
                                           label="Birthday" label-class="text-primary" value="{{ $user->birth_at }}">
                    </x-adminlte-input-date>
                </div>
            </div>
            <div class="btn-group">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        $(document).ready(function () {
            setInterval(function () {
                $("#event_list").refreshBox({
                    source: '{{ route('api-event-list') }}'
                });
            }, 3000);
        })
    </script>
@stop
