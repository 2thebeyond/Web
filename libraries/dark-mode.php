<style>
.theme-container-mobile{
	top: 140px;
	right: 173px;
	position: absolute;
	height: 50px;
}
.theme-container-mobile .theme-toggle{
	position: absolute;
	width: 150px;
	height: 70px;
	background: black;
	border-radius: 30px;
	transition: 0.5s;
}
.theme-container-mobile .theme-toggle .theme-toggle-btn{
	top: 10px;
	left: 10px;
	position: absolute;
	width: 50px;
	height: 50px;
	background: lightgray;
	border-radius: 50%;
	transition: 0.5s;
}
.theme-container-mobile .theme-toggle.active{
	background: cornflowerblue;
}
.theme-container-mobile .theme-toggle.active .theme-toggle-btn{
	background: yellow;
	left: 80px;
}

/* desktop */
.theme-container-pc{
	position: absolute;
}
.theme-container-pc .theme-toggle{
	transition: 0.5s;
	position: absolute;
	border-radius: 30px;
}
.theme-container-pc .theme-toggle .theme-toggle-btn{
	transition: 0.5s;
	border-radius: 50%;
	position: absolute;
	background: lightgray;
}
.theme-container-pc .theme-toggle.active{
	background: cornflowerblue;
}
.theme-container-pc .theme-toggle.active .theme-toggle-btn{
	background: yellow;
}

/**/
@media(min-width: 1000px){
	.theme-container-pc{
		top: 90px;
		right: 60px;
		height: 50px;
	}
	.theme-container-pc .theme-toggle{
		width: 50px;
		height: 20px;
		background: black;
	}
	.theme-container-pc .theme-toggle .theme-toggle-btn{
		top: 3px;
		left: 6px;
		width: 15px;
		height: 15px;
	}
	.theme-container-pc .theme-toggle.active .theme-toggle-btn{
		left: 30px;
	}
}
@media(max-width: 1000px){
	.theme-container-pc{
		top: 40px;
		right: 173px;
		height: 50px;
	}
	.theme-container-pc .theme-toggle{
		width: 150px;
		height: 70px;
		background: #545454;
	}
	.theme-container-pc .theme-toggle .theme-toggle-btn{
		top: 10px;
		left: 10px;
		width: 50px;
		height: 50px;
	}
	.theme-container-pc .theme-toggle.active .theme-toggle-btn{
		left: 80px;
	}
}
@media(max-width: 600px){
	.theme-container-pc{
		display: none;
	}
}
</style>
<html>
<?php
$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){ 
	?> <div class='theme-container-mobile'> <?php  
} else {
	?> <div class='theme-container-pc'> <?php
} ?>	<div class='theme-toggle'>
				<div class='theme-toggle-btn' onclick='darkmode()'></div>
			</div>
		</div>
</html>
<script>
var background = document.querySelector("body");
var ol = document.querySelector('ol');
var a = document.querySelector('a');
var div = document.querySelector("div");
var nav = document.querySelector(".nav");

let toggle = document.querySelector(".theme-toggle");
let GetTheme = JSON.parse(localStorage.getItem("PageTheme"));
// console.log(GetTheme);

if(GetTheme === "DARK"){
	document.body.classList = "dark-mode";
	// toggle.classList.toggle("active");
} else {
	toggle.classList.toggle("active");
}

function darkmode(){
	var SetTheme = document.body;
	
	SetTheme.classList.toggle("dark-mode");
	toggle.classList.toggle("active");
	
	var theme;
	
	if(SetTheme.classList.contains("dark-mode")){
		console.log("Dark Mode");
		theme = "DARK";
		SetTheme.style.transition = '2s';
	} else {
		console.log("Light Mode");
		theme = "LIGHT";
		SetTheme.style.transition = '2s';
	}
	
	localStorage.setItem("PageTheme", JSON.stringify(theme));
}

function loadTheme(){
	if (GetTheme === "DARK") {
		background.setAttribute("style", "background-color: black; color: white;");
		ol.setAttribute("style", "color: white;");
		a.setAttribute("style", "color: white;");
		div.setAttribute("style", "color: white;");
	} else{
		background.setAttribute("style", "background-color: white; color: black;");
		ol.setAttribute("style", "color: black;");
		a.setAttribute("style", "color: black;");
		div.setAttribute("style", "color: black;");
	}
}
</script>