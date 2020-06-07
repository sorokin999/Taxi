var rass,
    otkuda,
    kuda,
    client;


var b = false;

function get_rasstoyanie() {
    rass = $("#rasstgmaps").text();
}

//$("#mapgmaps").hide();


$("#jj").on('click', function(event) {
    event.preventDefault();
    let timerInterval
    var oren = 'оренбург ';
    otkuda = $("#startgmaps").val();
    kuda = $("#endgmaps").val();
    $("#startgmaps").val(oren + otkuda);
    $("#endgmaps").val(oren + kuda);
    Swal.fire({
        title: 'Расчет стоимости',
        html: 'Пожалуйста, подождите',
        timer: 2000,
        onBeforeOpen: () => {
            Swal.showLoading()
            marshrutgmaps()
        },
        onClose: () => {
            clearInterval(timerInterval)
            get_rasstoyanie()
            get_price(rass)
            $("#startgmaps").val(otkuda)
            $("#endgmaps").val(kuda)
            b = true;
        }
    });
})

function getClient() {
    $.ajax({
        url: 'php/get_client.php',
        type: "GET",
        dataType: 'html',
        success: function(response) {
            client = response;
        }
    })
}


$("#btn-add-zakaz").on('click', function(event) {
    event.preventDefault()
    if (b) {
        get_price(rass);
        let timerInterval;
        Swal.fire({
            title: 'Оформляем заказ',
            html: 'Пожалуйста, подождите',
            timer: 2000,
            onBeforeOpen: () => {
                Swal.showLoading()
                    //get_rasstoyanie();
                    //get_price(rass);
                getClient();
            },
            onClose: () => {
                clearInterval(timerInterval)
                add_zakaz(otkuda, kuda, rass, client)
            }
        });
    } else
        Swal.fire("Сначала нужно рассчитать стоимость");
})