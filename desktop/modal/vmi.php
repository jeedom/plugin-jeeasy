<?php
if (!isConnect()) {
        throw new Exception('{{401 - Accès non autorisé}}');
}
?>
<div style="margin: 50px;">
<?php 
  include_file('desktop', 'ventilairsec', 'js', 'ventilairsec');
  include_file('core', 'plugin.template', 'js');
  config::save('jeedom::firstUse', 0);
?>
</div>
<script>
  $('#md_modal').dialog({title: "{{Intégrateur VMI}}"});
  $('#md_modal').load('index.php?v=d&plugin=ventilairsec&modal=integrator').dialog('open');
</script>
