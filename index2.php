<?php include_once("php/queryChart.php"); ?>
<?php
    $color1 = "#548235";
    $color2 = "#2F5597";
    $color3 = "#FF0000";
    $color4 = "#D60093";
    $color5 = "#FFFF00";

?>
<!DOCTYPE html>
<html lang="it" class="h-100">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Object Detection - MBC</title>
    <script src="js/jquery-3.6.0.js" ></script>
    <script src="js/lib_chart.js"></script>  
 
     <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css"  rel="stylesheet" />

</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-1"><img src="img/imgregisc.png" /></div>
        <div class="col-10">
            <div class="title1 text-center">Gestione e Innovazione Sistemi di Comando e Controllo - Gruppo Innovazione, Sviluppo e Sperimentazione C4-ISR</div>
            <div class="title2 text-center">Sistema Advanced Recognition and Exploitation System</div>
        </div>
        <div class="col-1"><img src="img/imgregisc2.png" /></div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="kpi_list">
                <div class="row kpi_item" style="color: <?php echo $color1 ?> !important;">
                    <div class="col-6 kpi_label">Individual</div>
                    <div id="nIndividual" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color2 ?> !important;">
                    <div class="col-6 kpi_label">Car</div>
                    <div id="nCar" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color3 ?> !important;">
                    <div class="col-6 kpi_label">Excavator</div>
                    <div id="nExcavator" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color4 ?> !important;">
                    <div class="col-6 kpi_label">Pick-Up</div>
                    <div id="nPickUp" class="col-6 kpi_value"></div>
                </div>
                <div class="row kpi_item" style="color: <?php echo $color5 ?> !important;">
                    <div class="col-6 kpi_label">Truck</div>
                    <div id="nTruck" class="col-6 kpi_value"></div>
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
    var ArrayCountExcavator = Array();
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
    function LoadArrayExcavator() {
        return $.ajax({
            method: "POST",
            url: "php/queryChartParams.php",
            data: { label: "Excavator" },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayCountExcavator.push(element));
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
        ArrayCountExcavator = Array();
        ArrayCountCar = Array();

        $.when(
            LoadArrayPickup(),
            LoadArrayIndividual(),
            LoadArrayCar(),
            LoadArrayExcavator(),
            LoadArrayTruck(),
            LoadArrayAsseX()
            ).done(function(response)
        {

            myChart.data.datasets[0].data = ArrayCountIndividual;
            myChart.data.datasets[1].data = ArrayCountCar;
            myChart.data.datasets[2].data = ArrayCountExcavator;
            myChart.data.datasets[3].data = ArrayCountPickup;
            myChart.data.datasets[4].data = ArrayCountPickup;
            myChart.data.labels = ArrayHourMinute;
            ArrayCountTruck
            myChart.update();
        });
        console.log("Chart updated.");
    }

    function LoadArrayAsseX() {
        ArrayHourMinute = Array();
        var sql = 'select * from(select *, DATE_FORMAT(Istante, "%H:%i") as ora_minuto from mask_cam.mask order by convert(Istante,DATETIME) desc ) as y order by convert(Istante,DATETIME) DESC LIMIT 30;';
        var field = 'ora_minuto';
        return $.ajax({
            method: "POST",
            url: "php/queryChart.php",
            data: { 
                "sql": sql,
                "field": field
             },
            success: function(result){
                var arRes = JSON.parse(result);
                arRes.forEach(element =>ArrayHourMinute.push(element));
                console.log(ArrayHourMinute, "HourMinute OK");
            }
        });
    }    
    function CreaGrafico()
    {
        ArrayLabels = ["Individual" , "Car", "Excavator" , "Pick-Up" , "Truck"];
            // Printing the passed array elements
        console.log(ArrayLabels, "Labels OK");

        var ctx = document.getElementById("myChart").getContext('2d');
        console.log("Update chart");
        myChart = new Chart(ctx, {  
            type: 'line',
            plugins: {
                tooltip: {
                    mode: 'index'
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            data: {
                //Asse X
                labels: [ArrayHourMinute][0],
                datasets: [
                //Conteggio Pick-up
                    {
                    label: ArrayLabels[0],
                    data: [ArrayCountIndividual][0],
                    backgroundColor: '<?php echo $color1 ?>',
                    borderColor:'<?php echo $color1 ?>',
                    fill: true,
                    borderWidth: 2
                },
                //Conteggio Soldier
                {
                    label: ArrayLabels[1],
                    data: [ArrayCountCar][0],
                    borderColor: '<?php echo $color2 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $color2 ?>',
                    borderWidth: 2
                },
                //Conteggio Truck
                {
                    label: ArrayLabels[2],
                    data: [ArrayCountExcavator][0],
                    borderColor: '<?php echo $color3 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $color3 ?>',
                    borderWidth: 2
                },
                //Conteggio Tanker
                {
                    label: ArrayLabels[3],
                    data: [ArrayCountPickup][0],
                    borderColor: '<?php echo $color4 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $color4 ?>',
                    borderWidth: 2
                },
                //Conteggio Truck
                {
                    label: ArrayLabels[4],
                    data: [ArrayCountTruck][0],
                    borderColor: '<?php echo $color5 ?>',
                    fill: true,
                    backgroundColor:'<?php echo $color5 ?>',
                    borderWidth: 2
                }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: true
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
    LoadArrayExcavator(),
    LoadArrayTruck(),
    LoadArrayAsseX()
    ).done(function(response)
    {
        CreaGrafico();
    });

    // $.when(LoadArrayObjects("Pick-up",this.ArrayCountPickup) , 
    //         LoadArrayObjects("Indiviual",this.ArrayCountIndividual),
    //         LoadArrayObjects("Truck",this.ArrayCountTruck),
    //         LoadArrayObjects("Excavator",this.ArrayCountExcavator)
    //     ).done(function(response)
    //     {
    //         CreaGrafico();
    //     });
    setInterval(AggiornaGrafico, 1000);
    setInterval(PopulateKPI, 1000);
    setInterval(popolaDB,  1000);
});

</script>