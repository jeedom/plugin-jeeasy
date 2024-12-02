<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

$userCountry = config::byKey('info::stateCode', 'core', 'FR');
sendVarToJS('userCountry', $userCountry);

?>

<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://nominatim.openstreetmap.org; style-src 'self' 'unsafe-inline';">
<link rel="stylesheet" href="plugins/jeeasy/3rdparty/leaflet.css"/>

<div class="modalContainer" style="display:flex;flex-direction:column;align-items:center;height:100%; width:100%;">

            <div class="input-group" style="width:50%;min-width:600px;">
                <span class="input-group-addon roundedLeft">{{Adresse}}
                    <sup><i class="fas fa-question-circle" title="{{Coordonnées de votre box}}"></i></sup>
                </span>

                <div style="display:flex; align-items: center;" class="inputcontainer">
                    <input type="text" class="form-control " id="address-input" placeholder="Entrez une adresse" autocomplete="off">
                    <div class="icon-container hidden" id="iconSpinner" style="z-index:1000;">
                        <i class="loader"></i>
                    </div>
                </div>
            </div>
            <ul id="suggestions" style="z-index:1000;"></ul>

            <div  class="input-group" id="gpsCoordonates" style="width:50%;min-width:600px;display:flex:">
                <span class="input-group-addon roundedLeft">{{Coordonnées GPS}}
                    <sup><i class="fas fa-question-circle" title="{{Renseigner la latitude et la longitude du site. Ces champs seront remplis automatiquement si vous recherchez votre adresse}}"></i></sup>
                </span>
                <input type="number" class="form-control" id="in_latitude" value="<?= config::byKey('info::latitude') ?>">
                <span class="input-group-addon">{{,}}</span>
                <input type="number" class="form-control" id="in_longitude" value="<?= config::byKey('info::longitude') ?>">
                <span id="validCoordonates" class="input-group-addon roundedLeft modern-btn-disabled">{{Valider les coordonnées}}
                    <sup><i class="fas fa-question-circle" id="iValidBtn" title="{{Veuillez rechercher une adresse valide pour enregistrer le résultat.}}"></i></sup>
                </span>
            </div>

            <div id="mapJeeasy" style="height:80%;width:100%;margin-top:2%;"></div>
            <span style="font-size:12px;margin-top:1%;">{{ Ceci est alimenté par }} [OpenStreetMap] <a>(https://www.openstreetmap.org/)</a></span>


</div>


<script src="plugins/jeeasy/3rdparty/leaflet.js"></script>

<script>

(function() {

  var map, marker, adresse, zipCode, city, country_code;
  var timeout = null;

  const capitalsCoordonates = {
    "FR" : "48.8566,2.3522",  
    "US" : "38.9072,-77.0369", 
    "ES" : "40.4168,-3.7038",  
    "DE" : "52.5200,13.4050", 
    "IT" : "41.9028,12.4964"   
  }

  let defaultLatitude = capitalsCoordonates[userCountry].split(',')[0];
  let defaultLongitude = capitalsCoordonates[userCountry].split(',')[1];

  initializeMap(defaultLatitude, defaultLongitude);


  function initializeMap(latitude, longitude) {
    if (map) {
      map.remove();
    }
    map = L.map('mapJeeasy').setView([latitude, longitude], 18);

    var customIcon = L.icon({
      iconUrl: 'plugins/jeeasy/3rdparty/images/marker-icon.png',
      shadowUrl: 'plugins/jeeasy/3rdparty/images/marker-shadow.png'
    });

    marker = new L.marker([latitude,longitude],{
      draggable: true,
      autoPan: true,
      icon: customIcon
    }).addTo(map).bindPopup('Vous pouvez affiner la position en déplaçant le marqueur', {className: 'popUp'}).openPopup();

    L.tileLayer('https://basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    let latitudeInput = document.getElementById('in_latitude');
    let longitudeInput = document.getElementById('in_longitude');
    latitudeInput.value = latitude;
    longitudeInput.value = longitude;

    marker.on('dragend', function(e) {
      var latlng = marker.getLatLng();
      latitudeInput.value = latlng.lat;
      longitudeInput.value = latlng.lng;
      var event = new Event('change');
      latitudeInput.dispatchEvent(event);
      longitudeInput.dispatchEvent(event);
    });
  }

  function updateMap(latitude, longitude) {
    map.setView([latitude, longitude], 18);
    marker.setLatLng([latitude, longitude]);
    let latitudeInput = document.getElementById('in_latitude');
    let longitudeInput = document.getElementById('in_longitude');
    latitudeInput.value = latitude;
    longitudeInput.value = longitude;
    var event = new Event('change');
    latitudeInput.dispatchEvent(event);
    longitudeInput.dispatchEvent(event);
  }

  var selectedAddressData = null;

  document.getElementById('address-input')?.addEventListener('keyup', function(_event) {
    if(this.value.length == 0){    
        let btnValidCoordonates = document.getElementById('validCoordonates');
        btnValidCoordonates.classList.add('disabled');
        document.getElementById('iValidBtn').classList.remove('hidden');
        document.getElementById('iconSpinner').classList.add('hidden');
    }
    clearTimeout(timeout);
    var addressInput = document.getElementById('address-input').value;
    if (addressInput.length < 4) {
      document.getElementById('suggestions').style.display = 'none';
      return;
    }

    document.getElementById('iconSpinner').classList.remove('hidden');

    timeout = setTimeout(function() {
      var fullAddress = encodeURIComponent(addressInput);
      var countryCode = userCountry;
      var url = "https://nominatim.openstreetmap.org/search?q=" + fullAddress + "&format=json&addressdetails=1&countrycodes=" + countryCode;

      fetch(url)
        .then(response => response.json())
        .then(data => {
          document.getElementById('iconSpinner').classList.add('hidden');
          var suggestions = document.getElementById('suggestions');
          suggestions.innerHTML = '';
          if (data.length > 0) {
            console.log(data);
            data.forEach(function(item) {
              var li = document.createElement('li');
              li.textContent = item.display_name;
              li.style.padding = '5px';
              li.style.cursor = 'pointer';
              li.addEventListener('click', function() {
                document.getElementById('address-input').value = item.display_name;
                document.getElementById('in_latitude').value = item.lat;
                document.getElementById('in_longitude').value = item.lon;
                var event = new Event('change');
                document.getElementById('in_latitude').dispatchEvent(event);
                document.getElementById('in_longitude').dispatchEvent(event);
                updateMap(item.lat, item.lon);
                suggestions.style.display = 'none';

                var btnValidCoordonates = document.getElementById('validCoordonates');
                btnValidCoordonates.classList.remove('modern-btn-disabled');
                btnValidCoordonates.classList.add('modern-btn');
                document.getElementById('iValidBtn').classList.add('hidden');

                selectedAddressData = item;

              });
              suggestions.appendChild(li);
            });
            suggestions.style.display = 'block';
          } else {
            suggestions.style.display = 'none';
          }
        })
        .catch(error => {
          document.getElementById('iconSpinner').classList.remove('hidden');
          console.error('Erreur lors de la récupération des suggestions d\'adresse:', error);
        });
    }, 1000); 
  });

  document.getElementById('validCoordonates')?.addEventListener('click', function(_event) {
    if(this.classList.contains('modern-btn-disabled')){
      return;
    }
    if (!selectedAddressData) {
       return;
    }
    console.log('selectedAddressData', selectedAddressData);
    bootbox.confirm({
      message: "Voulez-vous enregistrer cette adresse dans la configuration de la box ?",
      buttons: {
        confirm: {
          label: 'Oui',
          className: 'btn-success'
        },
        cancel: {
          label: 'Non',
          className: 'btn-danger'
        }
      },
      callback: function(result) {
        if (result) {
          configSave({
            'info::address': selectedAddressData.address.house_number ? selectedAddressData.address.house_number + ' ' + selectedAddressData.address.road : selectedAddressData.address.road,
            'info::postalCode': selectedAddressData.address.postcode,
            'info::city': selectedAddressData.address.city,
            'info::stateCode': selectedAddressData.address.country_code.toUpperCase(),
          });
          $('#div_alert').showAlert({ message: "Adresse enregistrée en configuration", level: 'success' });
        }
        bootbox.confirm({
          message: "Voulez-vous enregistrer vos points coordonnés ?",
          buttons: {
            confirm: {
              label: 'Oui',
              className: 'btn-success'
            },
            cancel: {
              label: 'Non',
              className: 'btn-danger'
            }
          },
          callback: function(secondResult) {
            if (secondResult) {
                configSave({
                    'info::latitude': document.getElementById('in_latitude').value,
                    'info::longitude': document.getElementById('in_longitude').value,
                });
                $('#div_alert').showAlert({ message: "Adresse enregistrée en configuration", level: 'success' });
            } else {

            }
          }
        });
      }

    });
  });

  jeedomUtils.initTooltips();
  document.querySelector('#sel_timezone > option[value="' + _timezone + '"]').selected = true;

  document.getElementById('sel_timezone').addEventListener('change', function(_event) {
    configSave({
      timezone: this.value
    });
  });

  document.getElementById('in_boxName').addEventListener('change', function(_event) {
    configSave({
      name: this.value
    });
  });

  document.getElementById('in_latitude').addEventListener('change', function(_event) {
    configSave({
      'info::latitude': this.value
    });
  });

  document.getElementById('in_longitude').addEventListener('change', function(_event) {
    configSave({
      'info::longitude': this.value
    });
  });
})();
</script>


<style>

.hidden {
display: none;
}

.popUp{
font-size : 1.6em;
}

#suggestions {
    list-style-type: none; 
    padding: 0; 
    margin: 0; 
    width: 50%; 
    min-width: 400px; 
    min-height: 50px;
    display: none; 
    border: 1px solid #ccc; 
    max-height: 150px; 
    overflow-y: auto;
    background-color: rgba(100, 160, 230, 0.5);
    color: black;
  }


#suggestions li:hover {
background-color: #94CA04;
}

.inputcontainer {
  position: relative;
  width: 100%;
}

.icon-container {
  position: absolute;
  right: 10px;
  top: calc(50% - 10px);
}
.loader {
  position: relative;
  height: 20px;
  width: 20px;
  display: inline-block;
  animation: around 5.4s infinite;
}

@keyframes around {
  0% {
    transform: rotate(0deg)
  }
  100% {
    transform: rotate(360deg)
  }
}

.loader::after, .loader::before {
  content: "";
  background: #E0E2E2;
  position: absolute;
  display: inline-block;
  width: 100%;
  height: 100%;
  border-width: 2px;
  border-color: #94CA04 #94CA04 transparent transparent;
  border-style: solid;
  border-radius: 20px;
  box-sizing: border-box;
  top: 0;
  left: 0;
  animation: around 0.7s ease-in-out infinite;
}

.loader::after {
  animation: around 0.7s ease-in-out 0.1s infinite;
  background: transparent;
}

.modern-btn {
    background-color: #94CA04 !important;
  }

  .modern-btn-disabled {
    background-color: #cc6600;
  }

  .modern-btn:hover {
    cursor: pointer !important;
  }

</style>
