<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}
$discovers = jeeasy::discoverNetwork();
?>
<table class="table table-condensed">
  <thead>
    <tr>
      <th>{{Ip}}</th>
      <th>{{Nom}}</th>
      <th>{{MAC}}</th>
      <th>{{Plugins suggérés}}</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($discovers as $mac => $value) {
      echo '<tr>';
      echo '<td>';
      echo $value['ip'];
      echo '</td>';
      echo '<td>';
      echo $value['name'];
      echo '</td>';
      echo '<td>';
      echo $mac;
      echo '</td>';
      echo '<td>';
      foreach ($value['plugin'] as $plugin) {
        $class="btn-info";
        if($plugin['certification'] == 'official'){
          $class="btn-success";
        }
        echo '<a class="btn '.$class.' btn-xs" href="https://www.jeedom.com/market/index.php?v=d&p=market&type=plugin&plugin_id='.$plugin['id'].'" target="_blank"><i class="fas fa-external-link-alt"></i> '.$plugin['name'].'</a> ';
      }
      echo '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
