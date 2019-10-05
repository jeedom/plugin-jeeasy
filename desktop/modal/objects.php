<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<p>Nous vous proposons la configuration type suivante, vous pouvez déselectionner les pièces que vous ne souhaitez utiliser :
</p>
<div class="row globalObject">
  <div class="col-md-3 selectEtage">
    <ul class="nav nav-pills nav-stacked">
      <li role="etage" class="active"><a href="#">RDC</a></li>
      <li role="etage"><a href="#">Dans ton cul</a></li>
      <li role="etage"><a href="#">A l'arriere de la maison</a></li>
    </ul>
  </div>
  <div class="col-md-9 selectObject">

      <div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
        <label class="image-checkbox">
          <img class="img-responsive" src="/core/img/object_background/chambre/chambre_1.jpg" />
          <input type="checkbox" name="image[]" value="" />
          <i class="fa fa-check hidden"></i>
          Chambre 1
        </label>
      </div>
      <div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
        <label class="image-checkbox">
          <img class="img-responsive" src="/core/img/object_background/chambre/chambre_3.jpg" />
          <input type="checkbox" name="image[]" value="" />
          <i class="fa fa-check hidden"></i>
          Chambre 2
        </label>
      </div>
      <div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
        <label class="image-checkbox">
          <img class="img-responsive" src="/core/img/object_background/chambre/chambre_4.jpg" />
          <input type="checkbox" name="image[]" value="" />
          <i class="fa fa-check hidden"></i>
          Chambre 3
        </label>
      </div>
      <div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
        <label class="image-checkbox">
          <img class="img-responsive" src="/core/img/object_background/chambre/chambre_6.jpg" />
          <input type="checkbox" name="image[]" value="" />
          <i class="fa fa-check hidden"></i>
          Chambre 4
        </label>
      </div>
      <div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
        <label class="image-checkbox">
          <img class="img-responsive" src="https://dummyimage.com/600x400/000/fff" />
          <input type="checkbox" name="image[]" value="" />
          <i class="fa fa-check hidden"></i>
        </label>
      </div>


  </div>
</div>


<style>
.globalObject {
  width: 90%;
  margin: 0 auto;
}
.selectEtage {
  border-right: 1px solid black;
  min-height: 90%
}
.selectObject {
  min-height: 90%
}
.nopad {
	padding-left: 0 !important;
	padding-right: 0 !important;
}
/*image gallery*/
.image-checkbox {
	cursor: pointer;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border: 4px solid transparent;
	margin-bottom: 0;
	outline: 0;
}
.image-checkbox input[type="checkbox"] {
	display: none;
}

.image-checkbox-checked {
	border-color: #4783B0;
}
.image-checkbox .fa {
  position: absolute;
  color: #4A79A3;
  background-color: #fff;
  padding: 10px;
  top: 0;
  right: 0;
}
.image-checkbox-checked .fa {
  display: block !important;
}
</style>
<script>
// image gallery
// init the state from the input
$(".image-checkbox").each(function () {
  if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
    $(this).addClass('image-checkbox-checked');
  }
  else {
    $(this).removeClass('image-checkbox-checked');
  }
});

// sync the state to the input
$(".image-checkbox").on("click", function (e) {
  $(this).toggleClass('image-checkbox-checked');
  var $checkbox = $(this).find('input[type="checkbox"]');
  $checkbox.prop("checked",!$checkbox.prop("checked"))

  e.preventDefault();
});
</script>
