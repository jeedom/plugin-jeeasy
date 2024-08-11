<?php
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('desktop', 'jeeasy.welcome', 'css', 'jeeasy');
// if (file_exists(config::byKey('path_wizard')))
// 	$path_wizard = json_decode(file_get_contents(config::byKey('path_wizard')), true);
// else
// 	$path_wizard = json_decode(file_get_contents('plugins/jeeasy/core/data/wizard.json'), true);
?>

<div class="text-center" id="jeeasy_wizard">
	<button class="btn btn-xs btn-danger" id="bt_quitJeeasyWizard"><i class="fas fa-times"></i> {{Quitter l'assistant}}</button>
	<div class="container" id="jeeasy_container">
		<h2>{{Assistant de configuration}}</h2>
		<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image" style="max-width:100%">
		<p>{{Bienvenue dans l'assistant de configuration}} <?php echo config::byKey('product_name'); ?>.</p>
		<p>{{Configurez facilement votre installation domotique en suivant les étapes de cet assistant.}}</p>
		<p>{{Cliquez sur la flèche pour commencer...}}</p>
		<!-- <div class="arrow" onclick="window.location.href='nextpage.php'">
			<i class='icon far fa-arrow-alt-circle-right icon_green'></i>
		</div> -->
	</div>
	<div class="carousel-dots"></div>
</div>

<script>
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

	const pages = [{
			index: 1,
			name: 'index.php?v=d&plugin=jeeasy&modal=welcome',
			tooltip: '{{Bienvenue}}'
		},
		{
			index: 2,
			name: 'index.php?v=d&plugin=jeeasy&modal=boxName',
			tooltip: '{{Nom de la box}}'
		},
		{
			index: 3,
			name: 'page3.php'
		}
	];

	const carouselDots = document.querySelector('.carousel-dots');
	const contentContainer = document.querySelector('.container');

	const tooltip = document.createElement('div');
	tooltip.className = 'modal-tooltip';
	document.getElementById('jeeasy_wizard').appendChild(tooltip)

	pages.forEach(page => {
		const dot = document.createElement('div');
		dot.classList.add('dot');
		dot.dataset.page = page.name;
		dot.innerText = page.index;

		dot.addEventListener('mouseover', function(event) {
			tooltip.innerText = page.tooltip;
			tooltip.style.display = 'block';
			tooltip.style.left = event.pageX + 'px';
			tooltip.style.top = (event.pageY + 20) + 'px';
		});

		dot.addEventListener('mouseout', function() {
			tooltip.style.display = 'none';
		});

		dot.addEventListener('mousemove', function(event) {
			tooltip.style.left = event.pageX + 'px';
			tooltip.style.top = (event.pageY + 20) + 'px';
		});

		dot.addEventListener('click', function() {
			loadPageContent(this.dataset.page);
		});

		carouselDots.appendChild(dot);
	});

	function loadPageContent(page) {
		const initialWidth = contentContainer.offsetWidth;
		const initialHeight = contentContainer.offsetHeight;

		fetch(page)
			.then(response => response.text())
			.then(data => {
				if (page === 'index.php?v=d&plugin=jeeasy&modal=welcome') {
					const parser = new DOMParser();
					const doc = parser.parseFromString(data, 'text/html');
					const newContent = doc.querySelector('.container').innerHTML;
					contentContainer.innerHTML = newContent;
				} else {
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
