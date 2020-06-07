var price;

function table_sort(table) {
    $("#" + table).tablesorter()
}

function send_ajax_form(ajax_form, url) {
    $.ajax({
        url: url,
        type: "POST",
        dataType: "html",
        data: $("#" + ajax_form).serialize(),
        success: function(response) {
            response = JSON.parse(response);
            switch (response['status']) {
                case 'Успешно':
                    {
                        Swal.fire(response['status'], response['text'], 'success');
                        show_tarif()
                        break;
                    }
                case 'Ошибка':
                    {
                        Swal.fire(response['status'], response['text'], 'error');
                        break;
                    }
                default:
                    {
                        Swal.fire(response['status'], response['text'], 'info');
                        break;
                    }
            }
        }
    })
}


function show_table(url, where, who) {
    let timerInterval
    Swal.fire({
        title: "Загрузка списка " + who,
        html: "Пожалуйста, подождите",
        timer: 1500,
        onBeforeOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: url,
                type: "GET",
                dataType: "html",
                success: function(response) {
                    $("#" + where).html(response);
                    table_sort(where)
                }
            })
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
    })

}

function deleteDriver(i) {
    $.ajax({
        url: admin_php_url + 'delete_driver.php',
        type: "POST",
        dataType: 'html',
        data: { "key": (i) },
        success: function(response) {
            if (response === 'Успешно')
                Swal.fire({
                    title: response,
                    html: 'Водитель удален',
                    icon: 'success',
                    onClose: () => {
                        show_table(admin_php_url + 'show_drivers.php', 'drivers_table', 'водителей');
                    }
                });
            else
                Swal.fire(response);
        }
    })
}

function changeDriverStatus(i) {
    $.ajax({
        url: admin_php_url + 'change_driver_status.php',
        type: "POST",
        dataType: 'html',
        data: { "key": (i) },
        success: function(response) {
            if (response === 'Успешно')
                Swal.fire({
                    title: response,
                    html: 'Статус водителя изменен',
                    icon: 'success',
                    onClose: () => {
                        show_table(admin_php_url + 'show_drivers.php', 'drivers_table', 'водителей');
                    }
                });
            else
                Swal.fire(response);

        }

    })
}


function get_price(a) {
    $.ajax({
        url: 'php/get_price.php',
        type: "POST",
        dataType: 'html',
        data: { "rass": (a) },
        success: function(response) {
            price = response
            $("#price-div").html('Стоимость поездки : ' + response + ' руб.')
        }
    })
}

function changeZakaz(i) {
    let timerInterval
    Swal.fire({
        title: 'Изменение статуса заказа',
        html: 'Пожалуйста, подождите...',
        timer: 500,
        onBeforeOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: admin_php_url + 'change_zakaz.php',
                type: "POST",
                data: { "key": (i) },
                dataType: 'html',
                success: function(response) {
                    if (response === "OK")
                        Swal.fire({
                            title: 'Успешно',
                            html: 'Статус заказа изменен',
                            icon: 'success',
                            onClose: () => {
                                show_table(admin_php_url + 'show_zakaz.php', 'drivers_table', 'заказов');
                            }
                        })
                    else
                        Swal.fire('', response, 'info')
                }
            })
        },
        onClose: () => {
            clearInterval(timerInterval)
        }
    })
}

function deleteZakaz(i) {
    let timerInterval
    Swal.fire({
        title: 'Удаление заказа',
        html: 'Пожалуйста, подождите...',
        timer: 1500,
        onBeforeOpen: () => {
            Swal.showLoading()
            $.ajax({
                url: admin_php_url + 'delete_zakaz.php',
                type: "POST",
                data: { "key": (i) },
                dataType: 'html',
                success: function(response) {
                    if (response === "OK")
                        Swal.fire({
                            title: 'Успешно',
                            html: 'Заказ удален',
                            icon: 'success',
                            onClose: () => {
                                show_table(admin_php_url + 'show_zakaz.php', 'drivers_table', 'заказов');
                            }
                        })
                    else
                        Swal.fire('', response, 'info')
                }
            })
        },
        onClose: () => {
            clearInterval(timerInterval)

        }
    })
}

function add_zakaz(a, b, c, client, d = price) {
    var zakaz = { "otkuda": a, "kuda": b, "rass": c, "price": d, "client": client }
    $.ajax({
        url: admin_php_url + 'add_zakaz.php',
        type: "POST",
        data: zakaz,
        dataType: "html",
        success: function(response) {
            if (response === 'OK')
                Swal.fire('Заказ оформлен', 'Водитель назначится в ближайшее время', 'success');
            else
                Swal.fire(response);
        }
    })
}

function isEnter() {
    $.ajax({
        url: 'php/isEnter.php',
        type: "GET",
        dataType: 'html',
        success: function(response) {

        }
    })
}

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

function show_tarif() {
    $.ajax({
        url: admin_php_url + 'show_tarif.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            $("#tarif").html(response)
        }
    })
}

function payDriver(i) {
    $.ajax({
        url: admin_php_url + 'pay_driver.php',
        type: "POST",
        dataType: "html",
        data: { "key": (i) },
        success: function(response) {
            (response == 1) ? (
                Swal.fire('Успешно', 'Налог уплачен', 'success'),
                show_table(admin_php_url + 'show_drivers.php', 'drivers_table', 'водителей')
            ) : (
                Swal.fire(response)
            )
        }
    })
}

function cash() {
    (async() => {
        const { value: text } = await Swal.fire({
            input: 'text',
            inputPlaceholder: 'Введите сумму',
            showCancelButton: true,
            cancelButtonText: "Закрыть",
            confirmButtonText: "Снять деньги"
        })
        if (text) {
            $.ajax({
                url: admin_php_url + 'cash.php',
                type: "POST",
                dataType: 'html',
                data: { 'sum': text },
                success: function(response) {
                    (response == 1) ? (
                        Swal.fire('Успешно', 'Деньги сняты', 'success'),
                        show_table(admin_php_url + 'show_dohod.php', 'dohod', 'операций'),
                        show_table(admin_php_url + 'show_balance.php', 'balance', 'доходов')
                    ) : (
                        Swal.fire(response)
                    )
                }
            })
        }
    })()
}