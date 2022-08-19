var background = document.querySelector("body");
var ol = document.querySelector('ol');
var a = document.querySelector('a');
var div = document.querySelector("div");
var nav = document.querySelector(".nav");

let toggle = document.querySelector(".toggle");
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
		// console.log("Dark Mode");
		theme = "DARK";
		SetTheme.style.transition = '2s';
	} else {
		// console.log("Light Mode");
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
		// background.style.transition = '2s';
	} else{
		background.setAttribute("style", "background-color: white; color: black;");
		ol.setAttribute("style", "color: black;");
		a.setAttribute("style", "color: black;");
		div.setAttribute("style", "color: black;");
		// background.style.transition = '2s';
	}
}
