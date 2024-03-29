<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}


$actualLanguage = config::byKey('language');
log::add('jeeasy','debug','test '.$atualLanguage);

if (file_exists(config::byKey('path_wizard')))
  $path_wizard = json_decode(file_get_contents(config::byKey('path_wizard')), true);
else
  $path_wizard = json_decode(file_get_contents('plugins/jeeasy/core/data/wizard.json'), true);



?>
  
  <script>
  $('#languageJeeasy option[value="<?= $actualLanguage; ?>"]').prop('selected', true);
  
  </script>

<div class="mainContainer" style="height:100%;display:flex;flex-direction:column;justify-content:center;">
<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" style="width:80%;height:80%;" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
  <p class="text-center">
  <h3 class="titlelanguage" id="titlelanguage">{{Langage Systeme}}</h3>
  </p>
  <p class="text-center">
  <h4 class="textAtlas" style="color:#93ca02;"></h4>
  </p>
  
  
      <div style="display:flex;justify-content:center;">
            <select class="form-control selectpicker" id="languageJeeasy" style="width:350px">
                    <option value="fr_FR">Français</option>
                    <option value="en_US">English</option>
                    <option value="de_DE">Deutsch</option>
                    <option value="es_ES">Español</option>
                    <option value="it_IT">Italiano (nessun supporto)</option>
                    <option value="pt_PT">Português (sem apoio)</option>
                    <option value="ru_RU">Русский язык (без поддержки)</option>
                    <option value="ja_JP">日本語（非対応)</option>
                    <option value="id_ID">Bahasa Indonesia (tidak mendukung)</option>
                    <option value="tr">Türkçe (destek yok)</option>
            </select>
      </div>


  <br>


  <div class="testbtnb" style="display:flex; flex-direction:column;justify-content:center; align-items:center;">
    <p class="ignorebtn">{{Cliquez sur la flèche pour ignorer}}</p>
  </div>

</div>



  <script>

  
  $('#languageJeeasy').on('change', function() {
        $('#bt_next').show();
        $('.textAtlas').append($('#languageJeeasy option:selected').text());
        $('#titlelanguage').hide();
        $.ajax({
          type: "POST",
          url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
          data: {
            action: "choiceLanguageJeeasy",
            choice: $('#languageJeeasy').val()
          },
          dataType: 'json',
          error: function(request, status, error) {
            console.log(status);
            handleAjaxError(request, status, error);
          },
          success: function(data) {
            $('#md_modal').dialog({
              title: "{{Bienvenue}}"
            });
            $("#md_modal").load('index.php?v=d&modal=wizard&plugin=jeeasy').dialog('open');
          }
        });
    });
  
  


  </script>