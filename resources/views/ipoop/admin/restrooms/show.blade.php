<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      Detalhes do Banheiro - {{ $restroom->name }}
    </h2>
  </x-slot>

  <div class="px-4 py-6 max-w-4xl mx-auto space-y-4">
    <a href="{{ route('admin.restrooms.index') }}" class="text-purple-600 hover:underline">← Voltar</a>

    <div class="bg-white p-6 rounded shadow space-y-3">
      <p><strong>Nome:</strong> {{ $restroom->name }}</p>
      <p><strong>Tipo:</strong> {{ ucfirst($restroom->type) }}</p>
      <p><strong>Acessível:</strong> {{ $restroom->accessible ? 'Sim' : 'Não' }}</p>
      <p><strong>Custo:</strong> R$ {{ number_format($restroom->cost, 2, ',', '.') }}</p>
      <p><strong>Descrição:</strong> {{ $restroom->description }}</p>
    </div>

    <div class="w-full h-80 border rounded" id="map"></div>
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
