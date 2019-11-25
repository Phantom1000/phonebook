@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <h2>Редактирование контакта</h2>
    </div>

    <hr />

    <form class="form-horizontal" action="{{ route('contact.update', $contact) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('contacts.form')
    </form>

</div>

@endsection