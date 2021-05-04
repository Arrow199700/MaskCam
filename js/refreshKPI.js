$( document ).ready(function() {
    //console.log( "Document is ready!" );

    //Fade in KPIs
    $(".kpi").fadeIn(2000);

    var xPrev, yPrev, zPrev;
    var  x,  y,  z;

    setInterval(function(){
        //Refresh KPIs
        $(".kpi:nth-child(1) h1").load(location.href + " .kpi:nth-child(1) h1");
        $(".kpi:nth-child(2) h1").load(location.href + " .kpi:nth-child(2) h1");
        $(".kpi:nth-child(3) h1").load(location.href + " .kpi:nth-child(3) h1");
        $(".ref").load(location.href + " .ref");


        //creo variabili per poter inserire l'alert legato al refreshing del kpi..
        x = parseInt(document.querySelector(".kpi:nth-child(1) h1").textContent, 10);
        console.log(xPrev, x);
        y = parseInt(document.querySelector(".kpi:nth-child(2) h1").textContent, 10);
        console.log(yPrev, y);
        z = parseInt(document.querySelector(".kpi:nth-child(3) h1").textContent, 10);
        console.log(zPrev, z);

        if (xPrev != x || yPrev != y || zPrev != z ){
            console.log("If sì");
            $(".up-left img").attr("src","img/alertarancione.png");
            $(".up-left").append("<p>incremento mask 6 val</p>");
            xPrev = x;
            yPrev = y;
            zPrev = z; 
        } else {
            $(".up-left img").attr("src","img/immaginealertprova.jpg");
            $(".up-left p").empty();
        }

        console.log("Updated!");

    }, 

    //Refresh every 5 seconds
    5000);
});
