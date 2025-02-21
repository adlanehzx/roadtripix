document.addEventListener("DOMContentLoaded", () => {
  const dropzone = document.getElementById("dropzone");
  const fileInput = document.getElementById("image_file");
  const fileNameDisplay = document.getElementById("file-name");

  dropzone.addEventListener("click", () => fileInput.click());

  dropzone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropzone.classList.add("dropzone--is-dragging");
  });

  dropzone.addEventListener("dragleave", () => {
    dropzone.classList.remove("dropzone--is-dragging");
  });

  dropzone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropzone.classList.remove("dropzone--is-dragging");

    const files = e.dataTransfer.files;
    if (files.length > 0) {
      handleFiles(files);
    }
  });

  fileInput.addEventListener("change", (e) => {
    handleFiles(e.target.files);
  });

  function handleFiles(files) {
    if (files.length > 0) {
      fileNameDisplay.textContent = `Fichier sélectionné : ${files[0].name}`;
    }
  }
});
