<?php
if (!isConnect()) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$language = config::byKey('language', 'core');
?>

<h3>{{Services}} Jeedom</h3>

<div class="logo flex-evenly services">
    <div class="panel service" style="background-image:url('plugins/jeeasy/core/img/service_backup.jpg')">
        <a href="https://doc.jeedom.com/<?= $language ?>/howto/backup_cloud" target="_blank" title="{{Accéder à la documentation du service Sauvegarde Cloud}}"></a>
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

<div class="flex-evenly services">
    <i class="fas fa-chevron-left service-nav cursor" data-direction="prev" title="{{SMS et Appels}}"></i>

    <div>
        <div class="panel service service-carousel" style="background-image:url('plugins/jeeasy/core/img/service_cadenas.jpg')">
            <a href="https://doc.jeedom.com/<?= $language ?>/howto/mise_en_place_dns_jeedom" target="_blank" title="{{Accéder à la documentation du service Accès à distance}}"></a>
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
            <a href="https://doc.jeedom.com/<?= $language ?>/howto/assistant_vocaux_cloud" target="_blank" title="{{Accéder à la documentation du service Assistants vocaux}}"></a>
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
            <a href="https://doc.jeedom.com/<?= $language ?>/howto/monitoring_cloud" target="_blank" title="{{Accéder à la documentation du service Monitoring}}"></a>
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
            <a href="https://doc.jeedom.com/<?= $language ?>/howto/sms_cloud" target="_blank" title="{{Accéder à la documentation du service SMS et Appels}}"></a>
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
    if (isset(servicesCarousel)) {
        clearInterval(servicesCarousel)
    }
    if (isset(servicesCarouselTimeout)) {
        clearTimeout(servicesCarouselTimeout)
    }
    var servicesCarousel, servicesCarouselTimeout
    servicesCarousel = setInterval(() => {
        document.querySelector('.service-nav[data-direction="next"]')?.triggerEvent('click')
    }, 5000);

    document.querySelectorAll('.service-nav').forEach(_nav => {
        _nav.addEventListener('click', function(_event) {
            if (_event.pointerType) {
                clearInterval(servicesCarousel)
                clearTimeout(servicesCarouselTimeout)
                servicesCarouselTimeout = setTimeout(() => {
                    servicesCarousel = setInterval(() => {
                        document.querySelector('.service-nav[data-direction="next"]')?.triggerEvent('click')
                    }, 5000);
                }, 10000);
            }

            let current = document.querySelector('.service-carousel:not(.hidden)')
            if (this.dataset.direction == 'next') {
                var prevTitle = current.querySelector('.panel-title').innerText
                var goTo = current.nextElementSibling || document.querySelector('.service-carousel')
                var nextTitle = goTo.nextElementSibling?.querySelector('.panel-title').innerText || document.querySelector('.service-carousel').querySelector('.panel-title').innerText
            } else {
                var nextTitle = current.querySelector('.panel-title').innerText
                var goTo = current.previousElementSibling || document.querySelector('.service-carousel:last-child')
                var prevTitle = goTo.previousElementSibling?.querySelector('.panel-title').innerText || document.querySelector('.service-carousel:last-child').querySelector('.panel-title').innerText
            }

            current.animate({
                opacity: [1, 0]
            }, {
                duration: 250
            })

            setTimeout(() => {
                current.addClass('hidden')
                goTo.removeClass('hidden')
                document.querySelector('.service-nav[data-direction="prev"]').title = prevTitle.substring(1)
                document.querySelector('.service-nav[data-direction="next"]').title = nextTitle.substring(1)
            }, 250);
        })
    })
</script>
