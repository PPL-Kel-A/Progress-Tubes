import './bootstrap';

// Import Leaflet CSS for map functionality
import 'leaflet/dist/leaflet.css';

// Import Leaflet library and make it globally available
import L from 'leaflet';
window.L = L;

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
