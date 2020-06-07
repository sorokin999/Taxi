var driver_php_url = '../php/driver/';

function checkDriver() {
    $.ajax({
        url: driver_php_url + 'check.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            if (response == 0) {
                window.location = "index.html"
            }
        }
    })
}

function showNalog() {
    let timerInterval;
    Swal.fire({
        title: 'Загрузка информации о финансах',
        html: 'Пожалуйста, подождите...',
        timer: 1000,
        onBeforeOpen: () => {
            Swal.showLoading();
            $.ajax({
                url: driver_php_url + 'showMyNalog.php',
                type: "GET",
                dataType: "html",
                success: function(response) {
                    $("#nalog").html(response);
                }
            })
        },
        onClose: () => {
            clearInterval(timerInterval);
        }
    })
}

function payNalog() {
    Swal.fire({
        title: "Чтобы оплатить налог, переведите на счет организации сумму налога, либо явитесь в офис и оплатите наличными",
        html: 'Номер счета можно уточнить у оператора',
        icon: 'info',
        onClose: () => {
            Swal.fire('В случае превышения налога (более 1000 рублей) вы будете заблокированы', '', 'warning')
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
        }
    })
}

$(document).ready(function() {
    getDriver();
    showNalog();
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