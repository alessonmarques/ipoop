<x-app-layout>

    <div class="flex flex-col h-[80vh] relative" style="z-index: 1;">
        <a href="{{ auth()->check() ? '/restrooms/create' : '#' }}"
            id="addRestroomBtn"
            class="absolute bottom-6 right-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-5 rounded shadow-lg z-[10000]">
            + Adicionar Banheiro
        </a>

        <x-map-filter />

        <x-map />
    </div>

    <div id="authPromptModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[11000] hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center relative">
            <h2 class="text-lg font-bold mb-4">Você precisa estar logado</h2>
            <p class="mb-6 text-gray-600">Entre ou registre-se para cadastrar um banheiro.</p>
            <div class="flex justify-between">
            <a href="/login"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded w-[48%]">Entrar</a>
            <a href="/register"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded w-[48%]">Registrar</a>
            </div>
            <button id="closeAuthPrompt" class="absolute top-2 right-3 text-xl text-gray-500 hover:text-gray-700">&times;</button>
        </div>
    </div>

    @push('scripts')
    <script>
        const btn = document.getElementById('addRestroomBtn');
        const modal = document.getElementById('authPromptModal');
        const closeBtn = document.getElementById('closeAuthPrompt');

        btn.addEventListener('click', function (e) {
            @if(!auth()->check())
                e.preventDefault();
                modal.classList.remove('hidden');
            @endif
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        window.addEventListener('load', function () {
            // Initialize the map
            const iPoopMap = window.iPoop.map;

            if (document.getElementById('map')) {
                iPoopMap.initMap();
            }
        });
    </script>
    @endpush

</x-app-layout>