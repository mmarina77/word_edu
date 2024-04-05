/*
	module.js
*/

var moduleObject = {
	
	modules: null,
	ticketsList: null,
	audioWords: {},
	
	translated: '',
	
	loadModule: function() {
		document.querySelector("#ticket").style.visibility = 'visible';
		document.querySelector("#wordLearn").style.visibility = 'visible';
		document.querySelector("#wordCheck").style.visibility = 'visible';
		document.querySelector("#hangmangame").style.visibility = 'visible';
	},
	
	unloadModule: function() {
		document.querySelector("#ticket").style.visibility = 'hidden';
		document.querySelector("#wordLearn").style.visibility = 'hidden';
		document.querySelector("#wordCheck").style.visibility = 'hidden';
		document.querySelector("#hangmangame").style.visibility = 'hidden';
	},
	
	initCreateModule: function() {
		
		//
		var moduleTab = document.querySelector(".moduleTab");
		var saveButton = moduleTab.querySelector(".moduleTabBtn");

		// save a new module
		saveButton.addEventListener("click", ()=>{
			
			var moduleTab = document.querySelector(".moduleTab");
			var moduleName = moduleTab.querySelector(".moduleName").value;
			var moduleDescription = moduleTab.querySelector(".moduleDescription").value;
			let data = {
				  action: 'createModule',
				  moduleName: moduleName,
				  moduleDescription: moduleDescription
				};
				
			utility.request('module.php', data, function(resp){
				if(resp && resp.status > 0) {
					moduleObject.getModules();
					moduleObject.initList();
					
				} else { }
				var moduleTab = document.querySelector(".moduleTab");
				moduleTab.querySelector(".moduleName").value = '';
				moduleTab.querySelector(".moduleDescription").value = '';
			});
		});

		moduleObject.getModules();
		moduleObject.initList();
		
	},
	initList: function() {
		
		let list = '<option value="-1" style="color:#ebebeb">- - -</option>';
		
		if(moduleObject.modules) {
			for(let i = 0; i < moduleObject.modules.length; i++ ) {
				let item = moduleObject.modules[i];
				let selected = '';
				if(sidebarObject.activeModule && sidebarObject.activeModule.id == item.id) {
					selected = 'selected';
				}
				list += '<option value="' + item.id + '" ' + selected + '>' + item.name + '</option>';
			}
		}

		list = '<select class="form-control" id="moduleSelect">' + list + '</select>';
		
		var moduleSelect = document.querySelector(".modulesList");
		moduleSelect.innerHTML = list; 
		
		// onchange event
		var selectEl = document.querySelector("#moduleSelect");
		selectEl.addEventListener("change", ()=>{
			
			var value = selectEl.options[selectEl.selectedIndex].value;
			var text = selectEl.options[selectEl.selectedIndex].text;
			// 
			var el = document.querySelector("#activeModuleId");
			if(value > 0 ) {
				el.innerText = text;
				sidebarObject.activeModule = {id: value, name: text};
				// get tickets by module id
				moduleObject.moduleTickets(value);
				
moduleObject.loadModule();
			} else {
				el.innerText = " ";
				sidebarObject.activeModule = null;
			}


		});
		
	},

	// get modules list
	getModules: function() {
		var data = {action: 'modules'};

		utility.request('module.php', data, function(resp){
			moduleObject.modules = null;
			if(resp && resp.status > 0) {
				moduleObject.modules = resp.data;
			} else {
				moduleObject.modules = null;
			}
		});
	},

	// get tickets by module id
	moduleTickets: function(moduleId) {
		let data = {action: 'moduleTickets', module_id: moduleId};

		utility.request('module.php', data, function(resp){
			if(resp && resp.status > 0 ) {
				
				moduleObject.ticketsList = resp.data;
				moduleObject.showTicketsList();
				
			} else {
				moduleObject.ticketsList = null;
				document.querySelector(".ticket_accordion").innerHTML = '';
			}
		});
	},
	
	showTicketsList: function() {
		var list = moduleObject.ticketsList;
		
		let str = '';
		for(var i = 0; i < list.length; i++) {


			var definition = list[i].definition; // + '<span class="tooltip-text">'+r +'</span>';

			var id = 'def_' + list[i].moduleId + '_' + list[i].oxId;
			
			let tbl = '<table><tr><td width="50%" id="' + id + '" moduleId="'+list[i].moduleId+'" oxId="'+list[i].oxId+'" class="tickeDefinitionTranslated">' + definition + '</td>\
			<td width="10px"><i class="fas fa-volume-up ticketDefinitionAudioClass" style="color:grey"></i></td>\
			<td width="40%">'+list[i].example+'</td>\
			<td class="wordAudio"><i class="fas fa-volume-down ticketWordAudioClass" url="'+list[i].audioURL+'"></i>\
			<i class="fas fa-close ticketIdClass" ticket_id="'+list[i].ticketId+'" module_id="'+list[i].moduleId+'">\
			</td></tr></table>';
			
			str += '<button class="accordion">'+list[i].word+'</button>\
						<div class="panel">'+tbl+'</div>';
		}
		
	
		var main = document.querySelector(".ticket_accordion");
		main.innerHTML = str;
		
		const acc = document.getElementsByClassName("accordion");
		for (var i = 0; i < acc.length; i++) {
		  acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
			  panel.style.display = "none";
			} else {
			  panel.style.display = "block";
			}
		  });

		}
		
		var audio = document.getElementsByClassName("ticketWordAudioClass");
		for (var i = 0; i < audio.length; i++) {
			audio[i].style.cursor = 'pointer';
			audio[i].addEventListener("click", function() {
				var url = this.getAttribute("url");
				utility.playWord(url);
			});
		}

		// delete ticket event
		var delTicket = document.getElementsByClassName("ticketIdClass");
		for (var i = 0; i < delTicket.length; i++) {
	
			delTicket[i].style.cursor = 'pointer';
			delTicket[i].addEventListener("click", function() {
				var ticketId = this.getAttribute("ticket_id");
				var moduleId = this.getAttribute("module_id");
				
				let data = {action: 'removeTicket', ticket_id: ticketId, module_id: moduleId};

				utility.request('module.php', data, function(resp){
					if(resp && resp.status > 0 ) {
						moduleObject.moduleTickets(sidebarObject.activeModule.id);
						
					} 
				});
			});
		}
		
		//
		var audioDef = document.getElementsByClassName("ticketDefinitionAudioClass");
		for (var i = 0; i < audioDef.length; i++) {
			audioDef[i].style.cursor = 'pointer';
			audioDef[i].addEventListener("click", function() {
				var defn = this.parentNode.previousElementSibling;
				var text = defn.innerHTML;

				var utterance = new SpeechSynthesisUtterance(text);
				utterance.voice = sidebarObject.currentVoice;
				window.speechSynthesis.speak(utterance);
			});
		}
		
		// 
		var tooltipDef = document.getElementsByClassName("tickeDefinitionTranslated");
		for (var i = 0; i < tooltipDef.length; i++) {
			var index = i;
			tooltipDef[i].addEventListener("click", function() {
				var defn = this.innerHTML;
				moduleObject.translateText(this.innerHTML);
			});
			//tooltipDef[i].setAttribute('title', item['translated']);
		}	
	},
	
	//translateText: function(text, index, moduleId, oxId) {
	translateText: function(text) {
		
		let translateFrom = 'en-GB';
		let translateTo = 'ru-RU';
				
		let apiUrl = `https://api.mymemory.translated.net/get?q=${text}&langpair=${translateFrom}|${translateTo}`;
		let response = '';
		fetch(apiUrl).then(res => res.json()).then(data => {

			let translatedText = data.responseData.translatedText;
			response = data.responseData.translatedText;
//console.log(data.responseData.translatedText);

		});
	},
	
	itemByIds: function(moduleId, oxId) {
		for(var i = 0; i < moduleObject.ticketsList.length; i++) {
			if(moduleObject.ticketsList[i]["moduleId"] == moduleId && moduleObject.ticketsList[i]["oxId"] == oxId) {
				console.log("===== OK ===");
				return moduleObject.ticketsList[i];
			}
		}
		return null;
	}
	
}

