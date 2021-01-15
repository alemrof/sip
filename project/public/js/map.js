// Tworzenie źródła na podstawie danych przesłanych z bazy danych
let vectorSource = new ol.source.Vector();
for(let warehouse of warehouses) {
    let pointFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(warehouse.location.coordinates)),
    });
    pointFeature.setId(warehouse.id);
    vectorSource.addFeature(pointFeature);
}

// Tworzenie warstwy wektorowej
var vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    style: new ol.style.Style({
        image: new ol.style.Icon({
            src: '../imgs/warehouse-icon-20px.png'
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
    center: ol.proj.fromLonLat([18.65, 54.35]),
    zoom: 11
    })
});

// Wyświetlanie elementu z danym składu budowlanego
var popup = new ol.Overlay({
    // position: pos,
    positioning: 'center-center',
    element: document.querySelector('#popup'),
    autoPan: true
})

map.addOverlay(popup);

// Zamykanie elementu z danymi składu budowlanego
let closer = document.querySelector('#closer');
closer.addEventListener('click', function(e){
    popup.setPosition(undefined);
    return false;
});

// Wybieranie składu
var select = new ol.interaction.Select({
    // condition: ol.events.condition.Click
});

map.addInteraction(select);

function findWarehouse(id) {
    for(let warehouse of warehouses) {
        if (warehouse.id == id) {
            return warehouse;
        }
    }
    return null;
}

select.on('select', function(e) {
    let selectedWarehouse = findWarehouse(e.target.getFeatures().item(0).getId())
    if (selectedWarehouse !== null) {
        let coordinates = e.target.getFeatures().item(0).getGeometry().getCoordinates();
        popup.setPosition(coordinates);

        let warehouseName = document.querySelector('#warehouse-name');
        warehouseName.innerHTML = selectedWarehouse.name;
        let warehouseCompany = document.querySelector('#warehouse-company');
        warehouseCompany.innerHTML = selectedWarehouse.company.name;
        let warehouseLocation = document.querySelector('#warehouse-location');
        warehouseLocation.innerHTML = selectedWarehouse.location.coordinates;
        let editLink = document.querySelector('#edit-link');
        editLink.href = `http://localhost:8000/admin/warehouses/${selectedWarehouse.id}/edit`;
    }
});


// Dodawanie nowych składów
var draw = new ol.interaction.Draw({
    source: vectorSource,
    type: 'Point'
});
  
vectorSource.on('addfeature', function(e) {
    map.removeInteraction(draw);
})
  
let addWarehouse = document.querySelector('#addWarehouse');
addWarehouse.addEventListener('click', function (e) {
    map.addInteraction(draw);
})

let stopDrawing = document.querySelector('#stopDrawing');
stopDrawing.addEventListener('click', function (e) {
    map.removeInteraction(draw);
    // map.removeInteraction(snap);
})

