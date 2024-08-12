<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

?>

    <h3>{{Personnalisation de l'interface}}</h3>
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
</script>
