


function progress(ProgressPourcent, idElement){
		let divProgressbar = document.getElementById(idElement);
		if(ProgressPourcent == -1){
			divProgressbar.removeClass('progress-bar-success progress-bar-info progress-bar-warning');
			divProgressbar.addClass('active progress-bar-danger');
			divProgressbar.width('100%');
			divProgressbar.attr('aria-valuenow',100);
			divProgressbar.html('N/A');
				return;
		}
		if(ProgressPourcent == 100){
				divProgressbar.classList.remove('active', 'progress-bar-info', 'progress-bar-danger', 'progress-bar-warning');
				divProgressbar.classList.add('progress-bar-success');
				divProgressbar.style.width = ProgressPourcent + '%';
				divProgressbar.setAttribute('aria-valuenow', ProgressPourcent);
				divProgressbar.innerHTML = 'FIN';
				textAtlasElements.forEach(function(element) {
				 element.style.display = 'none';
				});
				Good();
				return;
		}
			divProgressbar.classList.remove('active', 'progress-bar-info', 'progress-bar-danger', 'progress-bar-warning');
			divProgressbar.classList.add('progress-bar-success');
			divProgressbar.style.width = ProgressPourcent + '%';
			divProgressbar.setAttribute('aria-valuenow', ProgressPourcent);
			divProgressbar.innerHTML = ProgressPourcent + '%';
	}



