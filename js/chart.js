var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {  
    type: 'line',
        data: {
        fill: true,
        //Asse X
        labels: [ArrayHourMinute][0],
        datasets: [
        //Conteggio Pick-up
            {
            label: ArrayLabels[0],
            data: [ArrayCountPickup][0],
            borderColor: [
                'rgb(232, 197, 71)'
            ],
            fill: true,
            backgroundColor:'rgba(232, 197, 71, 0.3)',
            borderWidth: 2
        },
        //Conteggio Soldier
        {
            label: ArrayLabels[1],
            data: [ArrayCountSoldier][0],
            borderColor: [
                'rgb(248, 244, 249)'
            ],
            fill: true,
            backgroundColor:'rgba(248, 244, 249, 0.3)',
            borderWidth: 2
        },
        //Conteggio Tru
        {
            label: ArrayLabels[2],
            data: [ArrayCountTruck][0],
            borderColor: [
                'rgb(190, 167, 229)'
            ],
            fill: true,
            backgroundColor:'rgba(190, 167, 229, 0.3)',
            borderWidth: 2
        },
        //Conteggio Tanker
        {
            label: ArrayLabels[3],
            data: [ArrayCountTanker][0],
            borderColor: [
                'rgb(214, 73, 51)'
            ],
            fill: true,
            backgroundColor:'rgba(214, 73, 51, 0.3)',
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


setInterval(function(){ 
    myChart.data.labels = JSON.parse($("#p1")[0].innerHTML);


    myChart.data.datasets[0].data = JSON.parse($("#p2")[0].innerHTML);
    myChart.data.datasets[1].data = JSON.parse($("#p3")[0].innerHTML);
    myChart.data.datasets[2].data = JSON.parse($("#p4")[0].innerHTML);
    myChart.data.datasets[3].data = JSON.parse($("#p5")[0].innerHTML);
    myChart.update();
    
    console.log("Chart updated.");
}, 11000);

