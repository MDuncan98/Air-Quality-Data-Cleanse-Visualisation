<?php
$station = $_POST['station'];
$startDate = $_POST['startdatepicker'];
//$endDate = $_POST['enddatepicker'];
$pollutant = $_POST['pollutant'];

function getData($handle) {
    //Retrieve global variables
    global $station;
    global $startDate;
    global $endDate;
    global $pollutant;
    $dataArr = array();
    //https://www.php.net/manual/en/book.xmlreader.php
    $xml = new XMLReader;
    $xml->open($handle);
    $startDate = strtotime($startDate); // Convert to unix timestamp
    $endDate = $startDate + 86400;
    while ($xml->read()) {
        //If xml element is a record
        if($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'rec') {
            //get timestamp
            $recTS = $xml->getAttribute('ts');
            //if timestamp is between start and end date
            if (($recTS >= $startDate) and ($recTS <= $endDate)) {
                //store the pollutant value
                $dom = $xml->expand(new DOMDocument());
                $sx = simplexml_import_dom($dom);
                $dataArr[$recTS] = (float)$sx[$pollutant];
            }
        }
    }
    //sort array based on keys (chronological order)
    ksort($dataArr);
    return $dataArr;
}

function main() {
    //Retrieve global variable
    global $startDate;
    global $station;
    global $pollutant;
    //set file handle
    $fileHandle = "../data-" . $station . ".xml";
    $dailyData = getData($fileHandle);
    echo "<html><script>";
    $largestCount = 0;
    $i = 0;
    foreach($dailyData as $entry) {
        //if value is larger than current largest
        if ($entry > $largestCount) {
            $largestCount = $entry;
        }
        //store variable in javascript localstorage
        echo "localStorage.setItem('data" . $i ."', " . $entry . ");\n";
        $i++;
    }
    //store all other data in localstorage
    echo "localStorage.setItem('counter', '" . $i . "');\n";
    echo "localStorage.setItem('station', '" . $station . "');\n";
    echo "localStorage.setItem('date', '" . $startDate . "');\n";
    echo "localStorage.setItem('bound', '" . $largestCount . "');\n";
    echo "localStorage.setItem('pollutant', '" . $pollutant . "');\n";
    echo "localStorage.setItem('type', 'line');\n";
    echo "</script></html>";
    include "chart.html";
}

main();
?>