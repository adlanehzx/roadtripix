document.addEventListener("DOMContentLoaded", () => {
  const dropzone = document.getElementById("dropzone");
  const fileInput = document.getElementById("fileInput");

  dropzone.addEventListener("click", () => fileInput.click());

  dropzone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropzone.classList.add("dropzone--dragging");
  });

  dropzone.addEventListener("dragleave", () => {
    dropzone.classList.remove("dropzone--dragging");
  });

  dropzone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropzone.classList.remove("dropzone--dragging");

    const files = e.dataTransfer.files;
    if (files.length > 0) {
      handleFiles(files);
    }
  });

  fileInput.addEventListener("change", (e) => {
    handleFiles(e.target.files);
  });

  function handleFiles(files) {
    alert(`Fichier sélectionné : ${files[0].name}`);
  }
});
