@extends('layout')

@section('nav-type', 'navbar-left')

@section('menu')
<span class="navbar-brand mb-0 h1">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-left"
        viewBox="0 0 16 16" onclick="history.back()">
        <path fill-rule="evenodd"
            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
    </svg>
</span>
<span class="navbar-brand ml-3 mb-0 h1">
    New Note
</span>
@endsection

@section('content')
<div class="container">
    <form action="{{ route('note.store') }}" method="post">
        @csrf
        <input type="text" class="input-form mb-3" name="title" placeholder="Title">
        <input id="body" type="hidden" name="body">
        <trix-editor input="body"></trix-editor>

        <button type="submit" class="btn btn-warning mt-3 color-theme font-weight-bold">Tambah</button>
    </form>
</div>
@endsection

@section('script')
<script>

</script>
@endsection