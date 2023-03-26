<div class="mt-4">
    @if (isset($ototubus))
        <ul class="list-none">
            @foreach ($ototubus as $ototubu)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($ototubu->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $ototubu->user->id) }}">{{ $ototubu->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $ototubu->created_at }}</span>
                        </div>
                        <div>
                            {{-- 投稿内容 --}}
                            <ul class="mb-0">
                                <li>{!! $ototubu->music !!}</li>
                                <li>{!! $ototubu->artist !!}</li>
                                <li>{!! $ototubu->url !!}</li>
                                <li>{!! $ototubu->content !!}</li>
                            </ul>
                        </div>
                        <div>
                            @if (Auth::id() == $ototubu->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                <form method="POST" action="{{ route('ototubus.destroy', $ototubu->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm normal-case" 
                                        onclick="return confirm('Delete id = {{ $ototubu->id }} ?')">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{-- ページネーションのリンク --}}
        {{ $ototubus->links() }}
    @endif
</div>