
//region Инициализавция графика
const ctx = document.getElementById('myChart');
let labels = [];
let pass = [];
let chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Data',
            data: pass,
            borderWidth: 1
        }]
    },
    options: {
        // elements: {
        //     point: {
        //         radius : 0
        //     }
        // }
    }
});
//endregion


let charts; // глобальная переменная для хранения данных графика


//region Подгрузка рейсов по аэропортам
$('select.airports').on('change', function (e) {
    let from = $('select[name="from"]').val();
    let to = $('select[name="to"]').val();
    if(from.length > 0 && to.length > 0 && from !== to)
    {
        $.ajax({
            method: "POST",
            url: 'http://localhost/hackathon/api/search_flight',
            data: {to: to, from: from},
            accept: "application/json",
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('select[name="flight"]').empty().attr('disabled', true);
                $('#loader').removeClass('hidden')
            },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader').addClass('hidden')
            },
        })
            .done(function( msg ) {
                console.log(msg)
                try
                {
                    let flights = JSON.parse(msg);
                    $.each(flights, function (key, value) {
                        $('select[name="flight"]').append('<option value'+value+'>'+value+'</option>');
                    })
                    $('select[name="flight"]').attr('disabled', false);
                }catch (e)
                {
                    alert('No data!');
                    return;
                }
            });
    }
})
//endregion


//region Скроллинг графиков
$('.scroll input').on('change', function () {

    let deep = charts['count'] - $(this).val();
    updateChart(charts, deep);
    $('#range').text( $(this).val());
})
//endregion


//region Обработчик форм и функция обновления графика
$('form#demand').on("submit", function (e){
    let url = $(this).attr('action');
   e.preventDefault();
    $.ajax({
        method: "POST",
        url: url,
        data: $(this).serialize(),
        accept: "application/json",
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            $('#loader').removeClass('hidden')
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            $('#loader').addClass('hidden')
        },
    })
        .done(function( msg ) {
            console.log(msg + url)
            try
            {
                charts = JSON.parse(msg);
            }catch (e)
            {
                alert('No data!');
                return;
            }
            if(charts.length == 0)
            {
                alert('No data!');
                return;
            }
            // updateChart(charts['pass'], charts['dates'], charts['label']);
            // charts['pass_div'][charts['count']-1] = 0
            let dataset = [
                {
                    label: "Стандарт",
                    data: charts['pass']
                },
                {
                label: 'Деление',
                data: charts['pass_div']
            },
                {
               label: 'Квадрат',
               data: charts['pass_sqrt']
            },{
               label: 'Разница',
               data: charts['pass_def']
            }];
            console.log(dataset)
            chart.config.data.labels = charts['dates'];
            chart.config.data.datasets = dataset;
            chart.update();

            $('.scroll input').attr('max', charts['count']).val(charts['count'])
            $('#range').text(charts['count']);

            // alert( "Data Saved: " + msg );
        });
});
function updateChart(data, deep)
{
    chart.config.data.labels = charts['dates'].slice(deep);
    chart.config.data.datasets[0].data = charts['pass'].slice(deep);
    chart.config.data.datasets[1].data = charts['pass_div'].slice(deep);
    chart.config.data.datasets[2].data = charts['pass_sqrt'].slice(deep);
    chart.config.data.datasets[3].data = charts['pass_def'].slice(deep);
    chart.update();
}
//endregion
