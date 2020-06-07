var reg_url = "php/reg.php";

$(document).ready(function() {
    $("#register_form").on('submit', function(event) {
        event.preventDefault();
        let timerInterval
        Swal.fire({
            title: 'Регистрация в системе',
            html: 'Пожалуйста, подождите...',
            timer: 2000,
            onBeforeOpen: () => {
                Swal.showLoading();
                add_user();
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        })
    })
})



function add_user() {
    $.ajax({
        url: reg_url,
        type: "POST",
        dataType: "html",
        data: $("#register_form").serialize(),
        success: function(response) {
            switch (response) {
                case "OK":
                    {
                        Swal.fire({
                            title: 'Успешно!',
                            html: 'Для продолжения закройте это окно.',
                            icon: 'success',
                            onClose: () => {
                                window.location = 'index.html'
                            }
                        });
                        break;
                    }
                case "ERROR":
                    {
                        Swal.fire({
                            title: 'Ошибка!',
                            html: 'Произошла ошибка сервера'
                        });
                        break;
                    }
                default:
                    {
                        Swal.fire(response);
                        break;
                    }
            }
        }
    })
}