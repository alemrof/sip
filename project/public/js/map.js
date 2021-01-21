let selectedWarehouses = null;
let selectedWarehouseNumber = 0;

let warehouseIconSrc = '../imgs/warehouse-icon-20px.png';

// Tworzenie źródła na podstawie danych przesłanych z bazy danych
let vectorSource = new ol.source.Vector();
for(let warehouse of warehouses) {
    let pointFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(warehouse.location.coordinates)),
        name: warehouse.name,
        company: warehouse.company.name,
        address: warehouse.address
    });
    pointFeature.setId(warehouse.id);
    vectorSource.addFeature(pointFeature);
}

// Tworzenie warstwy wektorowej
let vectorLayer = new ol.layer.Vector({
    source: vectorSource,
    style: new ol.style.Style({
        image: new ol.style.Icon({
            src: warehouseIconSrc
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
                image: new ol.style.Icon({
                    src: warehouseIconSrc,
                }),
                // image: new ol.style.Circle({                 // Alternatywny wygląd
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
var map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }),
        // vectorLayer,
        clusterLayer,
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
    selectedWarehouses = null;
    selectedWarehouseNumber = 0;
    return false;
});

function updatePopup(id) {
    let warehouseName = document.querySelector('#warehouse-name');
    warehouseName.innerHTML = selectedWarehouses[id].get('name');
    
    let warehouseCompany = document.querySelector('#warehouse-company');
    warehouseCompany.innerHTML = selectedWarehouses[id].get('company');
    
    let warehouseAddress = document.querySelector('#warehouse-address');
    warehouseAddress.innerHTML = selectedWarehouses[id].get('address');

    let editLink = document.querySelector('#edit-link');
    editLink.href = `http://localhost:8000/warehouses/${selectedWarehouses[id].getId()}/edit`;

    let editMapLink = document.querySelector('#editMap-link');
    editMapLink.href = `http://localhost:8000/warehouses/${selectedWarehouses[id].getId()}/editMap`;
}

// Wybieranie składu
var select = new ol.interaction.Select({
    // condition: ol.events.condition.Click
});

map.addInteraction(select);

select.on('select', function(e) {
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
            
            // let warehouseName = document.querySelector('#warehouse-name');
            // warehouseName.innerHTML = selectedWarehouses[selectedWarehouseNumber].get('name');
            
            // let warehouseCompany = document.querySelector('#warehouse-company');
            // warehouseCompany.innerHTML = selectedWarehouses[selectedWarehouseNumber].get('company');
            
            // let warehouseAddress = document.querySelector('#warehouse-address');
            // warehouseAddress.innerHTML = selectedWarehouses[selectedWarehouseNumber].get('address');
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

vectorSource.on('addfeature', function(e) {
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