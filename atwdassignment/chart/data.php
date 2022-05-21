<?php

function getMonthlyData($month, $year, $handle){
    //https://www.php.net/manual/en/book.xmlreader.php
    $xml = new XMLReader;
    $xml->open($handle);
    //set up array to store one year of data in months
    $yearData = array(
        "01" => array(),
        "02" => array(),
        "03" => array(),
        "04" => array(),
        "05" => array(),
        "06" => array(),
        "07" => array(),
        "08" => array(),
        "09" => array(),
        "10" => array(),
        "11" => array(),
        "12" => array()
    );
    $yearAvgs = array();
    $monthArray = array();
    $validData = False;
    //https://stackoverflow.com/questions/1835177/how-to-use-xmlreader-in-php
    while ($xml->read()) {
        //if xml element is a record
        if ($xml->nodeType == XMLReader::ELEMENT && $xml->name == 'rec') {
            //store timestamp
            $recTS = $xml->getAttribute('ts');
            //if timestamp year matches target year
            if (date("Y", $recTS) == $year) {
                //if time matches timestamp time
                if (date("H:i", $recTS) == "08:00") {
                    //push to respective month array
                    array_push($yearData[date("m", $recTS)], $xml->getAttribute('no'));
                }
            }
        }
    }
    foreach($yearData as $mth) {
        //If at least one entry occurs in a month
        if (count($mth) != 0) {
            $totalNO = 0;
            $days = 0;
            //count up total values for pollutant
            foreach($mth as $i) {
                $totalNO += $i;
                $days++;
            }
            //calculate average
            $average = $totalNO / $days;
            $yearAvgs[] = $average;
        } else {
            $yearAvgs[] = 0;
        }
    }
    return $yearAvgs;
}


function getYearlyData() {
    //get global variables
    global $monitoringStations;
    global $years;
    foreach($monitoringStations as $stn) {
        //create file handle and open file
        $fileHandle = "../data-" . $stn . ".csv";
        $file = fopen($fileHandle, 'r') or die("Can't open file!");  // Open file
        foreach($years as $yr) {
            $yearData = '';
            //for each month in the year
            for($i=1; $i<=12; $i++) {
                //get month digit in correct format
                $number = $i;
                $length = 2;
                $string = substr(str_repeat(0, $length).$number, - $length);
                //return to start of file
                rewind($file);
                $data = getMonthlyData($string, $yr, $file);
                if ($data != 0) {
                    $yearData = $yearData . $data . ",";
                }
            }
            //If there is some data for the year
            if (!empty($yearData)) {
                //add to list of entries
                $yearData = $yr . "-" . $stn . "," . $yearData . "/";
                echo $yearData;
            } else {
                echo "No data found\n";
            }
        }
    }
}


function main() {
    //get user selection from POST variable
    $stationData = $_POST['scatter'];
    //seperate station and year
    $sdArr = explode(" - ", $stationData);
    $station = $sdArr[0];
    $year = $sdArr[1];
    //generate file handle
    $fileHandle = "../data-" . $station . ".xml";
    //get monthly averages
    $monthlyAverages = getMonthlyData($station, $year, $fileHandle);
    //create html file to carry variables over localstorage (javascript)
    echo "<html><script>";
    $largestCount = 0;
    for($i=1; $i<=count($monthlyAverages); $i++) {
        //If average is larger than current largest
        if ($monthlyAverages[$i - 1] > $largestCount) {
            $largestCount = $monthlyAverages[$i - 1];
        }
        //save average in localstorage
        echo "localStorage.setItem('data" . $i ."', " . $monthlyAverages[$i - 1] . ");\n";
    }
    //store remaining variables in localstorage
    echo "localStorage.setItem('station', '" . $station . "');\n";
    echo "localStorage.setItem('year', '" . $year . "');\n";
    echo "localStorage.setItem('bound', " . $largestCount . ");\n";
    echo "localStorage.setItem('time', '08:00:00');\n";
    echo "localStorage.setItem('type', 'scatter');\n";
    echo "</script></html>";
    include "chart.html";
}

main();
?>
