<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div class="col-md-12 text-center"><h2>{{Vous êtes prêt à commencer}}</h2></div>
<div class="col-xs-18 col-sm-12 col-md-6 col-md-offset-3">
    <div class="thumbnail"><img src="plugins/jeeasy/core/img/check.jpg" alt="" class="img-fullsize" style="border-radius:5px 5px 0 0;"></div>
</div>
<div class="col-md-12 text-center">
<p>{{Vous pourrez trouver la documentation complète de Jeedom à cette adresse :}} <a href="https://www.jeedom.com/doc" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Documentation}}</a></p>
<p>{{Vous pouvez également vous inscrire sur notre communauté et poser toutes vos questions :}} <a href="https://community.jeedom.com" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Communauté Jeedom}}</a></p>
</div>
