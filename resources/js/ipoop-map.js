import IPoopMapIcons from './ipoop-map-icons';

const ZOOM_TYPE = {
  NEIGHBORHOOD: 15,
  STREET: 18,
};

const IPoopMap = {
  map: null,
  bathrooms: [],
  userMarker: null,
  lastPosition: { lat: null, lng: null },
  filters: {},
  markers: [],
  icons: {},

  initMap(containerId = 'map', defaultCoords = [-22.875226309, -43.4648756], defaultZoom = ZOOM_TYPE.NEIGHBORHOOD) {
    IPoopMapIcons.setIcons();
    this.icons = IPoopMapIcons;

    this.map = window.map = L.map(containerId).setView(defaultCoords, defaultZoom);
    this.addTileLayer();
    this.locateUser();

  },

  addTileLayer() {
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(this.map);
  },

  locateUser() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const userLat = position.coords.latitude;
          const userLng = position.coords.longitude;
          // Store the user's last position
          this.lastPosition = { lat: userLat, lng: userLng };

          // Load nearby bathrooms
          this.fetchNearbyRestrooms(userLat, userLng);
          this.watchUserLocation();

          // Move the map to the user's location
          this.map.flyTo([userLat, userLng], ZOOM_TYPE.STREET);

          L.marker([userLat, userLng])
            .addTo(this.map)
            .bindPopup("Você está aqui!")
            .openPopup();
        },
        (err) => {
          console.warn("Erro ao obter localização:", err.message);
        }
      );
    } else {
      console.warn("Geolocalização não suportada.");
    }
  },

  addMarker(lat, lng, popupText = '') {
    if (!this.map) {
      console.error("O mapa ainda não foi inicializado.");
      return;
    }

    const marker = L.marker([lat, lng]).addTo(this.map);

    if (popupText) {
      marker.bindPopup(popupText);
    }

    return marker;
  },

  addComplexMarker({ lat, lng, title, rating, comment, imageUrl, detailsUrl, cost, isPublic, isAccessible }) {
    if (!this.map) {
        console.error("O mapa ainda não foi inicializado.");
        return;
    }

    const accessibilityInfo = isAccessible ? "Acessível" : "Não acessível";
    const publicInfo = isPublic ? "Público" : "Privado";

    const formattedCost = cost ? `R$ ${cost.toFixed(2).replace('.', ',')}` : 'Gratuito';
    const truncatedComment = comment.length > 100 ? comment.substring(0, 50) + '...' : comment;
    const popupHtml = `
        <div style="max-width: 250px;" class="text-sm">
            <h4 class="font-bold mb-1">${title}</h4>
            <p class="text-yellow-500 mb-1">${'⭐'.repeat(rating)}${'☆'.repeat(5 - rating)}</p>
            <p class="text-gray-700 mb-2"><em>${truncatedComment}</em></p>
            <p class="text-gray-600 mb-1"><strong>Custo:</strong> ${formattedCost}</p>
            ${imageUrl ? `<img src="${imageUrl}" class="w-full rounded mb-2" alt="Foto do banheiro">` : ''}
            <p class="text-gray-600 mb-1"><strong>Tipo:</strong> ${publicInfo}</p>
            <p class="text-gray-600 mb-2"><strong>Acessibilidade:</strong> ${accessibilityInfo}</p>
            <a href="${detailsUrl}" class="text-purple-600 underline">Ver mais detalhes</a>
        </div>
    `;
    let options = {
      icon: this.icons.getRestroomIcon(isPublic, isAccessible, rating),
    };
    const marker = L.marker([lat, lng], options).addTo(this.map);
    marker.bindPopup(popupHtml);

    return marker;
  },

  setFilters(filters) {
    this.filters = filters;
  },

  fetchNearbyRestrooms() {
    let lat = this.lastPosition.lat;
    let lng = this.lastPosition.lng;
    let accessible = this.filters.accessible ?? '';
    let type = this.filters.type ?? '';

    const params = new URLSearchParams({lat, lng, accessible, type,});
    fetch(`/api/restrooms/nearby?${params.toString()}`)
      .then(response => response.json())
      .then(data => {
        this.markers.forEach(m => this.map.removeLayer(m));
        this.markers = [];

        data.forEach(restroom => {
            const { lat, lng, title, rating, comment, imageUrl, detailsUrl, isPublic, isAccessible } = restroom;
            const marker = this.addComplexMarker({ lat, lng, title, rating, comment, imageUrl, detailsUrl, isPublic, isAccessible });
            this.markers.push(marker);
        });
      });
  },

  watchUserLocation() {
    setInterval(() => {
      navigator.geolocation.getCurrentPosition(position => {
        const newLat = position.coords.latitude;
        const newLng = position.coords.longitude;

        const distanceMoved = this._calculateDistance(this.lastPosition.lat, this.lastPosition.lng, newLat, newLng);
        if (distanceMoved > 0.01) {
          this.lastPosition = { lat: newLat, lng: newLng };
          this.userMarker.setLatLng([newLat, newLng]);
          this.fetchNearbyRestrooms(newLat, newLng);
        }
      });
    }, 10000);
  },

  _calculateDistance(lat1, lon1, lat2, lon2) {
    const toRad = (val) => val * Math.PI / 180;
    const R = 6371;
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
  },

  setClickMarker(marker, callback) {
    this.map.on('click', function (e) {
        if (marker) marker.remove();
        marker = L.marker(e.latlng).addTo(map);
        callback(e.latlng.lat, e.latlng.lng);
    });
    return marker;
  }

};

export default IPoopMap;