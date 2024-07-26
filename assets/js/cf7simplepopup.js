document.addEventListener(
    "wpcf7submit",
    function (event) {
        if (event.detail.status == "validation_failed") {
            Swal.fire({
                title: "",
                text: event.detail.apiResponse.message,
                width: 500,
                icon: "error",
                showCloseButton: true,
                timer: 5000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },

            });
        } else {
            Swal.fire({
                title: "",
                text: event.detail.apiResponse.message,
                width: 500,
                icon: "success",
                showCloseButton: true,
                timer: 5000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },

            });
        }
    },
    false
);