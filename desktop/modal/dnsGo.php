<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

if (file_exists(config::byKey('path_wizard')))
  $path_wizard = json_decode(file_get_contents(config::byKey('path_wizard')), true);
else
  $path_wizard = json_decode(file_get_contents('plugins/jeeasy/core/data/wizard.json'), true);


$jsonrpc = repo_market::getJsonRpc();
$marketURL = config::byKey('market::address');
$productName = jeedom::getHardwareName();
$servicePack = '';

if ($jsonrpc->sendRequest('servicepack::info')) {
  $result = $jsonrpc->getResult();
  $servicePack = $result['licenceName'];
}

if ($servicePack != 'Community') {
?>
  <script>
    $('#bt_next').hide();
    $('#bt_prev').show();

    dnsInstall();

    function dnsInstall() {
       progress(20);
       $('.textAtlas').html('{{Le plugin OpenVpn est en cours d\'installation... Veuillez patientez}}');
       progress(40);
      $.ajax({
        type: "POST",
        url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
        data: {
          action: "dnsInstall"
        },
        dataType: 'json',
        error: function(request, status, error) {
          handleAjaxError(request, status, error);
        },
        success: function(data) {
          progress(100);
          $('.textAtlas').html('');
          $('.textAtlas').html('{{Le plugin OpenVpn a bien été installé et configuré. Cliquez sur suivant}}');
        }
      });
    }


    function progress(ProgressPourcent) {
      if (ProgressPourcent == -1) {
        $('#div_progressbar').removeClass('progress-bar-success progress-bar-info progress-bar-warning');
        $('#div_progressbar').addClass('active progress-bar-danger');
        $('#div_progressbar').width('100%');
        $('#div_progressbar').attr('aria-valuenow', 100);
        $('#div_progressbar').html('N/A');
        return;
      }
      if (ProgressPourcent == 100) {
        $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
        $('#div_progressbar').addClass('progress-bar-success');
        $('#div_progressbar').width(ProgressPourcent + '%');
        $('#div_progressbar').attr('aria-valuenow', ProgressPourcent);
        $('#div_progressbar').html('FIN');
        Good();
        return;
      }
      $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
      $('#div_progressbar').addClass('progress-bar-success');
      $('#div_progressbar').width(ProgressPourcent + '%');
      $('#div_progressbar').attr('aria-valuenow', ProgressPourcent);
      $('#div_progressbar').html(ProgressPourcent + '%');
    }

    function Good() {
      $('#bt_next').show();
      $('#bt_prev').show();
      $('.img-atlas').attr('src', '<?php echo config::byKey('product_connection_image'); ?>');
    }
  </script>

  <div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
  <div class="col-md-12 text-center">
    <p class="text-center">
       <h4 class="textAtlas" style="margin-top:35px;"></h4>
    </p>

    <div id="contenuTextSpan" class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
  </div>

<?php

}else{

?>
<script>
$('#bt_next').show();
</script>
<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
  <p class="text-center">
     <h4 class="textAtlas" style="margin-top:35px;">Vous etes en service Pack Community. Pas de configuration OpenVpn nécessaire. Cliquez sur suivant</h4>
  </p>
</div>

<?php
} ?>
