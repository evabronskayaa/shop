@csrf
<div class="input-group mb-1">
    <input type="text" class="form-control" name="name" placeholder="Наименование"
           required maxlength="100" value="{{ old('name') ?? $brand->name ?? '' }}">
    <span class="input-group-text">|</span>
    <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $brand->slug ?? '' }}">
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Описание</span>
    <textarea class="form-control" name="content"
              rows="4">{{ old('content') ?? $brand->content ?? '' }}</textarea>
</div>
<div class="input-group mb-1">
    <input type="file" class="form-control" name="image" accept="image/png, image/jpeg" aria-label="Загрузить">
</div>
@isset($brand->image)
    <div class="form-check m-1">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
    </div>
@endisset
<div class="input-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
