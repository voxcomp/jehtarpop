function setProgressStyles() {
	const styleElement = document.createElement('style');
	
	styleElement.innerHTML = `
	`;

	document.head.appendChild(styleElement);
}

function showProgressGraphic() {
	let element = document.getElementById('donations-progress-graphic')
	$("#donations-progress-graphic").load("https://regstaging.gwgci.org/donation/progress");
}

window.addEventListener("DOMContentLoaded", function () {
	// setProgressStyles(); 
	showProgressGraphic();
});