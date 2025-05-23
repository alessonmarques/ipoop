<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Adicionar Banheiro') }}
        </h2>
    </x-slot>
    <div class="px-4 pt-4 max-w-4xl mx-auto">
        <a href="{{ route('home') }}"
            class="inline-flex items-center text-sm text-purple-600 hover:text-purple-800 font-semibold">
            ← Voltar para o mapa
        </a>
    </div>
    @if (auth()->check() && auth()->user()->hasVerifiedEmail())
        <div class="py-6 px-4 max-w-4xl mx-auto">
            <form action="{{ route('restrooms.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-medium">Nome</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">Tipo</label>
                    <select name="type" class="w-full border rounded px-3 py-2" required>
                        <option value="public" {{ old('type') === 'public' ? 'selected' : '' }}>Público</option>
                        <option value="private" {{ old('type') === 'private' ? 'selected' : '' }}>Privado</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="accessible" value="{{ old('accessible') }}" class="mr-2"> Acessível
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">Descrição</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2"
                        maxlength="500">{{ old('description') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">Custo de uso (R$)</label>
                    <input type="number" step="0.01" min="0" name="cost" value="{{ old('cost') }}" id="cost"
                        class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">Fotos (até 5 imagens)</label>
                    <input type="file" name="photos[]" multiple accept="image/*" value="{{ old('cost') }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block font-medium">Localização</label>
                    <div id="map" class="w-full h-64 rounded border"></div>
                    <input type="hidden" name="latitude" value="{{ old('latitude') }}" id="lat">
                    <input type="hidden" name="longitude" value="{{ old('longitude') }}" id="lng">
                </div>
                <div class="text-right">
                    <a href="{{ route('home') }}"
                        class="mb-4 inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
                        ← Voltar
                    </a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                        Enviar para Revisão
                    </button>
                </div>
            </form>
        </div>
    @else
        @include('auth.verification')
    @endif

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
        <script>
            window.addEventListener('load', function () {
                // Initialize the map
                const iPoopMap = window.iPoop.map;

                if (document.getElementById('map')) {
                    iPoopMap.initMap();

                    let marker, lat, lng;
                    iPoopMap.setClickMarker(marker, function (lat, lng) {
                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;
                    });
                }

                const costInput = document.getElementById('cost');
                if (costInput) {
                    costInput.addEventListener('blur', function () {
                        let value = parseFloat(this.value);
                        if (!isNaN(value)) {
                            this.value = value.toFixed(2); // formata com duas casas
                        }
                    });
                }

            });
        </script>
    @endpush

</x-app-layout>
