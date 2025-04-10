<button
  id="recenterButton"
  class="absolute bottom-12 left-4 z-[10050] bg-purple-600 hover:bg-purple-700 text-white py-3 px-5 rounded shadow-md text-sm"
  onclick="window.iPoop.map.recenterUser()"
>
  📍
</button>

<div id="map" class="flex-1 w-full rounded"></div>

@include('ipoop.restrooms.offcanvas.resume')
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style type="text/css">
        #map {
            {{ $height ? "height: {$height}; " : '' }}
            {{ $width ? "width: {$width}; " : '' }}
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@endpush
