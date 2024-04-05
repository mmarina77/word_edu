
var ticketObject = {
	
	oxWord: null,
	currentTicket: null,
	
	// init for add new word
	init: function() {
		
		const ticketTab = document.querySelector(".ticketsId");
		ticketEl = ticketTab.querySelector(".ticketTabBtn");
		
		const wordEl = ticketTab.querySelector("#ticketWordId");
		wordEl.addEventListener("change", ()=>{
			var word = ticketTab.querySelector("#ticketWordId").value;
			ticketObject.fetchApi(word, function(resp){
				
				ticketObject.oxWord = null;
				const exampleEl = ticketTab.querySelector("#ticketExampleId");
				if(resp) {
					if(resp.example.length > 0) {
						var example = utility.replaceWord(word, '____', resp.example);
						exampleEl.value = example;	//resp.example;
					} else {
						if(resp.phrase.length > 0) {
							exampleEl.value = resp.phrase;
						} else {
							if(resp.shortDefinition.length > 0) {
								exampleEl.value = resp.shortDefinition;
							}
						}
					}
					ticketObject.oxWord = resp;
				}
				
			});
		});
		

		// save ticket event
		ticketEl.addEventListener("click", ()=>{
			//
			let moduleId = 0;
			if(sidebarObject.activeModule && sidebarObject.activeModule.id) {
				moduleId = sidebarObject.activeModule.id;
			} 
			else {
				return "error";	//
			}
			
			const ticketTab = document.querySelector(".ticketsId");
			var word = ticketTab.querySelector(".ticketWord").value;
			var example = ticketTab.querySelector(".ticketExample").value;
			
			var data = {
				action: 'createTicket',
				word_id: ticketObject.oxWord.id,
				example: example,
				module_id: moduleId
			};
			utility.request('module.php', data, function(resp){
					// reset
					ticketTab.querySelector(".ticketWord").value = '';
					ticketTab.querySelector(".ticketExample").value = '';
					ticketObject.oxWord = null;
//console.log(sidebarObject.activeModule.id);		
					moduleObject.moduleTickets(sidebarObject.activeModule.id);	
			});
		});
	},
	
	// fetch the word full info
	fetchApi: function(word, callback) {
		data = {
			word:word,
			language:'en-gb'
		};
		$.ajax({
			url: 'searchWord.php',
			contentType: 'application/json', 
			data: data,
			success: function(result){
				let data = null;
				if(result && result.status == 200) {
					data = result.data;
				} 
				callback(data);
			}
		});	
	},
	
	// *************** learning words by cards
	activeIndex: 0,
	//learnMode: 1,		// 1 - sequentially, 2 - random
	
	cardInit: function() {
		var tickets = moduleObject.ticketsList;
		ticketObject.activeIndex = 0;
		if(tickets && tickets.length > 0 ){
			//ticketObject.activeIndex = 0;
			ticketObject.showCard(ticketObject.activeIndex);
			//ticketObject.toolbarInit();
		} else {
			
		}
	},
	
	showCard: function(index) {

		var cardEl = document.querySelector(".flip-card");
		var card = moduleObject.ticketsList[index];
		var str =  `<div class="flip-card-inner">
						<div class="flip-card-front">
							<h1>&nbsp;</h1> 
							<p>&nbsp;</p> 
							<p>${card.definition}</p>
						</div>
						<div class="flip-card-back">
							<h1>&nbsp;</h1> 
							<h1>${card.word}</h1>
							<h1>&nbsp;</h1> 
							<p></p>
						</div>
					</div>`;
		cardEl.innerHTML = str;
//console.log(card);
	},
	
	toolbarInit: function() {

		var toolbarEl = document.querySelector(".flip-card-toolbar");
		
		var nextCard = toolbarEl.querySelector(".cardNext");
		nextCard.addEventListener("click", function() {
			if(ticketObject.activeIndex < moduleObject.ticketsList.length-1){
				ticketObject.activeIndex++;
				ticketObject.showCard(ticketObject.activeIndex);
			}
		});
		  
		var previousCard = toolbarEl.querySelector(".cardPrevious");
		previousCard.addEventListener("click", function() {
			if(ticketObject.activeIndex > 0){
				ticketObject.activeIndex--;
				ticketObject.showCard(ticketObject.activeIndex);
			}
		});
		
		var wordAudio = toolbarEl.querySelector(".cardWordAudio");
		wordAudio.addEventListener("click", function() {
			var url = moduleObject.ticketsList[ticketObject.activeIndex].audioURL;
			utility.playWord(url);
		});
		
		var definitionAudio = toolbarEl.querySelector(".cardDefinitionAudio");
		definitionAudio.addEventListener("click", function() {
			var text = moduleObject.ticketsList[ticketObject.activeIndex].definition;
			var utterance = new SpeechSynthesisUtterance(text);
			utterance.voice = sidebarObject.currentVoice;
			window.speechSynthesis.speak(utterance);
			
		});
		
		var translatedDefinition = toolbarEl.querySelector(".translatedDefinition");
		translatedDefinition.addEventListener("click", function() {
			
			let translateFrom = language;
			let translateTo = secondLanguage;
			var text = moduleObject.ticketsList[ticketObject.activeIndex].definition;
	
			let apiUrl = `https://api.mymemory.translated.net/get?q=${text}&langpair=${translateFrom}|${translateTo}`;
			fetch(apiUrl).then(res => res.json()).then(data => {

				let translatedText = data.responseData.translatedText;
				//response = data.responseData.translatedText;
				modalBoxObject.translate(text, data.responseData.translatedText);
			});
		});
		
	},
	
	// ***************************************** check words by cards
	// init check card
	cardInitCheck: function() {

		var tickets = moduleObject.ticketsList;
		ticketObject.activeIndex = 0;
		if(tickets && tickets.length > 0 ){
			ticketObject.showCardCheck(ticketObject.activeIndex);
			//ticketObject.checkToolbarInit();
		} else {
			
		}
	},
	
	showCardCheck: function(index){
		var cardEl = document.querySelector(".cardCheck");
		var card = moduleObject.ticketsList[index];
		cardEl.querySelector(".checkCardExample").innerHTML = card.example;
	},
	
	// init check card toolbar
	checkToolbarInit: function() {

		var toolbarEl = document.querySelector(".word-check-toolbar");

		var nextCard = toolbarEl.querySelector(".cardNextCheck");
		nextCard.addEventListener("click", function() {
			if(ticketObject.activeIndex < moduleObject.ticketsList.length-1){
				ticketObject.activeIndex++;
				ticketObject.showCardCheck(ticketObject.activeIndex);
				toolbarEl.querySelector(".checkWordValue").value = '';
			}
		});
		  
		var previousCard = toolbarEl.querySelector(".cardPreviousCheck");
		previousCard.addEventListener("click", function() {
			if(ticketObject.activeIndex > 0){
				ticketObject.activeIndex--;
				ticketObject.showCardCheck(ticketObject.activeIndex);
				toolbarEl.querySelector(".checkWordValue").value = '';
			}
		});
		
		var wordAudio = toolbarEl.querySelector(".cardWordAudioCheck");
		wordAudio.addEventListener("click", function() {
			var url = moduleObject.ticketsList[ticketObject.activeIndex].audioURL;
			utility.playWord(url);
		});
		
		var checkEl = toolbarEl.querySelector(".checkInputWord");
		checkEl.addEventListener("click", function() {
			ticketObject.verifyWord();
			
		});
		
		var checkInput = toolbarEl.querySelector(".checkWordValue");
		checkInput.addEventListener("keydown", function(event) {
			
			if (event.key === 'Enter') {
				//console.log('Enter key pressed!');
				ticketObject.verifyWord();
			}
		});

	},
	
	verifyWord: function() {
		
		var toolbarEl = document.querySelector(".word-check-toolbar");
		var w = toolbarEl.querySelector(".checkWordValue").value;
		var ticket = moduleObject.ticketsList[ticketObject.activeIndex];
		var word = ticket.word;
		
		let data = { action:'ticketStatus', ticket_id:ticket.ticketId, success: 0, error: 0 };
		if(word == w) {
			// show OK
			if(ticketObject.activeIndex < moduleObject.ticketsList.length-1) {
				ticketObject.activeIndex++;
			} else {
				ticketObject.activeIndex = 0;
			}
			ticketObject.showCardCheck(ticketObject.activeIndex);
			toolbarEl.querySelector(".checkWordValue").value = '';
			data.success = 1;
			toastObject.createToast('success', utility.convertHTML("Congrats, that's the right word."));
		} else {
			// show Error
			console.log('Error');
			data.error = 1;
			toastObject.createToast('error', 'It is not right, the right is <b>'+word+'</b>.');
		}
		utility.request('module.php', data, function(resp){
			console.log(resp);
		});
	}
}
