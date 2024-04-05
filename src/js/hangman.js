

var hangmanObject = {
	

	wordDisplay: null,
	guessesText: null,
	keyboardDiv: null,
	hangmanImage: null,
	
	gameModal: null,
	playAgainBtn: null,
	
	// Initializing game variables
	currentWord: null, 
	correctLetters: null, 
	wrongGuessCount: 0,
	
	currentIndex: null, 
	maxGuesses: 6,
	
	resetGame: function(){

		// Ressetting game variables and UI elements
		hangmanObject.correctLetters = [];
		hangmanObject.wrongGuessCount = 0;

		hangmanObject.hangmanImage.src = "images/hangman-0.svg";

		hangmanObject.guessesText.innerText = `${hangmanObject.wrongGuessCount} / ${hangmanObject.maxGuesses}`;
		hangmanObject.wordDisplay.innerHTML = hangmanObject.currentWord.split("").map(() => `<li class="letter"></li>`).join("");
		hangmanObject.keyboardDiv.querySelectorAll("button").forEach(btn => btn.disabled = false);
		//hangmanObject.gameModal.classList.remove("show");
	
	},
	
	init: function(){
		hangmanObject.wordDisplay = document.querySelector(".word-display");
		hangmanObject.guessesText = document.querySelector(".guesses-text b");
		hangmanObject.keyboardDiv = document.querySelector(".keyboard");
		hangmanObject.hangmanImage = document.querySelector(".hangman-box img");
		
		hangmanObject.gameModal = document.querySelector(".game-modal");
		hangmanObject.playAgainBtn = hangmanObject.gameModal.querySelector("button");
		hangmanObject.initKeyboard();

		//this.playAgainBtn.addEventListener("click", getRandomWord);
		hangmanObject.playAgainBtn.addEventListener("click", hangmanObject.getWord);
	},
	
	getWord: function() {

		if(!moduleObject.ticketsList) return;
		
		var words = moduleObject.ticketsList;
		var index = Math.floor(Math.random() * words.length);
		
		hangmanObject.currentIndex = index;
		hangmanObject.currentWord = words[index].word;
		
		document.querySelector(".hint-text b").innerText = words[index].definition;
		
		hangmanObject.resetGame();
	},
	
	initHangmanGame: function(button, clickedLetter) {
		// Checking if clickedLetter is exist on the currentWord
		if(hangmanObject.currentWord.includes(clickedLetter)) {
			// Showing all correct letters on the word display
			[...hangmanObject.currentWord].forEach((letter, index) => {
				if(letter === clickedLetter) {
					hangmanObject.correctLetters.push(letter);
					hangmanObject.wordDisplay.querySelectorAll("li")[index].innerText = letter;
					hangmanObject.wordDisplay.querySelectorAll("li")[index].classList.add("guessed");
				}
			});
		} else {
			// If clicked letter doesn't exist then update the wrongGuessCount and hangman image
			hangmanObject.wrongGuessCount++;
			hangmanObject.hangmanImage.src = `images/hangman-${hangmanObject.wrongGuessCount}.svg`;
		}
		button.disabled = true; // Disabling the clicked button so user can't click again
		hangmanObject.guessesText.innerText = `${hangmanObject.wrongGuessCount} / ${hangmanObject.maxGuesses}`;

		// Calling gameOver function if any of these condition meets
		if(hangmanObject.wrongGuessCount === hangmanObject.maxGuesses) {
			return hangmanObject.gameOver(false);
		}
		if(hangmanObject.correctLetters.length === hangmanObject.currentWord.length) {
			return hangmanObject.gameOver(true);
		}
	},
	
	initKeyboard : function() {
		// Creating keyboard buttons and adding event listeners
		//const keyboardDiv = document.querySelector(".keyboard");
		for (let i = 97; i <= 122; i++) {
			const button = document.createElement("button");
			button.innerText = String.fromCharCode(i);
			hangmanObject.keyboardDiv.appendChild(button);
			button.addEventListener("click", (e) => hangmanObject.initHangmanGame(e.target, String.fromCharCode(i)));
		}
	},
	gameOver: function(isVictory) {
		// After game complete.. showing modal with relevant details
		const modalText = isVictory ? `You found the word:` : 'The correct word was:';
		hangmanObject.gameModal.querySelector("img").src = `images/${isVictory ? 'victory' : 'lost'}.gif`;
		hangmanObject.gameModal.querySelector("h4").innerText = isVictory ? 'Congrats!' : 'Game Over!';
		hangmanObject.gameModal.querySelector("p").innerHTML = `${modalText} <b>${hangmanObject.currentWord}</b>`;
		//hangmanObject.gameModal.classList.add("show");
		
		// send result status
		var ticket = moduleObject.ticketsList[hangmanObject.currentIndex];
		var result = false;
		let data = { action:'ticketStatus', ticket_id:ticket.ticketId, success: 0, error: 0 };
		if(isVictory) {
			data.success = 1;
		} else {
			data.error = 1;
		}
		// 
		utility.request('module.php', data, function(resp){
			console.log(resp);
		});
		
		hangmanObject.getWord();
	}
}
