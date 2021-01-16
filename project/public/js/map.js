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
let vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    style: new ol.style.Style({
        image: new ol.style.Icon({
            src: '../imgs/warehouse-icon-20px.png'
        })
    })
})

let clusterSource = new ol.source.Cluster({
    distance: 20,
    source: vectorSource
});

let styleCache = {};
let clusterLayer = new ol.layer.Vector({
    source: clusterSource,
    style: function(feature) {
        let size = feature.get('features').length;
        let style = styleCache[size];
        if (!style) {
            style = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 10,
                    stroke: new ol.style.Stroke({
                        color: '#fff',
                    }),
                    fill: new ol.style.Fill({
                        color: '#3399CC',
                    }),
                }),
                text: new ol.style.Text({
                    text: size.toString(),
                    fill: new ol.style.Fill({
                        color: '#fff',
                    }),
                }),
            });
            styleCache[size] = style;
        }
        return style;
    },
});

// Tworzenie mapy
var map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }),
        vectorLayer,
        // clusterLayer,
    ],
    view: new ol.View({
    center: ol.proj.fromLonLat([18.65, 54.35]),
    zoom: 11
    })
});

// Wyświetlanie elementu z danym składu budowlanego
var popup = new ol.Overlay({
    positioning: 'bottom-center',
    offset: [0, -20],
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
    // for (let i = 0; i < e.target.getFeatures().item(0).get('features').length; i++) {
    //     console.log(e.target.getFeatures().item(0).get('features')[i].getId());
    // }
    if (e.target.getFeatures().item(0)) {
        let selectedWarehouse = findWarehouse(e.target.getFeatures().item(0).getId())
        if (selectedWarehouse !== null) {
            let coordinates = e.target.getFeatures().item(0).getGeometry().getCoordinates();
            popup.setPosition(coordinates);
            let warehouseName = document.querySelector('#warehouse-name');
            warehouseName.innerHTML = selectedWarehouse.name;
            let warehouseCompany = document.querySelector('#warehouse-company');
            warehouseCompany.innerHTML = selectedWarehouse.company.name;
            let warehouseLocation = document.querySelector('#warehouse-location');
            let firstCoordinate = Math.round(selectedWarehouse.location.coordinates[0] * 100000) / 100000;
            let secondCoordinate = Math.round(selectedWarehouse.location.coordinates[1] * 100000) / 100000;
            warehouseLocation.innerHTML = firstCoordinate + ', ' + secondCoordinate;
            
            let editLink = document.querySelector('#edit-link');
            editLink.href = `http://localhost:8000/warehouses/${selectedWarehouse.id}/edit`;

            let editMapLink = document.querySelector('#editMap-link');
            editMapLink.href = `http://localhost:8000/warehouses/${selectedWarehouse.id}/editMap`;
        }
    } else {
        popup.setPosition(undefined);
    }
    
});

// Dodawanie nowych składów
var draw = new ol.interaction.Draw({
    source: vectorSource,
    type: 'Point'
});

vectorSource.on('addfeature', function(e) {
    map.removeInteraction(draw);
});