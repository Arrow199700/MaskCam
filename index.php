<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Object Detection - MBC</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--<link rel="icon" href="img/icon.png">-->
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/one.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.js" integrity="sha512-opXrgVcTHsEVdBUZqTPlW9S8+99hNbaHmXtAdXXc61OUU6gOII5ku/PzZFqexHXc3hnK8IrJKHo+T7O4GRIJcw==" crossorigin="anonymous"></script>  
  </head>
  
  <body>
  
  
  <div class="up-logo">
  <img src="img/imgregisc.png">
  <h4 id="title"> Gestione e innovazione Sistemi di comando e controllo (prototipo 1) </h4>
  <img src="img/imgregisc2.png">
  </div>
  
  <section class="two">
    <div class="kpi fade-in">
      <p style="color:red;">People</p>
      <h1 style="color:red;">
        <?php
          include("php/query.php");
          query('');
        ?>
      </h1>
      
    </div>
    <div class="kpi fade-in">
    <p style="color:yellow;">Pick-up</p>
      <h1 style="color:yellow;">
        <?php
        query('WHERE label = "Pick-up"');
        ?>
      </h1>
      
    </div>
    <div class="kpi fade-in">
    <p style="color:orange;">car</p>  
      <h1 style="color:orange;">
        <?php
          query('WHERE label = "Soldier"');
        ?>
      </h1>
      
    </div>
    <div class="kpi fade-in">
    <p style="color:grey;"> Truck</p>
      <h1 style="color:grey;">
        <?php
          query('WHERE label = "Truck"');
        ?>
      </h1>
    </div>

    <div class="kpi fade-in">
    <p style="color:blue;"> Tanker</p>
      <h1 style="color:blue;">
        <?php
          query('WHERE label = "Tanker"');
        ?>
      </h1>
    </div>

    <div class="down-gis">
          <div class="mapouter">
          <div class="gmap_canvas">
              <iframe width="100%" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=viale%20luigi%20schiavonetti&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
              <a href="https://123movies-to.org"></a>
          </div>
      </div>
    </div>


  </section>
  
  <section class="one">
    
    <div class="up">
      <div class="up-left">
        <h2>Alert</h2>
      </div>
      <div class="up-right">
        <h3> VARIABLE1 </h3>
        <video  width="100%" height="400" controls="controls" src="videoprovaobj1.mp4" type="video/mp4" >
        </video>
      </div>
    </div>
      
    <div class="down">

      
      <div class="down-right">
    
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </section>

  <?php include("php/queryChart.php"); ?>

  <div class="ref">
  <p id="p0"><?php queryChart("SELECT label FROM mask_cam.mask group by label", "label");
    ?></p>

  <p id="p1"><?php
    queryChart('select *
      from(select *,
        DATE_FORMAT(Istante, "%H:%i") as ora_minuto
        from mask_cam.mask
        order by Istante desc
        limit 30) as y
      order by ora_minuto;', "ora_minuto");
      ?></p>

  <p id="p2"><?php
    queryChart('select *
      from (select count(*) as conteggio,
        label, DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
        from mask_cam.mask
        where label="Pick-up"
        group by label, ora_minuto
        order by ora_minuto desc
        limit 30) as x
      order by ora_minuto;', "conteggio");
    ?></p>

  <p id="p3"><?php
    queryChart('select *
      from (select count(*) as conteggio,
        label, DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
        from mask_cam.mask
        where label="Soldier"
        group by label, ora_minuto
        order by ora_minuto desc
        limit 30) as x
      order by ora_minuto;', "conteggio");
    ?></p>

<p id="p4"><?php
    queryChart('select *
      from (select count(*) as conteggio,
        label, DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
        from mask_cam.mask
        where label="Truck"
        group by label, ora_minuto
        order by ora_minuto desc
        limit 30) as x
      order by ora_minuto;', "conteggio");
    ?></p>
  
  <p id="p5"><?php
    queryChart('select *
      from (select count(*) as conteggio,
        label, DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
        from mask_cam.mask
        where label="Tanker"
        group by label, ora_minuto
        order by ora_minuto desc
        limit 30) as x
      order by ora_minuto;', "conteggio");
    ?></p>
</div>


</body>




<script type="text/javascript" src="js/refreshKPI.js"></script>
<script type="text/javascript" src="js/chart.js"></script>

<script type="text/javascript">

setInterval(() => {
  $.ajax({
    url: 'php/popolauto.php',
    type: 'GET',
    success: function(result){

    },

    error: function (xhr, ajaxOptions, thrownError) {

  }

  });
}, 10000);

</script>


</html>