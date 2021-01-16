// Zmienne przechowujące nowe położenie edytowanego składu
let newWarehouseLocation = null;
let newWarehouseLon = document.querySelector('#newWarehouse-lon');
let newWarehouseLat = document.querySelector('#newWarehouse-lat');

// Zmienna przechowująca wyśrodkowanie mapy
let mapCenter = null;

// Tworzenie źródła na podstawie danych przesłanych z bazy danych
let vectorSource = new ol.source.Vector();
for(let warehouse of warehouses) {
    let pointFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(warehouse.location.coordinates)),
    });
    pointFeature.setId(warehouse.id);
    vectorSource.addFeature(pointFeature);
}

// Jeżeli edytowany skład ma już współrzędne to wyśrodkowujemy na nich mapę
if (vectorSource.getFeatureById(id)) {
    mapCenter = vectorSource.getFeatureById(id).getGeometry().getCoordinates();
} else {
    mapCenter = ol.proj.fromLonLat([18.65, 54.35]);
}

// Tworzenie warstwy wektorowej
var vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    style: new ol.style.Style({
        image: new ol.style.Icon({
            src: '../../imgs/warehouse-icon-20px.png'
        })
    })
})

// Tworzenie mapy
var map = new ol.Map({
    target: 'map',
    layers: [
    new ol.layer.Tile({
        source: new ol.source.OSM()
    }),
    vectorLayer
    ],
    view: new ol.View({
    center: mapCenter,
    zoom: 11
    })
});

// Wyświetlanie okienka do akceptacji nowego położenia
var popup = new ol.Overlay({
    positioning: 'bottom-center',
    offset: [0, -30],
    element: document.querySelector('#popup'),
    autoPan: true
})

map.addOverlay(popup);

// map.addInteraction(select);

// Edytowanie współrzędnych składu budowlanego
var draw = new ol.interaction.Draw({
    source: vectorSource,
    type: 'Point'
});

map.addInteraction(draw);

vectorSource.on('addfeature', function(e) {
    map.removeInteraction(draw);
    
    newWarehouseLocation = e.feature.getGeometry().getCoordinates();
    e.feature.setId(0);
    newWarehouseLat.value = ol.proj.toLonLat(newWarehouseLocation)[0];
    newWarehouseLon.value = ol.proj.toLonLat(newWarehouseLocation)[1];
    popup.setPosition(newWarehouseLocation);
});

// Anulowanie wybranego położenia i wznowienie rysowania
let cancelBtn = document.querySelector('#cancelBtn');

cancelBtn.addEventListener('click', function (e) {
    popup.setPosition(undefined);
    vectorSource.removeFeature(vectorSource.getFeatureById(0));
    map.addInteraction(draw);
})