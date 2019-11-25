<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><i class="fas fa-home"></i> Основное</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="phones-tab" data-toggle="tab" href="#phones" role="tab" aria-controls="phones" aria-selected="true"><i class="far fa-edit"></i> Телефоны</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="locations-tab" data-toggle="tab" href="#locations" role="locations" aria-controls="locations" aria-selected="false"><i class="fab fa-html5"></i> Адреса</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="form-group my-4">
                <label for="photo">Фото абонента: </label>
                <input type="file" class="form-control-file" name="photo">
            </div>
            <div class="form-group">
                <label for="name">Имя абонента: </label>
                <input name="name" type="text" id="name" class="form-control  @error('name') is-invalid @enderror" value="{{ $contact->name ?? '' }}" placeholder="Имя">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Информация: </label>
                <textarea name="description" class="form-control" cols="30" rows="10">{{ $contact->description ?? '' }}</textarea>
            </div>		
        </div>

        <div class="tab-pane fade" id="phones" role="tabpanel" aria-labelledby="phones-tab">
            <phones-component :source="{{ $numbers ?? '[]' }}"></phones-component> 
        </div>

        <div class="tab-pane fade" id="locations" role="tabpanel" aria-labelledby="locations-tab">
            <locations-component :source1="{{ $countries ?? '[]' }}" :source2="{{ $towns ?? '[]' }}" :source3="{{ $addresses ?? '[]' }}"></locations-component>
        </div>
        <div class="form-group">
            <button class="btn btn-success">Сохранить</button>
        </div>
    </div>
</div>