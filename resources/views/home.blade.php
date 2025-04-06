<x-app-layout>

    <div class="flex flex-col h-[90vh] relative" style="z-index: 1;">
        <a href="{{ auth()->check() ? '/restrooms/create' : '#' }}"
            id="addRestroomBtn"
            class="absolute bottom-6 right-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-5 rounded shadow-lg z-[10000]">
            + Adicionar Banheiro
        </a>

        <x-map-filter />
        <x-map />

        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 mb-4 z-[10001]">
            <button id="scrollDownBtn"
                class="flex items-center gap-2 text-purple-700 hover:text-purple-900 font-medium text-sm animate-bounce">
                ↓ Ver mais informações
            </button>
        </div>
    </div>

    <section id="infoSection"
        class="bg-white mt-10 py-12 px-6 max-w-6xl mx-auto text-center rounded shadow">
        <div class="flex justify-center mb-3">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </div>
        <h2 class="text-2xl font-bold text-purple-700">Sobre o iPoop</h2>
        <p class="text-gray-700 max-w-2xl mx-auto">O iPoop é uma plataforma colaborativa para localizar, avaliar e compartilhar informações sobre banheiros públicos e privados com foco em acessibilidade e bem-estar urbano.</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-10">
            <div class="bg-gray-100 p-6 rounded shadow text-center">
                <p class="text-4xl font-bold text-purple-600">{{ $restroomCount }}</p>
                <p class="text-gray-600 mt-2">Banheiros cadastrados</p>
            </div>
            <div class="bg-gray-100 p-6 rounded shadow text-center">
                <p class="text-4xl font-bold text-purple-600">{{ $reviewCount }}</p>
                <p class="text-gray-600 mt-2">Avaliações feitas</p>
            </div>
            <div class="bg-gray-100 p-6 rounded shadow text-center">
                <p class="text-4xl font-bold text-purple-600">{{ $userCount }}</p>
                <p class="text-gray-600 mt-2">Usuários ativos</p>
            </div>
        </div>

        <div class="mt-12 text-left space-y-8">
            <h3 class="text-xl font-semibold text-purple-700">Como funciona o iPoop?</h3>
            <ol class="list-decimal list-inside text-gray-700 text-base space-y-1">
                <li>Encontre banheiros públicos e privados próximos.</li>
                <li>Veja avaliações reais e fotos enviadas por usuários.</li>
                <li>Cadastre novos banheiros e contribua com a comunidade.</li>
            </ol>
        </div>

        <div class="mt-12">
            <h3 class="text-xl font-semibold text-purple-700 mb-4">Depoimentos recentes</h3>
            @include('ipoop.components.testimonials')
        </div>

        <div class="mt-12 text-center">
            <a  id="addRestroomBtnCenter"
                href="{{ auth()->check() ? '/restrooms/create' : '#' }}"
                class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded text-lg shadow">
                Cadastre seu primeiro banheiro
            </a>
        </div>
    </section>

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
        const btnCenter = document.getElementById('addRestroomBtnCenter');
        const modal = document.getElementById('authPromptModal');
        const closeBtn = document.getElementById('closeAuthPrompt');

        let loginCheck = function(e) {
            @if(!auth()-> check())
                e.preventDefault();
                modal.classList.remove('hidden');
            @endif
        };
        btn.addEventListener('click', loginCheck);
        btnCenter.addEventListener('click', loginCheck);

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        const scrollBtn = document.getElementById('scrollDownBtn');
        const infoSection = document.getElementById('infoSection');

        scrollBtn?.addEventListener('click', () => {
            infoSection?.scrollIntoView({
                behavior: 'smooth'
            });
        });

        window.addEventListener('load', function() {
            // Initialize the map
            const iPoopMap = window.iPoop.map;

            if (document.getElementById('map')) {
                iPoopMap.initMap();
            }
        });
    </script>

    @endpush

</x-app-layout>