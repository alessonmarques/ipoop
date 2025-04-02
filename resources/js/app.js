import './bootstrap';

import Alpine from 'alpinejs';
import IPoopMap from './ipoop-map';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById('map')) {
      IPoopMap.initMap();
    }
  });