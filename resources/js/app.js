import './bootstrap';

import Alpine from 'alpinejs';
import IPoopMap from './ipoop-map';

window.Alpine = Alpine;
Alpine.start();

window.iPoop = window.iPoop || {};

document.addEventListener("DOMContentLoaded", () => {
  window.iPoop.map = IPoopMap;
});
