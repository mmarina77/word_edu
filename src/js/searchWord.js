
var searchWordObject = {
	wrapper: null,
	searchInput: null,
	infoText: null,
	removeIcon: null,
	wordInfo: null,
	
	// audio
	audioWord: null,
	volumeWord: null,
	
	init: function() {
		this.wrapper = document.querySelector(".searchWrapper");
	},
	
	initWord: function() {
		let str = `<div class="search">
        <input type="text" placeholder="Search a word" required spellcheck="false">
        <i class="fas fa-search"></i>
        <span class="material-icons">close</span>
      </div>
      <p class="info-text"></p>
      <div class="word-info"></div>`;
	  
	  this.init();
	  
	  this.wrapper.innerHTML = str;
	  this.searchInput = this.wrapper.querySelector("input");
	  this.infoText = this.wrapper.querySelector(".info-text");
	  
	  this.searchInput.addEventListener("keyup", e =>{
			let word = e.target.value.replace(/\s+/g, ' ');
			if(e.key == "Enter" && word){
				searchWordObject.fetchApi(word);
			}
		});
	},

	fetchApi: function(word) {
		data = {
			word:word,
			language:'en-gb'
		};
		$.ajax({
			url: 'searchWord.php',
			contentType: 'application/json', 
			data: data,
			success: function(result){
				if(result && result.status == 200) {
					searchWordObject.showWord(result.data);
				} else {
					
					searchWordObject.wrapper = document.querySelector(".searchWrapper");

					let infoText = searchWordObject.wrapper.querySelector(".info-text");
					let wordInfo = searchWordObject.wrapper.querySelector(".word-info");
					infoText.innerHTML = `Can't find the meaning of <span>"${word}"</span>. Please, try to search for another word.`;
					wordInfo.innerHTML = "";
				}
			}
		});	
	},
	
	showWord: function(obj) {
		
		let phontetics = `${obj.type}  /${obj.phonetic}/`;
		
		let etymology = obj.etymology.length > 0 ? '<li class="etymology"><div class="details"><p>etymology</p><span>'+obj.etymology+'</span></div></li>' : '';
		let meaning = obj.definition.length > 0 ? '<li class="meaning"><div class="details"><p>meaning</p><span>'+obj.definition+'</span></div></li>' : '';
		let example = obj.example.length > 0 ? '<li class="example"><div class="details"><p>example</p><span>'+obj.example+'</span></div></li>' : '';
		let shortMeaning = obj.shortDefinition.length > 0 ? '<li class="shortMeaning"><div class="details"><p>short meaning</p><span>'+obj.shortDefinition+'</span></div></li>' : '';
		let phrase = obj.phrase.length > 0 ? '<li class="phrase"><div class="details"><p>phrase</p><span>'+obj.phrase+'</span></div></li>' : '';
		let synonyms = obj.synonyms.trim().length > 0 ? '<li class="synonyms"><div class="details"><p>synonyms</p><span>'+obj.synonyms+'</span></div></li>' : '';
	
		let str = `<ul>
			<li class="word">
			  <div class="details">
				<p>${obj.word}</p>
				<span>${phontetics}</span>
			  </div>
			  <i class="fas fa-volume-up"></i>
			</li>
			<div class="meaning_content">
				${meaning}
				${shortMeaning}
				${example}
				${phrase}
				${etymology}
				${synonyms}
			</div>
		  </ul>`;


		this.wordInfo = this.wrapper.querySelector(".word-info");
		this.wordInfo.innerHTML = str;
		this.removeIcon = this.wrapper.querySelector(".search span");
	  
		this.removeIcon.addEventListener("click", ()=>{
			searchWordObject.searchInput.value = "";
			searchWordObject.searchInput.focus();
			searchWordObject.wordInfo.innerHTML = "";
			searchWordObject.infoText.style.color = "#9A9A9A";
			searchWordObject.infoText.innerHTML = "";	// Type any existing word.
		});

		// 
		this.audioWord = new Audio(obj.audioURL);
		
		this.volumeWord = this.wrapper.querySelector(".word i"),
		
		this.volumeWord.addEventListener("click", ()=>{
			searchWordObject.volumeWord.style.color = "#4D59FB";
			searchWordObject.audioWord.play();
			setTimeout(() =>{
				searchWordObject.volumeWord.style.color = "#999";
			}, 800);
		});
	}
	
	
}
