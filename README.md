# Air-Quality-Data-Cleanse-Visualisation
Web project developed using HTML, CSS, PHP, JavaScript and Google Charts &amp; Maps APIs as part of a coursework assignment at university
---
## Instructions

1. Download the uncleansed air quality data here: https://uweacuk-my.sharepoint.com/:f:/g/personal/michael3_duncan_live_uwe_ac_uk/EkQghDTlG29HoDK10pUDpYQBGcwgE_IBC9FgiVHe_x2DVQ?e=DDvSP9
2. Download the repository
3. Add the file downloaded in Step 1 to the ```atwdassignment``` folder from the repository.
4. Copy and paste the ```atwdassignment``` folder into a web server. If you are using XAMPP like I did, then this directory should be pasted into your "htdocs" folder.

### Task 1: Generating Cleansed CSV Files

1. Open the following file: ```atwdassignment/index.php```
2. Overwrite and save the file with the following code: ```<?php include"extract-to-csv.php";?>```
3. Run your server and type ```localhost/atwdassignment``` into your web browser.

### Task 2: Generating Normalised XML Files

1. Open the following file: ```atwdassignment/index.php```
2. Overwrite and save the file with the following code: ```<?php include"normalize-to-xml.php";?>```
3. Run your server and type ```localhost/atwdassignment``` into your web browser.

### Task 3: Generating Charts to Visualise Data

1. Run your server and type ```localhost/atwdassignment/chart``` into your web browser.
2. Choose from the two options. The first displays a scatter graph of NO data from each station that has data available from the latest 5 years. The second displays a line graph for a station for any of the pollutants specified, from the latest 5 years.

### Task 4: Visualising Data using Maps API
1. Run your server and type ```localhost/atwdassignment/map``` into your web browser.
2. Choose a station, date and pollutant from the lists and search to view pollution data for that day.
