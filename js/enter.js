var enter_script = "php/enter.php";

$(document).ready(function() {
    $("#enter_form").on('submit', function(event) {
        event.preventDefault();
        let timerInterval
        Swal.fire({
            title: 'Вход в систему',
            html: 'Пожалуйста, подождите...',
            timer: 2000,
            onBeforeOpen: () => {
                Swal.showLoading();
                enter();
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        })
    })
})



function enter() {
    $.ajax({
        url: enter_script,
        type: "POST",
        dataType: "html",
        data: $("#enter_form").serialize(),
        success: function(response) {
            switch (response) {
                case "Проверьте введенные данные":
                    {
                        Swal.fire('Что-то не так.', response);
                        break;
                    }
                case "Пользователя не существует":
                    {
                        Swal.fire('Ошибка', response);
                        break;
                    }
                case "Пароль неверный":
                    {
                        Swal.fire('Критическая ошибка', response);
                        break;
                    }
                default:
                    {
                        window.location = response;
                    }
            }
        }
    })
}