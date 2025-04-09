<div class="py-6 px-4 max-w-4xl m-6 mx-auto rounded border bg-white shadow flex items-center justify-center">
    <div class="mb-4">
        <form method="POST" action="{{ route('verification.send') }}" class="inline">
            @csrf
            <p class="text-gray-600 my-6 py-2">Você precisa verificar seu e-mail para cadastrar um banheiro.</p>
            <button type="submit" class="underline font-medium text-purple-700 hover:text-purple-900">Verificar seu e-mail </button>
        </form>
    </div>
</div>
