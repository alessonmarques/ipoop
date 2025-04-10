<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar o seu endereço de e-mail e enviaremos um link para redefinir sua senha, permitindo que você escolha uma nova.') }}
    </div>

    <!-- Status da Sessão -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        @if ($errors->has('g-recaptcha-response'))
            <div class="flex justify-center">
                <span class="text-red-600 text-sm my-2">
                    {{ $errors->first('g-recaptcha-response') }}
                </span>
            </div>
        @endif

        <!-- Endereço de E-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar Link de Redefinição de Senha') }}
            </x-primary-button>
        </div>
        <div class="flex justify-center mt-2">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        </div>
    </form>
</x-guest-layout>
