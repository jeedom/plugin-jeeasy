<?php
if (!isConnect()) {
  throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<style>
    .mainContainer {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .form-group {
        margin-bottom: 15px;
    }
</style>
<body>
    <div class="mainContainer">
        <div class="col-md-6 col-md-offset-3 text-center">
            <img class="img-responsive center-block img-atlas" style="width:80%;height:80%;" src="<?php echo config::byKey('product_connection_image'); ?>" />
        </div>
        <div class="col-md-12 text-center">
            <h3 class="lead" id="titlelanguage">{{Entrez votre adresse}}</h3>
            <div class="form-group">
                <label for="addressInput">Adresse :</label>
                <input type="text" id="addressInput" class="form-control" placeholder="Votre adresse">
            </div>
            <button type="button" class="btn btn-primary btn-lg" id="getCoordinatesButton">Obtenir les coordonnées</button>
            <div id="coordinatesContainer" class="mt-3"></div>
            <div id="map" class="mt-3"></div>
        </div>
    </div>

</body>
</html>