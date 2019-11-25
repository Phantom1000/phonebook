@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <h2>Создание контакта</h2>
    </div>

    <hr />

    <form class="form-horizontal" action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('contacts.form')
    </form>

</div>

@endsection
