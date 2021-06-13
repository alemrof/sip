const warehouseIconSrc = '../imgs/warehouse-icon-20px.png';
const posIconSrc = '../imgs/pos-icon-20px.png';
const params = new URLSearchParams(window.location.search);
let selectedWarehouses = [];
let intermediatePoints = [];
let selectedWarehouseNumber = 0;
let posChange=false;

$('#coord-x').val(userCoordinates[0]);
$('#coord-y').val(userCoordinates[1]);
$('#coordsText1').val(userCoordinates[0]);
$('#coordsText2').val(userCoordinates[1]);

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
    style: function (feature) {
        return new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: '#0066ff',
                width: 3,
            }),
            text: new ol.style.Text({
                text: `${feature.get("routeLength").toString()} m`,
                font: 'bold 14px arial',
                textAlign: 'center',
                offsetY: -15,
                fill: new ol.style.Fill({
                    color: '#0066ff',
                }),
            }),
        })
    }
})

let userSource = new ol.source.Vector();
let userLayer = new ol.layer.Vector({
    source: userSource,
    style: new ol.style.Style({
        image: new ol.style.Circle({
            radius: 4,
            stroke: new ol.style.Stroke({
                color: '#a60e03',
            }),
            fill: new ol.style.Fill({
                color: '#bf382e',
            }),
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
        routeLayer,
        userLayer
    ],
    view: view
});

// User position code start

// var geolocation = new ol.Geolocation({
//     tracking: true,
//     // enableHighAccuracy must be set to true to have the heading value.
//     trackingOptions: {
//         enableHighAccuracy: true,
//     },
//     projection: view.getProjection()
// });

// var accuracyFeature = new ol.Feature();

// geolocation.on('change:accuracyGeometry', function () {
//     accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
// });

// var positionFeature = new ol.Feature();
// positionFeature.setStyle(
//     new ol.style.Style({
//         image: new ol.style.Circle({
//             radius: 6,
//             fill: new ol.style.Fill({
//                 color: '#3399CC',
//             }),
//             stroke: new ol.style.Stroke({
//                 color: '#fff',
//                 width: 2,
//             }),
//         }),
//     })
// );

// geolocation.on('change:position', function () {
//     var coordinates = geolocation.getPosition();
//     userCoordinates = ol.proj.toLonLat(coordinates);
//     if (selectedWarehouses.length < 1) {
//         view.setCenter(coordinates);
//     }
//     positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
// });

// new ol.layer.Vector({
//     map: map,
//     source: new ol.source.Vector({
//         features: [accuracyFeature, positionFeature],
//     }),
// });

// User position code end


// Wyświetlanie elementu z danymi składu budowlanego
var popup = new ol.Overlay({
    positioning: 'bottom-center',
    offset: [0, -20],
    element: document.querySelector('#popup'),
    autoPan: true
})

map.addOverlay(popup);

let popupElement = document.querySelector('#popup').parentElement;
draggable(popupElement);

// Zamykanie elementu z danymi składu budowlanego
let closer = document.querySelector('#closer');
closer.addEventListener('click', function (e) {
    popup.setPosition(undefined);
    selectedWarehouses = [];
    selectedWarehouseNumber = 0;
    routeSource.clear();
    resetDraggablePosition(popupElement);
    return false;
});

function updatePopup(id) {
    let warehouse = selectedWarehouses[id];
    let coordinates = warehouse.getGeometry().getCoordinates();

    let warehouseName = document.querySelector('#warehouse-name');
    warehouseName.innerHTML = warehouse.get('name');
    warehouseName.href = `/warehouses/${warehouse.getId()}`;

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
                console.log(result);
                let polyline = result.routes[0].geometry;
                let route = new ol.format.Polyline({
                }).readGeometry(polyline, {
                    dataProjection: 'EPSG:4326',
                    featureProjection: 'EPSG:3857'
                });
                let routeFeature = new ol.Feature({
                    geometry: route,
                    routeLength: result.routes[0].summary.distance
                });
                routeSource.addFeature(routeFeature);
            }
        };
        
        let body = `{"coordinates":[[${userCoordinates[0]}, ${userCoordinates[1]}],`
        for (let point of intermediatePoints)
        {
            pointCoordinates = ol.proj.transform(point.getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326');
            body += `[${pointCoordinates[0]}, ${pointCoordinates[1]}],`
        }
        let warehouseCoordinates = ol.proj.toLonLat(warehouse.getGeometry().getCoordinates());
        body += `[${warehouseCoordinates[0]},${warehouseCoordinates[1]}]]}`;
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
    resetDraggablePosition(popupElement);

    if (e.target.getFeatures().item(0)) {
        if (e.target.getFeatures().item(0).get('name') == "Intermediate Point") {
            pointContextmenuObject = e.target.getFeatures().item(0);
            pointContextmenu.setPosition(pointContextmenuObject.getGeometry().getCoordinates());
        }
        else {
            selectedWarehouseNumber = 0;

            if (e.target.getFeatures().item(0).get('features')) {
                
                selectedWarehouses = e.target.getFeatures().item(0).get('features');
            }

            if (selectedWarehouses.length > 0) {
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

//Porownywanie dwoch objektow
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

//Ustawianie pozycji na mapie

self.map.on("singleclick", function(evt){
    if (posChange==true)
        setPinOnMap(evt);
})

function setPinOnMap(evt){
    var self = this;
    console.log(evt);
    var latLong = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
    var lat     = latLong[1];
    var long    = latLong[0];
    userCoordinates= latLong;
    $('#coordsText1').val(userCoordinates[0]);
    $('#coordsText2').val(userCoordinates[1]);

    if(self.dinamicPinLayer !== undefined){
        console.log("moove")
        self.iconGeometry.setCoordinates(evt.coordinate);
        //or create another pin
    } else {
        self.iconGeometry = new ol.geom.Point(evt.coordinate);
        var iconFeature = new ol.Feature({
            geometry: self.iconGeometry,
            name: 'Null'

        });
        var iconStyle = new ol.style.Style({
            image: new ol.style.Icon(({
                anchor: [0.1, 0.1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'pixels',
                size: [24, 24],
                opacity: 1,
                src: posIconSrc
            }))
        });

        iconFeature.setStyle(iconStyle);

        var vectorSource = new ol.source.Vector({
            features: [iconFeature]
        });
        self.dinamicPinLayer = new ol.layer.Vector({
            source: vectorSource
        });
        self.map.addLayer(self.dinamicPinLayer);
    }
}

// Inicjalne ustawienie pozycji użytkownika
setPinOnMap({coordinate: ol.proj.transform(userCoordinates, 'EPSG:4326', 'EPSG:3857')});

function posButtonChange(button){
    if (posChange == false)
        posChange=true;
    else if (posChange == true)
        posChange=false;
}

$(document).ready(function (){
    $('#change-button').on('click', function (){
        var text = $('#change-button').text();
        if (text == "Ustaw nowa pozycje"){
            $(this).text('Zakończ ustawianie')
            $('#coordsText2').addClass("d-none")
            $('#coordsText1').addClass("d-none")
            $('#warehouse-search-name').addClass("d-none")
            $('#warehouse-search-button').addClass("d-none")
            $('#update-coords-button').addClass("d-none")
        }
        else{
            $(this).text('Ustaw nowa pozycje');
        $('#coordsText2').removeClass('d-none')
        $('#coordsText1').removeClass('d-none')
        $('#warehouse-search-name').removeClass('d-none')
        $('#warehouse-search-button').removeClass('d-none')
        $('#update-coords-button').removeClass('d-none')
                let formData = {
                    x: parseFloat(document.getElementById("coordsText1").value),
                    y: parseFloat(document.getElementById("coordsText2").value),
                    _token : $('meta[name="csrf-token"]').attr('content'),
                };
                $.ajax({
                    type:'POST',
                    url:'/Home/updateCoords',
                    dataType: 'json',
                    data: formData,
                    success: function (data) {
                        },

                    error: function (data) {
                        console.log(data);
                    }
                });
        }
    })
});

// Menu kontekstowe 
let contextmenu = new ol.Overlay({
    positioning: 'top-left',
    element: document.querySelector('#contextmenu'),
    autoPan: true
});

let contextmenuObject = null;

map.addOverlay(contextmenu);

document.querySelector('#contextmenuUserPositionButton').addEventListener('click', function (evt) {
    setPinOnMap(contextmenuObject);
    resetContextmenu();
});

document.querySelector('#contextmenuIntermediatePositionButton').addEventListener('click', function (evt) {
    addUserPoint(userSource, contextmenuObject.coordinate, "Intermediate Point");
    resetContextmenu();
});

document.querySelector('#contextmenuClearButton').addEventListener('click', function (evt) {
    userSource.clear();
    intermediatePoints.length = 0;
    resetContextmenu();
});

document.querySelector('#contextMenuCancelButton').addEventListener('click', function (evt) {
    resetContextmenu();
});

map.on('contextmenu', function(e) {
    e.preventDefault();
    resetPointContextmenu();
    contextmenuObject = e;
    contextmenu.setPosition(e.coordinate);
});

function resetContextmenu() {
    contextmenu.setPosition(undefined);
    contextmenuObject = null;
}

map.on('singleclick', resetContextmenu);
// Koniec menu kontekstowego

// Menu kontekstowe dla istniejących punktów
let pointContextmenu = new ol.Overlay({
    positioning: 'top-left',
    element: document.querySelector('#pointContextmenu'),
    autoPan: true
});

let pointContextmenuObject = null;

map.addOverlay(pointContextmenu);

document.querySelector('#pointContextmenuRemoveButton').addEventListener('click', function (evt) {
    removeUserPoint(userSource, pointContextmenuObject);
    resetPointContextmenu();
});

document.querySelector('#pointContextMenuCancelButton').addEventListener('click', function (evt) {
    resetPointContextmenu();
});

function resetPointContextmenu() {
    pointContextmenu.setPosition(undefined);
    pointContextmenuObject = null;
}

map.on('singleclick', resetPointContextmenu);
// Koniec menu kontekstowego

// Wstawianie punktu na wybranym źródle
function addUserPoint(vectorSource, coordinates, geometryName) {
    let pointFeature = new ol.Feature({
        geometry: new ol.geom.Point(coordinates),
        name: geometryName,
    });
    vectorSource.addFeature(pointFeature);
    intermediatePoints.push(pointFeature);
}

function removeUserPoint(vectorSource, point) {
    let index = intermediatePoints.indexOf(point)
    if (index >= 0) {
        intermediatePoints.splice(index, 1);
    }
    vectorSource.removeFeature(point);
}

// Funkcja umożliwiająca przesuwanie elementów  HTML za pomocą myszy
'use strict';

/**
 * Makes an element draggable.
 *
 * @param {HTMLElement} element - The element.
 */
function draggable(element) {
    var isMouseDown = false;

    // initial mouse X and Y for `mousedown`
    var mouseX;
    var mouseY;

    // element X and Y before and after move
    var elementX = 0;
    var elementY = 0;

    // mouse button down over the element
    element.addEventListener('mousedown', onMouseDown);

    /**
     * Listens to `mousedown` event.
     *
     * @param {Object} event - The event.
     */
    function onMouseDown(event) {
        mouseX = event.clientX;
        mouseY = event.clientY;
        isMouseDown = true;
    }

    // mouse button released
    document.addEventListener('mouseup', onMouseUp);

    /**
     * Listens to `mouseup` event.
     *
     * @param {Object} event - The event.
     */
    function onMouseUp(event) {
        isMouseDown = false;
        elementX = parseInt(element.style.left) || 0;
        elementY = parseInt(element.style.top) || 0;
    }

    // need to attach to the entire document
    // in order to take full width and height
    // this ensures the element keeps up with the mouse
    document.addEventListener('mousemove', onMouseMove);

    /**
     * Listens to `mousemove` event.
     *
     * @param {Object} event - The event.
     */
    function onMouseMove(event) {
        if (!isMouseDown) return;
        var deltaX = event.clientX - mouseX;
        var deltaY = event.clientY - mouseY;
        element.style.left = elementX + deltaX + 'px';
        element.style.top = elementY + deltaY + 'px';
    }
}

function resetDraggablePosition(element)
{
    element.style.left = 0 + 'px';
    element.style.top = 0 + 'px';
}