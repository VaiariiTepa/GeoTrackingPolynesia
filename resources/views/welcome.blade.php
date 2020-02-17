<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<style type="text/css">
			#map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
				height:400px;
			}
		</style>
		<title>Carte</title>
	</head>
	<body>
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div id="map">
			<!-- Ici s'affichera la carte -->
		</div>

        <script src="https://maps.google.com/maps/api/js?key=AIzaSyAf1TaA4FTpPmk7p9hSgpdiNJ-z1q4PzwQ" type="text/javascript"></script>
		<script async type="text/javascript">
			// On initialise la latitude et la longitude de Paris (centre de la carte)
            var lat = -17.686144;
            var lon = -149.570525;
            var map = null;

            var villes = {
                "Paris":{"lat": 48.852969,"lon": 2.349903},
                "Brest":{"lat": 48.383,"lon": -4.500},
                "Quimper":{"lat": 48.000,"lon": -4.100},
                "Maison":{"lat": -17.686144,"lon": -149.570525}
            };

            // Permet d'ajouté une InfoBulle lors du clique sur le marqueur
            var contentString = 'test d\'affichage<br>'+'autre ligne';
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 200
            });

			// Fonction d'initialisation de la carte
			function initMap() {
				// Créer l'objet "map" et l'insèrer dans l'élément HTML qui a l'ID "map"
				map = new google.maps.Map(document.getElementById("map"), {
					// Nous plaçons le centre de la carte avec les coordonnées ci-dessus
					center: new google.maps.LatLng(lat, lon),
					// Nous définissons le zoom par défaut
					zoom: 15,
					// Nous définissons le type de carte (ici carte routière)
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					// Nous activons les options de contrôle de la carte (plan, satellite...)
					mapTypeControl: true,
					// Nous désactivons la roulette de souris
					scrollwheel: false,
					mapTypeControlOptions: {
						// Cette option sert à définir comment les options se placent
						style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
					},
					// Activation des options de navigation dans la carte (zoom...)
					navigationControl: true,
					navigationControlOptions: {
						// Comment ces options doivent-elles s'afficher
						style: google.maps.NavigationControlStyle.ZOOM_PAN
                    }


                });

                // Nous parcourons la liste des villes
                for(ville in villes){
                    var marker = new google.maps.Marker({
                        // A chaque boucle, la latitude et la longitude sont lues dans le tableau
                        position: {lat: villes[ville].lat, lng: villes[ville].lon},
                        // On en profite pour ajouter une info-bulle contenant le nom de la ville
                        title: ville,
                        map: map
                    });
                }

                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });


                infoWindow = new google.maps.InfoWindow;

                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Vous êtes ici ;) ');
                    infoWindow.open(map);
                    map.setCenter(pos);
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
                } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
                }

			}
			window.onload = function(){
				// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
				initMap();
			};

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                                    'Geolocalisation échouer !' :
                                    'Erreur: votre naviguateur ne supporte pas la géolocalisation');
                infoWindow.open(map);
            }
		</script>
	</body>
</html>
