
const IPoopMap = {
  map: null,
  bathrooms: [],

  initMap(containerId = 'map', defaultCoords = [-22.8742, -43.4686], defaultZoom = 13) {
    this.map = L.map(containerId).setView(defaultCoords, defaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(this.map);

    this.locateUser();
  },

  locateUser() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const userLat = position.coords.latitude;
          const userLng = position.coords.longitude;

          // Load nearby bathrooms
          // this.setNearBathrooms();

          // Move the map to the user's location
          this.map.setView([userLat, userLng], 15);

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

  addComplexMarker({ lat, lng, title, rating, comment, imageUrl, detailsUrl }) {
    if (!this.map) {
      console.error("O mapa ainda não foi inicializado.");
      return;
    }

    const popupHtml = `
      <div style="max-width: 250px;" class="text-sm">
        <h4 class="font-bold mb-1">${title}</h4>
        <p class="text-yellow-500 mb-1">${'⭐'.repeat(rating)}${'☆'.repeat(5 - rating)}</p>
        <p class="text-gray-700 mb-2"><em>${comment}</em></p>
        ${imageUrl ? `<img src="${imageUrl}" class="w-full rounded mb-2" alt="Foto do banheiro">` : ''}
        <a href="${detailsUrl}" class="text-purple-600 underline">Ver mais detalhes</a>
      </div>
    `;

    const marker = L.marker([lat, lng]).addTo(this.map);
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
  }


};

export default IPoopMap;