@extends(config('settings.theme').'.layouts.site')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('bar')
    {!! $leftBar !!}
@endsection

@section('copyright')
    {!! $footer !!}
@endsection