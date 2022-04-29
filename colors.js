var Body = {
	setFontColor:function(color){
		$('body').css('color', color);
		// document.querySelector('body').style.color = color;
	},
	setBackgroundColor:function(color){
		$('body').css('backgroundColor', color);
		//document.querySelector('body').style.backgroundColor = color;
	}
}
var Ol = {
	setFontColor:function(color){
		$('ol').css('color', color);
		//document.querySelector('ol').style.color = color;
	}
}
var A = {
	setFontColor:function(color){
		$('a').css('color', color);
	}	
}
var Line = {
	setBorderColor:function(color){
		$('.nav').css('borderColor', color);
		$('.header').css('borderColor', color);
	}
}
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
function darkmodeHandler(self) {
	if (self.value === 'Dark Mode'){
		Body.setBackgroundColor('black');
		Body.setFontColor('white');
		Ol.setFontColor('white');
		A.setFontColor('white');
		Line.setBorderColor('white');
		self.value = 'Lite Mode';
	} else {
		Body.setBackgroundColor('white');
		Body.setFontColor('black');
		Ol.setFontColor('black');
		A.setFontColor('black');
		Line.setBorderColor('black');
		self.value = 'Dark Mode';
	}	
}