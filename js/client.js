var client_php_url = '../php/';
var myvar;

function checkUser() {
    $.ajax({
        url: client_php_url + 'check.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            if (response == 0) {
                window.location = "index.html"
            }
        }
    })
}


function add_zakaz(a, b, c, client, d = price) {
    var zakaz = { "otkuda": a, "kuda": b, "rass": c, "price": d, "client": client }
    $.ajax({
        url: client_php_url + 'add_zakaz.php',
        type: "POST",
        data: zakaz,
        dataType: "html",
        success: function(response) {
            if (response === 'OK')
                Swal.fire({
                    title: 'Заказ оформлен',
                    html: 'Водитель назначится в ближайшее время',
                    icon: 'success',
                    onClose: () => {
                        $("#curZakaz").fadeIn();
                        $("#client-action").fadeOut();
                        $("#client-zakaz").fadeOut();
                        myvar = setInterval(getCurrentZakaz, 1000);
                    }
                })
            else
                Swal.fire(response);
        }
    })
}

function get_price(a) {
    $.ajax({
        url: client_php_url + 'get_price.php',
        type: "POST",
        dataType: 'html',
        data: { "rass": (a) },
        success: function(response) {
            price = response
            $("#price-div").html('Стоимость поездки : ' + response + ' руб.')
        }
    })
}

function getCurrentZakaz() {
    $.ajax({
        url: client_php_url + 'getCurrentZakaz.php',
        type: "GET",
        dataType: 'html',
        success: function(response) {
            if (response === "OK") {
                // document.location.reload(true);
                $("#curZakaz").fadeOut();
                $("#client-action").fadeIn();
                $('#driver_action').val('История заказов');
                $('#driver_action').change();
                $("#startgmaps").val("");
                $("#endgmaps").val("");
                $("#price-div").html("");
                clearInterval(myvar);
                rass = null;
                otkuda = null;
                kuda = null;
                client = null;
            } else if (response === "NO") {
                clearInterval(myvar);
                $('#driver_action').val('История заказов');
                $('#driver_action').change();
                rass = null;
                otkuda = null;
                kuda = null;
                client = null;

                //location.reload();
            } else {
                $("#client-action").fadeOut();
                $("#client-zakaz").fadeOut();
                $("#client-history").fadeOut();
                $("#curZakaz").fadeIn();
                $("#curZakaz").html(response);
            }
        }
    })
}

function leave_otziv(i) {
    (async() => {
        const { value: text } = await Swal.fire({
            input: 'textarea',
            inputPlaceholder: 'Введите текст...',
            inputAttributes: {
                'aria-label': '...'
            },
            showCancelButton: true,
            cancelButtonText: 'Закрыть',
            confirmButtonText: 'Оставить отзыв'
        })

        if (text) {
            $.ajax({
                url: 'php/otzyv.php',
                type: "POST",
                dataType: 'html',
                data: { "text": text, "zakaz": (i) },
                success: function(response) {
                    response === "Успешно" ?
                        Swal.fire(response, 'Отзыв оставлен', 'success') :
                        Swal.fire(response, '', 'info');
                }
            })
        } else Swal.fire("Отзыв не может быть пустым");
    })()
}

function cancelZakaz(i) {
    $.ajax({
        url: client_php_url + 'cancelZakaz.php',
        type: "POST",
        dataType: 'html',
        data: { "key": (i) },
        success: function(response) {
            if (response == "OK") {
                Swal.fire("Успешно", '', 'success');
                $("#curZakaz").fadeOut();
                $("#client-action").fadeIn();
                $("#client-zakaz").fadeIn();
                $("#client-history").fadeIn();
            } else
                Swal.fire(response);
        }
    })
}

$(document).ready(function() {
    $("#curZakaz").fadeOut();
    $("#client-zakaz").fadeOut();
    $("#client-history").fadeIn();
    getCurrentZakaz();
    $("#driver_action").on('change', function() {
        $("#driver_action").val() == "Создать заказ" ? (
            $("#client-zakaz").fadeIn(),
            $("#client-history").fadeOut(),
            $("#startgmaps").val(""),
            $("#endgmaps").val(""),
            $("#price-div").html(""),
            $("#rasstgmaps").html(""),
            $("#timesgmaps").html("")
        ) : (
            $("#client-zakaz").fadeOut(),
            $("#client-history").fadeIn(),
            getZakazHistory()
        )
    })
})

function getZakazHistory() {
    $.ajax({
        url: client_php_url + 'showZakazHistory.php',
        type: "GET",
        dataType: "html",
        success: function(response) {
            $("#drivers_list").html(response);
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