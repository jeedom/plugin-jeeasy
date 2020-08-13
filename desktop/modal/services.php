<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div class="col-md-12 text-center"><h2>{{Les services complémentaires}}</h2></div>
<div class="nos-services text-center">
    <div id="backup" class="col-xs-18 col-sm-6 col-md-3 services">
        <div class="thumbnail" style="box-shadow: 1px 1px 12px #93cc0180; height: 430px;"><img src="plugins/jeeasy/core/img/service_backup.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0;">
            <div class="caption">
                <h4>Les Sauvegardes Cloud</h4>
                <p></p>
                <p class="text-center"><a href="https://jeedom.github.io/core/fr_FR/backup" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> Documentation</a></p>
                <p></p>
                <p>Nous vous proposons de sauvegarder votre Jeedom chaque nuit de façon sécurisée avec vos propres mots de passe. Soyez rassurés du moindre souci sur votre Jeedom. De plus nous économisons votre bande passante en sauvegardant uniquement les changements.</p>
            </div>
        </div>
    </div>
    <div class="col-xs-18 col-sm-6 col-md-3 services" style="">
        <div class="thumbnail" style="box-shadow: rgba(147, 204, 1, 0.501961) 1px 1px 12px;  height: 430px;"><img src="plugins/jeeasy/core/img/service_sms.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0; height: 5OOpx;">
            <div class="caption">
                <h4>SMS et Appels</h4>
                <p></p>
                <p class="text-center"><a href="https://jeedom.github.io/documentation/howto/fr_FR/sms_cloud" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> Documentation</a> </p>
                <p></p>
                <p>Envoyez depuis votre Jeedom facilement un message écrit ou vocal sans posséder de clé 3G et sans abonnement. (nécessite une connexion internet)</p>
            </div>
        </div>
    </div>
    <div class="col-xs-18 col-sm-6 col-md-3 services">
        <div class="thumbnail" style="box-shadow: 1px 1px 12px #93cc0180;  height: 430px;"><img src="plugins/jeeasy/core/img/service_monitoring.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0; height: 5OOpx;">
            <div class="caption">
                <h4>Monitoring</h4>
                <p></p>
                <p class="text-center"><a href="https://jeedom.github.io/documentation/howto/fr_FR/monitoring_cloud" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> Documentation</a></p>
                <p></p>
                <p>Notre serveur vérifie certains critères vitaux de votre solution domotique et vous alerte en cas de souci. Même si celle-ci ne répond plus !</p>
            </div>
        </div>
    </div>
</div>
<style>
.nos-services{
	margin-top:15px;
	text-align: center;
}
#backup{
	margin-left:12%;
}
</style>
