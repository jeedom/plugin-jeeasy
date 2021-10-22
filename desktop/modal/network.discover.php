<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}

$discovers = jeeasy::discoverNetwork();
$jsonrpc = repo_market::getJsonRpc();
$marketURL = config::byKey('market::address');




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
      echo '<tr height="50%">';
      echo '<td >';
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
        $arrId = array();
        $arrId['id'] = $plugin['id'];
        if ( $jsonrpc->sendRequest('market::byId', $arrId)) {
             $result = $jsonrpc->getResult();
             $finalCost = '';
             if($result['cost'] > 0){
               $finalCost = '('.$result['cost'].'.00 €)';
             }
            /* log::add('gestAccess','debug','KIKOO'.json_encode($result));*/
             $imgPlugin = $result['img'];

        }
        $class="btn-info";
        if($plugin['certification'] == 'official'){
          $class="btn-success";
        }
        echo '<a class="btn '.$class.' btn-xs" href="https://www.jeedom.com/market/index.php?v=d&p=market&type=plugin&plugin_id='.$plugin['id'].'" target="_blank" ><img class="test" src="'.$marketURL.'/'.$imgPlugin["icon"].'" style="height:20px; margin-bottom:5px; width:20px;border:1px solid black;"> '.$plugin['name'].'  '.$finalCost.'    '.'</a> ';
      }
      echo '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>
