var admin_php_url = '../php/admin/';


function checkAdmin() {
    $.ajax({
        url: admin_php_url + 'check.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            if (response == 0) {
                window.location = "index.html"
            }
        }
    })
}



$(document).ready(function() {

    $("#new_driver_form").on('submit', function(event) {
        event.preventDefault();
        let timerInterval;
        Swal.fire({
            title: 'Добавление',
            html: 'Пожалуйста, подождите...',
            timer: 1000,
            onBeforeOpen: () => {
                Swal.showLoading();
                send_ajax_form("new_driver_form", admin_php_url + "new_driver.php")
            },
            onClose: () => {
                clearInterval(timerInterval);
            }
        })
    })
    $("#drivers_list").hide();
    show_tarif();
    $("#driver_action").on('change', function() {
        switch ($("#driver_action").val()) {
            case 'Добавить водителя':
                {
                    $("#new_driver").show();
                    $("#drivers_list").hide();
                    break;
                }
            case 'Список водителей':
                {
                    $("#new_driver").hide();
                    $("#drivers_list").show();
                    show_table(admin_php_url + 'show_drivers.php', 'drivers_table', 'водителей');
                    break;
                }
            case 'Создать заказ':
                {
                    $("#new_driver").show();
                    $("#drivers_list").hide();
                    break;
                }
            case 'Список заказов':
                {
                    $("#new_driver").hide();
                    $("#drivers_list").show();
                    show_table(admin_php_url + 'show_zakaz.php', 'drivers_table', 'заказов');
                    break;
                }
            case 'Тариф':
                {
                    $("#new_driver").show();
                    $("#drivers_list").hide();
                    show_tarif();
                    break;
                }
            case 'Прибыль':
                {
                    $("#new_driver").hide();
                    $("#drivers_list").show();
                    show_table(admin_php_url + 'show_balance.php', 'balance', 'доходов');
                    show_table(admin_php_url + 'show_dohod.php', 'dohod', 'операций');
                    break;
                }
        }
    })
    $("#new_tarif_form").on('submit', function(event) {
        event.preventDefault()
        let timerInterval
        Swal.fire({
            title: 'Изменение тарифа',
            html: 'Пожалуйста, подождите...',
            timer: 1000,
            onBeforeOpen: () => {
                Swal.showLoading()
                send_ajax_form("new_tarif_form", admin_php_url + 'change_tarif.php')
            },
            onClose: () => {
                clearInterval(timerInterval)
            }
        })
    })
    $("#cash").on('click', function(event) {
        event.preventDefault();
        cash();
    })
})