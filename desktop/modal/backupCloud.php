<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

?>

<div class="nos-services text-center">
    <div id="backup" class="col-xs-18 col-sm-6 col-md-3 services">
        <div class="thumbnail" style="box-shadow: 1px 1px 12px #93cc0180; height: 430px;"><img src="plugins/jeeasy/core/img/service_backup.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0;">
            <div class="caption">
                <h4>{{Les Sauvegardes Cloud}}</h4>
                <p></p>
                <p class="text-center"><a href="https://doc.jeedom.com/<?= $actualLanguage; ?>/howto/backup_cloud" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Documentation}}</a></p>
                <p></p>
                <p>{{Nous vous proposons de sauvegarder votre Jeedom chaque nuit de façon sécurisée avec vos propres mots de passe. Soyez rassurés du moindre souci sur votre Jeedom. De plus nous économisons votre bande passante en sauvegardant uniquement les changements.}}</p>
            </div>
        </div>
    </div>
		<div style="display:flex;flex-direction:column;justify-content:center;">
		     <h3>Assurez la Pérennité de Votre Système avec le Service Backup Cloud de Jeedom</h3>

					<p>Nous mettons en avant notre service Backup Cloud car il représente la solution incontournable pour garantir la pérennité de votre système Jeedom.</p>
					<p> En cas de problème avec votre Jeedom, la possibilité de restaurer rapidement votre configuration sur un autre matériel ou sur votre box remise à jour est un atout majeur.</p>

					<p>Imaginez : un problème surgit, et vous pouvez restaurer votre Jeedom en quelques minutes, préservant ainsi des mois de travail et de configurations.</p>

					<h2>Comment Configurer le Service Backup Cloud sur Votre Jeedom :</h2>

					<p><strong>Accédez à la Configuration :</strong> Rendez-vous dans l'interface Jeedom, puis dans l'onglet "Configuration" et sélectionnez "Système".</p>
					<p><strong>Paramètres du Market :</strong> Cliquez sur l'onglet "Réglages" et accédez à la section "Market". Ici, entrez un nom de backup, qui peut être votre nom Jeedom, et un mot de passe.</p>
					<p>Ce mot de passe est crucial pour reconfigurer le Backup Cloud après un éventuel reset.</p>
					<p><strong>Activez les Sauvegardes Cloud :</strong> Dirigez-vous ensuite vers la page "Sauvegarde" sur votre Jeedom. Activez l'envoi des sauvegardes vers le Market une fois que l'onglet "Market/BackupCloud" est correctement renseigné.</p>

					<p><strong>Conseil Important :</strong> Gardez précieusement ce mot de passe, car il sera indispensable pour reconfigurer le Backup Cloud sur la box après un éventuel reset.</p>

					<p>Ne prenez aucun risque. Configurez dès maintenant le service Backup Cloud sur votre Jeedom et assurez-vous de la sécurité et de la continuité de vos données.</p>
		</div>
 
</div>
<style>
    .nos-services {
        margin-top: 15px;
        text-align: center;
    }

</style>
