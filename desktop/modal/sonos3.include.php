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
jeeasy::checkPlugin('philipsHue');
?>
<div id="div_AlertJeeasyInclude"></div>
<div class="row row-overflow">
	<div class="col-lg-2">
		<div class="bs-sidebar">
			<ul class="nav nav-list bs-sidenav">
				<li class="cursor li_jeeEasySummary active" data-href="home"><a><i class="fas fa-plus"></i> {{Accueil}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="include"><a><i class="fas fa-wifi"></i> {{Ajout}}</a></li>
				<li class="cursor li_jeeEasySummary" data-href="end"><a><i class="fas fa-check"></i> {{Fin}}</a></li>
			</ul>
		</div>
	</div>

	<div class="col-lg-10" id="div_jeeasyIncludeDisplay">
		<a class="btn btn-sm btn-success pull-left bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a>
		<a class="btn btn-sm btn-success pull-right bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a>
		<a class="btn btn-sm btn-default pull-right bt_jeeasyPrevious"><i class="fas fa-angle-double-left"></i> {{Précédent}}</a>
		<br/><br/>
		<div class="jeeasyDisplay home">
			<center><i class="fas fa-plus" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{Très bien ajoutons un module à votre domotique.}}</div></center>
			<center>{{Cliquez sur suivant pour commencer}}</center>
			<br/>
			<center><a class="btn btn-sm btn-success bt_jeeasyNext">{{Suivant}} <i class="fas fa-angle-double-right"></i></a></center>
		</div>

		<div class="jeeasyDisplay include" style="display:none;">
			<center><i class="fas fa-wifi" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-info">{{C'est parti, lançons nous. Pour commencer ajoutez votre nouveau module à l'application Sonos.}}</div></center>
			<center><div class="alert alert-info">{{Puis une fois le module ajouté cliquez simplement sur le bouton synchroniser ci-dessous}}</div></center>
			<br/>
			<center><a class="btn btn-default" id="bt_jeeasySyncSonos3"><i class="fas fa-refresh"></i> {{Synchroniser}}</a></center>
		</div>

		<div class="jeeasyDisplay end" style="display:none;">
			<center><i class="fas fa-check" style="font-size: 10em;"></i></center>
			<br/>
			<center><div class="alert alert-success">{{Bravo !!! Vous avez fini d'ajouter votre module}}</div></center>
			<center>{{Cliquez sur sauvegarder pour valider votre configuration}}</center>
			<br/>
			<center><a class="btn btn-success bt_jeeasySave"><i class="fas fa-save"></i> {{Sauvegarder}}</a></center>
		</div>

	</div>
</div>
<script type="text/javascript">
	eqLogic_id = null;
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


	$('#bt_jeeasySyncSonos3').off('click').on('click',function(){
		$.ajax({
			type: "POST",
			url: "plugins/sonos3/core/ajax/sonos3.ajax.php",
			data: {
				action: "syncSonos",
			},
			dataType: 'json',
			error: function (request, status, error) {
				handleAjaxError(request, status, error,$('#div_AlertJeeasyInclude'));
			},
			success: function (data) {
				if (data.state != 'ok') {
					$('#div_AlertJeeasyInclude').showAlert({message: data.result, level: 'danger'});
					return;
				}
				$('#div_AlertJeeasyInclude').showAlert({message: '{{Synchronisation réussie}}', level: 'success'});
			}
		});
	});


</script>

<?php include_file('3rdparty', 'deepmerge', 'js', 'jeeasy');?>
