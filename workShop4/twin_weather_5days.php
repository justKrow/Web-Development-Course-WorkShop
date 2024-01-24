<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>openweathermap API</title>
    <style>
        .content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <?php
    function callAPI($city_name, $country_code) {
        $key = "###";
        $url = "https://api.openweathermap.org/data/2.5/forecast?q=" . $city_name . "," . $country_code . "&mode=xml&appid=" . $key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($response);
        if ($xml === false) {
            return false;
        }
        return $xml;
    }

    function aggregateDailyData($xml) {
        $forecasts = $xml->forecast->time;
        $dailyData = [];

        foreach ($forecasts as $time) {
            $dateTime = new DateTime((string)$time['from']);
            $date = $dateTime->format('Y-m-d');

            if (!isset($dailyData[$date])) {
                $dailyData[$date] = [
                    'temperatures' => [],
                    'precipitations' => [],
                    'max_wind_speed' => 0,
                    'humidity' => [],
                ];
            }

            $temperature = (float)$time->temperature['value'] - 273.15; // Convert Kelvin to Celsius
            $dailyData[$date]['temperatures'][] = $temperature;

            $humidity = (float)$time->humidity['value'];
            $dailyData[$date]['humidity'][] = $humidity;

            $precipitationValue = isset($time->precipitation['value']) ? (float)$time->precipitation['value'] : 0;
            $dailyData[$date]['precipitations'][] = $precipitationValue;

            $windSpeed = (float)$time->windSpeed['mps'];
            if ($windSpeed > $dailyData[$date]['max_wind_speed']) {
                $dailyData[$date]['max_wind_speed'] = $windSpeed;
            }
        }

        foreach ($dailyData as $date => $data) {
            $dailyData[$date]['avg_temperature'] = round(array_sum($data['temperatures']) / count($data['temperatures']));
            $dailyData[$date]['total_precipitation'] = array_sum($data['precipitations']);
            $dailyData[$date]['avg_humidity'] = array_sum($data['humidity']) / count($data['humidity']);
        }

        return $dailyData;
    }


    function displayWeather($city_name, $country_code) {
        $data = callAPI($city_name, $country_code);
        if ($data === false) {
            echo "<h1>Error: Couldn't process the request for {$city_name}</h1>";
            return;
        }

        $dailyData = aggregateDailyData($data);
        echo "<h1>Weather Forecast for {$city_name}</h1>";

        foreach ($dailyData as $date => $summary) {
            echo "<h2>{$date}</h2>";
            echo "<table>";
            echo "<tr><th>Metric</th><th>Value</th></tr>";
            echo "<tr><td>Average Temperature</td><td>{$summary['avg_temperature']} &deg;C</td></tr>";
            echo "<tr><td>Total Precipitation</td><td>{$summary['total_precipitation']} mm</td></tr>";
            echo "<tr><td>Max Wind Speed</td><td>{$summary['max_wind_speed']} m/s</td></tr>";
            echo "<tr><td>Average Humidity</td><td>{$summary['avg_humidity']}%</td></tr>";
            echo "</table>";
        }
    }
    ?>

    <div class="content-wrapper">
        <div class="city-forecast">
            <?php displayWeather('Bristol', 'UK'); ?>
        </div>
        <div class="city-forecast">
            <?php displayWeather('Bordeaux', 'FR'); ?>
        </div>
    </div>

</body>

</html>
