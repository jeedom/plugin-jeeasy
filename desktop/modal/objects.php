<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
?>

<!--<p>Nous vous proposons la configuration type suivante, vous pouvez déselectionner les pièces que vous ne souhaitez utiliser :
</p>-->
<div class="row globalObject">
	<div id="divSelecthouse" class="col-md-12">
		<div class="col-md-12 text-center"><h2>{{Que souhaitez-vous configurer ?}}</h2></div>
		<div id="selectHouse" class="col-xs-6 col-sm-5 col-md-4 nopad text-center cursor selectType">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/salon/salon_5.jpg" />
				<input type="checkbox" name="selectHouse[house]" value="1" />
				{{Une maison}}
			</label>
		</div>
		<div id="selectApartment" class="col-xs-6 col-sm-5 col-md-4 nopad text-center cursor selectType">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/cuisine/cuisine_1.jpg" />
				<input type="checkbox" name="selectHouse[apartment]" value="1" />
				{{Un appartement}}
			</label>
		</div>
		<div id="selectWork" class="col-xs-6 col-sm-5 col-md-4 nopad text-center cursor selectType">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/bureau/bureau_1.jpg" />
				<input type="checkbox" name="selectHouse[work]" value="1" />
				{{Un bureau}}
			</label>
		</div>
	</div>
	<div class="col-md-3 selectEtage hidden">
    <ul class="nav nav-pills nav-stacked">
      <li role="etage" class="active"><a href="#">Rez de chaussée</a></li>
      <li role="etage"><a href="#">Etage 1</a></li>
      <li role="etage"><a href="#">Jardin</a></li>
			<li role="etage"><a href="#">Ajouter</a></li>
    </ul>
  </div>
  <div class="col-md-9 selectObject hidden">
		<div class="col-md-12 text-center"><h2>{{Sélectionnez les pièces}}</h2></div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/chambre/chambre_1.jpg" />
				<input type="checkbox" name="selectObject[chambre1]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Chambre 1}}
			</label>
    	</div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/chambre/chambre_3.jpg" />
				<input type="checkbox" name="selectObject[chambre2]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Chambre 2}}
			</label>
		</div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/chambre/chambre_4.jpg" />
				<input type="checkbox" name="selectObject[chambre3]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Chambre 3}}
			</label>
    	</div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/cuisine/cuisine_2.jpg" />
				<input type="checkbox" name="selectObject[cuisine]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Cuisine}}
			</label>
		</div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/salle_a_manger/salle_a_manger_1.jpg" />
				<input type="checkbox" name="selectObject[sam]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Salle à manger}}
			</label>
		</div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/salon/salon_2.jpg" />
				<input type="checkbox" name="selectObject[salon]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Salon}}
			</label>
		</div>
		<div class="col-xs-5 col-sm-4 col-md-3 nopad text-center">
			<label class="image-checkbox">
				<img class="img-responsive" src="/core/img/object_background/salle_de_bain/salle_de_bain_1.jpg" />
				<input type="checkbox" name="selectObject[sdb]" value="1" />
				<i class="fas fa-check hidden"></i>
				{{Salle de bain}}
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
.image-checkbox .fas {
  position: absolute;
  color: #4A79A3;
  background-color: #fff;
  padding: 10px;
  top: 0;
  right: 0;
}
.image-checkbox-checked .fas {
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
$(".selectType").on("click", function (e) {
	$('#divSelecthouse').addClass('hidden');
	$('.selectObject').removeClass('hidden');
	switch ($(this).attr('id')) {
		case 'selectHouse':
			//$('.selectEtage').removeClass('hidden');
			break;
		case 'selectApartment':

			break;
		case 'selectWork':

			break;
		default:

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
