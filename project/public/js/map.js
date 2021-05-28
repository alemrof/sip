const warehouseIconSrc = '../imgs/warehouse-icon-20px.png';
const params = new URLSearchParams(window.location.search);
let selectedWarehouses = [];
let selectedWarehouseNumber = 0;
let userCoordinates = [18.65, 54.35];

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

let routeSource = new ol.source.Vector();
let routeLayer = new ol.layer.Vector({
    source: routeSource,
    style: new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: '#0066ff',
            width: 3,
        }),
    })
})

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
        clusterLayer,
        routeLayer
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
    userCoordinates = ol.proj.toLonLat(coordinates);
    if (selectedWarehouses.length < 1) {
        view.setCenter(coordinates);
    }
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
    selectedWarehouses = [];
    selectedWarehouseNumber = 0;
    routeSource.clear();
    return false;
});

function updatePopup(id) {
    let warehouse = selectedWarehouses[id];
    let coordinates = warehouse.getGeometry().getCoordinates();

    let warehouseName = document.querySelector('#warehouse-name');
    warehouseName.innerHTML = warehouse.get('name');

    let warehouseCompany = document.querySelector('#warehouse-company');
    warehouseCompany.innerHTML = warehouse.get('company');

    let warehouseAddress = document.querySelector('#warehouse-address');
    warehouseAddress.innerHTML = warehouse.get('address');

    // Warehouse Hours Tab
    let hours = openingHours.filter(e => e.warehouse_id === warehouse.id_);
    let days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
    days.forEach(function (day) {
        let dayHours = hours.filter(e => e.weekday == day)[0];
        document.querySelector("#" + day + "-hours").innerHTML = formatHours(dayHours.start_hour, dayHours.end_hour);
    });

    let warehouseLocation = document.querySelector('#warehouse-location');
    let firstCoordinate = Math.round(ol.proj.toLonLat(coordinates)[0] * 100000) / 100000;
    let secondCoordinate = Math.round(ol.proj.toLonLat(coordinates)[1] * 100000) / 100000;
    warehouseLocation.innerHTML = firstCoordinate + ', ' + secondCoordinate;

    let offerLink = document.querySelector('#offer-link');
    if (offerLink) offerLink.href = `/warehouses/${warehouse.getId()}/offer`;

    let editLink = document.querySelector('#edit-link');
    if (editLink) editLink.href = `/warehouses/${warehouse.getId()}/edit`;

    let editMapLink = document.querySelector('#editMap-link');
    if (editMapLink) editMapLink.href = `/warehouses/${warehouse.getId()}/editMap`;

    popup.setPosition(coordinates);
}

function formatHours(start, end) {
    return start.substring(0, 5) + "-" + end.substring(0, 5);
}

let routeLink = document.querySelector('#route-link');
routeLink.addEventListener('click', function (e) {
    e.preventDefault();
    warehouse = selectedWarehouses[selectedWarehouseNumber];
    if (warehouse) {
        let request = new XMLHttpRequest();
        request.open('POST', "https://api.openrouteservice.org/v2/directions/driving-car");

        request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
        request.setRequestHeader('Content-Type', 'application/json');
        request.setRequestHeader('Authorization', '5b3ce3597851110001cf6248d497e3ae60ae4e0da2dddd72b6f0a3ac');

        request.onreadystatechange = function () {
            if (this.readyState === 4) {
                let result = JSON.parse(this.responseText);
                let polyline = result.routes[0].geometry;
                let route = new ol.format.Polyline({
                }).readGeometry(polyline, {
                    dataProjection: 'EPSG:4326',
                    featureProjection: 'EPSG:3857'
                });
                let routeFeature = new ol.Feature({
                    geometry: route
                });
                routeSource.addFeature(routeFeature);
            }
        };
        let warehouseCoordinates = ol.proj.toLonLat(warehouse.getGeometry().getCoordinates());
        const body = `{"coordinates":[[${userCoordinates[0]}, ${userCoordinates[1]}],[${warehouseCoordinates[0]},${warehouseCoordinates[1]}]]}`;

        request.send(body);
    }
})

// Wybieranie składu
var select = new ol.interaction.Select({
    // condition: ol.events.condition.Click
});

map.addInteraction(select);

select.on('select', function (e) {
    routeSource.clear();
    if (e.target.getFeatures().item(0)) {
        selectedWarehouseNumber = 0;

        if (e.target.getFeatures().item(0).get('features')) {
            selectedWarehouses = e.target.getFeatures().item(0).get('features');
        }

        if (selectedWarehouses) {
            let popupArrows = document.querySelector('#popupArrows');
            if (selectedWarehouses.length > 1) {
                popupArrows.classList.add('d-flex');
                popupArrows.classList.remove('d-none');
            } else {
                popupArrows.classList.add('d-none');
                popupArrows.classList.remove('d-flex');
            }

            updatePopup(selectedWarehouseNumber);
        }
    } else {
        popup.setPosition(undefined);
        selectedWarehouseNumber = 0;
        select.getFeatures().clear();
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

let warehouseSearch = document.querySelector('#warehouse-search-form');
warehouseSearch.addEventListener('submit', (e) => {
    e.preventDefault() // Stom form submission
    let warehouseSearchName = document.querySelector('#warehouse-search-name');
    let serachedWarehouse = warehouseSearchName.value;
    selectedWarehouses = [];
    select.getFeatures().clear();

    for (let warehouse of warehouses) {
        if (warehouse.name.includes(serachedWarehouse)) {
            selectedWarehouses.push(vectorSource.getFeatureById(warehouse.id));
            select.getFeatures().push(vectorSource.getFeatureById(warehouse.id));
        }
    }
    if (selectedWarehouses.length > 0) {
        select.dispatchEvent('select');
    } else {
        warehouseSearchName.value = "";
    }
    return false; // stop form submission
}, false);

if (params.has('id')) {
    const id = params.get('id');
    selectedWarehouses = [];
    select.getFeatures().clear();
    if (vectorSource.getFeatureById(id)) {
        selectedWarehouses.push(vectorSource.getFeatureById(id));
        select.getFeatures().push(vectorSource.getFeatureById(id));
        select.dispatchEvent('select');
        view.setCenter(selectedWarehouses[0].getGeometry().getCoordinates());
    }
}

function send(form) {
    let productSearchName = document.querySelector('#product-search-name');
    let searchedproduct = productSearchName.value;
    let ChosenWarehouses=[];
    let whWithLowPrice = null;
    for (let prod of products) {
        if (deepEqual(prod.name, searchedproduct)) {
            if (whWithLowPrice == null)
                whWithLowPrice = prod;
            else {
                if (prod.price <= whWithLowPrice.price)
                    whWithLowPrice = prod;
            }
        }
    }
    $("#secret").val(whWithLowPrice.warehouse_id)


    //alert('Please correct the errors in the form and js!');
}

function deepEqual(object1, object2) {
    const keys1 = Object.keys(object1);
    const keys2 = Object.keys(object2);

    if (keys1.length !== keys2.length) {
        return false;
    }

    for (const key of keys1) {
        const val1 = object1[key];
        const val2 = object2[key];
        const areObjects = isObject(val1) && isObject(val2);
        if (
            areObjects && !deepEqual(val1, val2) ||
            !areObjects && val1 !== val2
        ) {
            return false;
        }
    }

    return true;
}

function isObject(object) {
    return object != null && typeof object === 'object';
}

