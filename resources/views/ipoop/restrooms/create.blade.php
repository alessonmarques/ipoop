<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Adicionar Banheiro') }}
    </h2>
  </x-slot>

  <div class="py-6 px-4 max-w-4xl mx-auto">
    <form action="{{ route('restrooms.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block font-medium">Nome</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
      </div>
      <div class="mb-4">
        <label class="block font-medium">Tipo</label>
        <select name="type" class="w-full border rounded px-3 py-2" required>
          <option value="public">Público</option>
          <option value="private">Privado</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="accessible" class="mr-2"> Acessível
        </label>
      </div>
      <div class="mb-4">
        <label class="block font-medium">Descrição</label>
        <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
      </div>
      <div class="mb-4">
        <label class="block font-medium">Custo de uso (R$)</label>
        <input type="number" step="0.01" name="cost" class="w-full border rounded px-3 py-2">
      </div>
      <div class="mb-4">
        <label class="block font-medium">Localização</label>
        <div id="map" class="w-full h-64 rounded border"></div>
        <input type="hidden" name="latitude" id="lat">
        <input type="hidden" name="longitude" id="lng">
      </div>
      <div class="text-right">
        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
          Enviar para Revisão
        </button>
      </div>
    </form>
  </div>

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
      });
    </script>
  @endpush

</x-app-layout>