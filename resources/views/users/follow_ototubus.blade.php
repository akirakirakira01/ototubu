@extends('layouts.app')

@section('content')
            {{-- タブ --}}
            @include('users.ototubu_tab')
            {{-- おきにいり一覧 --}}
            @include('ototubus.ototubus')
@endsection