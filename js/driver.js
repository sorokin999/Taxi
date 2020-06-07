var driver_php_url = '../php/driver/';

function checkDriver() {
    $.ajax({
        url: driver_php_url + 'check.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            switch (response) {
                case "У вас нет доступа к странице водителя":
                    {
                        Swal.fire({
                            title: response,
                            html: "",
                            onClose: () => {
                                let timerInterval;
                                Swal.fire({
                                    title: 'Возврат на главную',
                                    html: 'Пожалуйста, подождите...',
                                    timer: 1000,
                                    onBeforeOpen: () => {;
                                        Swal.showLoading();
                                        window.location = "index.html";
                                    }
                                })
                            }
                        })
                        break;
                    }
                case "Заблокирован":
                    {
                        Swal.fire({
                            title: "Вы заблокированы",
                            html: "Свяжитесь с администрацией для получения информации",
                            onClose: () => {
                                let timerInterval;
                                Swal.fire({
                                    title: 'Возврат на главную',
                                    html: 'Пожалуйста, подождите...',
                                    timer: 1000,
                                    onBeforeOpen: () => {;
                                        Swal.showLoading();
                                        window.location = "index.html";
                                    }
                                })
                            }
                        })
                        break;
                    }
                case "0":
                    { window.location = "index.html"; break; }
                case "1":
                    {
                        break;
                    }

            }
        }
    })
}

function getDriver() {
    $.ajax({
        url: driver_php_url + 'getDriver.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            $("#driver_name").html(response)
            $("#zakaz_history").hide();
        }
    })
}

function getZakaz() {
    $.ajax({
        url: driver_php_url + 'getZakaz.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            $("#zakaz").html(response)
        }
    })
}

function setZakaz(i) {
    $("#driver_choice").fadeOut();
    $("#zakaz").fadeOut();
    $("#zakaz_current").fadeIn();
    $.ajax({
        url: driver_php_url + 'setZakaz.php',
        type: "POST",
        dataType: 'html',
        data: { "key": (i) },
        success: function(response) {
            $("#zakaz_current").html(response);
            getCurrentZakaz();
        }
    })
}

function completeZakaz(i, price) {
    $.ajax({
        url: driver_php_url + 'completeZakaz.php',
        type: "POST",
        dataType: 'html',
        data: { "key": (i), "price": (price) },
        success: function(response) {
            if (response == "OK") {
                Swal.fire("Успешно", '', 'success');
                $("#zakaz_current").fadeOut();
                $("#driver_choice").fadeIn();
                $("#zakaz").fadeIn();
            } else
                Swal.fire(response);
        }
    })
}

function getCurrentZakaz() {
    $.ajax({
        url: driver_php_url + 'getCurrentZakaz.php',
        type: "GET",
        dataType: 'html',
        success: function(response) {
            if (response == "0" || response == "OK") {
                $("#zakaz_current").fadeOut();
                $("#driver_choice").fadeIn();
                $("#zakaz").fadeIn();
            } else {
                $("#driver_choice").fadeOut();
                $("#zakaz").fadeOut();
                $("#zakaz_current").fadeIn();
                $("#zakaz_current").html(response);
            }
        }
    })
}

function cancelZakaz(i) {
    $.ajax({
        url: driver_php_url + 'cancelZakaz.php',
        type: "POST",
        dataType: 'html',
        data: { "key": (i) },
        success: function(response) {
            if (response == "OK") {
                Swal.fire("Успешно", '', 'success');
                $("#zakaz_current").fadeOut();
                $("#driver_choice").fadeIn();
                $("#zakaz").fadeIn();
            } else
                Swal.fire(response);
        }
    })
}

function showMyZakaz() {
    let timerInterval;
    Swal.fire({
        title: 'Загрузка списка заказов',
        html: 'Пожалуйста, подождите...',
        timer: 1000,
        onBeforeOpen: () => {
            Swal.showLoading();
            $.ajax({
                url: driver_php_url + 'showMyZakaz.php',
                type: "GET",
                dataType: "html",
                success: function(response) {
                    $("#zakaz_history").html(response);
                }
            })
        },
        onClose: () => {
            clearInterval(timerInterval);
        }
    })
}


$(document).ready(function() {
    getDriver();
    getCurrentZakaz();
    setInterval(getZakaz, 1000);
    setInterval(getCurrentZakaz, 1000);
    $("#driver_action").on("change", function() {
        switch ($("#driver_action").val()) {
            case 'Список заказов':
                {
                    $("#zakaz").fadeIn();
                    $("#zakaz_history").fadeOut();
                    break;
                }
            case 'История заказов':
                {
                    $("#zakaz").fadeOut();
                    $("#zakaz_history").fadeIn();
                    showMyZakaz();
                    break;
                }
        }

    })
})


function logOut() {
    let timerInterval
    Swal.fire({
        title: "Выход из системы",
        html: "Пожалуйста, подождите...",
        timer: 1000,
        onBeforeOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: 'php/exit.php',
                type: "GET",
                dataType: "html",
                success: function(response) {
                    window.location = response
                }
            })
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
    })
}