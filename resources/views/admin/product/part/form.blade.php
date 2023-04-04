@csrf
<div class="input-group mb-1">
    <input type="text" class="form-control" name="name" placeholder="Наименование"
           required maxlength="100" value="{{ old('name') ?? $product->name ?? '' }}">
    <span class="input-group-text">|</span>
    <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $product->slug ?? '' }}">
</div>
<div class="input-group mb-1">
    <!-- цена (руб) -->
    <input type="text" class="form-control w-25 d-inline mr-4" placeholder="Цена (руб.)"
           name="price" required value="{{ old('price') ?? $product->price ?? '' }}">
    <!-- новинка -->
    <div class="input-group-text">
        @php
            $checked = false; // создание нового товара
            if (isset($product)) $checked = $product->new; // редактирование товара
            if (old('new')) $checked = true; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="new" class="form-check-input mt-0" id="new-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label ms-1" for="new-product">Новинка</label>
    </div>
    <!-- лидер продаж -->
    <div class="input-group-text">
        @php
            $checked = false; // создание нового товара
            if (isset($product)) $checked = $product->hit; // редактирование товара
            if (old('hit')) $checked = true; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="hit" class="form-check-input mt-0" id="hit-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label ms-1" for="hit-product">Лидер продаж</label>
    </div>
    <!-- распродажа -->
    <div class="input-group-text">
        @php
            $checked = false; // создание нового товара
            if (isset($product)) $checked = $product->sale; // редактирование товара
            if (old('sale')) $checked = true; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="sale" class="form-check-input mt-0" id="sale-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label ms-1" for="sale-product">Распродажа</label>
    </div>
</div>
<div class="input-group mb-1">
    @php
        $category_id = old('category_id') ?? $product->category_id ?? 0;
    @endphp
    <select name="category_id" class="form-control" title="Категория">
        <option value="0">Выберите категорию</option>
        @if(count($items))
            @include('admin.product.part.branch', ['level' => -1, 'parent' => 0])
        @endif
    </select>
    @php
        $brand_id = old('brand_id') ?? $product->brand_id ?? 0;
    @endphp
    <select name="brand_id" class="form-control" title="Бренд" required>
        <option value="0">Выберите бренд</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" @if($brand->id == $brand_id) selected @endif>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Описание</span>
    <textarea class="form-control" name="content"
              rows="4">{{ old('content') ?? $product->content ?? '' }}</textarea>
</div>
<div class="input-group mb-1">
    <input type="file" class="form-control" name="image" accept="image/png, image/jpeg" aria-label="Загрузить">
</div>
@isset($product->image)
    <div class="form-check m-1">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
    </div>
@endisset
<div class="input-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
