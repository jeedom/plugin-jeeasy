<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

config::save('updateWizard', 'okay', 'jeeasy');
?>



<div class="bodyModal animated slideInRight">
  <div class="multisteps-form">
    <div class="row" id="contentModal">
	    <div class="col-md-12 text-center"><h2>{{Initialisation de }} <?php echo config::byKey('product_name'); ?></h2></div>
		<div class="col-md-8 col-md-offset-2 text-center"><img class="img-responsive center-block" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
		<div class="col-md-12 text-center"><p class="text-center"><br/>{{Veuillez patienter quelques instants, cela peut prendre au maximum 10 minutes}}</p>

		<div id="contenuTextSpan" class="progress">
			<div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
			</div>
		</div>
    </div>
  </div>
</div>

<style>
#md_modal {
  <?php
    if(config::byKey('product_connection_color') != ''){
      echo "background:".config::byKey('product_connection_color')." !important;";
    }else{
      echo "background-image: linear-gradient(to bottom right, rgba(147,204,1,0.6), rgba(147,204,1,1)) !important;";
    }
  ?>
}

.next {
  font-size: 50px;
  color: rgba(147,204,1,1);
}

.saveDiv {
  width: 100px;
  height: 100px;
  margin-right: -45px;
  bottom: -40px;
  right: 5px;
  position: absolute;
}

.prevDiv {
  width: 100px;
  height: 100px;
  margin-right: -45px;
  bottom: -40px;
  left: 5px;
  position: absolute;
}

.nextDiv {
  width: 100px;
  height: 100px;
  margin-right: -45px;
  bottom: -40px;
  right: 5px;
  position: absolute;
}

.bodyModal{
  background-color : white;
  width: 75%;
  min-height: 85%;
  margin: 0 auto;
  padding: 20px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  position: relative;
}
.multisteps-form {
  margin-bottom:0px;
}
</style>

<script>
$('#dada').click(function() {
	$('#md_modal').dialog({title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?>"});
	$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
});
</script>

<script>
var progress = -2;

function updateProgressBar(){
  if(progress == -4){
    $('#div_progressbar').removeClass('active progress-bar-info progress-bar-success progress-bar-danger');
    $('#div_progressbar').addClass('progress-bar-warning');
    return;
  }
  if(progress == -3){
    $('#div_progressbar').removeClass('active progress-bar-info progress-bar-success progress-bar-warning');
    $('#div_progressbar').addClass('progress-bar-danger');
    return;
  }
  if(progress == -2){
    $('#div_progressbar').removeClass('active progress-bar-info progress-bar-success progress-bar-danger progress-bar-warning');
    $('#div_progressbar').width(0);
    $('#div_progressbar').attr('aria-valuenow',0);
    $('#div_progressbar').html('0%');
    return;
  }
  if(progress == -1){
    $('#div_progressbar').removeClass('progress-bar-success progress-bar-danger progress-bar-warning');
    $('#div_progressbar').addClass('active progress-bar-info');
    $('#div_progressbar').width('100%');
    $('#div_progressbar').attr('aria-valuenow',100);
    $('#div_progressbar').html('N/A');
    return;
  }
  if(progress == 100){
    $('#div_progressbar').removeClass('active progress-bar-info progress-bar-danger progress-bar-warning');
    $('#div_progressbar').addClass('progress-bar-success');
    $('#div_progressbar').width(progress+'%');
    $('#div_progressbar').attr('aria-valuenow',progress);
    $('#div_progressbar').html(progress+'%');
    return;
  }
  $('#div_progressbar').removeClass('progress-bar-success progress-bar-danger progress-bar-warning');
  $('#div_progressbar').addClass('active progress-bar-info');
  $('#div_progressbar').width(progress+'%');
  $('#div_progressbar').attr('aria-valuenow',progress);
  $('#div_progressbar').html(progress+'%');
}

function getJeedomLog(_autoUpdate, _log) {
  $.ajax({
    type: 'POST',
    url: 'core/ajax/log.ajax.php',
    data: {
      action: 'get',
      log: _log,
    },
    dataType: 'json',
    global: false,
    error: function (request, status, error) {
      setTimeout(function () {
        getJeedomLog(_autoUpdate, _log)
      }, 1000);
    },
    success: function (data) {
      if (data.state != 'ok') {
        setTimeout(function () {
          getJeedomLog(_autoUpdate, _log)
        }, 1000);
        return;
      }
      var log = '';
      if($.isArray(data.result)){
        for (var i in data.result.reverse()) {
          log += data.result[i]+"\n";
          if(data.result[i].indexOf('[END ' + _log.toUpperCase() + ' SUCCESS]') != -1){
            progress = 100;
            updateProgressBar();
            $('#md_modal').dialog({title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?>"});
			$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
            _autoUpdate = 0;
          }
          if(data.result[i].indexOf('[END ' + _log.toUpperCase() + ' ERROR]') != -1){
            progress = -3;
            updateProgressBar();
            $('#md_modal').dialog({title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?> {{Mode dégradé}}"});
			$('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
            _autoUpdate = 0;
          }
          if(data.result[i].indexOf('[PROGRESS][5]') != -1){
          	if(progress < 5){
            	progress = 5;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][15]') != -1){
          	if(progress < 15){
            	progress = 15;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][25]') != -1){
          	if(progress < 25){
            	progress = 25;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][30]') != -1){
          	if(progress < 30){
            	progress = 30;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][35]') != -1){
          	if(progress < 35){
            	progress = 35;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][40]') != -1){
          	if(progress < 40){
            	progress = 40;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][50]') != -1){
          	if(progress < 50){
            	progress = 50;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][55]') != -1){
          	if(progress < 55){
            	progress = 55;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][75]') != -1){
          	if(progress < 75){
            	progress = 75;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
          if(data.result[i].indexOf('[PROGRESS][90]') != -1){
          	if(progress < 90){
            	progress = 90;
				updateProgressBar();
				_autoUpdate = 1;
			}
          }
        }
      }
      if (init(_autoUpdate, 0) == 1) {
        setTimeout(function () {
          getJeedomLog(_autoUpdate, _log)
        }, 1000);
      } else {
      }
    }
  });
}

jeedom.update.doAll({
    options: '',
    error: function (error) {
      $('#md_modal').dialog({title: "{{Configuration de votre}} <?php echo config::byKey('product_name'); ?> / {{Mode dégradé}}"});
	  $('#md_modal').load('index.php?v=d&plugin=jeeasy&modal=wizard').dialog('open');
    },
    success: function () {
      getJeedomLog(1, 'update');
    }
  });
</script>
