 <?php
$monitoringStations = ['188', '203', '206', '209', '213', '215', '228', '270', '271', '375', '395', '452', '447', '459', '463', '500', '501'];
$years = ['2015', '2016', '2017', '2018', '2019'];

function getMonthlyData($month, $year, $handle){
    //https://stackoverflow.com/questions/1835177/how-to-use-xmlreader-in-php
    $xml = new XMLReader;
    $xml->open($handle);
    $validData = False;
    while ($xml->read()) {
        //If xml element is a record
        if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'rec') {
            //store timestamp
            $recTS = $xml->getAttribute('ts');
            //if value occurs within the target timeframe
            if (date("Y", $recTS) == $year) {
                if (date("H:i", $recTS) == "08:00") {
                    //year and station can be added to list of entries
                    $validData = True;
                    break;
                }
            }
        }
    }
    return $validData;
}

function getYearlyData($station, $year, $handle){
    $number = $i ?? 0;
    echo "hello";
    $yearData = '';
    $length = 2;
    //get month in correct digit format
    $string = substr(str_repeat(0, $length).$number, - $length);
    if (getMonthlyData($string, $year, $handle) == True) {
        $tag = $station . " - " . $year;
        addYearToSelect($tag);
    }
}

function addYearToSelect($select){
    echo "<option>" . $select . "</option>";
}

function main() {
    //get global variables
    global $monitoringStations;
    global $years;
    //generate html page
    echo "<html>
            <body>
                <form id=\"form\" method=\"POST\" action=\"data.php\" onsubmit=\"return submitForm();\">
                Select a monitoring station:
                <select name=\"scatter\" id \"scatter\">";
    //generate option tags for selection
    foreach($monitoringStations as $stn) {
        $fileHandle = "../data-" . $stn . ".xml";
        foreach($years as $yr) {
            getYearlyData($stn, $yr, $fileHandle);
        }
    }
    echo "</select>
          </br><button type=\"submit\">Submit</button>
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