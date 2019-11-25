@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            @can('create', ['App\Contact', $pub])
                <a href="{{ route('contact.create') }}" class="btn btn-primary my-3"><i class="fa fa-plus-square"></i> Создать</a>
            @endcan
            <form class="form-inline my-2 my-lg-0" action="{{ route('contact.index', ['pub' => $pub]) }}" method="GET">
                <input class="form-control mr-sm-2" name="q"  value="{{ old('q') }}" type="text" placeholder="введите искомое слово" aria-label="Search" required>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
            </form>
        </div>
        <div class="row justify-content-end pb-2">
            Сортировка по: 
            <a href="{{ route('contact.index', ['pub' => $pub, 'sort' => 'date']) }}" class="pl-2">дате добавления</i></a><span class="pl-2">|</span>
            <a href="{{ route('contact.index', ['pub' => $pub, 'sort' => 'name']) }}" class="pl-2">имени</i></a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Имя</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th class="text-center">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $contact->name ?? '' }}</td>
                        <td>{{ $contact->phones()->first()->number ?? '' }}</td>
                        <td>{{ $contact->locations()->first()->address ?? '' }}</td>
                        <td>
                            <div class="row justify-content-center">
                                <a href="{{ route('contact.show', $contact) }}" class="mr-2 btn btn-link">Просмотр</i></a>
                                @can('add', [$contact, $pub])
                                    <a href="{{ route('contact.add', $contact) }}" class="mr-2 btn btn-link">Добавить в контакты</i></a>
                                @endcan
                                @can('update', $contact)
                                    <a href="{{ route('contact.edit', $contact) }}" class="mr-2 btn btn-primary"><i class="fa fa-edit"> Редактировать</i></a>
                                    <form action="{{ route('contact.destroy', $contact) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="mr-2 btn btn-danger" type="submit"><i class="fa fa-trash"> Удалить</i></button>
                                    </form>                                          
                                @endcan
                            </div>
                        </td>
                    </tr>        
                @empty
                    <tr>
                        <td colspan="5">
                            <h1 class="text-center">Контакты отсутствуют</h1>
                        </td>
                    </tr>    
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $contacts->links() }}
        </div>
    </div>
@endsection