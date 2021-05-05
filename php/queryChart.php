<?php
include ("dbconnection.php");

function queryChart($sql,$field){
    //$sql = "SELECT label FROM mask_cam.mask group by label";

    if ($result = $GLOBALS["link"] -> query($sql)) {
        //echo "Returned rows are: " . $result -> num_rows . "<br>";

        //create array
        $Array = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              //echo "label: ". $row["label"] . "<br>";
              $Array[] = $row[$field];
            }
          } else {
            echo "0 results";
          }
          echo json_encode($Array);
          //return $Array;
        // Free result set
        $result -> free_result();
      }
      
}

//queryChart();

?>



<script type="text/javascript">
//SEND TO JAVASCRIPT

//ARRAY FOR LABELS (Mask/NoMask)
var ArrayLabels = 
    <?php queryChart("SELECT label FROM mask_cam.mask group by label", "label") ?>;
    // Printing the passed array elements
console.log(ArrayLabels, "Labels OK");

//ARRAY FOR HOURMINUTE (H/M) ASSE X
var ArrayHourMinute =
  <?php queryChart('select *
from(select *,
    DATE_FORMAT(Istante, "%H:%i") as ora_minuto
    from mask_cam.mask
    order by Istante desc
  limit 15) as y
  order by ora_minuto;', "ora_minuto");
  ?>;
console.log(ArrayHourMinute, "HourMinute OK");

//ARRAY FOR CountMask / ASSE Y
var ArrayCountPickup =
  <?php queryChart('select *
from (select count(*) as conteggio,
	  label,
      DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
  from mask_cam.mask
  where label="Pick-up"
  group by label, ora_minuto
  order by ora_minuto desc
  limit 15) as x
  order by ora_minuto;', "conteggio");
  ?>;
console.log(ArrayCountPickup, "Conteggio Pick-up OK");


//ARRAY FOR CountNoMask / ASSE Y
var ArrayCountSoldier =
  <?php queryChart('select *
from (select count(*) as conteggio,
	  label,
      DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
  from mask_cam.mask
  where label="Soldier"
  group by label, ora_minuto
  order by ora_minuto desc
  limit 15) as x
  order by ora_minuto;', "conteggio");
  ?>;
console.log(ArrayCountSoldier, "Conteggio Soldier OK");

//ARRAY FOR Pick-up / ASSE Y
var ArrayCountTruck =
  <?php queryChart('select *
from (select count(*) as conteggio,
	  label,
      DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
  from mask_cam.mask
  where label="Truck"
  group by label, ora_minuto
  order by ora_minuto desc
  limit 15) as x
  order by ora_minuto;', "conteggio");
  ?>;
console.log(ArrayCountTruck, "Conteggio Truck OK");

//ARRAY FOR Tanker / ASSE Y
var ArrayCountTanker =
  <?php queryChart('select *
from (select count(*) as conteggio,
	  label,
      DATE_FORMAT(Istante, "%H:%i") as `ora_minuto`
  from mask_cam.mask
  where label="Tanker"
  group by label, ora_minuto
  order by ora_minuto desc
  limit 15) as x
  order by ora_minuto;', "conteggio");
  ?>;
console.log(ArrayCountTanker, "conteggio Tanker OK");


</script>

