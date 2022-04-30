function characterCheck(obj){
	const allowExp = /^[ |a-zA-Z|0-9|ㄱ-ㅎ|ㅏ-ㅣ|가-힣|!@$%^*()_?:{}]*$/;
	
	if ( !allowExp.test(obj.value) ){
		alert("제목에 특수문자를 입력하실 수 없습니다.");
		obj.value = obj.value.substring( 0 , obj.value.length - 30);
	}
}