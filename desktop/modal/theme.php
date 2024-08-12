<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}

$jeedomTheme = config::byKey('jeedom_theme_main');
?>

<h3>{{Choix du thème}}</h3>
<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image">
<p>
    <strong>{{Vous pouvez changer le thème de votre installation ou passer à l'étape suivante}} <i class='far fa-arrow-alt-circle-right'></i></strong>
</p>
<br>
<div class="input-group">
    <span class="input-group-addon roundedLeft">{{Thème actuel}}</span>
    <select class="form-control roundedRight" id="in_theme">
        <option value="core2019_Light" <?= ($jeedomTheme == 'core2019_Light') ? ' selected' : '' ?>>Thème clair</option>
        <option value="core2019_Dark" <?= ($jeedomTheme == 'core2019_Dark') ? ' selected' : '' ?>>Thème sombre</option>
    </select>
</div>

<script>
    document.getElementById('in_theme').addEventListener('change', function(_event) {
        let newTheme = this.value

        jeedom.config.save({
            configuration: {
                jeedom_theme_main: newTheme
            },
            error: function(_error) {
                jeedomUtils.showAlert({
                    message: _error.message,
                    level: 'danger'
                })
            },
            success: function() {
                jeedomUtils.changeTheme(newTheme);

            }
        })
    })
</script>
