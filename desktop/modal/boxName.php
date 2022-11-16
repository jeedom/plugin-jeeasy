<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}



if (file_exists(config::byKey('path_wizard')))
  $path_wizard = json_decode(file_get_contents(config::byKey('path_wizard')), true);
else
  $path_wizard = json_decode(file_get_contents('plugins/jeeasy/core/data/wizard.json'), true);

$hostname = shell_exec('cat /etc/hostname');

if (strpos($hostname, 'Luna') !== false) {
    config::save('hardware_name', "Luna");
    $productName = 'Luna';
}else{
    $productName = jeedom::getHardwareName();

}

if(config::byKey('name') == ''){
  $nameBox = 'Jeedom '.ucfirst($productName);
}else{
  $nameBox = config::byKey('name');
  
}

?>
  
 

<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:50%;height:50%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
  <p class="text-center">
  <h3 class="titlelanguage" id="titlelanguage">{{Nom actuel de votre box : }} <?= $nameBox ?></h3>
  </p>
  <p class="text-center">
  <h4 class="textAtlas" style="color:#93ca02;"></h4>
  </p>

  

  <input type="text" id="boxName" name="boxName" style="width:30%;" placeholder="{{ Nouveau nom de votre box (laissez vide pour laisser le nom par defaut) }}">
  <br>


  <div class="testbtnb" style="display:flex; flex-direction:row;justify-content:center; align-items:center;">
    <button type="button" class="btn btn-primary btn-success btn-lg" id="btn-BoxName" style="margin-bottom:10px;margin-top:10px;">{{Valider}}</button>
    <h4 id="textValidate" style="color:#93ca02;" hidden></h4>
    <button type="button" class="btn btn-primary btn-primary btn-lg" id="btn-BoxNameIgnore" style="margin-left:35px;margin-bottom:10px;margin-top:10px;">{{Ignorer}}</button>
  </div>



  <script>
   $('#bt_next').hide();
  $('#btn-BoxNameIgnore').click( function() {
      $('#bt_next').trigger('click');
      $('#bt_next').show();
  });
  
  
  
    $('#btn-BoxName').on('click', function() {
        let choiceUser = $('input:text').val();
        let newString = '{{Nouveau nom de votre box : }} ' + choiceUser
       
        $.ajax({
          type: "POST",
          url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
          data: {
            action: "changeBoxName",
            choice: choiceUser
          },
          dataType: 'json',
          error: function(request, status, error) {
            console.log(status);
            handleAjaxError(request, status, error);
          },
          success: function(data) {
            $('#btn-BoxName').hide();  
            $('#boxName').hide();
            $('#btn-BoxNameIgnore').hide();
            $('#bt_next').show();
            $('#textValidate').removeAttr('hidden');
            $('#textValidate').html('Choix Validé, cliquez sur Suivant');
            $('#titlelanguage').html(newString);
            
          }
        });
    });
  </script>
