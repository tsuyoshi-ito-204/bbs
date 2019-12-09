window.onload = function(){
	var nodeary = [];
	var content = document.getElementById('content');
	var preview = document.getElementById('preview');
	var bt = document.getElementById('bt');
	
	bt.addEventListener('click',function(){
		content.textContent += '``` ```';
	});
}