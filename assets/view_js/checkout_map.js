
var markers = [];
var map;
function initMap() {
    

   var haightAshbury = {
      lat: 25.28704728025247,
      lng: 51.51610505350684
   };

   map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16.3, // Set the zoom level manually
      center: haightAshbury,
      mapTypeId: 'terrain'
   });
   var infoWindow = new google.maps.InfoWindow({
        map: map
    });
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);
            $("#latitude").val(pos.lat);
            $("#longitude").val(pos.lng);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());

        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.'
        );
    }
     var input = /** @type {!HTMLInputElement} */ (
      document.getElementById('pac-input'));
   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   var autocomplete = new google.maps.places.Autocomplete(input);
   autocomplete.bindTo('bounds', map);
   var infowindow = new google.maps.InfoWindow();
   var marker = new google.maps.Marker({
      map: map,
      anchorPoint: new google.maps.Point(0, -29)
   });
   autocomplete.addListener('place_changed', function () {
      infowindow.close();
      marker.setVisible(false);
      var place = autocomplete.getPlace();
      if (!place.geometry) {
         // User entered the name of a Place that was not suggested and
         // pressed the Enter key, or the Place Details request failed.
         window.alert("No details available for input: '" + place.name + "'");
         return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
         map.fitBounds(place.geometry.viewport);
      } else {
         map.setCenter(place.geometry.location);
         map.setZoom(17); // Why 17? Because it looks good.
      }
      marker.setIcon( /** @type {google.maps.Icon} */ ({
         url: place.icon,
         size: new google.maps.Size(71, 71),
         origin: new google.maps.Point(0, 0),
         anchor: new google.maps.Point(17, 34),
         scaledSize: new google.maps.Size(35, 35)
      }));
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);
      var item_Lat = place.geometry.location.lat();
      var item_Lng = place.geometry.location.lng();
      var item_Location = place.formatted_address;
      //alert("Lat= "+item_Lat+"_____Lang="+item_Lng+"_____Location="+item_Location);
      $("#latitude").val(item_Lat);
      $("#longitude").val(item_Lng);
      //  $("#city").val(item_Location);

      var address = '';
      if (place.address_components) {
         address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
         ].join(' ');
      }

      infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
      infowindow.open(map, marker);
   });
   // This event listener will call addMarker() when the map is clicked.
   map.addListener('click', function (event) {
      if (markers.length >= 1) {
         deleteMarkers();
      }

      addMarker(event.latLng);
      var lat = document.getElementById('latitude').value = event.latLng.lat();
      var long = document.getElementById('longitude').value = event.latLng.lng();

      // $.ajax({
      //    url: bases_url + "Frontend/getAddress",
      //    method: "POST",
      //    data: {
      //       lat: lat,
      //       long: long,
      //    },
      //    success: function (data) {
      //       //  $('#city').val(data);

      //    }
      // });

   });
   
}

// function ediTinitMap() {
    
//     var selected_lat = $("#edit_lat").val();
//     var selected_lng = $("#edit_long").val();
//     selected_lat = parseFloat(selected_lat);
//     selected_lng = parseFloat(selected_lng);
//     var myLatLng = {
//         lat: selected_lat,
//         lng: selected_lng
//     };
//    var haightAshbury = {
//       lat: selected_lat,
//       lng: selected_lng
//    };

//    map = new google.maps.Map(document.getElementById('map1'), {
//       zoom: 16.3, // Set the zoom level manually
//       center: haightAshbury,
//       mapTypeId: 'terrain'
//    });
//      var input = /** @type {!HTMLInputElement} */ (
//       document.getElementById('pac-input'));
//    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
//    var autocomplete = new google.maps.places.Autocomplete(input);
//    autocomplete.bindTo('bounds', map);
//    var infowindow = new google.maps.InfoWindow();
//    var marker = new google.maps.Marker({
//       map: map,
//       anchorPoint: new google.maps.Point(0, -29)
//    });
//    new google.maps.Marker({
//     position: myLatLng,
//     map,
//     title: "Hello World!",
//   });
//    autocomplete.addListener('place_changed', function () {
//       infowindow.close();
//       marker.setVisible(false);
//       var place = autocomplete.getPlace();
//       if (!place.geometry) {
//          // User entered the name of a Place that was not suggested and
//          // pressed the Enter key, or the Place Details request failed.
//          window.alert("No details available for input: '" + place.name + "'");
//          return;
//       }

//       // If the place has a geometry, then present it on a map.
//       if (place.geometry.viewport) {
//          map.fitBounds(place.geometry.viewport);
//       } else {
//          map.setCenter(place.geometry.location);
//          map.setZoom(17); // Why 17? Because it looks good.
//       }
//       marker.setIcon( * @type {google.maps.Icon}  ({
//          url: place.icon,
//          size: new google.maps.Size(71, 71),
//          origin: new google.maps.Point(0, 0),
//          anchor: new google.maps.Point(17, 34),
//          scaledSize: new google.maps.Size(35, 35)
//       }));
//       marker.setPosition(place.geometry.location);
//       marker.setVisible(true);
//       var item_Lat = place.geometry.location.lat();
//       var item_Lng = place.geometry.location.lng();
//       var item_Location = place.formatted_address;
//       //alert("Lat= "+item_Lat+"_____Lang="+item_Lng+"_____Location="+item_Location);
//       $("#edit_lat").val(item_Lat);
//       $("#edit_long").val(item_Lng);
//       //  $("#city").val(item_Location);

//       var address = '';
//       if (place.address_components) {
//          address = [
//             (place.address_components[0] && place.address_components[0].short_name || ''),
//             (place.address_components[1] && place.address_components[1].short_name || ''),
//             (place.address_components[2] && place.address_components[2].short_name || '')
//          ].join(' ');
//       }

//       infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
//       infowindow.open(map, marker);
//    });
//    // This event listener will call addMarker() when the map is clicked.
//    map.addListener('click', function (event) {
//       if (markers.length >= 1) {
//          deleteMarkers();
//       }

//       addMarker(event.latLng);
//       var lat = document.getElementById('edit_lat').value = event.latLng.lat();
//       var long = document.getElementById('edit_long').value = event.latLng.lng();

//       $.ajax({
//          url: bases_url + "Frontend/getAddress",
//          method: "POST",
//          data: {
//             lat: lat,
//             long: long,
//          },
//          success: function (data) {
//             //  $('#city').val(data);

//          }
//       });

//    });
   
// }

// Adds a marker to the map and push to the array.
function addMarker(location) {
   var marker = new google.maps.Marker({
      position: location,
      map: map
   });
   markers.push(marker);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
   for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
   }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
   setMapOnAll(null);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
   clearMarkers();
   markers = [];
}

document.onfullscreenchange = function (event) {
   let target = event.target;
   let pacContainerElements = document.getElementsByClassName("pac-container");
   if (pacContainerElements.length > 0) {
      let pacContainer = document.getElementsByClassName("pac-container")[0];
      if (pacContainer.parentElement === target) {
         document.getElementsByTagName("body")[0].appendChild(pacContainer);
         pacContainer.className += pacContainer.className.replace("fullscreen-pac-container", "");
      } else {
         target.appendChild(pacContainer);
         pacContainer.className += " fullscreen-pac-container";
      }
   }
};