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

          // Move the map to the user's location
          this.map.flyTo([userLat, userLng], ZOOM_TYPE.STREET);

          this.userMarker = L.marker([userLat, userLng])
            .addTo(this.map)
            .bindPopup("Você está aqui!")
            .openPopup();

            this.watchUserLocation();
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

  addOffCanvasMarker(lat, lng, restroom) {
    if (!this.map) {
      console.error("O mapa ainda não foi inicializado.");
      return;
    }

    const marker = L.marker([lat, lng], {
      icon: this.icons.getRestroomIcon(restroom.isPublic, restroom.isAccessible, restroom.rating)
    }).addTo(this.map);

    marker.on('click', () => {
      this.openBottomSheet(restroom);
    });

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

    const params = new URLSearchParams({lat, lng, accessible, type});
    fetch(`/api/restrooms/nearby?${params.toString()}`)
    .then(response => {
      if (response.status === 429) {
        console.warn('⏳ esperando próxima chance de request');
        return null;
      }
      return response.json();
    })
    .then(data => {
      if (!data) return; // skip 429

      // Clear previous markers
      this.restrooms = [];

      // Remove existing markers from the map
      this.markers.forEach(m => this.map.removeLayer(m));
      this.markers = [];

      // Add new markers
      data.forEach(restroom => {
        this.restrooms.push(restroom);
        const marker = this.addOffCanvasMarker(restroom.lat, restroom.lng, restroom);
        this.markers.push(marker);
      });
    })
    .catch(error => {
      console.error('Erro ao buscar banheiros próximos:', error);
    });
  },

  watchUserLocation() {
    setInterval(() => {
      navigator.geolocation.getCurrentPosition(position => {
        const newLat = position.coords.latitude;
        const newLng = position.coords.longitude;
        // Check if the user has moved significantly
        let distanceMoved = this._calculateDistance(this.lastPosition.lat, this.lastPosition.lng, newLat, newLng);
        distanceMoved = 1;
        if (distanceMoved >= 0.1) { // 100 meters
          // Update the user's last position
          this.lastPosition = { lat: newLat, lng: newLng };
          // Update the marker position
          this.userMarker.setLatLng([newLat, newLng]);
          // Fetch nearby restrooms again
          this.fetchNearbyRestrooms(newLat, newLng);
        }
      });
    }, 15000);
  },

  _calculateDistance(lat1, lon1, lat2, lon2, unit = 'km') {
    const toRad = (val) => val * Math.PI / 180;
    const R = 6371; // raio da Terra em km
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    const a = Math.sin(dLat/2) ** 2 +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
              Math.sin(dLon/2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const d = R * c;
    return unit === 'm' ? d * 1000 : d;
  },

  setClickMarker(marker, callback) {
    this.map.on('click', function (e) {
        if (marker) marker.remove();
        marker = L.marker(e.latlng).addTo(map);
        callback(e.latlng.lat, e.latlng.lng);
    });
    return marker;
  },

  openBottomSheet(restroom) {
    this.closeBottomSheet();

    const bottomSheet = document.getElementById('bathroomBottomSheet');
    const backDrop = document.getElementById('bottomSheetBackdrop');
    if (!bottomSheet) {
      console.error("Bottom sheet element not found.");
      return;
    }

    const bottomSheetHeader = document.getElementById('bottomSheetHeader');
    const title = document.getElementById('bottomSheetTitle');
    const accessibilityInfo = document.getElementById('accessibilityInfo');
    const commentList = document.getElementById('commentList');
    const restroomMeta = document.getElementById('restroomMeta');
    const detailsLink = document.getElementById('detailsLink');

    const wrapper = document.getElementById('swiperWrapper');
    if (!wrapper) {
      console.error("Swiper wrapper element not found.");
      return;
    }

    // Clear previous
    accessibilityInfo.innerHTML = '';
    commentList.innerHTML = '';
    restroomMeta.innerHTML = '';
    detailsLink.innerHTML = '';
    wrapper.innerHTML = '';

    // Title
    title.innerText = restroom.title ?? "Bathroom Details";

    if (restroom.imageUrls && restroom.imageUrls.length > 0) {
      let list = restroom.imageUrls.map(url => `
        <div class="swiper-slide">
          <img src="${url}" class="w-full h-48 object-cover" />
        </div>
      `).join('');
      // If there's only 1 image insert two of it.
      if (restroom.imageUrls.length === 1) {
        list += list;
      }
      wrapper.innerHTML = list;
    } else {
      wrapper.innerHTML = `
        <div class="swiper-slide flex items-center justify-center text-gray-400 bg-gray-100">
          No image available
        </div>
      `;
    }

    // Instanciar o swiper (após preencher o DOM)
    new Swiper('#imageCarousel', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
      },
    });

    // Accessibility
    accessibilityInfo.innerHTML = restroom.isAccessible
      ? '♿ Este banheiro é acessível.'
      : '⚠️ Este banheiro não está marcado como acessível.';


    // Reset classes
    bottomSheetHeader.classList.remove('bg-purple-700', 'bg-blue-700');
    if (restroom.isPublic) {
      bottomSheetHeader.classList.add('bg-blue-700');
    } else {
      bottomSheetHeader.classList.add('bg-purple-700');
    }

    // Rating, Public, Cost
    restroomMeta.innerHTML = `
      <p>⭐ Avaliação: ${restroom.rating == 0 && restroom.comments.length > 0 ? restroom.rating : 'Não Avaliado'} / 5</p>
      <p>💸 Custo: ${restroom.cost === "0.00" ? "Gratuito" : `R$ ${restroom.cost}`}</p>
      <p>${restroom.isPublic ? '🌐 Público' : '🔒 Privado'}</p>
    `;
    if (this.userMarker) {
      const userLatLng = this.userMarker.getLatLng();
      const distance = this._calculateDistance(userLatLng.lat, userLatLng.lng, restroom.lat, restroom.lng, 'm');

      const formattedDistance = distance < 1000
        ? `${Math.round(distance)} m`
        : `${(distance / 1000).toFixed(1)} km`;

      restroomMeta.innerHTML += `<p>📍 Aproximadamente ${formattedDistance} de distância</p>`;
    }
    // More details link
    if (restroom.detailsUrl) {
      detailsLink.innerHTML = `
        <a href="${restroom.detailsUrl}"
           class="inline-block mt-2 text-purple-600 hover:underline text-sm font-medium">
           🔍 Ver detalhes
        </a>
      `;
    }

    // Comments
    if (restroom.comments && restroom.comments.length > 0) {
      commentList.innerHTML = restroom.comments.map(comment => `
        <div class="p-3 bg-gray-100 rounded shadow-sm">
          <div class="flex justify-between items-center mb-1">
            <p class="text-sm font-medium text-purple-700">${comment.user}</p>
            <p class="text-sm text-yellow-500 font-semibold">⭐ ${comment.rating ?? '—'}</p>
          </div>
          <p class="text-sm text-gray-700">${comment.comment ?? 'Nenhum comentário fornecido.'}</p>
        </div>
      `).join('');
    } else {
      commentList.innerHTML = '<p class="text-sm text-gray-500">Nenhum comentário disponível.</p>';
    }

    bottomSheet.classList.remove('translate-y-full');
    backDrop.classList.remove('hidden');
  },

  recenterUser() {
    if (this.userMarker) {
      const latlng = this.userMarker.getLatLng();
      this.map.setView(latlng, ZOOM_TYPE.NEIGHBORHOOD);
    } else {
      console.warn("Localização do usuário ainda não disponível.");
    }
  },

  closeBottomSheet() {
    const bottomSheet = document.getElementById("bathroomBottomSheet");
    const backDrop = document.getElementById("bottomSheetBackdrop");
    if (bottomSheet) {
      bottomSheet.classList.add("translate-y-full");
      backDrop.classList.add("hidden");
    }
  }
};

export default IPoopMap;
