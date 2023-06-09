

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
    }
});
//endregion
const arr =
  [
      ["Количество проданных", 'pass'],
      ['Отношение за сутки', 'pass_div'],
      ['Квадрат', 'pass_sqrt'],
      ['Разница за сутки', 'pass_def'],
      ['Пассажиры', 'pass_seasons'],
  ]

let charts; // глобальная переменная для хранения данных графика


//region Подгрузка рейсов по аэропортам
$('select.airports').on('change', function (e) {
    let from = $('select[name="from"]').val();
    let to = $('select[name="to"]').val();
    if(from.length > 0 && to.length > 0 && from !== to)
    {
        $.ajax({
            method: "POST",
            url: 'http://localhost/leaders2023/api/search_flight',
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

//region Подгрузка доступных классов
$('select[name="flight"]').on('change', function (e) {
        let flight = $('select[name="flight"]').val();
        console.log($(this).attr('data-equip'))
        let method = 'search_class';
        let block = 'class';
        if($(this).attr('data-equip') == "1")
        {
            method = 'search_equip';
            block = 'equip';
        }
        console.log(method)
      $.ajax({
            method: "POST",
            url: 'http://localhost/leaders2023/api/'+method,
            data: {flight: flight},
            accept: "application/json",
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('select[name="'+block+'"]').empty().attr('disabled', true);
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
                    $('select[name="'+block+'"]').append('<option></option>')
                    $.each(flights, function (key, value) {
                        $('select[name="'+block+'"]').append('<option value'+value+'>'+value+'</option>');
                    })
                    $('select[name="'+block+'"]').attr('disabled', false);
                }catch (e)
                {
                    alert('No data!');
                    return;
                }
            });
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
        error: function(msg) {
            console.log(msg)
        }
    })
        .done(function( msg ) {
            console.log(msg + url)
            try
            {
                charts = JSON.parse(msg);
                console.log(charts)
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
            let dataset = [];
            const arr =
              [
                  ["Количество проданных", 'pass'],
                  ['Отношение за сутки', 'pass_div'],
                  ['Квадрат', 'pass_sqrt'],
                  ['Разница за сутки', 'pass_def'],
                  ['Пассажиры', 'pass_seasons'],
                ['Бизнес>', 'predict'],
                ['Эконом', 'predict_y']
              ]

            let j = 0;
            for(let i = 0; i < arr.length; i++)
            {
                if(charts[arr[i][1]])
                {
                    console.log(charts[arr[i][1]]);
                    dataset.push({
                        label: arr[i][0],
                        data: charts[arr[i][1]]
                    })
                }
            }
            if(charts['segments'])
            {
                for(let i = 0; i < charts['segments'].length; i++)
                {
                    let data = [...Array(j).fill(0), ...charts['segments'][i], ...Array(charts['count']-j-charts['segments'][i].length).fill(0)];
                    j = j+charts['segments'][i].length;
                    dataset.push({
                        type: 'bar',
                        label: i,
                        data: data,
                        barPercentage: 1.0,
                        barThickness: 2,
                        // xAxisID: 'x-axis-2',
                    })
                }


            }
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
    console.log()
    if(chart.config.data.datasets[0].label == 'Количество проданных')
    {
        for(let i = 0; i < arr.length; i++)
        {
            if(charts[arr[i][1]])
            {

                chart.config.data.datasets[i].data = charts[arr[i][1]].slice(deep);
            }
        }
    } else if(chart.config.data.datasets[0].label == 'Прогноз')
    {
        chart.config.data.datasets[0].data = charts['predict'].slice(deep);
    }

    chart.update();
}
//endregion
