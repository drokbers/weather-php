
<?php

date_default_timezone_set('Europe/Istanbul');

$googleApiUrl = "https://api.openweathermap.org/data/2.5/onecall?lat=39.92077&lon=32.85411&units=metric&lang=en&exclude=&appid=xxxxxx";

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);
$currentTime = time();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title>Weather in Ankara</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">



    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <! –– Grafik ––>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Time of Day');
            data.addColumn('number', 'Celcius');

            data.addRows([
                <?php

                for ($x = 0; $x <= 24; $x++) {
                    $timestamp= $data->hourly[$x]->dt;
                    echo "[new Date(2021, 0,". gmdate("d ", $timestamp +11000) . ",". gmdate("H ", $timestamp +11000) . ")," . round($data->hourly[$x]->temp) . "],";
                }

                ?>

            ]);

            var options = {
                width: 1000,
                height: 500,
                legend: {position: 'none'},
                enableInteractivity: false,
                chartArea: {
                    width: '85%'
                },
                hAxis: {

                    gridlines: {
                        count: -1,
                        units: {
                            days: {format: ['MMM dd']},
                            hours: {format: ['HH:mm', 'ha']},
                        }
                    },
                    minorGridlines: {
                        units: {
                            hours: {format: ['hh:mm:ss a', 'ha']},
                            minutes: {format: ['HH:mm a Z', ':mm']}
                        }
                    }
                }
            };

            var chart = new google.visualization.LineChart(
                document.getElementById('chart_div'));

            chart.draw(data, options);



        }

    </script>

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">




</head>

<body class="animsition">
<div class="page-wrapper">

    <div class="page-container">

        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">



                        <div class="col-lg-3">
                            <div class="au-card au-card--bg-blue au-card-top-countries m-b-30">
                                <div class="au-card-inner">
                                    <div>
                                        <p style="color:white; font-size:28px;"> <strong>Weather in Ankara,TR </strong> </p> <br>
                                        <table >
                                        <tbody>

                                        <tr>
                                            <td><img src="/noktacase/iconlar/<?php  echo  $data->current->weather[0]->icon ?>.png"></td>
                                            <td ><p style="color:white; font-size:37px;  "  > <strong>&emsp;<?php  echo  round($data->hourly[0]->temp) ?>&deg;C</strong></p></td>

                                        </tr>
                                        </tbody>
                                        </table>

                                        <div>
                                            <table >
                                                <tbody>

                                                <tr>
                                            <td><p style="color:white; font-size:18px;"><br> <?php  $timestamp= $data->hourly[0]->dt;
                                            echo gmdate("H:i M d", $timestamp +11000 ,  ) ; ?></p><br></td>
                                                    <td> &emsp;&emsp;<a  href="https://www.noktamedya.com/" > <b><p style="color: yellow">Wrong Data?</p></b></a></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>





                                    </div>


                                    <! –– Sol bilgi kismi. ––>
                                    <div class="table-responsive">

                                        <table class="table table-top-countries">
                                            <tbody>
                                            <tr>
                                                <td>Wind Speed</td>
                                                <td class="text-right"><?php  echo  $data->current->wind_speed ?></td>
                                            </tr>
                                            <tr>
                                                <td>Cloudiness</td>
                                                <td class="text-right"><?php  echo  $data->current->weather[0]->description ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pressure</td>
                                                <td class="text-right"><?php  echo  $data->current->pressure ?></td>
                                            </tr>
                                            <tr>
                                                <td>Humidity</td>
                                                <td class="text-right">%<?php  echo  $data->current->humidity ?></td>
                                            </tr>
                                            <tr>
                                                <td>Sunrise</td>
                                                <td class="text-right"><?php  $timestamp= $data->current->sunrise;
                                                     echo gmdate("H:i", $timestamp +11000 ,  ) ; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Humidity</td>
                                                <td class="text-right"><?php  echo  $data->current->humidity ?></td>
                                            </tr>
                                            <tr>
                                                <td>Sunset</td>
                                                <td class="text-right"><?php  $timestamp= $data->current->sunset;
                                                    echo gmdate("H:i", $timestamp +11000 ,  ) ; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Geo Coords</td>
                                                <td class="text-right"><?php  echo  $data->lat . ',' . $data->lon ?></td>
                                            </tr>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div></div>



                            </div>
                        </div>

                        <! –– Sag Kisim ––>
                        <div>

                        <div class="col-lg-9">
                            <div class="au-card m-b-30">
                                <div id="chart_div"></div>
                            </div>
                        </div>

                            <div class="col-lg-9">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">

                                        <tbody>
                                        <tr>
                                            <td><p style=" font-size:18px;"><br> <?php  $timestamp= $data->daily[1]->dt;
                                                    echo gmdate(" D ", $timestamp +11000 ,  ) ; ?></p></td>
                                            <td><p style=" font-size:18px;"><br> <?php  $timestamp= $data->daily[2]->dt;
                                                    echo gmdate(" D ", $timestamp +11000 ,  ) ; ?></p></td>
                                            <td><p style=" font-size:18px;"><br> <?php  $timestamp= $data->daily[3]->dt;
                                                    echo gmdate(" D ", $timestamp +11000 ,  ) ; ?></p></td>
                                            <td ><p style=" font-size:18px;"><br> <?php  $timestamp= $data->daily[4]->dt;
                                                    echo gmdate(" D ", $timestamp +11000 ,  ) ; ?></p></td>
                                            <td ><p style=" font-size:18px;"><br> <?php  $timestamp= $data->daily[5]->dt;
                                                    echo gmdate(" D ", $timestamp +11000 ,  ) ; ?></p></td>

                                        </tr>
                                        <tr>
                                            <td><img src="/noktacase/iconlar/<?php  echo  $data->daily[1]->weather[0]->icon ?>.png"></td>
                                            <td><img src="/noktacase/iconlar/<?php  echo  $data->daily[2]->weather[0]->icon ?>.png"></td>
                                            <td><img src="/noktacase/iconlar/<?php  echo  $data->daily[3]->weather[0]->icon ?>.png"></td>
                                            <td><img src="/noktacase/iconlar/<?php  echo  $data->daily[4]->weather[0]->icon ?>.png"></td>
                                            <td><img src="/noktacase/iconlar/<?php  echo  $data->daily[5]->weather[0]->icon ?>.png"></td>

                                        </tr>
                                        <tr>
                                            <td><?php  echo  round($data->daily[1]->temp->day) ?>&deg;C</td>
                                            <td><?php  echo  round($data->daily[2]->temp->day) ?>&deg;C</td>
                                            <td><?php  echo  round($data->daily[3]->temp->day) ?>&deg;C</td>
                                            <td ><?php  echo  round($data->daily[4]->temp->day) ?>&deg;C</td>
                                            <td ><?php  echo  round($data->daily[5]->temp->day) ?>&deg;C</td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


                    </div>

                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->

    </div>
    <!-- END PAGE CONTAINER-->

</div>

<!-- Jquery JS-->
<script src="vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="js/main.js"></script>




</body>

</html>
<!-- end document-->
