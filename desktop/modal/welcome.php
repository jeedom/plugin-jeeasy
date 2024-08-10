<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
?>

    <style>
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-15px);
            }
            60% {
                transform: translateY(-7px); 
            }
        }

		#jeedomMenuBar{
			display: none;
		}

		legend{
			display: none;
		}

        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
			height: 100%;
			min-height: 500px; 
			/* height: 1200px;
			width: 570px; */
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            color: black;
            margin-bottom: 20px;
        }
        .container img {
            max-width: 50%;
            height: auto;
            margin-bottom: 20px;
        }
        .container p {
            margin-bottom: 20px;
            color: black;
        }
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            animation: bounce 2s infinite;
        }
        .alert h4 {
            margin-top: 0;
            font-weight: bold;
        }
        .alert hr {
            border-top: 1px solid #f5c6cb;
            width: 50%;
            margin: 10px auto;
        }
		.arrow {
			position:absolute;	
			bottom: 0;
			cursor: pointer;
			color: white;
			border-radius: 5px;
			margin-bottom: 20%;
			transition: transform 0.3s;
		}
        .arrow:hover {
            transform: scale(1.1);
        }

		.icon {
            font-size: 40px;
        }

		.exit-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        background-color: #dc3545;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
		position: absolute; 
        right: 10px; 
        top: 10px; 
		z-index: 1000;
    }

    .exit-button:hover {
        background-color: #c82333;
        transform: scale(1.05);
    }

	#modalDisplay {
		background-color: transparent !important;
	}

	.carousel-dots {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .dot {
        width: 20px;
        height: 20px;
        margin: 0 5px;
        background-color: #94CA02;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .dot:hover {
        background-color: #0056b3;
    }

    </style>
<body>
    <div class="container">
			<button class="exit-button" id="bt_quitJeeasyWizardV2">Quitter l'assistant</button>
			<h2 class="lead" style="font-weight:400;">{{Assistant de configuration}}</h2>
			<img src="<?php echo config::byKey('product_connection_image'); ?>" alt="Product Image" />
			<p class="lead">{{Ce guide va vous aider à configurer votre}} <?php echo config::byKey('product_name'); ?> {{en quelques étapes.}}</p>
			
			<div class="alert alert-danger">
				<h4>{{IL EST IMPORTANT DE TERMINER CETTE CONFIGURATION}}</h4>
				<p style="color:floralwhite">{{Plusieurs plugins essentiels seront installés durant le processus.}}</p>
			</div>
			<p>{{Cliquez sur la flèche pour commencer la configuration.}}</p>
			<!-- <div class="arrow" onclick="window.location.href='nextpage.php'">
				<i class='icon far fa-arrow-alt-circle-right icon_green'></i>
			</div> -->
    </div>
	<div class="carousel-dots"></div>
</body>

	<script>


		document.getElementById('bt_quitJeeasyWizardV2').addEventListener('click', function() {
			window.close();
		});

		const pages = [
				{ index: 1, name: 'index.php?v=d&plugin=jeeasy&modal=welcome' },
				{ index: 2, name: 'index.php?v=d&plugin=jeeasy&modal=boxName' },				
				{ index: 3, name: 'page3.php' }
         ];

		 const carouselDots = document.querySelector('.carousel-dots');
		 const contentContainer = document.querySelector('.container');

		 pages.forEach(page => {
				const dot = document.createElement('div');
				dot.classList.add('dot');
				dot.dataset.page = page.name;
				dot.innerText = page.index;
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
					contentContainer.style.width = initialWidth + 'px';
					contentContainer.style.height = initialHeight + 'px';
                }
				})
				.catch(error => console.error('Erreur sur le chargement de la page:', error));
		}

	</script>


