var background = document.querySelector("body");
var ol = document.querySelector('ol');
var a = document.querySelector('a');
var div = document.querySelector("div");
var nav = document.querySelector(".nav");
var btnName = document.querySelector(".header");
var currentTheme = localStorage.getItem("currentTheme");
const btnElement = document.getElementById("darkmode");
const dark = '<div>Dark Mode</div>';
const light = '<div>Light Mode</div>';
var btnName = document.querySelector('#darkmode');

loadTheme();

function loadTheme(){
	if (currentTheme == "dark") {
		background.setAttribute("style", "background-color: black; color: white;");
		ol.setAttribute("style", "color: white;");
		a.setAttribute("style", "color: white;");
		div.setAttribute("style", "color: white;");
		btnName.setAttribute("value", "Light Mode");
		// console.log("현재 테마 : 다크");
	} else{
		background.setAttribute("style", "background-color: white; color: black;");
		ol.setAttribute("style", "color: black;");
		a.setAttribute("style", "color: black;");
		div.setAttribute("style", "color: black;");
		btnName.setAttribute("value", "Dark Mode");
		// console.log("현재 테마 : 라이트");
	}
}

function ToggleTheme(self){
	const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

	if (prefersDarkScheme.matches) {
		window.matchMedia("(prefers-color-scheme: light)").matches ? 'light' : 'dark';
	} else {
		window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
	}

	const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
	localStorage.setItem('currentTheme', newTheme);

	location.reload();
} 


// if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
//    	var background = document.querySelector("body");
// 	// var ol = document.querySelector('ol');
// 	var a = document.querySelector('a');
// 	var div = document.querySelector("div");
// 	var nav = document.querySelector(".nav");
// 	var btnName = document.querySelector(".header");
// 	var currentTheme = localStorage.getItem("currentTheme");
// 	const btnElement = document.getElementById("darkmode");
// 	const dark = '<div>Dark Mode</div>';
// 	const light = '<div>Light Mode</div>';
// 	var btnName = document.querySelector('#darkmode');

// 	loadTheme();

// 	function loadTheme(){
// 		if (currentTheme == "dark") {
// 			background.setAttribute("style", "background-color: black; color: white;");
// 			// ol.setAttribute("style", "color: white;");
// 			a.setAttribute("style", "color: white;");
// 			div.setAttribute("style", "color: white;");
// 			btnName.setAttribute("value", "Light Mode");
// 			// console.log("현재 테마 : 다크");
// 		} else{
// 			background.setAttribute("style", "background-color: white; color: black;");
// 			// ol.setAttribute("style", "color: black;");
// 			a.setAttribute("style", "color: black;");
// 			div.setAttribute("style", "color: black;");
// 			btnName.setAttribute("value", "Dark Mode");
// 			// console.log("현재 테마 : 라이트");
// 		}
// 	}

// 	function ToggleTheme(self){
// 		const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

// 		if (prefersDarkScheme.matches) {
// 			window.matchMedia("(prefers-color-scheme: light)").matches ? 'light' : 'dark';
// 		} else {
// 			window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
// 		}

// 		const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
// 		localStorage.setItem('currentTheme', newTheme);

// 		location.reload();
// 	}
// } else {
// 	var background = document.querySelector("body");
// 	// var ol = document.querySelector('ol');
// 	var a = document.querySelector('a');
// 	var div = document.querySelector("div");
// 	var nav = document.querySelector(".nav");
// 	var btnName = document.querySelector(".header");
// 	var currentTheme = localStorage.getItem("currentTheme");
// 	background.setAttribute("style", "background-color: white; color: black;");
// 	// ol.setAttribute("style", "color: black;");
// 	a.setAttribute("style", "color: black;");
// 	div.setAttribute("style", "color: black;");
// 	btnName.setAttribute("value", "Dark Mode");
// }

// var Body = {
// 	setFontColor:function(color){
// 		$('body').css('color', color);
// 		// document.querySelector('body').style.color = color;
// 	},
// 	setBackgroundColor:function(color){
// 		$('body').css('backgroundColor', color);
// 		//document.querySelector('body').style.backgroundColor = color;
// 	}
// }
// var Ol = {
// 	setFontColor:function(color){
// 		$('ol').css('color', color);
// 		//document.querySelector('ol').style.color = color;
// 	}
// }
// var A = {
// 	setFontColor:function(color){
// 		$('a').css('color', color);
// 	}	
// }
// var Line = {
// 	setBorderColor:function(color){
// 		$('.nav').css('borderColor', color);
// 		$('.header').css('borderColor', color);
// 	}
// }
////////////////
// var Links = {
// 	setFontColor:function(target, color){
// 		var targets = document.querySelectorAll(target);
// 		for (i = 0; i < targets.length; i++) {
// 			targets[i].style.color = color;
// 		}
// 	},
// 	setBorderColor:function(target, color){
// 		var targets = document.querySelectorAll(target);
// 		for (i = 0; i < targets.length; i++) {
// 			targets[i].style.borderColor = color;
// 		}
// 	}
// }

// function darkmodeHandler(self) {
// 	if (self.value === 'Dark Mode'){
// 		Body.setBackgroundColor('black')
// 		Body.setFontColor('white')
// 		Ol.setFontColor('white')
// 		A.setFontColor('white')
// 		Line.setBorderColor('white')
// 		self.value = 'Light Mode'
// 	} else {
// 		Body.setBackgroundColor('white')
// 		Body.setFontColor('black')
// 		Ol.setFontColor('black')
// 		A.setFontColor('black')
// 		Line.setBorderColor('black')
// 		self.value = 'Dark Mode'
// 	}	
// }