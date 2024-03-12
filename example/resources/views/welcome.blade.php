<div class="card">
    <div class="card-body">
        <x-currency-table select-active></x-currency-table>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('footer')
<hr>
@php
    $formatter = function ($function_name, ...$params) {
        echo '<h1>';
        echo ucwords(implode(' ', preg_split('/(?=[A-Z])/', $function_name)));
        echo '</h1>';
        echo '<div style="margin-left: 20px;">';
        echo '<b>Function:</b>';
        echo '<br>';
        echo "Currency::$function_name(";

        echo '<pre>';
        foreach ($params[0] as $key => $value) {
            echo "  $key = $value";
            if (count(array_keys($params[0])) > 1 && array_key_last($params[0]) !== $key) {
                echo ',<br>';
            }
        }
        echo '</pre>';
        echo ');';

        echo '<br>';
        echo '<br>';
        echo '<b>Result:</b>';
        echo '<pre>';
        $response = Currency::$function_name(...$params[0]);
        if (is_array($response) || is_object($response)) {
            print_r($response);
        } else {
            echo $response;
        }

        if ($response === false) {
            echo '<br>';
            echo '<b>False</b>';
            echo '<pre>';
        }

        echo '</pre>';
        echo '</div>';
        echo '<br><br><hr><br><br>';
    };

    $formatter('convertWithId', [
        'from_currency_id' => 1,
        'to_currency_id' => 2,
        'amount' => 100,
    ]);
    $formatter('getActiveCurrencies', []);
    $formatter('getCurrency', ['currency_code' => 'TRY']);
    $formatter('getCurrencyById', ['currency_id' => 1]);
    $formatter('convertByDate', [
        'from_currency_code' => 'USD',
        'to_currency_code' => 'TRY',
        'amount' => 100,
        'date' => '2024-03-12',
    ]);
    $formatter('convertByDateWithId', [
        'from_currency_id' => 2,
        'to_currency_id' => 4,
        'amount' => 100,
        'date' => '2024-03-12',
    ]);
    // $formatter('all', []);
@endphp
