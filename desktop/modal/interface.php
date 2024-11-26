<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$themesDescription = array(
    'core2019_Light' => '{{Clair}}/Light',
    'core2019_Dark' => '{{Sombre}}/Dark'
);
if (version_compare(jeedom::version(), '4.4', '>=')) {
    $defaultTheme = config::byKey('jeedom_theme_main');
    $alternateTheme = config::byKey('jeedom_theme_alternate');
} else {
    $defaultTheme = config::byKey('default_bootstrap_theme');
    $alternateTheme = config::byKey('default_bootstrap_theme_night');
}
?>

<h3>{{Paramètres d'affichage}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<div class="bold">{{Vous pouvez modifier certains paramètres d'affichage de votre installation puis passer à l'étape suivante}}
    <i class="far fa-arrow-alt-circle-right"></i>
</div>
<div class="input-group <?= ($defaultTheme == $alternateTheme) ? ' hidden' : ''  ?>">
    <span class="input-group-addon roundedLeft">{{Thème}}
        <sup><i class="fas fa-question-circle" title="{{Sélectionner le thème de l'interface}}"></i></sup>
    </span>
    <select class="form-control roundedRight" id="in_theme">
        <option value="<?= $defaultTheme ?>"><?= $themesDescription[$defaultTheme] ?> ({{Principal}})</option>
        <option value="<?= $alternateTheme ?>"><?= $themesDescription[$alternateTheme] ?> ({{Alternatif}})</option>
    </select>
</div>

<script>
    jeedomUtils.initTooltips()

    document.querySelector('#in_theme option[value="' + document.body.dataset.theme + '"]').selected = true
    document.getElementById('in_theme').addEventListener('change', function(_event) {
        jeedomUtils.switchTheme()
    })
</script>


<!-- <h3>{{Personnalisation de l'interface}}</h3>
    <img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
    <br>
    <label>{{Icones colorées}} : </label>
    <input type="checkbox" id="changeColoredIcons"></checkbox>




<script>

// Fonction pour eviter conflits de portée
(function() {

    let coloredIcons = '<?= config::byKey('interface::advance::coloredIcons'); ?>';

    let checkboxColored = document.getElementById('changeColoredIcons');

    let isInitialUpdate = true;

    checkboxColored.checked = coloredIcons == '1'  ? true : false;

    isInitialUpdate = false;


    checkboxColored.addEventListener('click', function(_event) {
        if (isInitialUpdate) {
            return;
        }

        let newColoredIcons = checkboxColored.checked ? 1 : 0;
        jeedom.config.save({
            configuration: {
                'interface::advance::coloredIcons': newColoredIcons
            },
            error: function(_error) {
                jeedomUtils.showAlert({
                    message: _error.message,
                    level: 'danger'
                });
            },
            success: function() {
                jeedomUtils.showAlert({
                    message: '{{Les icones colorées sont}} : <strong>' + (newColoredIcons ? 'Activées' : 'Désactivées') + '</strong>',
                    level: 'success',
                    timeOut: 3000
                });
            }
        });
    });
})();
</script> -->
