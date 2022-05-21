<?php 

$st = microtime(true);

$monitoringStations = ['188', '203', '206', '209', '213', '215', '228', '270', '271', '375', '395', '452', '447', '459', '463', '481', '500', '501'];
$file_header="<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
$stationFormat = "\n<station id=\"%s\" name=\"%s\" geocode=\"%s,%s\">";
//$recordFormat = "\n    <rec ts=\"%s\" nox=\"%s\" no2=\"%s\" no=\"%s\" />";

foreach($monitoringStations as $i) {
    $fileName = 'data-' . $i . '.xml';
    $file_array[$i] = fopen($fileName, 'w') or die ("Can't open file!");
    fputs($file_array[$i], $file_header);
}

$csv_header="siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long";

foreach($monitoringStations as $i) {
    $fileName = 'data-' . $i . '.csv';
    $file = fopen($fileName, 'r') or die ("Can't open file!");
    $headerLine = explode(',', fgets($file));
    $firstLine = explode(',', fgets($file));
    if (str_contains($firstLine[14], '&')) {
        $firstLine[14] = str_replace('&', '&amp;', $firstLine[14]);
    }
    $stationTag = sprintf($stationFormat, $i, $firstLine[14], $firstLine[15], $firstLine[16]);
    fputs($file_array[$i], $stationTag);
    rewind($file);
    fgets($file);
    while($line = fgets($file)) {
        $csvRecord = explode(',', $line);
        $xmlRecord = "\n    <rec ts=\"" . $csvRecord[1] . "\" ";
        $validLine = False;
        for ($j=2; $j<=4; $j++) {
            if ($csvRecord[$j] != "") {
                $validLine = True;
                $xmlRecord = $xmlRecord . $headerLine[$j] . "=\"" . $csvRecord[$j] . "\" ";
            }
        }
        if ($validLine == True) {
            $xmlRecord = $xmlRecord . "/>";
            fputs($file_array[$i], $xmlRecord);
        }
    }
    $xmlRecord = "\n</station>";
    fputs($file_array[$i], $xmlRecord);
}


echo '<p>It took ';
echo microtime(true) - $st;
echo ' seconds.</p>';
?>