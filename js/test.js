var rass,
    otkuda,
    kuda,
    client;

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
        }
    });
})

$("#btn-add-zakaz").on('click', function(event) {
    event.preventDefault()
    get_price(rass);
    let timerInterval;
    Swal.fire({
        title: 'Оформляем заказ',
        html: 'Пожалуйста, подождите',
        timer: 2000,
        onBeforeOpen: () => {
            Swal.showLoading()
            client = $("#client").val()
        },
        onClose: () => {
            clearInterval(timerInterval)
            add_zakaz(otkuda, kuda, rass, client)
        }
    });
})