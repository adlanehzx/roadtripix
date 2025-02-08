// code js de la navbar

// lorsque le document est prêt : écouter le clic sur navbar__button
// au clic :
//  - si l'ul est inactive : lui donner la classe .active et changer sa height
//  - sinon : lui enlever la classe .active

document.addEventListener("DOMContentLoaded", function (event) {
	document.querySelectorAll(".navbar__button").forEach(function (elem) {
		elem.addEventListener("click", function (evt) {
			// sélectionner le parent
			// dans le parent, selectionner l'element <ul>
			const ul = elem.parentElement.querySelector("ul");
			// si cet élément n'a pas la classe active : modifier sa height pour la valeur scrollHeight
			if (!ul.classList.contains("active")) {
				ul.classList.add("active");
				ul.style.height = ul.scrollHeight + "px";
			} else {
				ul.classList.remove("active");
				ul.style.height = 0;
			}
			// sinon, lui donner une height de 0
		});
	});
});
