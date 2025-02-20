window.openModal = function (imageUrl, description, imageId, groupId) {
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const modalDesc = document.getElementById("modalDescription");
  const deleteImageBtn = document.getElementById("deleteImageBtn");

  modalImg.src = imageUrl;
  modalDesc.textContent = description;

  modal.classList.add("show");

  deleteImageBtn.href = `/images/${groupId}/delete/${imageId}`;
};

window.closeModal = function () {
  document.getElementById("imageModal").classList.remove("show");
};
