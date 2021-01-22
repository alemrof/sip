const warehouseIconSrc = '../imgs/warehouse-icon-20px.png';
let selectedWarehouses = null;
let selectedWarehouseNumber = 0;

// Tworzenie źródła na podstawie danych przesłanych z bazy danych
let vectorSource = new ol.source.Vector();
for (let warehouse of warehouses) {
    let pointFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(warehouse.location.coordinates)),
        name: warehouse.name,
        company: warehouse.company.name,
        address: warehouse.address
    });
    pointFeature.setId(warehouse.id);
    vectorSource.addFeature(pointFeature);
}

let clusterSource = new ol.source.Cluster({
    distance: 20,
    source: vectorSource
});

let styleCache = {};
let clusterLayer = new ol.layer.Vector({
    source: clusterSource,
    style: function (feature) {
        let size = feature.get('features').length;
        let style = styleCache[size];
        if (!style) {
            style = new ol.style.Style({
                image: new ol.style.Icon({
                    src: warehouseIconSrc,
                }),
                // Alternatywny wygląd
                // image: new ol.style.Circle({
                //     radius: 10,
                //     stroke: new ol.style.Stroke({
                //         color: '#fff',
                //     }),
                //     fill: new ol.style.Fill({
                //         color: '#3399CC',
                //     }),
                // }),
                text: new ol.style.Text({
                    text: size.toString(),
                    font: '14px arial',
                    textAlign: 'center',
                    offsetY: -15,
                    fill: new ol.style.Fill({
                        color: '#000',
                    }),
                }),
            });
            styleCache[size] = style;
        }
        return style;
    },
});

// Tworzenie mapy
let gdansk = ol.proj.transform([18.65, 54.35], 'EPSG:4326', 'EPSG:3857');
let view = new ol.View({
    center: gdansk,
    zoom: 11
});
var map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }),
        clusterLayer
    ],
    view: view
});

// User position code start

var geolocation = new ol.Geolocation({
    tracking: true,
    // enableHighAccuracy must be set to true to have the heading value.
    trackingOptions: {
        enableHighAccuracy: true,
    },
    projection: view.getProjection()
});

var accuracyFeature = new ol.Feature();

geolocation.on('change:accuracyGeometry', function () {
    accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
});

var positionFeature = new ol.Feature();
positionFeature.setStyle(
    new ol.style.Style({
        image: new ol.style.Circle({
            radius: 6,
            fill: new ol.style.Fill({
                color: '#3399CC',
            }),
            stroke: new ol.style.Stroke({
                color: '#fff',
                width: 2,
            }),
        }),
    })
);

geolocation.on('change:position', function () {
    var coordinates = geolocation.getPosition();
    view.setCenter(coordinates);
    positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
});

new ol.layer.Vector({
    map: map,
    source: new ol.source.Vector({
        features: [accuracyFeature, positionFeature],
    }),
});

// User position code end


// Wyświetlanie elementu z danymi składu budowlanego
var popup = new ol.Overlay({
    positioning: 'bottom-center',
    offset: [0, -20],
    element: document.querySelector('#popup'),
    autoPan: true
})

map.addOverlay(popup);

// Zamykanie elementu z danymi składu budowlanego
let closer = document.querySelector('#closer');
closer.addEventListener('click', function (e) {
    popup.setPosition(undefined);
    selectedWarehouses = null;
    selectedWarehouseNumber = 0;
    return false;
});

function updatePopup(id) {
    let warehouse = selectedWarehouses[id];

    let warehouseName = document.querySelector('#warehouse-name');
    warehouseName.innerHTML = warehouse.get('name');

    let warehouseCompany = document.querySelector('#warehouse-company');
    warehouseCompany.innerHTML = warehouse.get('company');

    let warehouseAddress = document.querySelector('#warehouse-address');
    warehouseAddress.innerHTML = warehouse.get('address');

    let editLink = document.querySelector('#edit-link');
    editLink.href = `/warehouses/${warehouse.getId()}/edit`;

    let editMapLink = document.querySelector('#editMap-link');
    editMapLink.href = `/warehouses/${warehouse.getId()}/editMap`;
}

// Wybieranie składu
var select = new ol.interaction.Select({
    // condition: ol.events.condition.Click
});

map.addInteraction(select);

select.on('select', function (e) {
    if (e.target.getFeatures().item(0)) {
        selectedWarehouses = e.target.getFeatures().item(0).get('features');
        selectedWarehouseNumber = 0;

        if (selectedWarehouses) {
            let popupArrows = document.querySelector('#popupArrows');
            if (selectedWarehouses.length > 1) {
                popupArrows.classList.add('d-flex');
                popupArrows.classList.remove('d-none');
            } else {
                popupArrows.classList.add('d-none');
                popupArrows.classList.remove('d-flex');
            }

            let coordinates = e.target.getFeatures().item(0).getGeometry().getCoordinates();
            popup.setPosition(coordinates);
            updatePopup(selectedWarehouseNumber);

            let warehouseLocation = document.querySelector('#warehouse-location');
            let firstCoordinate = Math.round(ol.proj.toLonLat(coordinates)[0] * 100000) / 100000;
            let secondCoordinate = Math.round(ol.proj.toLonLat(coordinates)[1] * 100000) / 100000;
            warehouseLocation.innerHTML = firstCoordinate + ', ' + secondCoordinate;
        }
    } else {
        popup.setPosition(undefined);
        selectedWarehouseNumber = 0;
    }
});

// Dodawanie nowych składów
var draw = new ol.interaction.Draw({
    source: vectorSource,
    type: 'Point'
});

vectorSource.on('addfeature', function (e) {
    map.removeInteraction(draw);
});

// Przyciski umożliwające przełączenia danych w okienku po wybraniu klastru punktów
let showNextWarehouse = document.querySelector('#popupNextWarehouse');
showNextWarehouse.addEventListener('click', (e) => {
    e.preventDefault();
    if (selectedWarehouses.length > 1) {
        selectedWarehouseNumber = (selectedWarehouseNumber + 1) % selectedWarehouses.length;
        updatePopup(selectedWarehouseNumber);
    } else {
        selectedWarehouseNumber = 0;
    }
})

let showPreviousWarehouse = document.querySelector('#popupPreviousWarehouse');
showPreviousWarehouse.addEventListener('click', (e) => {
    e.preventDefault();
    if (selectedWarehouseNumber > 0) {
        selectedWarehouseNumber--;
        updatePopup(selectedWarehouseNumber);
    } else {
        selectedWarehouseNumber = selectedWarehouses.length - 1;
        updatePopup(selectedWarehouseNumber);
    }
})

