@props(['selectedTpsId' => null])

<div class="space-y-4">
    <!-- Map Container -->
    <div class="rounded-lg border border-gray-300 overflow-hidden shadow-md">
        <div id="map" {{ $attributes->merge(['class' => 'w-full h-96 bg-gray-200']) }}></div>
    </div>

    <!-- Selected Location Info -->
    <div id="location-info" class="hidden bg-blue-50 p-4 rounded-lg border border-blue-200">
        <p class="text-sm font-semibold text-blue-900">Lokasi Terpilih:</p>
        <p id="selected-location-name" class="text-blue-700 mt-1"></p>
        <p id="selected-location-coords" class="text-xs text-blue-600 mt-1"></p>
    </div>

    <!-- Distance Info (shown after geolocation) -->
    <!-- Removed: no longer using geolocation -->

    <!-- Hidden input to store selected TPS ID -->
    <input type="hidden" id="tps_id" name="tps_id" value="{{ $selectedTpsId }}">

    <!-- Map Loading Indicator -->
    <div id="map-loading" class="hidden text-center py-4">
        <div class="inline-block">
            <div class="animate-spin h-8 w-8 border-4 border-blue-500 border-t-transparent rounded-full"></div>
        </div>
        <p class="text-gray-600 text-sm mt-2">Memuat data TPS...</p>
    </div>

    <!-- Map Error Message -->
    <div id="map-error" class="hidden bg-red-50 p-4 rounded-lg border border-red-200 text-red-700 text-sm"></div>
</div>

@pushOnce('scripts')
<script>
    console.log('🔍 map-picker script starting...');
    
    // Create custom pinpoint icons (SVG-based)
    function createPinpointIcon(color) {
        // SVG pinpoint icon - simple and reliable
        const svg = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 32">
                <defs>
                    <style>
                        .pin { fill: ${color}; }
                        .inner { fill: white; }
                    </style>
                </defs>
                <path class="pin" d="M12 0C5.9 0 1 4.9 1 11c0 8 11 21 11 21s11-13 11-21c0-6.1-4.9-11-11-11z"/>
                <circle class="inner" cx="12" cy="10" r="4"/>
            </svg>
        `;
        
        const blob = new Blob([svg], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(blob);
        
        return L.icon({
            iconUrl: url,
            iconSize: [24, 32],
            iconAnchor: [12, 32],
            popupAnchor: [0, -32]
        });
    }
    
    // Color palette for pinpoint icons
    const pinpointColors = {
        blue: '#2563eb',
        green: '#16a34a',
        red: '#dc2626'
    };

    console.log('🔍 map-picker script starting...');
    
    // Initialize map immediately when document & Leaflet ready
    function initMapWhenReady() {
        console.log('⏳ Checking readiness... DOM:', document.readyState, 'L:', typeof L);
        
        // Check if Leaflet is loaded
        if (typeof L === 'undefined') {
            console.log('⏳ Waiting for Leaflet...');
            setTimeout(initMapWhenReady, 100);
            return;
        }

        // Check if DOM element exists
        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.log('⏳ Waiting for map DOM element...');
            setTimeout(initMapWhenReady, 100);
            return;
        }

        console.log('✅ ALL READY! Starting initializeMap...');
        initializeMap();
    }

    // Start initialization
    // Try multiple triggers to ensure it runs
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMapWhenReady);
    }
    // Also start immediately in case DOM is already ready
    setTimeout(initMapWhenReady, 50);


    function initializeMap() {
        // Leaflet is now available globally
        if (typeof L === 'undefined') {
            console.error('❌ Leaflet not loaded. Make sure resources/js/app.js includes Leaflet.');
            console.error('window.L:', window.L);
            console.error('Available window keys:', Object.keys(window).filter(k => k.includes('leaf') || k.includes('L')));
            return;
        }

        console.log('🗺️ Initializing map...');
        console.log('✅ Leaflet object:', L);
        console.log('✅ Leaflet version:', L.version);

        // Initialize map
        const map = L.map('map').setView([-6.2, 106.8], 13);

        // Add tile layer from OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        // Marker references
        let tpsMarkers = [];
        let selectedTpsMarker = null;

        // Element references
        const mapElement = document.getElementById('map');
        const locationInfo = document.getElementById('location-info');
        const mapLoading = document.getElementById('map-loading');
        const mapError = document.getElementById('map-error');
        const tpsIdInput = document.getElementById('tps_id');
        const tpsDropdown = document.getElementById('tps');

        // Store collection points globally for dropdown handler
        let collectionPointsData = [];

        // ========================
        // FETCH TPS DATA
        // ========================
        async function fetchCollectionPoints() {
            try {
                console.log('📡 Fetching collection points...');
                mapLoading.classList.remove('hidden');
                mapError.classList.add('hidden');

                const response = await fetch('/api/collection-points');
                console.log('📍 API Response status:', response.status);
                console.log('📍 API Response headers:', response.headers);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ API Error Response:', errorText);
                    throw new Error('API returned ' + response.status + ': ' + errorText);
                }

                const data = await response.json();
                console.log('✅ API Response data:', data);
                
                if (!data.success) throw new Error('Invalid API response: success=false');

                console.log('✅ Fetched collection points:', data.data.length);
                return data.data;
            } catch (error) {
                console.error('❌ Error fetching collection points:', error);
                console.error('❌ Full error details:', error.message, error.stack);
                mapError.textContent = '❌ Gagal memuat data TPS. Error: ' + error.message;
                mapError.classList.remove('hidden');
                return [];
            } finally {
                mapLoading.classList.add('hidden');
            }
        }

        // ========================
        // DISPLAY TPS MARKERS
        // ========================
        async function displayTpsMarkers() {
            const collectionPoints = await fetchCollectionPoints();
            collectionPointsData = collectionPoints; // Store globally for dropdown handler
            console.log('📍 Displaying markers for', collectionPoints.length, 'points');

            collectionPoints.forEach((point) => {
                const marker = L.marker([point.latitude, point.longitude], {
                    icon: createPinpointIcon(pinpointColors.blue)
                }).addTo(map);  // ✅ TAMBAH KE MAP!

                const popupContent = `
                    <div class="font-semibold text-gray-900">${point.name}</div>
                    <p class="text-sm text-gray-600">${point.address}</p>
                    <p class="text-xs text-gray-500 mt-2">${point.desa}, ${point.kecamatan}, ${point.kota}</p>
                    <button class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm py-1 rounded select-tps-btn" data-tps-id="${point.id}" data-tps-name="${point.name}">
                        Pilih TPS Ini
                    </button>
                `;

                marker.bindPopup(popupContent);
                marker.on('click', function() {
                    // Auto-select this TPS when marker is clicked - pass full point data
                    selectTps(point);
                    if (tpsDropdown) {
                        tpsDropdown.value = point.name;
                    }
                    // Then open popup for info
                    marker.openPopup();
                });

                tpsMarkers.push({ id: point.id, marker });
            });
        }

        // ========================
        // SELECT TPS FROM MARKER
        // ========================
        function selectTps(pointOrId, tpsName) {
            // Support both object and legacy (id, name) parameters
            let point, tpsId;
            
            if (typeof pointOrId === 'object' && pointOrId !== null) {
                // New: passing full point object
                point = pointOrId;
                tpsId = point.id;
                tpsName = point.name;
            } else {
                // Legacy: passing just id and name
                tpsId = pointOrId;
                // Find the point in collection data
                point = collectionPointsData.find(p => p.id == tpsId);
            }
            
            tpsIdInput.value = tpsId;

            // Update location info
            document.getElementById('selected-location-name').textContent = tpsName;
            document.getElementById('selected-location-coords').textContent = `${point?.address || 'ID: ' + tpsId}`;
            locationInfo.classList.remove('hidden');

            // Auto-fill form fields from map selection
            autoFillFormFromLocation(point);

            console.log('✅ Selected TPS:', tpsName, point);

            // Highlight selected marker
            tpsMarkers.forEach(({ id, marker }) => {
                if (id == tpsId) {
                    marker.setIcon(createPinpointIcon(pinpointColors.green));
                    selectedTpsMarker = marker;
                    map.flyTo(marker.getLatLng(), 15);
                } else {
                    marker.setIcon(createPinpointIcon(pinpointColors.blue));
                }
            });
        }
        
        // ========================
        // AUTO-FILL FORM FROM SELECTION
        // ========================
        function autoFillFormFromLocation(point) {
            if (!point) return;
            
            // Set TPS dropdown
            if (tpsDropdown) {
                tpsDropdown.value = point.name;
            }
            
            // Auto-fill location fields if they exist
            const desaField = document.querySelector('select[name="desa"]');
            const kecamatanField = document.querySelector('select[name="kecamatan"]');
            const kotaField = document.querySelector('select[name="kota"]');
            const desaBox = document.getElementById('desaBox');
            const kecamatanBox = document.getElementById('kecamatanBox');
            const kotaBox = document.getElementById('kotaBox');
            
            if (desaField && point.desa) {
                desaField.value = point.desa;
                if (desaBox) desaBox.classList.remove('hidden');
            }
            
            if (kecamatanField && point.kecamatan) {
                kecamatanField.value = point.kecamatan;
                if (kecamatanBox) kecamatanBox.classList.remove('hidden');
            }
            
            if (kotaField && point.kota) {
                kotaField.value = point.kota;
                if (kotaBox) kotaBox.classList.remove('hidden');
            }
            
            console.log('📋 Form auto-filled with:', { desa: point.desa, kecamatan: point.kecamatan, kota: point.kota });
            
            // Trigger form validation
            if (typeof validateForm === 'function') {
                validateForm();
            }
        }

        // ========================
        // EVENT LISTENERS
        // ========================

        // Select TPS from popup button
        mapElement.addEventListener('click', function(e) {
            if (e.target.classList.contains('select-tps-btn')) {
                const tpsId = e.target.getAttribute('data-tps-id');
                // Find the full point data to pass to selectTps
                const matchedPoint = collectionPointsData.find(p => p.id == tpsId);
                if (matchedPoint) {
                    selectTps(matchedPoint);
                } else {
                    // Fallback to legacy method
                    selectTps(tpsId, e.target.getAttribute('data-tps-name'));
                }
            }
        }, true);

        // Dropdown change handler - when user selects from "Atau Pilih dari Daftar"
        if (tpsDropdown) {
            tpsDropdown.addEventListener('change', function() {
                const selectedTpsName = this.value;
                if (!selectedTpsName) return; // Empty selection

                // Find matching TPS in collection points data
                const matchedTps = collectionPointsData.find(
                    point => point.name.toLowerCase().includes(selectedTpsName.toLowerCase()) 
                    || selectedTpsName.toLowerCase().includes(point.name.toLowerCase())
                );

                if (matchedTps) {
                    console.log('✅ Found TPS from dropdown:', matchedTps.name);
                    selectTps(matchedTps);
                } else {
                    console.warn('⚠️ No matching TPS found for:', selectedTpsName);
                }
            });
        }

        // ========================
        // INITIALIZE MAP
        // ========================
        console.log('🚀 Starting to display TPS markers...');
        displayTpsMarkers();
    }
</script>
@endPushOnce

@pushOnce('styles')
<style>
    /* Leaflet CSS overrides */
    .leaflet-container {
        font-family: inherit;
    }

    .leaflet-popup-content {
        margin: 0;
        width: auto;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 0.5rem;
    }
</style>
@endPushOnce
