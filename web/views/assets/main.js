// const app = Vue.createApp({...})
const ctx = document.getElementById('myChart');
let labels = [];
let pass = [];
let chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: '# of Votes',
            data: pass,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});


let charts;

console.log($('.scroll input'))
$('.scroll input').on('change', function () {
    updateChart(charts['pass'].slice($(this).val()), charts['dates'].slice($(this).val()))
    $('#range').text($(this).val());
})
$('form#demand').on("submit", function (e){
    console.log('s');
   e.preventDefault();
    $.ajax({
        method: "POST",
        url: "https://imdibil.ru/hackathon/api/demand",
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
            charts = JSON.parse(msg);
            console.log(charts)
            updateChart(charts['pass'], charts['dates'], charts['label']);
            $('.scroll input').attr('max', charts['count']).val(charts['count'])
            // alert( "Data Saved: " + msg );
        });
});
function updateChart(data, labels, label = null)
{
    chart.config.data.datasets[0].data = data;
    if(label != null)
    {
        chart.config.data.datasets[0].lablel = label;
    }
    chart.config.data.labels = labels;
    chart.update();
}
//
// app.component('chart', {
//     template:
//         "<canvas id=\"myChart\"></canvas>",
//     data: {
//
//     }
// })