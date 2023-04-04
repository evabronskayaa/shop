<form action="{{ route('cart.checkout') }}" method="get" id="profiles">
    <div class="input-group mb-1">
        <span class="input-group-text">Выберите профиль</span>
        <select name="profile_id" class="form-select">
            <option value="0">Не выбран</option>
            @foreach($profiles as $profile)
                <option value="{{ $profile->id }}"@if($profile->id == $current) selected @endif>
                    {{ $profile->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Выбрать</button>
    </div>
</form>
