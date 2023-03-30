@extends('layouts.app')

@section('content')
            {{-- タブ --}}
            @include('users.ototubu_tab')
            
            {{-- Ototubu一覧 --}}
            @include('ototubus.ototubus')
@endsection