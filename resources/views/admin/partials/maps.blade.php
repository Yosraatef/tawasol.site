<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsGwp19k_0lr31Hnyos-OPLdJ9FwTO6k4&libraries=places&callback=initialize" async defer></script>
<script type="text/javascript">
/*********************************/
function GetAddress(lat,lng) {
    var lat = parseFloat(lat);
    var lng = parseFloat(lng);
    var latlng = new google.maps.LatLng(lat, lng);
    var geocoder = geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                //alert("Location: " + results[1].formatted_address);
             document.getElementById("addresss").value = results[1].formatted_address;
            }/*else if (results[0]) {
                //alert("Location: " + results[1].formatted_address);
    document.getElementById("addresss").value = results[0].formatted_address;
            }*/
        }
    });
}
/*************************/

    var map;
    var marker;
        function initialize() {
        
            var myLatlng = new google.maps.LatLng(21.38595,39.85291);

            var myOptions = {
                zoom:12,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("gmap"), myOptions);
            // marker refers to a global variable
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });

            google.maps.event.addListener(map, "click", function(event) {
                // get lat/lon of click
                var clickLat = event.latLng.lat();
                var clickLon = event.latLng.lng();

                // show in input box
                document.getElementById("lat").value = clickLat.toFixed(5);
                document.getElementById("lon").value = clickLon.toFixed(5);
        /*******************/
        GetAddress(clickLat.toFixed(5),clickLon.toFixed(5));
        /****************/
            var latlng = new google.maps.LatLng(clickLat,clickLon);
            marker.setPosition(latlng);
                  /*marker = new google.maps.Marker({
                        position: new google.maps.LatLng(clickLat,clickLon),
                        map: map
                     });*/
            });
    }   

    window.onload = function () { initialize() };
</script>
    <style>
        #map_canvas { height: 100%; }
        div#gmap {
            width: 80%;
            height: 500px;
            border:double;
        }
    </style>


        <div class="form-group">
            <label for="computer">موقعه على الخريطة:</label>
            <input type="text" id="addresss" name="address" class="form-control">
            <label class="label label-success">حرك المؤشر لمكان العرض</label>
            <input type="hidden" id="lat" name="lat"><br>
            <input type="hidden" id="lon" name="lng"><br>
            {{-- <center> --}}
            <!-- MAP HOLDER -->
            <div id="gmap" class="form-control"></div>
            <!-- /MAP HOLDER -->
            {{-- </center> --}}
            
        </div>