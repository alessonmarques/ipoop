<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Detalhes do Banheiro - {{ $restroom->name }}
    </h2>
  </x-slot>

  <div class="px-4 py-6 max-w-4xl mx-auto space-y-4">

    <div class="flex justify-between items-center">
        <div class="mb-2">
            <a href="{{ url()->previous() }}" class="text-purple-600 hover:underline text-sm">
                ← Voltar
            </a>
        </div>
        <x-report-button :restroom="$restroom" />
    </div>


    <div class="mt-6 flex flex-col lg:flex-row gap-6 items-start">
        <!-- Informações -->
        <div class="bg-white p-6 rounded shadow space-y-3 w-full lg:w-1/2 lg:min-h-[500px]">
            <p><strong>Nome:</strong> {{ $restroom->name }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($restroom->type) }}</p>
            <p><strong>Acessível:</strong> {{ $restroom->accessible ? 'Sim' : 'Não' }}</p>
            <p><strong>Custo:</strong> R$ {{ number_format($restroom->cost, 2, ',', '.') }}</p>
            <p><strong>Descrição:</strong> {{ Str::limit($restroom->description, 500) }}</p>
        </div>

        <!-- Galeria -->
        <div class="bg-white p-6 rounded shadow space-y-3 w-full lg:w-1/2
                    {{ !$restroom->photos->count() ? 'flex justify-center items-center lg:min-h-[500px]' : '' }}">
            @include('ipoop.restrooms._photos', ['restroom' => $restroom])
        </div>
    </div>

    <div class="w-full h-80 border rounded" id="map"></div>

    <div class="mt-6">
      @include('ipoop.reviews._reviews', ['restroom' => $restroom])
    </div>

  </div>

  @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
  @endpush

  @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
      const map = L.map('map').setView([{{ $restroom->latitude }}, {{ $restroom->longitude }}], 18);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
      }).addTo(map);

      L.marker([{{ $restroom->latitude }}, {{ $restroom->longitude }}]).addTo(map)
        .bindPopup("{{ $restroom->name }}").openPopup();
    </script>
  @endpush

</x-app-layout>
