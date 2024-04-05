<?php
require_once 'middleware.php';
require_once 'authentication.php';

$vers = rand(1,1000);
$applicationUrl = APPLICATION_URL;
$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="author" content="CodePel">
      <title> Side Sliding Menu CSS Example </title>

	<link rel="shortcut icon" href="#">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>	
    
	<link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<!-- Style CSS -->
	<link rel="stylesheet" href="src/css/hangman.css?<?php echo $vers; ?>">
	<link rel="stylesheet" href="src/css/sidebar.css?<?php echo $vers; ?>">
	<link rel="stylesheet" href="src/css/toast.css?<?php echo $vers; ?>">
	<link rel="stylesheet" href="src/css/searchword.css?<?php echo $vers; ?>">
	<link rel="stylesheet" href="src/css/module.css?<?php echo $vers; ?>">
	<link rel="stylesheet" href="src/css/ticket.css?<?php echo $vers; ?>">


	<script src="src/js/hangman.js?<?php echo $vers; ?>"></script>
	<script src="src/js/utility.js?<?php echo $vers; ?>"></script>
	<script src="src/js/sidebar.js?<?php echo $vers; ?>"></script>
	<script src="src/js/module.js?<?php echo $vers; ?>"></script>
	<script src="src/js/ticket.js?<?php echo $vers; ?>"></script>
	<script src="src/js/searchWord.js?<?php echo $vers; ?>"></script>
	
	<!-- script src="src/js/notification.js?<?php echo $vers; ?>"></script -->
	
	</head>
	<body>
		<header class="cd__header">
			<span style="color:grey;"><i id="activeModuleId"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:grey;" id="messageId"></span>
			<ul class="notifications"></ul>
<!--div class="alert alert-warning alert-dismissible fade show" role="alert" style="display:block">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  fa-flask = fa-graduation-cap
  fa-ticket = fa-money 
</div-->

		</header>
		<main class="cd__main">
			<nav class="main-menu">

				<ul>
					<li><a href="#home" data-toggle="tab"><i class="fa fa-home fa-lg"></i><span class="nav-text home">Home</span></a></li>   
					<li><a href="#module" data-toggle="tab"><i class="fa fa-folder-open fa-lg"></i><span class="nav-text module">Module</span></a></li>                                 
					<li><a href="#ticket" data-toggle="tab"><i class="fa fa-ticket fa-lg"></i><span class="nav-text ticket">Ticket</span></a></li>
					
					<li class="darkerlishadow"><a href="#wordLearn" data-toggle="tab"><i class="fa fa-credit-card fa-lg"></i><span class="nav-text wordLearn">Cards</span></a></li>
					<li class="darkerli"><a href="#wordCheck" data-toggle="tab"><i class="fa fa-graduation-cap fa-lg"></i><span class="nav-text wordCheck">Check word</span></a></li>
					<li class="darkerli"><a href="#hangmangame" data-toggle="tab"><i class="fa fa-puzzle-piece fa-lg"></i><span class="nav-text hangmangame">Hangmang</span></a></li>
					<li class="darkerli"><a href="#"><i class="fa fa-shopping-cart1"></i><span class="nav-text">&nbsp;</span></a></li>
					<li class="darkerli"><a href="#"><i class="fa fa-microphone1 fa-lg"></i><span class="nav-text">&nbsp;</span></a></li>

					<li class="darkerli"><a href="#"><i class="fa fa-flask1 fa-lg"></i><span class="nav-text">&nbsp;</span></a></li>
					<li class="darkerli"><a href="#"><i class="fa fa-picture-o1 fa-lg"></i><span class="nav-text">&nbsp;</span></a></li>
					<li class="darkerli"><a href="#"><i class="fa fa-align-left1 fa-lg"></i><span class="nav-text">&nbsp;</span></a></li>

					<li class="darkerli"><a href="#"><i class="fa fa-glass1 fa-lg"></i><span class="nav-text">&nbsp;</span></a></li>
					<li class="darkerlishadowdown"><a href="#">
											<i class="fa fa-power fa-lg"></i><span class="nav-text">&nbsp;</span></a></li> 
				</ul>

				<ul>
					<li><a href="<?php echo $applicationUrl.'logout.php'?>">
					<i class="fa fa-power-off fa-lg"></i><span class="nav-text">Sign out</span></a></li>   
				</ul>
 
				<ul class="logout">
					<!--li><a href="#"><i class="fa fa-lightbulb1-o fa-lg"></i><span class="nav-text">&nbsp;</span></a></li-->  
				</ul>
			</nav>
		</main>
		<section  class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<h2>Home</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure, debitis nesciunt!</p>
			</div>
		
			<div id="module" class="moduleTab content tab-pane fade">
				<h4>Select module</h4>
				<div class="modulesList form-group">
					<!-- label for="moduleSelect"></label -->
					<select id="moduleSelect" class="form-control">
						<option>Disabled select</option>
					</select>
				</div>
				<br>
				<h4>Create module</h4>
				<div class="form-group">
					<!-- label for="moduleName">name</label -->
					<input class="form-control moduleName" id="moduleName" type="text"  placeholder="module name" >
				</div>
				<div class="form-group">
					<!-- label for="moduleDescription">description</label -->
					<textarea class="form-control moduleDescription" id="moduleDescription" rows="1" placeholder="module description"></textarea>
				</div>
				<button type="submit" class="moduleTabBtn btn btn-default"><span class="glyphicon glyphicon-ok"></button>

				<div class="ticket_accordion"></div>
			</div>
			
			<div id="ticket" class="ticketTab content tab-pane fade">
				<h4>New ticket</h4>
				<div class="ticketsId">
					<div class="form-group">
						<label for="ticketWordId">word</label>
						<input type="text" class="form-control ticketWord" id="ticketWordId">
					</div>
					<div class="form-group">
						<label for="ticketExampleId">example</label>
						<!-- textarea rows="3" class="form-control ticketExample" id="ticketExampleId" value="*******"></textarea -->
						<input type="text" class="form-control ticketExample" id="ticketExampleId" value="">
					</div>
					<button type="submit" class="ticketTabBtn btn btn-default"><span class="glyphicon glyphicon-ok"></button>
				</div>
				
			</div>
			
			<div id="wordLearn" class="ticketTab content tab-pane fade" style="text-align:center">
				<h4> </h4>
				<div class="flip-card">
					<div class="flip-card-inner">
						<div class="flip-card-front">
							<h1>&nbsp;</h1> 
							<p>&nbsp;</p> 
							<p>any of the more or less distinct parts into which something is or may be divided or from which it is made up</p>
						</div>
						<div class="flip-card-back">
							<h1>&nbsp;</h1> 
							<h1>section</h1>
							<h1>&nbsp;</h1> 
							<p></p>
						</div>
					</div>
				</div>

				<div class="flip-card-toolbar" style="text-align:center">
					<span class="flip-card-icon" style="float:left"><i class="fas fa-volume-up cardDefinitionAudio" style="color:grey" title="sound of definition"></i></span> 
					<span class="flip-card-icon" style="float:left"><i class="fas fa-file-text translatedDefinition" style="color:grey" title="translation of definition"></i></span> 
					<span class="flip-card-icon" style="float:right"><i class="fas fa-arrow-right cardNext" style="color:grey" title="next card"></i></span>  
					<span class="flip-card-icon" style="float:right"><i class="fas fa-arrow-left cardPrevious" style="color:grey" title="previous card"></i></span> 
					<span class="flip-card-icon" style="float:right"><i class="fas fa-volume-down cardWordAudio" style="color:grey" title="word sount"></i></span> 
				</div>
			</div>
			
			<div id="wordCheck" class="ticketTab content tab-pane fade" style="text-align:center">
				<h4> </h4>
				<div class="cardCheck">
					<div class="cardCheckContent">
						<h4>Fill in the missing word</h4> 
						<p class="checkCardExample">any of the more or less ____ parts into which something </p>
					</div>
				</div>

				<div class="word-check-toolbar" style="text-align:center;">
					<span class="flip-card-icon" style="float:left"><i class="fas fa-volume-up cardWordAudioCheck" style="color:grey" title="word sount"></i></span> 
					<input type="text" id="checkWordId" style="float:left" class="checkWordValue" />
					<span class="flip-card-icon" style="float:left"><i class="fas fa-play checkInputWord" style="color:green" title="check word"></i></span> 

					<span class="flip-card-icon" style="float:right"><i class="fas fa-arrow-right cardNextCheck" style="color:grey" title="next card"></i></span>  
					<span class="flip-card-icon" style="float:right"><i class="fas fa-arrow-left cardPreviousCheck" style="color:grey" title="previous card"></i></span> 
				</div>
			</div>
			
			<div id="hangmangame" class="ticketTab content tab-pane fade" style="text-align:center">
				<div class="game-modal">
					<div class="content">
						<img src="#" alt="gif">
						<h4>Game Over!</h4>
						<p>The correct word was: <b>rainbow</b></p>
						<button class="play-again">Play Again</button>
					</div>
				</div>
				<div class="hangmanContainer">
					<div class="hangman-box">
						<img src="#" draggable="false" alt="hangman-img">
						<!-- h1>Hangman Game</h1 -->
					</div>
					<div class="game-box">
						<ul class="word-display"></ul>
						<h4 class="hint-text">Hint: <b></b></h4>
						<h4 class="guesses-text">Incorrect guesses: <b></b></h4>
						<div class="keyboard"></div>
					</div>
				</div>
			</div>
			
			
		</section>
		<div class="searchWrapper active"></div>
		<div id="audioPlayerId"></div>
		
		
		<!-- The Modal -->
		<div id="messageModal" class="modalbox">
		  <div class="modal-content">
			<span class="close">&times;</span>
			<p id="modalContent">Some text in the Modal..</p>
		  </div>
		</div>

		<footer class="cd__credit">
			Copyright © 2024 Diploma All Rights Reserved			
		</footer>
      <!-- Script JS -->
       <!--$%analytics%$  Graduate Work -->
   </body>
</html>
<!-- script src="./js/script.js"></script -->
<script>
const user_id = <?php echo $user_id?>;

const language = "en-GB";
const secondLanguage = "ru-RU";

// for English text to speech
const synthSpeech = window.speechSynthesis;
var voicesSpeech;



$( document ).ready(function() {
	// Handler for .ready() called.
	//navObject.init();
	sidebarObject.init();
	
	sidebarObject.loadVoices();

	modalBoxObject.init();
	
	moduleObject.initCreateModule();
	
	moduleObject.getModules();
	moduleObject.initList();
	
	moduleObject.unloadModule();	// ???
	
	ticketObject.init();
	
	ticketObject.toolbarInit();
	ticketObject.checkToolbarInit();

	hangmanObject.init();
	
	
	searchWordObject.initWord();
	
	//toastObject.createToast('success', 'Success word.');
	//toastObject.createToast('error', 'Wrong word.');
	//toastObject.createToast('warning', 'Wrong warning.');
	//toastObject.createToast('info', 'info warning.');
});
</script>

