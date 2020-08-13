<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

$object = jeeObject::byId(init('object_id'));
if (!is_object($object)) {
	echo '<div class="alert alert-danger">' . __('Désolé je n\'arrive pas à trouver votre pièce  : ', __FILE__) . init('object_id') . '</div>';
	die();
}
sendVarToJs('object_id', $object->getId());
?>

<div id="div_AlertJeeasyJeedomObject"></div>
<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul class="nav nav-list bs-sidenav">
				<li class="cursor li_jeeEasySummary active" data-href="home"><a><i class="fas fa-home"></i> {{Accueil}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="main"><a><i class="fas fa-wrench"></i> {{Général}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="display"><a><i class="fas fa-tv"></i> {{Affichage}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="end"><a><i class="fas fa-check"></i> {{Fin}}</a></li>
			</ul>
		</div>
	</div>

	<div class="col-lg-10" id="div_jeeasyConfigureObject">
		<a class="btn btn-sm btn-success pull-left bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a>
		<a class="btn btn-sm btn-success pull-right bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a>
		<a class="btn btn-sm btn-default pull-right bt_jeeasyPrevious"><i class="fas fa-angle-double-left"></i> {{Précédent}}</a>
		<br/><br/>
		<div class="jeeasyDisplay home">
			<center><i class="fas fa-home" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Bienvenue sur l'assistant de configuration de votre maison, nous allons configurer ensemble votre pièce :}} <strong><?php echo $object->getName(); ?></strong></div></center>
			<center>{{Cliquez sur suivant pour commencer}}</center>
			<br/>
			<center><a class="btn btn-sm btn-success bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a></center>
		</div>

		<div class="jeeasyDisplay main" style="display:none;">
			<center><i class="fas fa-wrench" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Nous allons ici configurer votre pièce à travers quelques petites questions}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Nom de la pièce}}</label>
						<div class="col-xs-4">
							<input class="form-control objectAttr" type="text" data-l1key="name" placeholder="Nom de la pièce"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{La pièce est-elle dans une autre pièce (exemple salon est dans maison). Si oui laquelle ?}}</label>
						<div class="col-xs-4">
							<select class="form-control objectAttr" data-l1key="father_id">
								<option value="">{{Aucun}}</option>
								<?php
foreach (jeeObject::all() as $object_all) {
	if ($object_all->getId() == $object->getId()) {
		continue;
	}
	echo '<option value="' . $object_all->getId() . '">' . $object_all->getName() . '</option>';
}
?>
							</select>
						</div>
					</div>
				</fieldset>
			</form>
		</div>

		<div class="jeeasyDisplay display" style="display:none;">
			<center><i class="fas fa-tv" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Nous allons ici configurer l'affichage de votre pièce}}</div></center>
			<form class="form-horizontal">
				<fieldset>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Visible}}</label>
						<div class="col-xs-1">
							<input class="objectAttr" type="checkbox" data-l1key="isVisible" checked/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-4 control-label">{{Icône}}</label>
						<div class="col-xs-4">
							<div class="objectAttr" data-l1key="display" data-l2key="icon" style="font-size : 1.5em;"></div>
						</div>
						<div class="col-xs-4">
							<a class="btn btn-default btn-sm" id="bt_chooseIcon"><i class="fas fa-flag"></i> {{Choisir}}</a>
						</div>
					</div>
				</fieldset>
			</form>
		</div>


		<div class="jeeasyDisplay end" style="display:none;">
			<center><i class="fas fa-check" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-success">{{Bravo !!! Vous avez fini de configurer votre}} <?php echo config::byKey('product_name'); ?></div></center>
			<center>{{Cliquez sur sauvegarder pour valider votre configuration}}</center>
			<br/>
			<center><a class="btn btn-success bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a></center>
		</div>

	</div>
</div>

<script type="text/javascript">
	$('.bt_jeeasyNext').off('click').on('click',function(){
		$('.li_jeeEasySummary.active').next().click();
	});
	$('.bt_jeeasyPrevious').off('click').on('click',function(){
		$('.li_jeeEasySummary.active').prev().click();
	});
	$('.li_jeeEasySummary').off('click').on('click',function(){
		$('.li_jeeEasySummary.active').removeClass('active');
		$(this).addClass('active');
		$('.jeeasyDisplay').hide();
		$('.jeeasyDisplay.'+$(this).attr('data-href')).show();
		$(this).attr('data-display',1);
	});

	$('.objectAttr[data-l1key=display][data-l2key=icon]').on('dblclick',function(){
		$('.objectAttr[data-l1key=display][data-l2key=icon]').value('');
	});

	$('#bt_chooseIcon').on('click', function () {
		chooseIcon(function (_icon) {
			$('.objectAttr[data-l1key=display][data-l2key=icon]').empty().append(_icon);
		});
	});

	$('.bt_jeeasySave').off('click').on('click',function(){
		var object = {id : object_id}
		if($('.li_jeeEasySummary[data-href=main]').attr('data-display') == 1){
			object = deepmerge(object,$('.jeeasyDisplay.main').getValues('.objectAttr')[0]);
		}
		if($('.li_jeeEasySummary[data-href=display]').attr('data-display') == 1){
			object = deepmerge(object,$('.jeeasyDisplay.display').getValues('.objectAttr')[0]);
		}
		jeedom.object.save({
			object: object,
			error: function (error) {
				$('#div_AlertJeeasyJeedomObject').showAlert({message: error.message, level: 'danger'});
			},
			success: function () {
				$('#div_AlertJeeasyJeedomObject').showAlert({message: '{{Configuration sauvegardée}}', level: 'success'});
			}
		});
	});

	jeedom.object.byId({
		id: object_id,
		error: function (error) {
			$('#div_AlertJeeasyJeedomObject').showAlert({message: error.message, level: 'danger'});
		},
		success: function (data) {
			console.log(data)
			$('#div_jeeasyConfigureObject').setValues(data,'.objectAttr');
		}
	});

</script>

<?php include_file('3rdparty', 'deepmerge', 'js', 'jeeasy');?>
