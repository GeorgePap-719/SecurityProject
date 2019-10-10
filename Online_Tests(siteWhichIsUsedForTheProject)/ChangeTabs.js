function change(thisTab){
	var log = document.getElementById('container');
	var sign = document.getElementById('signUp');
	var pageName = document.getElementById('page');
	
	if(thisTab.match("signUp")){
		log.style.display = "none";
		sign.style.display = "block";
		pageName.innerHTML = 'Sign Up Page';
	}
	else if(thisTab.match("container")){
		sign.style.display = "none";
		log.style.display = "block";
		pageName.innerHTML = 'Login Page';
	}
}