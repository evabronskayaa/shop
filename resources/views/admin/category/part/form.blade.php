@csrf
<div class="input-group mb-1">
    <input type="text" class="form-control" name="name" placeholder="Наименование"
           required maxlength="100" value="{{ old('name') ?? $category->name ?? '' }}">
    <span class="input-group-text">|</span>
    <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $category->slug ?? '' }}">
</div>
<div class="input-group mb-1">
    @php
        $parent_id = old('parent_id') ?? $category->parent_id ?? 0;
    @endphp
    <select name="parent_id" class="form-select" title="Родитель">
        <option value="0">Без родителя</option>
        @if (count($items))
            @include('admin.category.part.branch', ['level' => -1, 'parent' => 0])
        @endif
    </select>
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Краткое описание</span>
    <textarea class="form-control" name="content"
              maxlength="200" rows="3">{{ old('content') ?? $category->content ?? '' }}</textarea>
</div>
<div class="input-group mb-1">
    <input type="file" class="form-control" name="image" accept="image/png, image/jpeg" aria-label="Загрузить">
</div>
@isset($category->image)
    <div class="form-check m-1">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
    </div>
@endisset
<div class="input-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
