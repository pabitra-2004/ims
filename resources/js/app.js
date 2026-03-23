import Swal from "sweetalert2";

document.addEventListener("livewire:init", () => {
    Livewire.on("toast-fire", ({ type, message, ...config }) => {
        Swal.fire({
            icon: type,
            title: message,
            position: "bottom-right",
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            ...config,
        });
    });

    Livewire.directive(
        "swal-confirm",
        ({ el, directive, component, cleanup }) => {
            let expression = directive.expression;

            // The "directive" object gives you access to the parsed directive.
            // For example, here are its values for: wire:click.prevent="deletePost(1)"
            //
            // directive.raw = wire:click.prevent
            // directive.value = "click"
            // directive.modifiers = ['prevent']
            // directive.expression = "deletePost(1)"

            let onClick = (e) => {
                // string to object convertion
                const { title, text, action, params, ...config } = new Function(
                    "return " + expression,
                )();
                Swal.fire({
                    title: title ?? "Are you sure?",
                    text: text,
                    icon: "warning",
                    confirmButtonText: "Yes, confirm!",
                    showCancelButton: true,
                    ...config,
                }).then((result) => {
                    if (result.isConfirmed) {
                        component.$wire.$call(action, ...params);
                    }
                });
            };

            el.addEventListener("click", onClick, { capture: true });

            // Register any cleanup code inside `cleanup()` in the case
            // where a Livewire component is removed from the DOM while
            // the page is still active.
            cleanup(() => {
                el.removeEventListener("click", onClick);
            });
        },
    );
});
