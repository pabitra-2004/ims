import Swal from "sweetalert2";

document.addEventListener("livewire:init", () => {
    Livewire.on("toast:fire", ({ type, message }) => {
        // console.log(type, message);

        Swal.fire({
            icon: type,
            title: message,
            position: "bottom",
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
        });
    });
});
