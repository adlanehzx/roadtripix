function openModal(imageUrl, description) {
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const modalDesc = document.getElementById("modalDescription");

  modalImg.src = imageUrl;
  modalDesc.textContent = description;
  modal.classList.add("show");
}

function closeModal() {
  document.getElementById("imageModal").classList.remove("show");
}
