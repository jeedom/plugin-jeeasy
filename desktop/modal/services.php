<?php
if (!isConnect()) {
    throw new Exception('401 - {{Accès non autorisé}}');
}
?>

<h3>{{Services}} Jeedom</h3>

<div class="logo flex-evenly services">
    <div class="panel service" style="background-image:url('plugins/jeeasy/core/img/service_backup.jpg')">
        <a href="<?= jeeasy::getDocUrl('howto', 'backup_cloud') ?>" target="_blank" title="{{Accéder à la documentation du service Sauvegarde Cloud}}"></a>
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fas fa-cloud"></i> {{Sauvegarde dans le Cloud}}</h3>
        </div>
        <div class="panel-body">
            <div style="margin:0 20px;">
                {{Une gestion rigoureuse des sauvegardes est la base de la pérennité d'un système, vous pouvez donc facilement conserver une copie de votre dernière sauvegarde Jeedom à l'abri en souscrivant au service Sauvegarde Cloud.}}
                <br>
                {{Ce service permet de copier votre installation sur le cloud Jeedom en ne sauvegardant que les modifications pour limiter la bande passante.}}
            </div>
        </div>
    </div>
</div>

<div class="bold">{{Vous pouvez découvrir les services Jeedom indispensables puis passer à l'étape suivante}}
    <i class="far fa-arrow-alt-circle-right"></i>
</div>

<div class="flex-evenly services" id="services_carousel">
    <i class="fas fa-chevron-left service-nav cursor" data-direction="prev" title="{{SMS et Appels}}"></i>

    <div id="services_slides">
        <div class="panel service service-carousel" style="background-image:url('plugins/jeeasy/core/img/service_cadenas.jpg')">
            <a href="<?= jeeasy::getDocUrl('howto', 'mise_en_place_dns_jeedom') ?>" target="_blank" title="{{Accéder à la documentation du service Accès à distance}}"></a>
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-lock"></i> {{Accès à distance}}</h3>
            </div>
            <div class="panel-body">
                <div style="margin:0 20px;">
                    {{Accédez facilement à Jeedom depuis l'extérieur de votre réseau local en souscrivant au service Accès à distance facilité.}}
                    <br>
                    {{Ce service est automatiquement mis en place à travers un serveur VPN crypté et sécurisé.}}
                </div>
            </div>
        </div>

        <div class="panel service service-carousel hidden" style="background-image:url('plugins/jeeasy/core/img/service_vocal.jpg')">
            <a href="<?= jeeasy::getDocUrl('howto', 'assistant_vocaux_cloud') ?>" target="_blank" title="{{Accéder à la documentation du service Assistants vocaux}}"></a>
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-microphone"></i> {{Assistants vocaux}}</h3>
            </div>
            <div class="panel-body">
                <div style="margin:0 20px;">
                    {{Prenez le contrôle de votre installation Jeedom par la voix en souscrivant au service Assistants vocaux.}}
                    <br>
                    {{Ce service permet de connecter vos assistants vocaux Amazon Alexa/Google Assistant avec Jeedom pour plus de confort d'utilisation.}}
                </div>
            </div>
        </div>

        <div class="panel service service-carousel hidden" style="background-image:url('plugins/jeeasy/core/img/service_monitoring.jpg')" title="{{Accéder à la documentation du service Monitoring}}">
            <a href="<?= jeeasy::getDocUrl('howto', 'monitoring_cloud') ?>" target="_blank" title="{{Accéder à la documentation du service Monitoring}}"></a>
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-medkit"></i> {{Monitoring}}</h3>
            </div>
            <div class="panel-body">
                <div style="margin:0 20px;">
                    {{Surveillez en permanence votre installation Jeedom en souscrivant au service Monitoring.}}
                    <br>
                    {{Ce service analyse régulièrement la santé de votre installation Jeedom et vous alerte en cas de dysfonctionnement.}}
                </div>
            </div>
        </div>

        <div class="panel service service-carousel hidden" style="background-image:url('plugins/jeeasy/core/img/service_sms.jpg')" title="{{Accéder à la documentation du service SMS et Appels}}">
            <a href="<?= jeeasy::getDocUrl('howto', 'sms_cloud') ?>" target="_blank" title="{{Accéder à la documentation du service SMS et Appels}}"></a>
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-sms"></i> {{SMS et Appels}}</h3>
            </div>
            <div class="panel-body">
                <div style="margin:0 20px;">
                    {{Envoyez facilement des messages écrits ou vocaux depuis Jeedom en souscrivant au service SMS et Appels.}}
                    <br>
                    {{Ce service nécessite uniquement une connexion internet sans avoir besoin d'une clé 3G/4G/5G ou d'un abonnement à un opérateur mobile.}}
                </div>
            </div>
        </div>
    </div>

    <i class="fas fa-chevron-right service-nav cursor" data-direction="next" title="{{Assistants vocaux}}"></i>
</div>

<script>
    (function() {
        const btPrev = document.querySelector('.service-nav[data-direction="prev"]')
        const btNext = document.querySelector('.service-nav[data-direction="next"]')
        const carousel = document.getElementById('services_carousel')
        const slides = document.getElementById('services_slides')
        let carouselInterval = null

        function slideTo(_direction) {
            let current = slides.querySelector('.service-carousel:not(.hidden)')
            let goTo, prevTitle, nextTitle
            if (_direction == 'next') {
                prevTitle = current.querySelector('.panel-title').innerText
                goTo = current.nextElementSibling || slides.querySelector('.service-carousel')
                nextTitle = goTo.nextElementSibling?.querySelector('.panel-title').innerText || slides.querySelector('.service-carousel').querySelector('.panel-title').innerText
            } else {
                nextTitle = current.querySelector('.panel-title').innerText
                goTo = current.previousElementSibling || slides.querySelector('.service-carousel:last-child')
                prevTitle = goTo.previousElementSibling?.querySelector('.panel-title').innerText || slides.querySelector('.service-carousel:last-child').querySelector('.panel-title').innerText
            }

            jeeFrontEnd.jeeasyTools.slide(slides, _direction == 'prev', () => {
                current.addClass('hidden')
                goTo.removeClass('hidden')
                btPrev.title = prevTitle.substring(1)
                btNext.title = nextTitle.substring(1)
            })
        }

        // Stops itself once the step is gone
        function startCarousel() {
            clearInterval(carouselInterval)
            carouselInterval = setInterval(() => {
                if (!carousel.isConnected) {
                    clearInterval(carouselInterval)
                    return
                }
                slideTo('next')
            }, 5000)
        }

        startCarousel()

        // Paused while hovered
        carousel.addEventListener('pointerenter', function() {
            clearInterval(carouselInterval)
        })
        carousel.addEventListener('pointerleave', startCarousel)

        carousel.addEventListener('click', function(_event) {
            let _target = null
            if (_target = _event.target.closest('.service-nav')) {
                slideTo(_target.dataset.direction)
            }
        })
    })()
</script>
