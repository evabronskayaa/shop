@csrf
<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
<div class="input-group mb-1">
    <span class="input-group-text">Название профиля</span>
    <input type="text" class="form-control" name="title"
           required maxlength="255" value="{{ old('title') ?? $profile->title ?? '' }}">
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Имя, Фамилия</span>
    <input type="text" class="form-control" name="name"
           required maxlength="255" value="{{ old('name') ?? $profile->name ?? '' }}">
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Адрес почты</span>
    <input type="email" class="form-control" name="email"
           required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Номер телефона</span>
    <input type="text" class="form-control" name="phone"
           required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Адрес доставки</span>
    <input type="text" class="form-control" name="address"
           required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
</div>
<div class="input-group mb-1">
    <span class="input-group-text">Комментарий</span>
    <textarea class="form-control" name="comment"
              maxlength="255" rows="2">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
</div>
<div class="input-group">
    <button type="submit" class="btn btn-success">Сохранить</button>
</div>
