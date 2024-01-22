<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}


$jsonrpc = repo_market::getJsonRpc();

if ($jsonrpc->sendRequest('servicepack::info')) {
    $result = $jsonrpc->getResult();
    $servicePack = $result['licenceName'];
}


if($servicePack != community){
  ?>
    <script>
       document.getElementById('externalDiv').style.display = 'flex';
    </script>
        
  <?php 
  
}

?>
<div class="col-md-12 text-center">
	<h2>{{Vous êtes prêt à commencer}}</h2>
</div>
  <div class="mainContainer col-md-12" style="display:flex;flex-direction:row;justify-content:center;align-items:center;margin-bottom:5%;">
          <div style="display:flex;justify-content:center;width:50%;background: rgba(0,0,0,0);"><img src="plugins/jeeasy/core/img/greenthumb.png" alt="pouce de validation" style="border-radius:5px 5px 0 0;width:25%;height:25%;background: rgba(0,0,0,0);"></div>
          <div class="divinformationsBox col-md-12" style="display:flex;flex-direction:column;width:50%;">
                 <div class="divnetworkBox">
                      <label style="margin-left:auto; margin-right:auto;margin-bottom:2%;">Informations réseau de votre box : </label>
                      <div class="internalDiv" style="display:flex;flex-direction:row;margin-left:5%;">
                            <label style="color:#93ca02">{{ Adresse locale de votre box : }}</label>
                             <div id="divInternalIp" style="font-weight:bold;margin-left:1%;"><?= network::getNetworkAccess('internal'); ?> </div>
                       </div>
                        <div class="externalDiv" id="externalDiv" style="display:none;flex-direction:row;margin-left:5%;">
                              <label style="color:#93ca02">{{Adresse externe de votre box : }}</label> 
                              <div id ="divExternalIp" style="font-weight:bold;margin-left:1%;"> <?= 
                                    network::getNetworkAccess('external') == 'http:' ? 'OpenVpn en cours d installation, merci de redemarrer le service DNS après son installation' : network::getNetworkAccess('external'); 
                                    ?> 
                               </div>
                       </div>
                 </div>            
                  <div class="divMobileBox" hidden>
                                <label style="margin-left:auto; margin-right:auto;margin-bottom:2%;">Plugin Mobile : </label>
                 </div>
          </div>
   </div>
  

<?php
  $mbState = config::byKey('mbState');
  if ($mbState == 0) {
?>
<div class="col-md-12 text-center">
	<p>{{Vous pourrez trouver la documentation complète de Jeedom à cette adresse}} : <a href="https://www.jeedom.com/doc" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Documentation}}</a></p>
	<p>{{Vous pouvez également rejoindre notre communauté et poser toutes vos questions}} : <a href="https://community.jeedom.com" target="_blank" class="btn btn-default btn-xs" role="button"><i class="fas fa-book"></i> {{Communauté Jeedom}}</a></p>
</div>

<?php
  }
?>