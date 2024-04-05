
var utility = {
	
	playWord: function(url) {
		
		var x = document.getElementById("audioPlayerId"); 
		x.innerHTML = '';
		var audio = document.createElement("AUDIO");
		audio.setAttribute("src", url);
		audio.preload = "auto";
		audio.autoplay = true;
		x.appendChild(audio);
	},
	
	replaceWord: function(word, to, str){
		var w = word.trim();
		var allWords = new RegExp( '\\b' + word + '\\b','gi');
console.log(word);
		var newString = str.replace(allWords, to);
		return newString;
/*
		var re = new RegExp( '\\b' + word.join('|') + '\\b','gi');
		return str.replace(re, word);
*/
	},
	
	request: function(url, data, callback) {
		
		$.ajax({
			type: "POST",
			url:url,
			data: data,
			success: function (res) {
				if(res ) {
					if(callback != 'undefined') {
						callback(res);
					}

				} else {
					console.log(res);
					//document.location.href = baseURL+"/";
				}
			}
		});
	},
	
	convertHTML: function(str) {
		let replacements = {
		  "&": "&amp;",
		  "<": "&lt;",
		  ">": "&gt;",
		  '""': "&quot;",//THIS PROBLEM ME MUCH
		  "'": "&apos;",
		  "<>": "&lt;&gt;",
		}
		return str.replace(/(&|<|>|""|'|<>)/gi, function(noe) {
		  return replacements[noe];
		});
	}
	/*request: function(action, data, callBack) {
		 $.post("demo_test_post.asp", data, function(data, status){
			alert("Data: " + data + "\nStatus: " + status);
			});
		$.ajax({
			url: 'searchWord.php',
			type: 'GET',
			data: 'word='+$value,
			success: function(result){
				$replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
				$(".form").append($replay);
				// when chat goes down the scroll bar automatically comes to the bottom
				$(".form").scrollTop($(".form")[0].scrollHeight);
			}
		});
  
	}*/
	
}

/*
// https://www.w3schools.com/jsref/jsref_obj_regexp.asp
// /g	Perform a global match (find all)
// /i	Perform case-insensitive matching
// /m	Perform multiline matching

function highlightWord(word) {
    // get your current div content by id
    var string = document.getElementById('your-id').innerHTML;

    // set word to highlight
    var newWord = '<mark>' + word + '</mark>';

    // do replacement with regular expression
    var allWords = new RegExp( '\\b' + word + '\\b','gi');
    var newString = string.replace(allWords, newWord);

    // set your new div content by id
    document.getElementById('your-id').innerHTML = newString;
};
*/

var modalBoxObject = {
	
	modalEl: null,
	
	init: function(){
		
		var modalEl = document.querySelector(".modalbox");	// or #messageModal
		var closeEl = modalEl.querySelector(".close");
		
		closeEl.addEventListener("click", function() {
			var modalEl = document.querySelector(".modalbox");
			modalEl.style.display = "none";
		});
		
		modalEl.addEventListener("click", function() {
			modalEl.style.display = "none";
		});
	},
	translate: function(text, trans) {
		
		var modalEl = document.querySelector(".modalbox");	// or #messageModal
		
		var str = `<table style="width:500px;min-height:100px;">
		<tr><td style="padding: 0 7px;width:50%;color:#aaaaaa">${text}</td><td style="padding: 0 7px;width:50%">${trans}</td></tr></table>`;
		var m = modalEl.querySelector("#modalContent");
		m.innerHTML = str;
		
		modalEl.style.display = "block";
	}
}

