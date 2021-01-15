@extends(config('settings.theme').'.layouts.site')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
<x-guest-layout>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div id="content-home" class="content group">
            <div class="hentry group">
                <form id="contact-form-contact-us" class="contact-form" method="POST" action="{{ route('login') }}">
                    @csrf

                    <fieldset>
                        <ul>
                            <li class="text-field">
                                <x-jet-label for="login" value="{{ __('Login') }}" />
                                <x-jet-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus />
                            </li>

                            <li class="text-field">
                                <x-jet-label for="password" value="{{ __('Password') }}" />
                                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            </li>

                            <div class="flex items-center justify-end mt-4">

                                <x-jet-button class="ml-4">
                                    {{ __('Login') }}
                                </x-jet-button>
                            </div>
                        </ul>
                    </fieldset>
                </form>
            </div>
        </div>
</x-guest-layout>
@endsection
