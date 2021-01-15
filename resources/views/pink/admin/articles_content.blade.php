@if($articles)
	<div id="content-page" class="content group">
        <div class="hentry group">
            <h2>Добавленные статьи</h2>
            <div class="short-table white">
                <table style="width: 100%" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="align-left">ID</th>
                            <th>Заголовок</th>
                            <th>Текст</th>
                            <th>Изображение</th>
                            <th>Категория</th>
                            <th>Псевдоним</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($articles as $article)
                        <tr>
                            <td class="align-left">{{$article->id}}</td>
                            <td class="align-left">{!! Html::link(route('adminArticles.edit', $article),$article->title) !!}</td>
                            <td class="align-left">{{Str::limit($article->text,200)}}</td>
                            <td>
                                @if(isset($article->img->mini))
                                    <img src="{{ asset(config('settings.theme')) }}/images/articles/{{ $article->img->mini }}">
                                @endif
                            </td>
                            <td>{{$article->category->title}}</td>
                            <td>{{$article->alias}}</td>
                            <td>
                                <form class="form-horizontal" action="{{ route('adminArticles.destroy', $article) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete">
                                    <!-- {{ method_field('DELETE') }} -->
                                    <button class="btn btn-french-5" type="submit">Удалить</button>

                                </form>
                            </td>
                            
                            </td>
                            </tr>	
                        @endforeach	
                        
                    </tbody>
                </table>
            </div>
            
            <a href="{{ route('adminArticles.create') }}" class="btn btn-the-salmon-dance-3">Добавить  материал</a>
            
            
        </div>
        <!-- START COMMENTS -->
        <div id="comments">
        </div>
        <!-- END COMMENTS -->
    </div>
@endif