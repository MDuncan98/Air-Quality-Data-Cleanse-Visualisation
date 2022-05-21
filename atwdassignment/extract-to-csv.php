<?php @date_default_timezone_set("GMT"); ini_set('memory_limit', '512M'); ini_set('max_execution_time', '300'); ini_set('auto_detect_line_endings', TRUE);

$lines=0;
$st = microtime(true);
$file = fopen('air-quality-data-2004-2019.csv', 'r') or die ('Unable to open file!');

$monitoringStations = ['188', '203', '206', '209', '213', '215', '228', '270', '271', '375', '395', '452', '447', '459', '463', '481', '500', '501'];
$file_header="siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long";
//Create empty files with headers on startup
$file_array = array();
foreach($monitoringStations as $i) {
    $fileName = 'data-' . $i . '.csv';
    $file_array[$i] = fopen($fileName, 'w') or die ("Can't open file!");
    fputs($file_array[$i], $file_header);
}
unset($monitoringStations);
unset($file_header);
//Open each file and store in array, create variable for siteID and use to get fileHandle in array.
//open uncleansed file
// https://stackoverflow.com/questions/2162497/efficiently-counting-the-number-of-lines-of-a-text-file-200mb
fgets($file);
while ($line = fgets($file)) { 
    $dataEntryList = explode(";", $line);
    if (!(empty($dataEntryList[1]) and empty($dataEntryList[11]))) {
        $siteID = $dataEntryList[4] ?? "";
        $dataEntryList[0] = strtotime($dataEntryList[0]);
        $csvString = "\r\n" . $siteID . ',';
        for ($i=0; $i<=13; $i++) {
            if ($i != 4) {
                $csvString = $csvString . $dataEntryList[$i] . ",";
            }
        }
        $csvString = $csvString . $dataEntryList[17] . "," . $dataEntryList[18] . ",";
        unset($dataEntryList);
        //https://www.w3schools.com/php/func_array_unshift.asp
        //https://www.geeksforgeeks.org/removing-array-element-and-re-indexing-in-php/
        $lines++;
        fputs($file_array[$siteID], $csvString);
        unset($csvString);
    }
}
fclose($file);

echo '<p>It took ';
echo microtime(true) - $st;
echo ' seconds to get at '. $lines .' lines.</p>';
?>