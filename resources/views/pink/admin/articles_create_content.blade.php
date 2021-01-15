<div id="content-page" class="content group">
    <div class="hentry group">

        <form class="contact-form" action="{{ (isset($article->id)) ? route('adminArticles.update', $article) : route('adminArticles.store') }}" method="post" enctype="multipart/form-data">
            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Название:</span>
                        <br />
                        <span class="sublabel">Заголовок материала</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" name="title" value="{{ isset($article->title) ? $article->title  : old('title') }}" placeholder='Введите название страницы'>
                    </div>
                </li>
                
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ключевые слова:</span>
                        <br />
                        <span class="sublabel">Заголовок материала</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" name="keywords" value="{{ isset($article->keywords) ? $article->keywords  : old('keywords') }}" placeholder='Введите ключевые слова страницы'>
                    </div>
                </li>
                
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Мета описание:</span>
                        <br />
                        <span class="sublabel">Заголовок материала</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" name="meta_desc" value="{{ isset($article->meta_desc) ? $article->meta_desc  : old('meta_desc') }}" placeholder='Введите мета описание страницы'>
                    </div>
                </li>
                
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Псевдоним:</span>
                        <br />
                        <span class="sublabel">Введите псевдоним</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    <input type="text" name="alias" value="{{ isset($article->alias) ? $article->alias  : old('alias') }}" placeholder='Введите псевдоним страницы'>    
                </div>
                </li>
                
                <li class="textarea-field">
                    <label for="message-contact-us">
                        <span class="label">Краткое описание:</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
                    <textarea name="desc" id="editor" class="form-control" placeholder='Введите описание страницы'>
                        {{isset($article->desc) ? $article->desc  : old('desc')}}
                    </textarea>
                    </div>
                    <div class="msg-error"></div>
                </li>
                
                <li class="textarea-field">
                    <label for="message-contact-us">
                        <span class="label">Описание:</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
                        <textarea name="text" id="editor2" class="form-control" placeholder='Введите текст страницы'>
                            {{isset($article->text) ? $article->text  : old('text')}}
                        </textarea>
                    </div>
                    <div class="msg-error"></div>
                </li>
                
                @if(isset($article->img->path))
                    <li class="textarea-field">
                        
                        <label>
                            <span class="label">Изображения материала:</span>
                        </label>
                        
                        <img src="{{ asset(config('settings.theme'))}}/images/articles/{{ $article->img->path }}" style='width:400px'>
                        <input type="hidden" name="old_image" value="{{$article->img->path}}">
                    
                    </li>
                @endif
                
                
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Изображение:</span>
                        <br />
                        <span class="sublabel">Изображение материала</span><br />
                    </label>
                    <div class="input-prepend">
                        <input type="file" name='image' class='filestyle' data-buttonText='Выберите изображение' data-buttonName="btn-primary" data-placeholder="Файла нет">
                    </div>
                    
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Категория:</span>
                        <br />
                        <span class="sublabel">Категория материала</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('category_id', $categories, isset($article->category_id) ? $article->category_id : '') !!}
                    </div>
		        </li>	 
                
                
                @if(isset($article->id))
                    <input type="hidden" name="_method" value="PUT">		
                
                @endif

                <li class="submit-button"> 
                @csrf
                    <button class="btn btn-the-salmon-dance-3" type="submit">Сохранить</button>
                </li>
                
            </ul>
        </form>

        <script>
            CKEDITOR.replace( 'editor' );
            CKEDITOR.replace( 'editor2' );
        </script>
    </div>
</div>