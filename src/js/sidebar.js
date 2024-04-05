

var sidebarObject = {
	
	active: 'home',
	activeModule: null,
	currentVoice: null,
	
	init: function() {
		var cd_main = document.querySelector(".main-menu");
		
		var home = cd_main.querySelector(".home");
		home.addEventListener("click", ()=>{
			this.active = 'home';
		});
		//
		var module = cd_main.querySelector(".module");
		module.addEventListener("click", ()=>{
			this.active = 'module';
			if( !sidebarObject.activeModule) {
				moduleObject.initCreateModule();
				moduleObject.initList();
			}
		});
		
		var ticket = cd_main.querySelector(".ticket");
		ticket.addEventListener("click", ()=>{
			this.active = 'ticket';
			ticketObject.activeIndex = 0;
		});
		
		var wordLearn = cd_main.querySelector(".wordLearn");
		wordLearn.addEventListener("click", ()=>{
			this.active = 'wordLearn';
			ticketObject.activeIndex = 0;
			ticketObject.cardInit();
		});
		
		var wordCheck = cd_main.querySelector(".wordCheck");
		wordCheck.addEventListener("click", ()=>{
			this.active = 'wordCheck';
			ticketObject.activeIndex = 0;
			ticketObject.cardInitCheck();
		});

		var hangmangame = cd_main.querySelector(".hangmangame");
		hangmangame.addEventListener("click", ()=>{
			this.active = 'hangmangame';
			hangmanObject.getWord();
		});

	},
	
	loadVoices: function() {
		voicesSpeech = synthSpeech.getVoices();
		for (let i = 0; i < voicesSpeech.length; i++) {
			if(voicesSpeech[i].lang.toLowerCase() == language.toLowerCase()) {
				this.currentVoice = voicesSpeech[i];
			}
		}
	}
}


var toastObject = {
	
	notifications: null,
	
	toastDetails: {
		timer: 5000,
		success: {
			icon: 'fa-check-circle',
			text: 'success: ',
		},
		error: {
			icon: 'fa-times-circle',		// circle-xmark
			text: 'error: ',
		},
		warning: {
			icon: 'fa-exclamation-triangle',	// triangle-exclamation, exclamation-circle
			text: 'warning: ',
		},
		info: {
			icon: 'fa-exclamation-circle',  // info-circle; 
			text: 'info: ',
		}
	},
	
	createToast: function(id, message) {
		// Getting the icon and text for the toast based on the id passed
		const { icon, text } = toastObject.toastDetails[id];
		const toast = document.createElement("li"); // Creating a new 'li' element for the toast
		toast.className = `toast ${id}`; // Setting the classes for the toast
		var msg = text + message;
		// Setting the inner HTML for the toast fa-solid to fa
		toast.innerHTML = `<div class="column">
							 <i class="fa ${icon} "></i>
							 <span class="lable">${text}</span><span>${message}</span>
						  </div>
						  <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`;
		var notifications = document.querySelector(".notifications");
		notifications.appendChild(toast); // Append the toast to the notification ul
		// Setting a timeout to remove the toast after the specified duration
		toast.timeoutId = setTimeout(() => toastObject.removeToast(toast), toastObject.toastDetails.timer);
	},
	
	removeToast: function(toast) {
		toast.classList.add("hide");
		if(toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
		setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
	}
	
}
