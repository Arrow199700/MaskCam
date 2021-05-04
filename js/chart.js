var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {  
    type: 'line',
        data: {
        fill: true,
        //Asse X
        labels: [ArrayHourMinute][0],
        datasets: [
        //Conteggio Mask
            {
            label: ArrayLabels[0],
            data: [ArrayCountMask][0],
            borderColor: [
                'rgb(53, 206, 141)'
            ],
            fill: true,
            backgroundColor:'rgba(53, 206, 141, 0.3)',
            borderWidth: 2
        },
        //Conteggio NoMask
        {
            label: ArrayLabels[1],
            data: [ArrayCountNoMask][0],
            borderColor: [
                'rgb(221, 64, 58)'
            ],
            fill: true,
            backgroundColor:'rgba(221, 64, 58, 0.3)',
            borderWidth: 2
        }
    ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
/*
function updateChart() {

    myChart.data.datasets[0].data = [1, 2, 3, 4, 45];
    myChart.data.datasets[1].data = [ArrayCountNoMask][0];

    myChart.update();

};
*/



setInterval(function(){ 
    myChart.data.datasets[0].data = [ArrayCountMask][0];
    myChart.data.datasets[1].data = [ArrayCountNoMask][0];

   myChart.update();
    console.log("Chart updated.");
}, 10000);

