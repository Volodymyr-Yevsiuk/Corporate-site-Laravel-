@if($users)
	<div id="content-page" class="content group">
        <div class="hentry group">
            <h2>Добавленные пользователи</h2>
            <div class="short-table white">
                <table style="width: 100%" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Логин</th>
                            <th>Роль</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($users as $user)
                        <tr>
                            <td class="align-left">{{$user->id}}</td>
                            <td class="align-left">{!! Html::link(route('users.edit', $user),$user->name) !!}</td>
                            <td class="align-left">{{$user->email}}</td>
                            <td class="align-left">{{$user->login}}</td>
                            <td class="align-left">{{$user->roles->implode('name', ', ')}}</td>
                            <td>
                                <form class="form-horizontal" action="{{ route('users.destroy', $user) }}" method="POST">
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
            
            <a href="{{ route('users.create') }}" class="btn btn-the-salmon-dance-3">Добавить пользователя</a>
            
            
        </div>

    </div>
@endif