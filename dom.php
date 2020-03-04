<?php
       include 'header.php'; //header
	   //isset funksjon som sjekker variablene på søk form har verdi
		if (isset($_POST['submit'])){
			// her sjekker vi om location og keyword er tøme og gir feil melding dersom det er tøme eller numeriske
			if (empty($_POST['location']) || is_numeric($_POST['location'])) {
				echo 'Fill in location'; }
			if (empty($_POST['keyword']) || is_numeric($_POST['keyword'])) {
				echo 'Fill in keyword';

			} else {
				 $location = ($_POST['location']); // her setter vi varible for location
				 $keyword = ($_POST['keyword']); // variabel for keyword

				$domdoc = new DOMDocument(); // her oppreter vi ny dom objekt
				$domdoc->loadXML("<document></document>"); // vi laster den ny dom objektet med xml file som er bare node element document

				$domEve = new DOMDocument(); // vi oppreter ny dom object
				$domEve->preserveWhiteSpace = false;
				//her laster vi ned data fra eventful.com API, her bruker vi variablene keyword og location for å hente riktig verdig når brukern søker
			    $domEve->load("http://api.eventful.com/rest/events/search?&app_key=x8WZzH4wgmf6CGtF&keywords={$keyword}&location={$location}&date=Future") or die("Error found");
				$node = $domEve->getElementsByTagName('events')->item(0); //her setter vi ny variabel som heter node og henter den root elementen med alle de barn elementer inne i den.
				$node =  $domdoc->importNode($node, true); // vi imporerer vardiene i variablen node til domdoc objectet
				$domdoc->documentElement->appendChild($node); //så adder vi dataene som barne element til filen document
				//vi laster ned data fra API openweather
				$domEve->load("http://api.openweathermap.org/data/2.5/weather?q={$location}&units=metric&mode=xml&type=accurate&appid=966cdc7c3ba84de599688090badbeb00&fbclid=IwAR0uf2j4PrvrxTdjaN5tJLi6EIlRWPVLVtiVMxEcIrBxSePqAgFxh3j00D0") or die("Error found");
				$node = $domEve->getElementsByTagName('current')->item(0); //henter root element
				$node =  $domdoc->importNode($node, true); //importere til domdoc
				$domdoc->documentElement->appendChild($node); // vi adder til sluten av filen document
				//API for dnb
				$domEve->load("https://www.dnb.no/portalfront/datafiles/miscellaneous/csv/kursliste_ws.xml") or die("Error found");
				$node = $domEve->getElementsByTagName('valuta')->item(0);
				$node =  $domdoc->importNode($node, true);
				$domdoc->documentElement->appendChild($node);

				//API for googel maps
				$domEve->load("https://maps.googleapis.com/maps/api/geocode/xml?address={$location}&key=AIzaSyCfeCZM-Kq4IfErjeCoRIZVPJ7BE3fyV2E") or die("Error found");
				$node = $domEve->getElementsByTagName('result')->item(0);
				$node =  $domdoc->importNode($node, true);
				$domdoc->documentElement->appendChild($node);

				$domdoc->save("events.xml"); // her bruker vi funksjonen save() to å lagre dataene til et xml fil
				$xsldoc = new DOMDocument(); // her oppreter vi en ny dom document object
				$xsldoc->load("events.xsl"); // vi laster opp xsl fila til dom objektet xsldoc
				$xslt = new XSLTProcessor(); // vi oppreter ny XSLTProcessor
				$xslt->importStyleSheet($xsldoc); // vi imporerer dom objektet som har xsl fila
				echo $xslt->transformToXML($domdoc); // her bruker vi funksjonen transformToXML for implimentere xsl stil

				//her skal vi laste ned filen events.xml med simplexml,vi gjør dette fordi vi trenger å få "latitude" og "longitude" for googel maps
			    $map = simplexml_load_file("events.xml") or die("Error found");
				 //foreach loop for å hente verdiene for latitude og longitude i googel maps API
                 foreach ( $map->result->geometry->location as $laLn) :
					 if(($laLn->lat) && ($laLn->lng)!=''){
                             $latitude = $laLn->lat;
				             $longitude = $laLn->lng;

						}
				 endforeach;



}?>
<script type='text/javascript'>
// googel maps javascript
//funksjon som oppretter kartet
	function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat:  <?php echo $latitude;?>, lng: <?php echo $longitude;?>} //her setter vi verdiene for latitude og longitude
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }
// funksjon som gjør mulig å geocode et address
      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
</script>
<script src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCfeCZM-Kq4IfErjeCoRIZVPJ7BE3fyV2E&callback=initMap" style="width:40%" async defer></script>
  <?php } ?>
