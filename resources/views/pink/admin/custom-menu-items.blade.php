@foreach($items as $item)

	<tr>
		<td style="text-align: left;">{{ $paddingLeft }}<a href="{{ route('menus.edit', $item->id) }}">{{ $item->title }}</a></td>
		<td>{{ $item->url() }}</td>
		<td>
			<form class="form-horizontal" action="{{ route('menus.destroy', $item->id) }}" method="POST">
			@csrf
				{{ method_field('DELETE') }}
				<button type="submit" class="btn btn-french-5">Удалить</button>
			</form>

		</td>
	</tr>
	@if($item->hasChildren())
		        
		@include(config('settings.theme').'.admin.custom-menu-items', ['items' => $item->children(),'paddingLeft' => $paddingLeft.'--'])

	@endif 

@endforeach