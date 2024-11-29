<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$themesDescription = array(
    'core2019_Light' => '{{Clair}}/Light',
    'core2019_Dark' => '{{Sombre}}/Dark'
);
$defaultTheme = config::byKey('jeedom_theme_main');
$alternateTheme = config::byKey('jeedom_theme_alternate');
$coloredIcons = config::byKey('interface::advance::coloredIcons');
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

<div class="input-group">
    <span class="input-group-addon roundedLeft">{{Couleur des icônes}}
        <sup><i class="fas fa-question-circle" title="{{Cliquer sur le bouton pour basculer la coloration des icônes}}"></i></sup>
    </span>
    <div class="input-group-addon flex-evenly" style="font-size:20px;height:32px;">
        <i class="fas fa-check-circle icon_green"></i>
        <i class="fas fa-exclamation-circle icon_orange"></i>
        <i class="fas fa-times-circle icon_red"></i>
        <i class="fas fa-lightbulb icon_yellow"></i>
        <i class="fas fa-tint icon_blue"></i>
    </div>
    <span class="input-group-btn">
        <button class="btn btn-primary roundedRight" title="<?= ($coloredIcons == 1) ? '{{Ne pas colorer les icônes}}' : '{{Colorer les icônes}}' ?>" id="btn_coloredIcons" data-state="<?= $coloredIcons ?>">
            <i class="fas fa-sync-alt"></i>
        </button>
    </span>
</div>
<script>
    jeedomUtils.initTooltips()

    document.querySelector('#in_theme option[value="' + document.body.dataset.theme + '"]').selected = true
    document.getElementById('in_theme').addEventListener('change', function() {
        jeedomUtils.switchTheme()
    })

    document.getElementById('btn_coloredIcons').addEventListener('click', function() {
        let value = (this.dataset.state == 1) ? 0 : 1
        configSave({
            'interface::advance::coloredIcons': value
        })
        this.dataset.state = value
        this.title = (value == 1) ? '{{Ne pas colorer les icônes}}' : '{{Colorer les icônes}}'
        document.body.setAttribute('data-coloredIcons', value)
    })
</script>
