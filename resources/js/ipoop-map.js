import IPoopMapIcons from './ipoop-map-icons';

const ZOOM_TYPE = {
  NEIGHBORHOOD: 15,
  STREET: 18,
};

const IPoopMap = {
  map: null,
  bathrooms: [],
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

          // Load nearby bathrooms
          this.setNearBathroomsMocked();

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

  addComplexMarker({ lat, lng, title, rating, comment, imageUrl, detailsUrl, isPublic, isAccessible }) {
    if (!this.map) {
        console.error("O mapa ainda não foi inicializado.");
        return;
    }

    const accessibilityInfo = isAccessible ? "Acessível" : "Não acessível";
    const publicInfo = isPublic ? "Público" : "Privado";

    const popupHtml = `
        <div style="max-width: 250px;" class="text-sm">
            <h4 class="font-bold mb-1">${title}</h4>
            <p class="text-yellow-500 mb-1">${'⭐'.repeat(rating)}${'☆'.repeat(5 - rating)}</p>
            <p class="text-gray-700 mb-2"><em>${comment}</em></p>
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

  setNearBathrooms() {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;

        fetch('/api/bathrooms/nearby', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ latitude: userLat, longitude: userLng }),
        })
          .then(response => response.json())
          .then(data => {
            this.bathrooms = data;
            data.forEach(bathroom => {
              this.addComplexMarker(bathroom);
            });
          })
          .catch(err => {
            console.error("Erro ao buscar banheiros próximos:", err);
          });
      },
      (err) => {
        console.warn("Erro ao obter localização:", err.message);
      }
    );
  },

  setClickMarker(marker, callback) {
    this.map.on('click', function (e) {
        if (marker) marker.remove();
        marker = L.marker(e.latlng).addTo(map);
        callback(e.latlng.lat, e.latlng.lng);
    });
    return marker;
  },

  setNearBathroomsMocked() {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;

        const data = [
          {
            lat: userLat,
            lng: userLng,
            title: "Banheiro do Zé",
            rating: 4,
            comment: "Muito bom, recomendo!",
            imageUrl: "https://via.placeholder.com/250",
            detailsUrl: "#",
            isPublic: 0,
            isAccessible: 1,
          },
          {
            lat: userLat + 0.0001,
            lng: userLng + 0.0001,
            title: "Banheiro da Maria",
            rating: 3,
            comment: "Poderia ser melhor.",
            imageUrl: "https://via.placeholder.com/250",
            detailsUrl: "#",
            isPublic: 1,
            isAccessible: 0,
          },
          {
            lat: userLat - 0.0004,
            lng: userLng - 0.0009,
            title: "Banheiro do João",
            rating: 5,
            comment: "Perfeito!",
            imageUrl: "https://via.placeholder.com/250",
            detailsUrl: "#",
            isPublic: 0,
            isAccessible: 1,
          },
          {
            lat: userLat + 0.0007,
            lng: userLng - 0.0003,
            title: "Banheiro do Pedro",
            rating: 2,
            comment: "Precisa de melhorias.",
            imageUrl: "https://via.placeholder.com/250",
            detailsUrl: "#",
            isPublic: 1,
            isAccessible: 0,
          },
          {
            lat: userLat - 0.0005,
            lng: userLng - 0.0002,
            title: "Banheiro da Ana",
            rating: 5,
            comment: "Excelente, super limpo!",
            imageUrl: "https://via.placeholder.com/250",
            detailsUrl: "#",
            isPublic: 0,
            isAccessible: 1,
          },
          {
            lat: userLat + 0.0003,
            lng: userLng - 0.0001,
            title: "Banheiro do Carlos",
            rating: 3,
            comment: "Bom, mas pode melhorar.",
            imageUrl: "https://via.placeholder.com/250",
            detailsUrl: "#",
            isPublic: 1,
            isAccessible: 1,
          }
        ];

        data.forEach(bathroom => {
          this.addComplexMarker(bathroom);
        });
      },
      (err) => {
        console.warn("Erro ao obter localização:", err.message);
      }
    );
  }



};

export default IPoopMap;