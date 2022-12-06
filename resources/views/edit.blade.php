@extends('layout')

@section('content')


    <form action="/update/{{$todo['id']}}" method="post" style="max-width: 500px; margin: auto;">
        {{-- menampilkan alert ketika validasi menghasilkan error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- mengirim data ke controller yg ditampung oleh Request $request --}}
        @csrf
        @method('PATCH')
        <div class="d-flex flex-column">
            <label>Title</label>
            <input type="text" name="title" value="{{$todo['title']}}">
        </div>
        <div class="d-flex flex-column">
            <label>Date</label>
            <input type="date" name="date" value="{{$todo['date']}}">
        </div>
        <div class="d-flex flex-column">
            <label>Description</label>
            <textarea name="description" cols="30" rows="10">{{$todo['description']}}</textarea>
        </div>
        <button type="submit">Kirim</button>
    </form>
@endsection