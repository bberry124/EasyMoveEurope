google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
  var options_pickup = {
      types: ['(cities)'],
      componentRestrictions: { country: "ie" }
  };
  var options_desti = {
    types: ['(cities)'],
    componentRestrictions: { country: "al" }
};
  var pickup_location = document.getElementById('sender_ad');
  var destination_location = document.getElementById('receiver_ad');

  var autocomplete_pick = new google.maps.places.Autocomplete(pickup_location, options_pickup);
  var autocomplete_desti = new google.maps.places.Autocomplete(destination_location, options_desti);

  autocomplete_pick.addListener('place_changed', function () {

      var first_place = autocomplete_pick.getPlace();

  });
  autocomplete_desti.addListener('place_changed', function () {

    var second_place = autocomplete_desti.getPlace();

  });

}

function esti_calc() {
  var pickup_location = document.getElementById("sender_ad").value;
  var destination_location = document.getElementById("receiver_ad").value;
  var cost_val = document.getElementById("cost_val").innerHTML;

  const directionsService = new google.maps.DirectionsService();

  directionsService.route(
    {
      origin: pickup_location,
      destination: destination_location,
      travelMode: "DRIVING",
    },
    (response, status) => {
      if (status === "OK") {

        new google.maps.DirectionsRenderer({
          suppressMarkers: true,
          directions: response,
          map: map,
        });
      }
    }
  )

  var service = new google.maps.DistanceMatrixService();
  service.getDistanceMatrix(
    {
      origins: [pickup_location],
      destinations: [destination_location],
      travelMode: 'DRIVING',
    }, callback);

  function callback(response, status) {
    if (status == 'OK') {
      var origins = response.originAddresses;
      var destinations = response.destinationAddresses;

      for (var i = 0; i < origins.length; i++) {
        var results = response.rows[i].elements;
        for (var j = 0; j < results.length; j++) {
          var element = results[j];
          var distance = element.distance.text;
          var distance_value = element.distance.value;
          var duration = element.duration.text;
          var from = origins[i];
          var to = destinations[j];
        }
      }
    }
    var result_cost = distance_value * cost_val / 1000;
    var result_cost = Math.round(result_cost);
    document.getElementById("distance_val").innerHTML = distance;
    document.getElementById("duration_val").innerHTML = duration;
    document.getElementById("estimation_val").innerHTML = result_cost;
  }
}

const map = new google.maps.Map(document.getElementById("map"), {
  center: new google.maps.LatLng(53.14, -6.85),
  zoom: 7,
  mapTypeId: google.maps.MapTypeId.ROADMAP,
});