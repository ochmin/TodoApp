@extends('layout')  

@section('content')

    @if (Session::get('addTodo'))
        <div class="alert alert-success">
            {{ Session::get('addTodo') }}
        </div>
    @endif

   <h3> Selamat Datang Ophelia Phalosa </h3>
    <h2> Username : Ochmin </h2>
    <h2> Email : opheliaphalosa@gmail.com </h2>
    

@endsection