<?php
$date = $_POST['datepicker'];
$time = $_POST['time'];
$pollutant = $_POST['pollutant'];
$monitoringStations = ["188","203","206","209","213","215","228","270","271","375","395","447","452","463","500","501"];

function getData($handle) {
    global $date;
    global $time;
    global $pollutant;
    $value = 0;
    //Convert time to unix timestamp
    $timestamp = strtotime($date . " " . $time);
    //https://www.php.net/manual/en/book.xmlreader.php
    $xml = new XMLReader();
    $xml->open($handle);
    while($xml->read()) {
        if($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'rec') {
            $recTS = $xml->getAttribute('ts');
            if ($recTS == $timestamp) {
                $dom = $xml->expand(new DOMDocument());
                $sx = simplexml_import_dom($dom);
                $value = (float)$sx[$pollutant];
                break;
            }
        }
    }
    return $value;
}

function main() {
    global $pollutant;
    global $monitoringStations;
    $pollutionArray = [];
    foreach($monitoringStations as $station) {
        $fileHandle = "../data-" . $station . ".xml";
        $pollutionArray[] = getData($fileHandle) ?? 0;
    }
    echo "<html><script>";
    $i = 0;
    foreach($pollutionArray as $entry) {
        echo "localStorage.setItem('value" . $i ."', " . $entry . ");\n";
        $i++;
    }
    echo "localStorage.setItem('pollutant', '" . $pollutant . "');\n";
    echo "</script></html>";
}

main();
include "map.html";
?>