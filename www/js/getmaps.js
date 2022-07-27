var trans = {
    DefaultLat: 47.49780002574056,
    DefaultLng: 19.04032051563263,
    DefaultHeading: 182,
    DefaultPitch: 5,
    DefaultSvZoom: 17,
    DefaultAddress: "Budapest, Clark Ádám tér 1, 1013 Hungary",
    Geolocation: "Helyszín:",
    Latitude: "Szélességi fok:",
    Longitude: "Hosszúsági fok:",
    GetAltitude: "Get Altitude",
    NoResolvedAddress: "Nem található feloldható cím.",
    GeolocationError: "Hiba történt a helymeghatározás közben.",
    GeocodingError: "Hiba történt a helymeghatározás közben: ",
    Altitude: "Magasság: ",
    Meters: " méter",
    NoResult: "Niny megjeleníthető eredmény",
    ElevationFailure: "Elevation service failed due to: ",
    SetOrigin: "Set as Origin",
    SetDestination: "Set as Destination",
    Address: "Cím: ",
    Bicycling: "Kerékpár",
    Transit: "Tömegközlekedés",
    Walking: "Séta",
    Driving: "Autó",
    Kilometer: "kilométer",
    Mile: "mérföld",
    Avoid: "Avoid",
    DirectionsError: "Calculating error or invalid route.",
    North: "É",
    South: "D",
    East: "K",
    West: "Ny",
    Type: "típus",
    Lat: "latitude",
    Lng: "longitude",
    Dd: "DD",
    Dms: "DMS",
    CheckMapDelay: 7e3
};
var geocoder;
var map;
var infowindow = new google.maps.InfoWindow;
var marker = null;
var elevator;
var fromPlace = 0;
var locationFromPlace;
var addressFromPlace;
var placeName;
var defaultLatLng = new google.maps.LatLng(trans.DefaultLat, trans.DefaultLng);
var myOptions = {
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    scrollwheel: false
};
var mapLoaded = 0;

function initialize() {
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    var input = document.getElementById("address");
    var options = {};
    autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, "place_changed", function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            fromPlace = 0;
            return
        }
        fromPlace = 1;
        locationFromPlace = place.geometry.location;
        addressFromPlace = place.formatted_address;
        placeName = "";
        if ($.inArray("establishment", place.types) >= 0) placeName = place.name
    });
    geocoder = new google.maps.Geocoder;
    setTimeout(checkMap, trans.CheckMapDelay);
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            marker = new google.maps.Marker({
                map: map,
                position: pos,
				icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
            });
            map.setCenter(pos);
            mapLoaded = 1;
            geocoder.geocode({
                latLng: pos
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        if (marker != null) marker.setMap(null);
                        marker = new google.maps.Marker({
                            position: pos,
                            map: map,
							icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
                        });
                        var infoText = "<strong>" + trans.Geolocation + '</strong> <span id="geocodedAddress">' + results[0].formatted_address + "</span>";
                        infowindow.setContent(infowindowContent(infoText, position.coords.latitude, position.coords.longitude));
                        document.getElementById("latitude").value = position.coords.latitude;
                        document.getElementById("longitude").value = position.coords.longitude;
                        document.getElementById("address").value = results[0].formatted_address;
                        bookUp(results[0].formatted_address, position.coords.latitude, position.coords.longitude);
                        infowindow.open(map, marker);
                        ddversdms()
                    }
                } else {
                    if (marker != null) marker.setMap(null);
                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
						icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
                    });
                    var infoText = "<strong>" + trans.Geolocation + '</strong> <span id="geocodedAddress">' + trans.NoResolvedAddress + "</span>";
                    infowindow.setContent(infowindowContent(infoText, position.coords.latitude, position.coords.longitude));
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                    document.getElementById("address").value = trans.NoResolvedAddress;
                    bookUp(trans.NoResolvedAddress, position.coords.latitude, position.coords.longitude);
                    infowindow.open(map, marker);
                    ddversdms()
                }
            })
        }, function() {
            defaultMap()
        })
    } else {
        defaultMap()
    }
    google.maps.event.addListener(map, "click", codeLatLngfromclick);
    elevator = new google.maps.ElevationService
}

function codeAddress() {
    var address = document.getElementById("address").value;
    if (fromPlace == 1) {
        map.setCenter(locationFromPlace);
        if (marker != null) marker.setMap(null);
        marker = new google.maps.Marker({
            map: map,
            position: locationFromPlace,
			icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
        });
        latres = locationFromPlace.lat();
        lngres = locationFromPlace.lng();
        if (placeName != "") {
            document.getElementById("address").value = addressFromPlace;
            var addressForInfoWindow = "<strong>" + placeName + "</strong> " + addressFromPlace
        } else {
            document.getElementById("address").value = addressFromPlace;
            var addressForInfoWindow = "<strong>" + placeName + "</strong> " + addressFromPlace
        }
        infowindow.setContent(infowindowContent(addressForInfoWindow, latres, lngres));
        infowindow.open(map, marker);
        document.getElementById("latitude").value = latres;
        document.getElementById("longitude").value = lngres;
        bookUp(document.getElementById("address").value, latres, lngres);
        ddversdms()
    } else {
        geocoder.geocode({
            address: address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                if (marker != null) marker.setMap(null);
                marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
					icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
                });
                latres = results[0].geometry.location.lat();
                lngres = results[0].geometry.location.lng();
                document.getElementById("address").value = results[0].formatted_address;
                infowindow.setContent(infowindowContent(document.getElementById("address").value, latres, lngres));
                infowindow.open(map, marker);
                document.getElementById("latitude").value = latres;
                document.getElementById("longitude").value = lngres;
                bookUp(document.getElementById("address").value, latres, lngres);
                ddversdms()
            } else {
                alert(trans.GeocodingError + status)
            }
        })
    }
}

function codeLatLng(origin) {
    var lat = parseFloat(document.getElementById("latitude").value) || 0;
    var lng = parseFloat(document.getElementById("longitude").value) || 0;
    var latlng = new google.maps.LatLng(lat, lng);
    if (origin == 1) ddversdms();
    geocoder.geocode({
        latLng: latlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                if (marker != null) marker.setMap(null);
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                infowindow.setContent(infowindowContent(results[0].formatted_address, lat, lng));
                infowindow.open(map, marker);
                document.getElementById("address").value = results[0].formatted_address;
                bookUp(document.getElementById("address").value, lat, lng)
            }
        } else {
            if (marker != null) marker.setMap(null);
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
				icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
            });
            infowindow.setContent(infowindowContent(trans.NoResolvedAddress, lat, lng));
            infowindow.open(map, marker);
            document.getElementById("address").value = trans.NoResolvedAddress;
            bookUp(document.getElementById("address").value, lat, lng);
            alert(trans.GeocodingError + status)
        }
    });
    map.setCenter(latlng);
    fromPlace = 0
}

function codeLatLngfromclick(event) {
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
    var latlng = event.latLng;
    geocoder.geocode({
        latLng: latlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                if (marker != null) marker.setMap(null);
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
					icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
                });
                map.panTo(latlng);
                fromPlace = 0;
                infowindow.setContent(infowindowContent(results[0].formatted_address, lat, lng));
                infowindow.open(map, marker);
                document.getElementById("address").value = results[0].formatted_address;
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
                bookUp(document.getElementById("address").value, lat, lng);
                ddversdms()
            }
        } else {
            if (marker != null) marker.setMap(null);
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
				icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
            });
            map.panTo(latlng);
            fromPlace = 0;
            infowindow.setContent(infowindowContent(trans.NoResolvedAddress, lat, lng));
            infowindow.open(map, marker);
            document.getElementById("address").value = trans.NoResolvedAddress;
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
            // document.getElementById("latlong").value = lat + "," + lng;
            bookUp(document.getElementById("address").value, lat, lng);
            ddversdms();
            alert(trans.GeocodingError + status)
        }
    })
}

function ddversdms() {
    var lat, lng, latdeg, latmin, latsec, lngdeg, lngmin, lngsec;
    lat = parseFloat(document.getElementById("latitude").value) || 0;
    lng = parseFloat(document.getElementById("longitude").value) || 0;

    lat = Math.abs(lat);
    lng = Math.abs(lng);
    latdeg = Math.floor(lat);
    latmin = Math.floor((lat - latdeg) * 60);
    latsec = Math.round((lat - latdeg - latmin / 60) * 1e3 * 3600) / 1e3;
    lngdeg = Math.floor(lng);
    lngmin = Math.floor((lng - lngdeg) * 60);
    lngsec = Math.floor((lng - lngdeg - lngmin / 60) * 1e3 * 3600) / 1e3;
}

function infowindowContent(text, latres, lngres) {
    return '<div id="info_window">' + text + "<br/><strong>" + trans.Latitude + "</strong> " + Math.round(latres * 1e6) / 1e6 + "<br/><strong>" + trans.Longitude + "</strong> " + Math.round(lngres * 1e6) / 1e6 + bookmark() + "</div>"
}

function defaultMap() {
    map.setCenter(defaultLatLng);
    mapLoaded = 1;
    bookUp(trans.DefaultAddress, trans.DefaultLat, trans.DefaultLng);
    if (marker != null) marker.setMap(null);
    marker = new google.maps.Marker({
        map: map,
        position: defaultLatLng,
		icon: 'http://sceurpien.com/fixmystreet/img/marker_red.png'
    });
    infowindow.setContent(infowindowContent(trans.DefaultAddress, defaultLatLng.lat(), defaultLatLng.lng()));
    infowindow.open(map, marker);
    document.getElementById("latitude").value = defaultLatLng.lat();
    document.getElementById("longitude").value = defaultLatLng.lng();
    document.getElementById("address").value = trans.DefaultAddress;
    ddversdms()
}

function checkMap() {
    if (mapLoaded == 0) {
        defaultMap()
    }
}