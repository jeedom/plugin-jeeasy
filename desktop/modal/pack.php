<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<h2 class="center">{{Découvrez nos Services Packs}}</h2>
        <table class="table table-hover">
          <thead>
            <tr>
              <th></th>
              <th>Community</th>
              <th>Power</th>
              <th>Ultimate</th>
              <th>Pro</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{Inclus avec}}</td>
              <td>{{Tous}}</td>
              <td>{{Box Smart}}</td>
              <td>{{En option (45€)}}</td>
              <td>{{Box Pro}}</td>
            </tr>
            <tr>
              <td>{{Plugins offerts}}</td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td>{{Alarme et RFXcom}}</td>
              <td>{{Tous les Officiels}}</td>
              <td>{{Tous les Officiels}}</td>
            </tr>
            <tr>
              <td>{{Passerelle SMS crédit (web)}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{60 SMS offerts}}</td>
              <td>{{60 SMS offerts}}</td>
              <td>{{100 SMS offerts}}</td>
            </tr>
            <tr>
              <td>{{Passerelle VOIP (web)}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{Avec crédit}}</td>
              <td>{{Avec crédit}}</td>
            </tr>
            <tr>
              <td>{{Périphériques supportés}}</td>
              <td>{{Illimité}}</td>
              <td>{{Illimité}}</td>
              <td>{{Illimité}}</td>
              <td>{{Illimité}}</td>
            </tr>
            <tr>
              <td>{{Multi Antennes déportées}}</td>
              <td>1</td>
              <td>4</td>
              <td>4</td>
              <td>9</td>
            </tr>
            <tr>
              <td>{{Application native IOS/Android}}</td>
              <td>4€</td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{DNS dynamique et HTTPS}}</td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Backup cloud}}</td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{2€/mois}}</a></td>
            </tr>
	    <tr>
              <td>{{Monitoring}}</td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{1€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{1€/mois}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{1€/mois}}</a></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
	    </tr>
            <tr>
              <td>{{Accès à la gestion de Parc}}</td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Marque blanche}} <sup>(1)</sup></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Support forum}}</td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
              <td><i class="fas fa-check" style="color:#96c927"></i></td>
            </tr>
            <tr>
              <td>{{Assistance Jeedom}} <sup>(2)</sup></td>
              <td>{{2 / mois}}<sup>(3)</sup></td>
              <td>{{10 / mois}}</td>
              <td>{{10 / mois}}</td>
              <td>{{Illimité}}</td>
            </tr>
            <tr>
              <td>{{Délai de réponse}} </td>
              <td><i class="fas fa-times" style="color : #E53935"></i></td>
              <td>{{Rapide}}</td>
              <td>{{Rapide}}</td>
              <td>{{48 h ouvrées}}</td>
            </tr>
            <tr>
              <td></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://jeedom.github.io/documentation/installation/fr_FR/index">{{Gratuit}}</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{Acheter}} (50€)</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" target="_blank" href="https://www.jeedom.com/market/index.php?v=d&p=profils#services">{{Acheter}} (85€)</a></td>
              <td><a class="waves-effect waves-light btn" style="background-color:#96c927" href="https://www.jeedom.com/site/fr/pro.html">{{En savoir plus}}</a></td>
            </tr>

          </tbody>
        </table>
        <p style="font-size:10px; line-height:14px;">
        <sup>(1)</sup> : {{Selon conditions contractuelles}}<br/>
	<sup>(2)</sup> : {{Tickets sur plugin officiel}}<br/>
	<sup>(3)</sup> : {{Uniquement sur les plugins payants}}<br/>
        </p>
