<?php
$monitoringStations = ["203","215","270","452","463","500"];
$years = ["2015","2016","2017","2018","2019"];

function main() {
    //get global variables
    global $monitoringStations;
    global $years;
    //Display HTML page
    echo "<html>
            <head>
            <link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css\">
              <link rel=\"stylesheet\" href=\"/resources/demos/style.css\">
              <script src=\"https://code.jquery.com/jquery-3.6.0.js\"></script>
              <script src=\"https://code.jquery.com/ui/1.13.1/jquery-ui.js\"></script>
              <script>
              $( function() {
                $( \"#startdatepicker\" ).datepicker({ minDate: new Date(2015, 1 - 1, 1), maxDate: new Date(2019,11,31) });
                $( \"#enddatepicker\" ).datepicker({ minDate: new Date(2015, 1 - 1, 1), maxDate: new Date(2019,11,31) });
              } );
              </script>
            </head>
            <body>
                <form id=\"form\" method=\"POST\" action=\"line-data.php\" autocomplete=\"off\" onsubmit=\"return submitForm();\">
                Select a monitoring station:
                <select name=\"station\" id=\"station\">";
    //Insert monitoring stations into combobox
    foreach($monitoringStations as $stn) {
        echo "<option>" . $stn . "</option>";
    }
    echo "</select>
          <br/>
          Select a date:
          <input type=\"text/javascript\" name=\"startdatepicker\" id=\"startdatepicker\">
          </br>
          Select a pollutant:
          <select name=\"pollutant\" id=\"pollutant\">
          <option>nox</option>
          <option>no</option>
          <option>no2</option>
          <br/>
          </select>
          <button type=\"submit\">Submit</button>
          </form>
          <script>
            function submitForm() {
                localStorage.stationData = document.getElementById(\"scatter\").value;
            }
          </script>
          </body>
          </html>";
}
main();

?>