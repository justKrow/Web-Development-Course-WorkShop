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
        }
    </style>
</head>

<body>

    <?php
    function callAPI($city_name, $country_code)
    {
        $key = "###";
        $url = "https://api.openweathermap.org/data/2.5/forecast?q=" . $city_name . "," . $country_code . "&mode=xml&appid=" . $key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
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

    function displayWeather($city_name, $country_code)
    {
        $data = callAPI($city_name, $country_code);
        if ($data === false) {
            echo "<h1>Error couldn't process</h1>";
        }
        else {
            $location = $data->location->name;
            $datetime = $data->forecast->time['from'];
            $datetime = new DateTime($datetime);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i:s');
    
            $temperature_in_Celsius = round(($data->forecast->time->temperature['value']) - 273.15);
            $condition = $data->forecast->time->clouds['value'];
    
            $wind_speed = $data->forecast->time->windSpeed['mps'];
            $wind_name = $data->forecast->time->windSpeed['name'];
            $wind_direction = $data->forecast->time->windDirection['name'];
    
            $humidity = $data->forecast->time->humidity['value'];
            $pressure = $data->forecast->time->pressure['value'];
    
            $sun_rise = $data->sun['rise'];
            $sun_rise = new DateTime($sun_rise);
            $sun_rise = $sun_rise->format('H:i:s');
            $sun_set = $data->sun['set'];
            $sun_set = new DateTime($sun_set);
            $sun_set = $sun_set->format('H:i:s');
    
            echo "<h1>{$location}</h1>";
            echo "<p>Weather in {$location} on {$date} at {$time}</p>";
            echo "<table class='bristol-data'>";
            echo "<tr> <td> Condition : </td> <td> {$condition} </td> </tr>";
            echo "<tr> <td> Temperature :</td> <td>{$temperature_in_Celsius} &deg; C </td> </tr>";
            echo "<tr> <td> Wind :</td> <td> {$wind_speed} m/s ({$wind_name}) from {$wind_direction} direction </td> </tr>";
            echo "<tr> <td> Humidity : </td> <td> {$humidity} % </td> </tr>";
            echo "<tr> <td> Pressure : </td> <td> {$pressure} hPa </td> </tr>";
            echo "<tr> <td> Sun rise : </td> <td> {$sun_rise} </td> </tr>";
            echo "<tr> <td> Sun set : </td> <td> {$sun_set} </td> </tr> </table>";
        }
    }
    ?>

    <h1>Twin Cities Weather Example</h1>
    <div class="content-wrapper">
        <div class="bristol">
            <?php
            displayWeather('bristol', 'uk');
            ?>
        </div>
        <div class="bordeaux">
            <?php
            displayWeather('bordeaux', 'fr');
            ?>
        </div>
    </div>
</body>

</html>