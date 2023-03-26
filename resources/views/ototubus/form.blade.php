@extends('layouts.app')
@section('content')
@if(\Auth::check())
    <div class="mt-4">
        <form method="POST" action="{{ route('ototubus.store') }}">
            @csrf
            
             <div class="form-control mt-4">
                <h3>曲名</h3><textarea rows="2" name="music" class="input input-bordered w-full"></textarea>
            </div>
            
             <div class="form-control mt-4">
                <h3>アーティスト名</h3><textarea rows="2" name="artist" class="input input-bordered w-full"></textarea>
            </div>
            
             <div class="form-control mt-4">
                <h3>動画URL</h3><textarea rows="2" name="url" class="input input-bordered w-full"></textarea>
            </div>
            
            <div class="form-control mt-4">
                <h3>コメント</h3><textarea rows="2" name="content" class="input input-bordered w-full"></textarea>
            </div>
        
            <button type="submit" class="btn btn-primary btn-block normal-case">投稿</button>
        </form>
    </div>
@endif
@endsection