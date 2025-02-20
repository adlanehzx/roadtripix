window.openModal = function (imageUrl, description) {
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const modalDesc = document.getElementById("modalDescription");
  modalImg.src = imageUrl;
  modalDesc.textContent = description;
  modal.classList.add("show");
};

window.closeModal = function () {
  document.getElementById("imageModal").classList.remove("show");
};
