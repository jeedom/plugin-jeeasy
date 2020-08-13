<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div class="col-md-12 text-center"><h2>{{Les assistants vocaux}}</h2></div>
<div class="col-xs-18 col-sm-12 col-md-6 col-md-offset-3">
    <div class="thumbnail" style="box-shadow: 1px 1px 12px #93cc0180;"><img src="plugins/jeeasy/core/img/service_vocal.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0;">
        <div class="caption">
            <h4>Assistants vocaux</h4>
            <p></p>
            <center><a href="https://jeedom.github.io/documentation/howto/fr_FR/assistant_vocaux_cloud" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> Documentation</a></center>
            <p></p>
            <p>Nous vous proposons une connexion facile pour profiter des assistants vocaux "Amazon Alexa" et "Google Assistant"</p>
            <p></p>
            <center><a href="https://jeedom.github.io/plugin-gsh/fr_FR/" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> Google Assistant</a> <a href="https://jeedom.github.io/plugin-ash/fr_FR/" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> Amazon Alexa</a></center>
        </div>
    </div>
</div>
