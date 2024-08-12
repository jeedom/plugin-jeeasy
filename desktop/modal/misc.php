<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

$jeedomTheme = config::byKey('jeedom_theme_main');

?>

<div class="misc-container">
    <h3>{{Parametres optionnels}}</h3>
    <br>
    <div class="misc-content">
        <label>{{Theme actuel}} : </label>
        <br>
        <div class="theme-selector">
            <select id="changeThemeOnWizard">
            <option value="core2019_Light">Thème Clair</option>
            <option value="core2019_Dark">Thème Sombre</option>
            </select>
        </div>
        <br>
        <br>
        <div class="checkbox-div">
            <label>{{Icones colorées}} : </label>
            <input type="checkbox" id="changeColoredIcons"></checkbox>
        </div>

    </div>
  

</div>


<style>

.misc-container {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    height: 80vh; 
    padding-top: 20px; 
}

.misc-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex-grow: 1; 
    width: 50%;
}

.theme-selector {
    display: flex;
    justify-content: center;
    width: 50%;
}

.checkbox-div {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50%;
}

.checkbox-div >input {
  margin-left: 10px;
}


</style>



<script>

// Fonction pour eviter conflits de portée
(function() {
    let themeMain = '<?= $jeedomTheme ?>';
    let coloredIcons = '<?= config::byKey('interface::advance::coloredIcons'); ?>';

    let selectElement = document.getElementById('changeThemeOnWizard');
    let checkboxColored = document.getElementById('changeColoredIcons');

    let isInitialUpdate = true;

    checkboxColored.checked = coloredIcons == '1'  ? true : false;

    isInitialUpdate = false;


    selectElement.value = themeMain;



    selectElement.dispatchEvent(new Event('change'));


    selectElement.addEventListener('change', function(_event) {
    let newTheme = document.getElementById('changeThemeOnWizard').value
    let humanReadableTheme = newTheme == 'core2019_Light' ? 'Thème Clair' : 'Thème Sombre';

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
        jeedomUtils.showAlert({
            message: '{{Le nouveau thème de votre installation est}} : <strong>' + humanReadableTheme + '</strong>',
            level: 'success',
            timeOut: 3000
        })
        jeedomUtils.changeTheme(newTheme);
    
        }
    })
    })

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
