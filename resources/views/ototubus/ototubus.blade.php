
    @if (isset($ototubus))
            @foreach ($ototubus as $ototubu)
            
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar mt-4">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($ototubu->user->email) }}" alt="" />
                        </div>
                    </div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $ototubu->user->id) }}">{{ $ototubu->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $ototubu->created_at }}</span>
                            {{-- 投稿内容 --}}
                        <div class="sm:flex text-justify ms-10 items-center bg-white border border-gray-200 rounded-lg justify-content:flex-start shadow 
                            md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 
                            dark:hover:bg-gray-700">
                                
                            <div class="flex flex-col p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{!! $ototubu->artist !!}</h5>
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">「{!! $ototubu->music !!}」</h5>
                                
                            
                            
                                    <iframe width="300" height="169" class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" src="
                                      <?php
                                          $urls = $ototubu->url;
                                          $music = explode(".be/","$urls");
                                          $a = implode('be.com/embed/',$music);
                                          print_r($a);
                                      ?>
                                    " title="YouTube video player"
                                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                    </iframe>
                            </div>
                            <div class="flex-col ">
                                      <p class="  mb-4 font-normal  pe-5 inline-block text-gray-700 dark:text-gray-400">{!! nl2br(e($ototubu->content)) !!}</p>
                            
                            <div class="flex justify-start">
                             @include ('user_favorite.favorite_button')
                            @if (Auth::id() == $ototubu->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                <form method="POST" class="mt-5" action="{{ route('ototubus.destroy', $ototubu->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn block  btn-error btn-sm normal-case" 
                                        onclick="return confirm('Delete id = {{ $ototubu->id }} ?')">Delete</button>
                                </form>
                            @endif
                            </div>
                            </div>
                        </div>
                            
            @endforeach
        {{-- ページネーションのリンク --}}
        {{ $ototubus->links() }}
    @endif