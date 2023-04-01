<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ototubu;
use App\Rules\URL;

class OtotubusController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $ototubus = Ototubu::orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'ototubus' => $ototubus,
            ];
        }
        
        // dashboardビューでそれらを表示
        return view('dashboard', $data);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'music' => 'required|max:255',
            'artist' => 'required|max:255',
            'url' => ['required','max:255',new URL],
            'content' => 'required|max:255',
        ]);
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->ototubus()->create([
            'music' => $request->music,
            'artist' => $request->artist,
            'url' => $request->url,
            'content' => $request->content,
        ]);
        
        // 前のURLへリダイレクトさせる
        return redirect('dashboard');
    }
    
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $ototubu = \App\Models\Ototubu::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $ototubu->user_id) {
            $ototubu->delete();
            return back()
                ->with('success','Delete Successful');
        }

        // 前のURLへリダイレクトさせる
        return back()
            ->with('Delete Failed');
    }
    
    public function form()
    {
         return view('ototubus.form');
    }
    
    public function follow_ototubus()
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザとフォロー中ユーザの投稿の一覧を作成日時の降順で取得
            $ototubus = $user->feed_ototubus()->orderBy('created_at', 'desc')->paginate(10);

                
        }
        
        // dashboardビューでそれらを表示
        return view('users.follow_ototubus', [
            'user' => $user,
            'ototubus' => $ototubus
                ]);
    }
    
    public function search(Request $request)
    {
         $user = \Auth::user();
        // ユーザー一覧をページネートで取得
        $ototubus = Ototubu::paginate(20);
        
         // 検索フォームで入力された値を取得する
        $search = $request->input('search');
        
         // クエリビルダ
        $query = Ototubu::query();

       // もし検索フォームにキーワードが入力されたら
        if ($search) {

        // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');

        // 単語を半角スペースで区切り、配列にする
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


        // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('music', 'like', '%'.$value.'%')
                        ->orWhere('artist','like', '%'.$value.'%')
                        ->orWhere('content','like', '%'.$value.'%');
            }
        
        $ototubus = $query -> paginate(10);
        }
        
        return view('users.result')
            ->with([
                'ototubus' => $ototubus,
                'search' => $search,
                'user' =>$user,
            ]);
    }

}

