<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('desktop', 'jeeasy.welcome', 'css', 'jeeasy');
if (file_exists(config::byKey('path_wizard'))) {
	$wizard = json_decode(file_get_contents(config::byKey('path_wizard')), true);
} else {
	$wizard = json_decode(file_get_contents('plugins/jeeasy/core/data/wizard.json'), true);
}
$steps = $wizard['trame'];
usort($steps, function ($step1, $step2) {
	return $step1['order'] <=> $step2['order'];
});
?>

<button class="btn btn-xs btn-danger" id="bt_quitJeeasyWizard"><i class="fas fa-times"></i> {{Quitter l'assistant}}</button>

<div class="text-center" id="jeeasy_wizard">
	<div class="container" id="jeeasy_container">
		<h3>{{Assistant de configuration}}</h3>
		<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image" style="max-width:100%">
		<p>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</p>
		<p>{{Configurez facilement votre installation <?php echo config::byKey('product_name'); ?> en suivant les étapes de cet assistant interactif.}}</p>
		<br>
		<strong>{{Cliquez sur la flèche en bas à droite pour commencer}} <i class='far fa-arrow-alt-circle-right'></i></strong>
	</div>
	<div id="jeeasy_navigation">
		<div>
			<i class="far fa-arrow-alt-circle-left navBtn bt_prev hidden"></i>
		</div>
		<div>
			<?php
			foreach ($steps as $index => $step) {
				echo '<span class="navDot' . (($index == 0) ? ' active' : '') . '" data-page="' . $step['wizard'] . '" data-title="' . $step['title'] . '">';
				echo $index + 1;
				echo '</span>';
			}
			?>
			<div id="div_dots_tooltip"></div>
		</div>
		<div>
			<i class="far fa-arrow-alt-circle-right navBtn bt_next"></i>
			<i class="fas fa-check-circle hidden" id="bt_jeedom_ready"></i>
		</div>
	</div>
</div>

<script>
	var contentContainer = document.getElementById('jeeasy_container')
	var tooltip = document.getElementById('div_dots_tooltip')

	document.querySelectorAll('.navDot').forEach(_dot => {
		_dot.addEventListener('mouseover', function(_event) {
			tooltip.innerText = this.dataset.title;
			tooltip.style.display = 'block';
			tooltip.style.left = _event.pageX + 'px';
			tooltip.style.top = (_event.pageY + 20) + 'px';
		});

		_dot.addEventListener('mouseout', function() {
			tooltip.style.display = 'none';
		});

		_dot.addEventListener('mousemove', function(_event) {
			tooltip.style.left = _event.pageX + 'px';
			tooltip.style.top = (_event.pageY + 20) + 'px';
		});

		_dot.addEventListener('click', function() {
			document.querySelectorAll('.navDot.active').removeClass('active')
			this.addClass('active')
			loadPageContent(this.dataset.page);
		});
	})

	document.querySelectorAll('.navBtn').forEach(_navBtn => {
		_navBtn.addEventListener('click', function() {
			let activeNavDot = document.querySelector('.navDot.active')
			if (this.classList.value.includes('bt_next')) {
				activeNavDot.nextElementSibling.triggerEvent('click')
			} else if (this.classList.value.includes('bt_prev')) {
				activeNavDot.previousElementSibling.triggerEvent('click')
			}
		})
	})

	document.getElementById('bt_quitJeeasyWizard').addEventListener('click', function() {
		let confirm = "{{Voulez-vous vraiment quitter l'assistant de configuration?}}"
		confirm += '<br><br>'
		confirm += '<div class="alert alert-danger text-center">{{Certaines configurations ne seront pas effectuées et plusieurs plugins essentiels ne seront pas installés!}}</div>'
		bootbox.confirm(confirm, function(result) {
			if (result) {
				loadPage('index.php?v=d&p=dashboard')
			}
		})
	})

	document.getElementById('bt_jeedom_ready').addEventListener('click', function() {
		// set jeedomm::firstUse to 0
		// load dashboard
	})

	function loadPageContent(_page) {
		fetch('index.php?v=d&plugin=jeeasy&modal=' + _page)
			.then(response => response.text())
			.then(data => {
				if (_page === 'ready') {
					document.querySelectorAll('.navBtn').unseen()
					document.getElementById('bt_jeedom_ready').removeClass('hidden')
				} else {
					document.getElementById('bt_jeedom_ready').addClass('hidden')
					document.querySelectorAll('.navBtn').seen()
				}

				if (_page === 'welcome') {
					document.querySelector('.navBtn.bt_prev').addClass('hidden')
					const parser = new DOMParser();
					const doc = parser.parseFromString(data, 'text/html');
					const newContent = doc.querySelector('.container').innerHTML;
					contentContainer.innerHTML = newContent;
				} else {
					document.querySelector('.navBtn.bt_prev.hidden')?.removeClass('hidden')
					contentContainer.innerHTML = data;
				}

				// Rechargement des scripts
				const scripts = contentContainer.querySelectorAll('script');
				scripts.forEach(script => {
					console.log('script', script);
					const newScript = document.createElement('script');
					if (script.src) {
						newScript.src = script.src;
					} else {
						newScript.textContent = script.textContent;
					}
					document.getElementById('jeeasy_wizard').appendChild(newScript)
					document.getElementById('jeeasy_wizard').removeChild(newScript) // Optionnel : pour éviter d'encombrer le DOM
				});
			})
			.catch(error => console.error('{{Erreur au chargement de la page}}:', error));
	}
</script>
