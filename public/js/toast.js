document.querySelectorAll(".toast__close").forEach((button) => {
  button.addEventListener("click", function () {
    closeToast(this);
  });
});

function closeToast(button) {
  const toast = button.closest(".toast");
  toast.classList.remove("show");
}

setTimeout(() => {
  const toasts = document.querySelectorAll(".toast");
  toasts.forEach((toast) => {
    toast.classList.remove("show");
  });
}, 5000);
