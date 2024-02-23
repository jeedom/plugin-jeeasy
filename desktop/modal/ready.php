<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$jsonrpc = repo_market::getJsonRpc();
$servicePack = '';
if ($jsonrpc->sendRequest('servicepack::info')) {
    $result = $jsonrpc->getResult();
    $servicePack = $result['licenceName'];
}

$externalDivDisplay = ($servicePack !== 'community') ? 'flex' : 'none';
?>

<div class="mainContainer" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <div class="col-md-12 text-center" style="height:30%;">
        <h2>{{Vous êtes prêt à commencer}}</h2>
        <img src="plugins/jeeasy/core/img/greenthumb.png" alt="pouce de validation" style="border-radius: 5px; width: 10%; height: 10%;">
    </div>

        <!-- <div style="width: 50%; background: rgba(0,0,0,0); text-align: center;">
          
        </div> -->
        <!-- <div class="divinformationsBox col-md-12" style="width: 50%; text-align: left;"> -->
            <label style="margin-bottom: 2%;">Informations réseau de votre box</label>
            <div class="divnetworkBox" style="width:100%;display:flex;flex-direction:column;justify-content:center;align-items:center;">
                
                <div class="internalDiv" style="display:flex;width:60%">
                    <label style="color: #93ca02;">Adresse locale de votre box :</label>
                    <div id="divInternalIp" style="font-weight: bold; margin-left: 1%;"><?= network::getNetworkAccess('internal'); ?></div>
                </div>
                <div class="externalDiv" id="externalDiv" style="display: <?= $externalDivDisplay ?>; width:60%">
                    <label style="color: #93ca02;">Adresse externe de votre box :</label>
                    <div id="divExternalIp" style="font-weight: bold; margin-left: 1%;">
                        <?= (network::getNetworkAccess('external') == 'http:') ? 'OpenVpn en cours d installation, merci de redemarrer le service DNS après son installation' : network::getNetworkAccess('external'); ?>
                    </div>
                </div>
            </div>
        <!-- </div> -->



<?php
$mbState = config::byKey('mbState');
if ($mbState == 0) {
?>
<div class="col-md-12 text-center" style="margin-top: 20px;">
    <p>{{Vous pourrez trouver la documentation complète de Jeedom à cette adresse}} : <a href="https://www.jeedom.com/doc" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Documentation}}</a></p>
    <p>{{Vous pouvez également rejoindre notre communauté et poser toutes vos questions}} : <a href="https://community.jeedom.com" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Communauté Jeedom}}</a></p>
</div>
<?php
}
?>
    <div class="divinformationsBox col-md-12" style="width: 50%; text-align: left;">
        <div class="alert alert-warning" role="alert" id="alertDependancy">
            {{Des dépendances sont toujours en cours d'installation, vous pouvez suivre l'avancement dans la page santé}}
        </div>
    </div>
</div>