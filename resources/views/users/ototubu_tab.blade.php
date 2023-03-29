<div class="tabs bg-gray-300">
    {{-- Ototubu一覧タブ --}}
    <a href="{{ route('dashboard') }}" class="tab tab-lifted grow {{ Request::routeIs('dashboard') ? 'tab-active' : '' }}">
        TimeLine
    </a>
    {{-- フォロー済みの投稿一覧タブ --}}
    <a href="{{ route('follow_ototubus', $user->id) }}" class="tab tab-lifted grow {{ Request::routeIs('follow_ototubus') ? 'tab-active' : '' }}">
        フォロー中の投稿
    </a>
    {{-- お気に入り一覧タブ --}}
    <a href="{{ route('users.favorites2', $user->id) }}" class="tab tab-lifted grow {{ Request::routeIs('users.favorites2') ? 'tab-active' : '' }}">
        おきにいり
    </a>
</div>