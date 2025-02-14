const icons = {
    kantor: L.divIcon({
        className: 'custom-marker',
        html: '<i class="fa fa-home fa-2x" style="color: #155E95"></i>',
        iconSize: [32, 32]
    }),
    batasWilayah: L.divIcon({
        className: 'custom-marker',
        html: '<i class="fa fa-archway fa-2x" style="color: black"></i>',
        iconSize: [32, 32]
    }),
    jenisLahan: L.divIcon({
        className: 'custom-marker',
        html: '<i class="fa fa-map-marked fa-2x" style="color: brown"></i>',
        iconSize: [32, 32]
    }),
    orbitDesa: L.divIcon({
        className: 'custom-marker',
        html: '<i class="fa fa-map-pin fa-2x" style="color: red"></i>',
        iconSize: [36, 36]
    }),
    wisata: L.divIcon({
        className: 'custom-marker',
        html: '<i class="fa fa-tree fa-2x" style="color: green"></i>',
        iconSize: [32, 32]
    })
};

function addLayerIfValid(lat, lng, marker) {
    if (lat !== null && lng !== null && !isNaN(lat) && !isNaN(lng)) {
        return marker;
    }
    console.warn(`Koordinat tidak valid: ${lat}, ${lng}`);
    return null;
}

const kantor = L.marker([lat, lng], { icon: icons.kantor }).bindPopup('Kantor Desa');

const batasWilayahMarkers = markBatasWilayah.map(item => 
    addLayerIfValid(
        parseFloat(item.latitude), 
        parseFloat(item.longitude),
        L.marker([item.latitude, item.longitude], {
            icon: icons.batasWilayah
        }).bindPopup(`Batas Wilayah Desa - ${item.nama}`)
    )
).filter(Boolean);

const jenisLahanMarkers = markJenisLahan.map(item =>
    addLayerIfValid(
        parseFloat(item.latitude),
        parseFloat(item.longitude),
        L.marker([item.latitude, item.longitude], {
            icon: icons.jenisLahan
        }).bindPopup(`Jenis Lahan - ${item.nama}`)
    )
).filter(Boolean);

const orbitDesaMarkers = markOrbitDesa.map(item =>
    addLayerIfValid(
        parseFloat(item.latitude),
        parseFloat(item.longitude),
        L.marker([item.latitude, item.longitude], {
            icon: icons.orbitDesa
        }).bindPopup(`Orbitasi - ${item.nama}`)
    )
).filter(Boolean);

const wisataMarkers = markWisata.map(item =>
    addLayerIfValid(
        parseFloat(item.latitude),
        parseFloat(item.longitude),
        L.marker([item.latitude, item.longitude], {
            icon: icons.wisata
        }).bindPopup(`Tempat Wisata - ${item.nama}`)
    )
).filter(Boolean);

// Create layer groups
const layers = {
    kantorDesa: L.layerGroup([kantor]),
    batasWilayah: L.layerGroup(batasWilayahMarkers),
    jenisLahan: L.layerGroup(jenisLahanMarkers),
    orbitDesa: L.layerGroup(orbitDesaMarkers),
    wisata: L.layerGroup(wisataMarkers)
};

// Create base map
const street = L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
    attribution: '',
    maxZoom: 23
});

// Initialize map
const map = L.map('layerControl', {
    center: [lat, lng],
    zoom: 12,
    layers: [street, ...Object.values(layers)]
});

// Configure layer controls
const baseMaps = {
    "Peta Desa": street
};

const overlayMaps = {
    'Kantor Desa': layers.kantorDesa,
    'Batas Desa': layers.batasWilayah,
    'Jenis Lahan': layers.jenisLahan,
    'Orbitasi': layers.orbitDesa,
    'Tempat Wisata': layers.wisata
};

L.control.layers(baseMaps, overlayMaps).addTo(map);