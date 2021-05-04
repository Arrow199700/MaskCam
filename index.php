<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Mask Cam - MBC</title>

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

  <h1 id="title"> MBC Mask Cam</h1>

  <section class="one">
    <div class="up">
      <div class="up-left">
        <h2>Alert</h2>
        <img src="img/immaginealertprova.jpg" >
      </div>
      <div class="up-right">
        <h2>Video</h2>
        <iframe width="100%" height="300" src="https://www.youtube.com/embed/lxLyLIL7OsU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>

    <div class="down">
      <div class="down-left">
        <h2> GIS </h2>
          <div class="mapouter">
          <div class="gmap_canvas">
              <iframe width="100%" height="300px" id="gmap_canvas" src="https://maps.google.com/maps?q=viale%20luigi%20schiavonetti&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
              <a href="https://123movies-to.org"></a>
          </div>
      </div>
      </div>
      <div class="down-right">
        <h2> Trend <button class= "btn btn-success" onclick="updateChart()">update</button> </h2>
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </section>


  <section class="two">
    <div class="kpi fade-in">
      <h1>
        <?php
          include("php/query.php");
          query('');
        ?>
      </h1>
      <p>People</p>
    </div>
    <div class="kpi fade-in">
      <h1>
        <?php
        query('WHERE label = "Mask"');
        ?>
      </h1>
      <p>Mask</p>
    </div>
    <div class="kpi fade-in">
      <h1>
        <?php
          query('WHERE label = "NoMask"');
        ?>
      </h1>
      <p>No mask</p>
    </div>
  </section>

  <div class="ref">
  <h1><?php  
    include("php/queryChart.php");
    //ARRAY FOR LABELS (Mask/NoMask) 
    queryChart("SELECT label FROM mask_cam.mask group by label", "label");

    queryChart('select *
      from(select *,
        DATE_FORMAT(time, "%H:%i") as ora_minuto
        from mask_cam.mask
        order by time desc
        limit 15) as y
      order by ora_minuto;', "ora_minuto");

    queryChart('select *
      from (select count(*) as conteggio,
        label, DATE_FORMAT(time, "%H:%i") as `ora_minuto`
        from mask_cam.mask
        where label="Mask"
        group by label, ora_minuto
        order by ora_minuto desc
        limit 15) as x
      order by ora_minuto;', "conteggio");

    queryChart('select *
      from (select count(*) as conteggio,
        label, DATE_FORMAT(time, "%H:%i") as `ora_minuto`
        from mask_cam.mask
        where label="NoMask"
        group by label, ora_minuto
        order by ora_minuto desc
        limit 15) as x
      order by ora_minuto;', "conteggio");
    ?>;
    </h1>
</div>


</body>




<script type="text/javascript" src="js/refreshKPI.js"></script>
<script type="text/javascript" src="js/chart.js"></script>

<script type="text/javascript">

setInterval(() => {
   xPrev = <?php query(''); ?>;
   yPrev = <?php query('WHERE label = "Mask"'); ?>;
   zPrev = <?php query('WHERE label = "NoMask"'); ?>; 
}, 5000);

</script>


</html>