@extends('layouts.app')

@section('content')
    <div class="sm:grid sm:grid-cols-3 sm:gap-10">
        <div class="sm:col-span-2 mt-4">
            {{-- タブ --}}
            @include('users.ototubu_tab')
            <div class="mt-4">
            {{-- おきにいり一覧 --}}
            @include('ototubus.ototubus')
            </div>
        </div>
    </div>
@endsection