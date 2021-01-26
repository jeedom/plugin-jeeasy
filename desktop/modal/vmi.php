<?php
if (!isConnect()) {
        throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div style="margin: 50px;">
<?php include_once 'plugins/ventilairsec/desktop/modal/integrator.php';
?>
</div>
