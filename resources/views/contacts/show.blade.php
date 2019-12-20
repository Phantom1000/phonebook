@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="{{ asset('storage/' . $contact->photo) }}" alt="Фотография абонента" class="w-50 pb-4">
            </div>
            <div class="col-sm-8">
                <div class="jumbotron">
                    <div class="row justify-content-center">
                        <h2>{{ $contact->name ?? '' }}</h2>
                    </div>
                    <div class="row">
                        <p>{{ $contact->description ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h2 class="text-center">Контактные телефоны</h2>
                <ul class="list-group">
                    @forelse ($contact->phones as $phone)
                        <li class="list-group-item">{{ $phone->number ?? '' }}</li>
                    @empty
                        <h2 class="text-center">не добавлены</h2>
                    @endforelse
                </ul>
            </div>
            <div class="col-sm-6">
                <h2 class="text-center">Адреса</h2>
                <ul class="list-group">
                    @forelse ($contact->locations as $location)
                        <li class="list-group-item">{{ $location->country . ', ' . $location->town . ', ' . $location->address }}</li>
                    @empty
                        <h2 class="text-center">не добавлены</h2>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection