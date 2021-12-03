<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}



if( file_exists( config::byKey('path_wizard') ) )
  $path_wizard = json_decode( file_get_contents( config::byKey( 'path_wizard' ) ), true );
else
  $path_wizard = json_decode( file_get_contents('plugins/jeeasy/core/data/wizard.json'), true );

$custom = null;


?>

<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
<p class="text-center"><h3 class="titlelanguage" id="titlelanguage">Language Système : </h3></p>
<p class="text-center"><h4 class="textAtlas" style="color:#93ca02;"></h4></p>

<select class="form-control" id="languageJeeasy">
              <option value="fr_FR">{{Français}}</option>
              <option value="en_US">{{Anglais}}</option>
              <option value="de_DE">{{Allemand}}</option>
              <option value="es_ES">{{Espagnol}}</option>
              <option value="it_IT">{{Italien (pas de support)}}</option>
              <option value="pt_PT">{{Portugais (pas de support)}}</option>
              <option value="ru_RU">{{Russe (pas de support)}}</option>
              <option value="ja_JP">{{Japonais (pas de support)}}</option>
              <option value="id_ID">{{Indonesien (pas de support)}}</option>
              <option value="tr">{{Turque (pas de support)}}</option>
</select>
<br>

<div class="btnlanguage">
    <a class='btn btn-success btn-md pull-right' id="btn-language" style="margin-right:50px" >Valider</a>
</div>



<script>
    $('#bt_next').hide();

       $('#btn-language').on('click', function () {
             	$('#bt_next').show();
            	$('.textAtlas').text('{{Nouvelle langue système choisie : }}');
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
                 error: function (request, status, error) {
                   console.log(status);
                   handleAjaxError(request, status, error);
                 },
                 success: function (data) {
                   console.log(data);
                 }
             });
           });
</script>


<?php
