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
$('form#demand').on("submit", function (e){
    console.log('s');
   e.preventDefault();
    $.ajax({
        method: "POST",
        url: "http://localhost/hackathon/api/demand",
        data: $(this).serialize(),
        accept: "application/json"
    })
        .done(function( msg ) {
            let charts = JSON.parse(msg);
            console.log(charts)
            chart.config.data.datasets[0].data = charts['pass'];
            chart.config.data.labels = charts['dates'];
            chart.update();
            // alert( "Data Saved: " + msg );
        });
});

//
// app.component('chart', {
//     template:
//         "<canvas id=\"myChart\"></canvas>",
//     data: {
//
//     }
// })