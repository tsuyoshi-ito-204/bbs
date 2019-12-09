function change(button,flag){
	if(flag){
		button.parentElement.style.display = 'none';
		button.parentElement.nextElementSibling.style.display = 'block';
	}else{
		const ancestor = button.parentElement.parentElement;
		ancestor.previousElementSibling.style.display = 'block';
		ancestor.style.display = 'none';
	}
}