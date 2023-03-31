@if (Auth::user()->is_favorite($ototubu->id))
        <form method="POST" class="m-4" action="{{ route('favorites.unfavorite', $ototubu->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-error btn-sml normal-case rounded" 
                onclick="return confirm('id = {{ $user->id }} のいいねを取り消します。よろしいですか？')">いいね解除</button>
        </form>
    @else
        <form method="POST" class="m-4" action="{{ route('favorites.favorite', $ototubu->id) }}">
            @csrf
            <button type="submit" class="btn  btn-primary btn-sml normal-case rounded">いいね！</button>
        </form>
@endif
