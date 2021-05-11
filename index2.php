<?php include_once("php/queryChart.php"); ?>

<!DOCTYPE html>
<html lang="it" class="h-100">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Object Detection - MBC</title>
    <script src="js/jquery-3.6.0.js" ></script>
    <script src="js/lib_chart.js"></script>  
 
    <script src="js/functions.js"></script>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css"  rel="stylesheet" />

</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-1"><img src="img/imgregisc.png" /></div>
        <div class="col-10">
            <div class="title1 text-center">Gestione e Innovazione Sistemi di Comando e Controllo</div>
            <div class="title2 text-center">Gruppo Innovazione, Sviluppo e Sperimentazione C4-ISR</div>
        </div>
        <div class="col-1"><img src="img/imgregisc2.png" /></div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="kpi_list">
                <div class="row kpi_item">
                    <div class="col-4">Persone</div>
                    <div id="nIndividual" class="col-4">3</div>
                </div>
                <div class="row kpi_item">
                    <div class="col-4">Auto</div>
                    <div id="nCar" class="col-4">3</div>
                </div>
                <div class="row kpi_item">
                    <div class="col-4">Excavator</div>
                    <div id="nExcavator" class="col-4">3</div>
                </div>
                <div class="row kpi_item">
                    <div class="col-4">Pick-up</div>
                    <div id="nPickUp" class="col-4">3</div>
                </div>
                <div class="row kpi_item">
                    <div class="col-4">Truck</div>
                    <div id="nTruck" class="col-4">3</div>
                </div>
            </div>
            <div class="drone">

            </div>
        </div>
        <div class="col-6">
            <div class="vidoeTitle">Drone xyz - Video del 2020-09-11 15:35</div>
            <video  width="100%" height="400" controls autoplay >
            <source src="DEMO_labelled.mp4" type="video/mp4" />
            Your browser does not support HTML video.
            </video>
        </div>
        <div class="col-3">
            <div class="ctnAlert">
                <p>Alert</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-3">
            <iframe width="100%" height="200" id="gmap_canvas" src="https://maps.google.com/maps?q=viale%20luigi%20schiavonetti&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    var ArrayCountPickup = Array();
    var ArrayCountIndividual = Array();
    var ArrayCountTruck = Array();
    var ArrayCountTanker = Array();
    var ArrayCountCar = Array();

    var ArrayHourMinute = Array();
    var ArrayLabels = Array();
    var myChart = null;
    function CountItems(sLabel,target) {
        var n = -1;
        $.ajax({
            method: "POST",
            url: "php/queryFiltered.php",
            data: { label: sLabel },
            success: function(result){
                target[0].innerHTML = result;
            }
        });
    }
    function LoadArrayObjects(sLabel,ArrayTarget) {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: sLabel },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayTarget.push(element));
                console.log( sLabel + "- Values : " , ArrayTarget);
            }
        });
    }
    function LoadArrayPickup() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Pick-up" },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountPickup.push(element));
            }
        });
    }    
    function LoadArrayTanker() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Excavator" },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountTanker.push(element));
            }
        });
    }    
    function LoadArrayTruck() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Truck" },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountTruck.push(element));
            }
        });
    }    
    function LoadArrayIndividual() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Indiviual" },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountIndividual.push(element));
            }
        });
    }    
    function LoadArrayCar() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Car" },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountCar.push(element));
            }
        });
    }    
     function AggiornaGrafico()
    {
        ArrayCountPickup = Array();
        ArrayCountIndividual = Array();
        ArrayCountTruck = Array();
        ArrayCountTanker = Array();
        ArrayCountCar = Array();

        $.when(
            LoadArrayPickup(),
            LoadArrayIndividual(),
            LoadArrayCar(),
            LoadArrayTanker(),
            LoadArrayTruck()
            ).done(function(response)
        {

            myChart.data.datasets[0].data = ArrayCountPickup;
            myChart.data.datasets[1].data = ArrayCountIndividual;
            myChart.data.datasets[2].data = ArrayCountTruck;
            myChart.data.datasets[3].data = ArrayCountTanker;
            myChart.update();
        });
        console.log("Chart updated.");
    }

    function CreaGrafico()
    {
        ArrayLabels = <?php queryChart("SELECT label FROM mask_cam.mask group by label", "label") ?>;
            // Printing the passed array elements
        console.log(ArrayLabels, "Labels OK");

        //ARRAY FOR HOURMINUTE (H/M) ASSE X
        ArrayHourMinute = <?php queryChart('select *
        from(select *,
            DATE_FORMAT(Istante, "%H:%i") as ora_minuto
            from mask_cam.mask
            order by Istante desc
        limit 30) as y
        order by ora_minuto;', "ora_minuto");
        ?>;
        console.log(ArrayHourMinute, "HourMinute OK");
        var ctx = document.getElementById("myChart").getContext('2d');
        console.log("Update chart");
        myChart = new Chart(ctx, {  
            type: 'line',
            data: {
                //Asse X
                labels: [ArrayHourMinute][0],
                datasets: [
                //Conteggio Pick-up
                    {
                    label: ArrayLabels[0],
                    data: [ArrayCountPickup][0],
                    backgroundColor: 'rgb(255,255,0)',
                    borderColor:'rgb(255,255,0)',
                    fill: true,
                    borderWidth: 2
                },
                //Conteggio Soldier
                {
                    label: ArrayLabels[1],
                    data: [ArrayCountIndividual][0],
                    borderColor: 'rgb(243,165,005)',
                    fill: true,
                    backgroundColor:'rgb(243,165,005)',
                    borderWidth: 2
                },
                //Conteggio Truck
                {
                    label: ArrayLabels[2],
                    data: [ArrayCountTruck][0],
                    borderColor: 'rgb(125,127,120)',
                    fill: true,
                    backgroundColor:'rgb(125,127,120)',
                    borderWidth: 2
                },
                //Conteggio Tanker
                {
                    label: ArrayLabels[3],
                    data: [ArrayCountTanker][0],
                    borderColor: 'rgb(0,0,255)',
                    fill: true,
                    backgroundColor:'rgb(0,0,255)',
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
    }
    function PopulateKPI()
    {
        CountItems("Pick-up", $("#nPickUp"));
        CountItems("Car", $("#nCar"));
        CountItems("Excavator", $("#nExcavator"));
        CountItems("Indiviual", $("#nIndividual"));
        CountItems("Truck", $("#nTruck"));

    }
    function popolaDB()
    {
        $.ajax({
            url: 'php/popolauto.php',
            type: 'GET',
            success: function(result){

            },

            error: function (xhr, ajaxOptions, thrownError) {

        }

        });
    }

$(document).ready(function(){


    PopulateKPI();
    $.when(
    LoadArrayPickup(),
    LoadArrayIndividual(),
    LoadArrayCar(),
    LoadArrayTanker(),
    LoadArrayTruck()
    ).done(function(response)
    {
        CreaGrafico();
    });

    // $.when(LoadArrayObjects("Pick-up",this.ArrayCountPickup) , 
    //         LoadArrayObjects("Indiviual",this.ArrayCountIndividual),
    //         LoadArrayObjects("Truck",this.ArrayCountTruck),
    //         LoadArrayObjects("Excavator",this.ArrayCountTanker)
    //     ).done(function(response)
    //     {
    //         CreaGrafico();
    //     });
    setInterval(AggiornaGrafico, 1000);
    setInterval(popolaDB,  1000);
});

</script>