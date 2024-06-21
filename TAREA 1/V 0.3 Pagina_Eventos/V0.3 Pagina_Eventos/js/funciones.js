// USO DE LA API DE GOOGLE MAPS

function maps(){
    var output = document.getElementById('map');
    var addressInput = document.getElementById('address');

    // Verificar si soporta geolocalizacion
    if (navigator.geolocation) {
        output.innerHTML = "<p>Tu navegador soporta Geolocalizacion</p>";
    }else{
        output.innerHTML = "<p>Tu navegador no soporta Geolocalizacion</p>";
    }

    //Obtenemos latitud y longitud
    function localizacion(posicion){

        var latitude = posicion.coords.latitude;
        var longitude = posicion.coords.longitude;

        var imgURL = "https://maps.googleapis.com/maps/api/staticmap?center="+latitude+","+longitude+"&zoom=15&size=600x300&markers=color:red%7C"+latitude+","+longitude+"&key=AIzaSyCdmG7Gq1NWeKFF-sKLcrcemIGGOTiCa58";

        output.innerHTML ="<img src='"+imgURL+"'>";
        geocodeLatLng(latitude, longitude);

    }

    function error(){
        output.innerHTML = "<p>No se pudo obtener tu ubicación</p>";

    }

    navigator.geolocation.getCurrentPosition(localizacion,error);
}

// Obtener la dirección a partir de la latitud y longitud
function geocodeLatLng(latitude, longitude) {
    var geocoder = new google.maps.Geocoder();
    var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
    
    geocoder.geocode({'location': latlng}, function(results, status) {
        var addressInput = document.getElementById('address');
        if (status === 'OK') {
            if (results[0]) {
                addressInput.value = results[0].formatted_address;
            } else {
                addressInput.value = 'Dirección no encontrada';
            }
        } else {
            addressInput.value = 'Error en la geolocalización';
        }
    });
}
