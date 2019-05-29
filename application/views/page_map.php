

<section style="height:100%;" class="map">
   <div style="height:100%;" id="map"></div>
</section>

<script>
      //Called by google maps once map is initiated
      function initMap() {
        // The directions service object (for showing route between two endpoints)
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});

        //The current users position
        var userPosition;

        //The google map object (Defaults to centering on Auckland)
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -36.86667, lng: 174.76667},
          zoom: 12
        });
        var infowindow = new google.maps.InfoWindow();
        //Sets the map for the directions display
        directionsDisplay.setMap(map);

        //Handles the recieved user location from geolocation API.
        var handleGeolocationPosition = function(position){
            //Update global user position
            userPosition = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            //Center the map on the users position
            map.setCenter(userPosition);
     
            //Reverse GEOcode the users position (used later for adding address to text box)
            $.get('https://maps.googleapis.com/maps/api/geocode/json?' + $.param({
                latlng:[position.coords.latitude,position.coords.longitude].join(','),
                key:'AIzaSyD-0lCAnTC-PzcxKe2_y-fQ9_TQT-8xS8k'
            }),function(data,status){
                console.log(data)
                let result = data;
                if(result.results.length){
                    let addr = result.results[0];
                    let address = addr.formatted_address;
                    console.log('The address is:', address);
                }else{
                    console.log('unable to reverse-geocode');
                }
            })


            //Add a marker to the map showing users position
            var marker = new google.maps.Marker({
                position: {
                    lat:position.coords.latitude,
                    lng:position.coords.longitude
                }, 
                map: map,
                icon:{
                    url:'<?=BASE_URL?>front_assets/images/you_are_here_icon_.png'
                }
           });
        }

        //Attempts to obtain the users location using the geolocation API.
        var obtainLocation = function(){
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(handleGeolocationPosition);
            }
        }

        //Adds the cafe markers to the map
        var addCafeMarkers = function(){

            //Create the marker pop up when click "info window"
            function createMarkerInfowindow (cafe,marker){


                //Content to be displayed within the info window
                var contentString = 
                '<div style="width:100%;">' +
                    cafe.name + '<br/>' +
                    cafe.address + '<br/>' +
                    cafe.city + '<br/>' +
                    '<button data-lat="'+ marker.getPosition().lat() +'" data-lng="'+ marker.getPosition().lng()+ '" id="mapButton"> Open in maps </button>'+
                '</div>';

                //Onclick listener for the marker, attaches a click listener to the open maps button on 'domReady'
                marker.addListener('click', function() {
                    infowindow.setContent(contentString);
                    infowindow.open(marker.get('map'), marker);
                });
            } 

            //Adds a listener to when a marker is clicked, for showing route from A->B
            function addMarkerListener(marker){
                marker.addListener('click', function() {
                    //calculate 
                    if(userPosition){
                        let usrLatLng = userPosition;
                        let destLatLng = marker.getPosition()
                        var request = {
                            origin: usrLatLng,
                            destination: destLatLng,
                            travelMode: 'DRIVING'
                        };
                        directionsService.route(request, function(result, status) {
                            if (status == 'OK') {
                                directionsDisplay.setDirections(result);
                            }
                        });
                    }
                });
            }

            //Retrieves cafes to display them on the map (calls back end cafes)
            $.get('/cards/retrieveCafes',function(data,status){
                let cafes = JSON.parse(data);
                cafes.cafes.forEach(function(cafe){
                    let lat = cafe.latitude;
                    let lng = cafe.longitude;
                    let marker = new google.maps.Marker({position:{lat:+lat,lng:+lng},map:map,icon:{
                        url:'<?=BASE_URL?>front_assets/images/cafe_logo.png'
                    }});
                    createMarkerInfowindow(cafe,marker);
                    addMarkerListener(marker);
                })
            })
        }

        //Add listener to the info window button to open in maps.//
           $("#map").on("click", "#mapButton", function() {
                    //Opens maps for the right platform
                    function openMaps(ele){
                        let lat = Number($(ele).attr('data-lat'));
                        let lng =  Number($(ele).attr('data-lng'));
                        let targetAddr;
                        if /* if we're on iOS, open in Apple Maps */
                            ((navigator.platform.indexOf("iPhone") != -1) || 
                            (navigator.platform.indexOf("iPad") != -1) || 
                            (navigator.platform.indexOf("iPod") != -1))
                            targetAddr = "maps://maps.google.com/maps?daddr=" + lat +","+lng+"&amp;ll=";
                        else /* else use Google */
                            targetAddr = "https://maps.google.com/maps?daddr=" + lat +","+lng+"&amp;ll=";

                        window.open(targetAddr);
                    }
                    $('#mapButton').off('click',openMaps(this));
                    $('#mapButton').on('click',openMaps(this));
                });

        //Obtain users location
        obtainLocation();
        //Add cafe markers
        addCafeMarkers();
      }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-0lCAnTC-PzcxKe2_y-fQ9_TQT-8xS8k&callback=initMap"
    async defer></script>