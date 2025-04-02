<div id="map" class="flex-1 w-full rounded"></div>

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
