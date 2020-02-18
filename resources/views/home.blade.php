
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

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            Vous êtes connecter :D
        </div>

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
        <br>
        <select name="list_categorie" id="list_categorie">
            @foreach ($list_categorie as $item)
                <option value="{{ $item['id'] }}">
                    {{ $item['nom_categorie'] }}
                </option>
            @endforeach
        </select>

        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="https://maps.google.com/maps/api/js?key=AIzaSyAf1TaA4FTpPmk7p9hSgpdiNJ-z1q4PzwQ" type="text/javascript"></script>
		<script async type="text/javascript">
			// On initialise la latitude et la longitude de Paris (centre de la carte)
            var lat = -17.686144;
            var lon = -149.570525;
            var map = null;

            // var villes = {
            //     "RSMA":{"lat": -17.528650,"lon": -149.530796},
            //     "Ma maison":{"lat": -17.686144,"lon": -149.570525}
            // };

            // Permet d'ajouté une InfoBulle lors du clique sur le marqueur
            var contentString = 'test d\'affichage<br>'+'autre ligne';
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 200
            });

            $(document).ready(function(){

                // c'est ici que je vais écrire le code JQuery de ma page
                $('#list_categorie').change(function(){

                    var id_categorie = $('#list_categorie').val();
                    generer_ajax(id_categorie);


                });

            });

            //AJAX
            function generer_ajax(id_categorie){
                $.ajax({
                    type:"GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"home/generer",
                    dataType:"json",
                    data: {
                        'id_categorie': id_categorie
                    },
                    'success': function(data){

                            show_map(data);
                        },
                        'error': function(){
                            alert('erreur');
                        }
                });
            }

            function show_map(data){

                var categories = data;
                // On parcourt l'objet villes
                for(categorie in categories){
                    // console.log(categories[categorie].nom_categorie);
                    var marker = new google.maps.Marker({
                        // parseFloat nous permet de transformer la latitude et la longitude en nombre décimal
                        position: {lat: parseFloat(categories[categorie].lat), lng: parseFloat(categories[categorie].lon)},
                        title: categories[categorie].nom_categorie,
                        map: map
                    });
                    marker.setAnimation(google.maps.Animation.DROP);
                }

            }

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
                // for(ville in villes){
                //     var marker = new google.maps.Marker({
                //         // A chaque boucle, la latitude et la longitude sont lues dans le tableau
                //         position: {lat: villes[ville].lat, lng: villes[ville].lon},
                //         // On en profite pour ajouter une info-bulle contenant le nom de la ville
                //         title: ville,
                //         map: map
                //     });
                // }

                // marker.addListener('click', function() {
                //     infowindow.open(map, marker);
                // });

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
