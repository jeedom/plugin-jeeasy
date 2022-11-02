<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

if (file_exists(config::byKey('path_pluginConfig'))) {
    $path_pluginsConf = json_decode(file_get_contents(config::byKey('path_pluginConfig')), true);
} else {
    $path_pluginsConf = json_decode(file_get_contents('plugins/jeeasy/core/data/pluginConfig.json'), true);
}

$hostname = shell_exec('cat /etc/hostname');

if (strpos($hostname, 'Luna') !== false) {
    config::save('hardware_name', "Luna");
    $productName = 'Luna';
}else{
    $productName = jeedom::getHardwareName();
}

$listPlugins = plugin::listPlugin();




$i = 0;

if ($listPlugins) {
    foreach ($listPlugins as $plugin) {
        $nameplug = $plugin->getId();

        if (array_key_exists($nameplug, $path_pluginsConf['pluginsInfos']) == true) {
            $i++;


            $step = $path_pluginsConf['pluginsInfos'][$nameplug]['versions'];
            foreach ($step as $key => $value) {
                if ($key == $productName) {
?> <script>
                        $('#pluginsConfigSelect').append($('<option>', {
                            nameplugin: '<?= $nameplug; ?>',
                            typebox: '<?= $productName; ?>',
                            config: 'gpio',
                            text: '<?= $nameplug; ?> : {{Configuration du contrôleur interne (GPIO)}}'
                        }));
                        $('#pluginsConfigSelect').append($('<option>', {
                            nameplugin: '<?= $nameplug; ?>',
                            typebox: '<?= $productName; ?>',
                            config: 'usb',
                            text: '<?= $nameplug; ?> : {{Configuration du contrôleur USB}}'
                        }));
                    </script>
        <?php
                }
            }
        }
    }
    if ($i == 0) {
        ?> <script>
            $('#choiceMode').hide();
            $('.textConfigAutoPlug').text('{{Aucun Plugin installé à paramétrer}}');
            $('#btn-choiceConfig').hide();
            $('#pluginsConfigSelect').hide();
        </script>
    <?php

    }
} else {
    ?> <script>
        $('#choiceMode').hide();
        $('.textConfigAutoPlug').text('{{Aucun Plugin installé à paramétrer}}');
        $('#btn-choiceConfig').hide();
        $('#pluginsConfigSelect').hide();
    </script>
<?php

}

?>
<script>
    $('#btn-choiceConfig').on('click', function() {
        var choiceConfig = $('#pluginsConfigSelect option:selected').attr('config');
        var typeBox = $('#pluginsConfigSelect option:selected').attr('typebox');
        var pluginName = $('#pluginsConfigSelect option:selected').attr('nameplugin');

        $.ajax({
            type: "POST",
            url: "plugins/jeeasy/core/ajax/jeeasy.ajax.php",
            data: {
                action: "configInternalPlugin",
                typeConfig: choiceConfig,
                typeBox: typeBox,
                pluginName: pluginName
            },
            dataType: 'json',
            error: function(request, status, error) {
                console.log(status);
                handleAjaxError(request, status, error);
            },
            success: function(data) {
                console.log(data);
                if (data.result == 'usb') {
                    $('.textConfigAutoPlug').text('{{Vous avez choisi un contrôleur USB, veuillez le configurer dans la gestion de votre plugin}}');
                    $('#choiceMode').hide();
                } else if (data.result == 'gpio') {
                    $('#choiceMode').hide();
                    $('.textConfigAutoPlug').text('{{Votre plugin à été configuré automatiquement}}');

                }
            }
        });
    });


    $('#pluginsConfigSelect').on('change', function() {
        $('#choiceMode').show();
        $('.textConfigAutoPlug').text('');
    });
</script>

<div class="col-md-6 col-md-offset-3 text-center"><img class="img-responsive center-block img-atlas" src="<?php echo config::byKey('product_connection_image'); ?>" /></div>
<div class="col-md-12 text-center">
    <p class="text-center">
    <h3 class="configplugins" style="color:#93ca02;">{{Configuration Auto des Plugins}} :</h3>
    </p>
    <p class="text-center">
    <h4 class="configplugins" style="font-weight: bold;">{{Votre box est une}} <?= $productName; ?></h4>
    </p>
    <p class="text-center">
    <h4 class="configplugins" id="choiceMode">{{Choississez le mode de configuration du plugin}} :</h4>
    </p>
    <p class="text-center">
    <h4 class="textConfigAutoPlug" style="color:#93ca02;"></h4>
    </p>
    <table class="table table-hover" id="pluginsConfigTab" style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
        <thead>
        </thead>
        <tbody>
            <select id="pluginsConfigSelect">
            </select>
        </tbody>
    </table>

    <div class="testbtn" style="display:flex; flex-direction:column;justify-content:center; align-items:center;">
        <button type="button" class="btn btn-primary btn-success btn-lg" id="btn-choiceConfig" style="margin-bottom:10px;">{{Valider}}</button>
        <p style="font-weight: bold">{{OU}}</p>
        <p class="ignorebtn">{{Cliquez sur la flèche pour ignorer}}</p>
    </div>


    <div id="contenuTextSpan" class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated active" id="div_progressbar" role="progressbar" style="width: 0; height:20px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
</div>
</div>
</div>
