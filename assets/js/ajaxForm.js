$(function () {
    $(".ajaxForm").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        $(".sweet-overlay, .sweet-alert").remove();
        let loading = Swal.fire({
            heightAuto: false,
            allowEscapeKey: false,
            allowOutsideClick: false,
            onOpen: () => {
                swal.showLoading();
            }
        });
        $.ajax({
            type: form.attr("method"),
            url: form.attr("action"),
            data: form.serialize(),
            success: function (response) {
                loading.close();
                Swal.fire({
                    icon: response.success ? "success" : "error",
                    title: response.title,
                    text: response.message,
                    heightAuto: false
                }).then(function () {
                    if (response.success && form.data("redirect") !== undefined) {
                        window.location.href = form.data("redirect");
                    }
                });
            }
        });
    });
});