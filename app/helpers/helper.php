<?php

use GuzzleHttp\Client;

function checkValidVat($vat, $country_code = 'FR')
{

    $client = new SoapClient("https://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");

    $params = array(
        "countryCode" => $country_code,
        "vatNumber" => $vat
    );

    try {

        $response = $client->checkVat($params);
    } catch (\Exception $e) {

        return false;
    }


    return $response->valid;

}

function euroSymbol()
{

    return '€';
}


function generateOrderNumber()
{

    $number = 110000;
    while (\App\Models\Price::where('order_number', $number)->exists()) {
        $number++;
    }

    return $number;
}

function sendMailContent($order_id, $which_content = 'web', $which_page = 'bank')
{

    $price_get = \App\Models\Price::where('order_number', $order_id)->first()->total_price;
    $price = euroSymbol() . " " . $price_get;
    $trans_func = function ($input, $args = []) {

        return empty($args) ? __($input) : __($input, $args);
    };
    if ($which_page == 'bank') :
        $HTML = <<<HTML
 <div class="col-lg-12">


                    <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("It is almost done!")}</h3><br>
                      <p style="text-align:center"> {$trans_func("Your order number is")} $order_id. </p>

                <div class="card">

HTML;

        if ($which_content == 'web') {
            $HTML .= <<<HTML
  <div class="card-header bg-primary text-white">
    {$trans_func("Bank Transfer Information")}
    </div>


  HTML;
        }
        $HTML .= <<<HTML
                    <div class="card-body">
                        <p class="card-text" style="text-align: center">
     {$trans_func("Please deposit the total amount of in the following bank account via direct bank transfer, so we can start the preparation for your transport.", ['amount' => "<b>$price</b>"])}
                        </p>
                        <table class="table table-bordered" style="text-align: center">
                            <tr>
                                <td><strong>{$trans_func("Bank BIC/SWIFT code")}:</strong></td>
                                <td>INGBROBU</td>
                            </tr>
                             <tr>
                                <td><strong>{$trans_func("Reference")}:</strong></td>
                                <td>$order_id</td>
                            </tr>
                            <tr>
                                <td><strong>{$trans_func("Bank IBAN")}:</strong></td>
                                <td>RO80 INGB 0000 9999 1362 3897</td>
                            </tr>

HTML;

        if ($which_page == 'bank') {
            $HTML .= <<<HTML
<tr>
<td><strong>{$trans_func("Amount to be paid")}:</strong></td>
<td>$price</td>
</tr>
HTML;
        }
        $HTML .= <<<HTML
                            <tr>
                                <td><strong>{$trans_func("Company Name")}:</strong></td>
                                <td>EASY MOVE EUROPE S.R.L.</td>
                            </tr>
                        </table>
                        <p  style="text-align:center">
                            {$trans_func("If you have any questions or need to make any changes, do not hesitate to contact us.")}
                        </p>
                        <p style="text-align:center">
    {$trans_func("Phone:")} +40 317 801 214 || <a href="mailto:info@easymoveeurope.com">info@easymoveeurope.com</a>
    </p>
                    </div>
                </div>
            </div>
HTML;
    else:
        $HTML = <<<HTML
 <div class="col-lg-12">


                    <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("It is done!")}</h3><br><p style="text-align:center"> {$trans_func("Your order number is")} $order_id. </p>

                <div class="card">

HTML;

        if ($which_content == 'web') {
            $HTML .= <<<HTML



  HTML;
        }
        $HTML .= <<<HTML
                    <div class="card-body">
                        <p class="card-text">
    {$trans_func("We have already started the preparation for your transport and we will contact you back between 24 and 48 hours before pick-up to provide you with the van and driver information.")}

                        </p>

                        <p style="text-align:center">
                            {$trans_func("If you have any questions or need to make any changes, do not hesitate to contact us.")}
                        </p>
                        <p style="text-align:center">
    {$trans_func("Phone:")} +40 317 801 214 || <a href="mailto:info@easymoveeurope.com">info@easymoveeurope.com</a>
    </p>
                    </div>
                </div>
            </div>
HTML;

    endif;

    return $HTML;
}


function sendInvoiceMailContent($invoice_id, $which_content = 'web', $which_page = 'bank')
{

    $price_get = \App\Models\Invoice::where('uuid', $invoice_id)->first()->invoice_amount;
    $type = \App\Models\Invoice::where('uuid', $invoice_id)->first()->invoice_type;
    $cur_order_id = \App\Models\Invoice::where('uuid', $invoice_id)->first()->order_id;
    $order_id = \App\Models\Price::where('id', $cur_order_id)->first()->order_number;
    $price = euroSymbol() . " " . $price_get;
    $trans_func = function ($input, $args = []) {

        return empty($args) ? __($input) : __($input, $args);
    };
    if ($which_page == 'bank') :
        $HTML = <<<HTML
                    <div class="col-lg-12">

HTML;
                if ($type == 'Invoice') {
            $HTML .= <<<HTML
                <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("Invoice!")}</h3><br>
HTML;
                }
                else
                {
                    $HTML .= <<<HTML
                    <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("Extra charge!")}</h3><br>
HTML;
                }
                $HTML .= <<<HTML
                      <p style="text-align:center"> {$trans_func("Your order number is")} $order_id. </p>

                <div class="card">

HTML;

        if ($which_content == 'web') {
            $HTML .= <<<HTML
  <div class="card-header bg-primary text-white">
    {$trans_func("Bank Transfer Information")}
    </div>


  HTML;
        }
        $HTML .= <<<HTML
                    <div class="card-body">
                        <p class="card-text" style="text-align: center">
     {$trans_func("Please deposit the total amount of in the following bank account via direct bank transfer, so we can start the preparation for your transport.", ['amount' => "<b>$price</b>"])}
                        </p>
                        <table class="table table-bordered" style="text-align: center">
                            <tr>
                                <td><strong>{$trans_func("Bank BIC/SWIFT code")}:</strong></td>
                                <td>INGBROBU</td>
                            </tr>
                             <tr>
                                <td><strong>{$trans_func("Reference")}:</strong></td>
                                <td>$order_id</td>
                            </tr>
                            <tr>
                                <td><strong>{$trans_func("Bank IBAN")}:</strong></td>
                                <td>RO80 INGB 0000 9999 1362 3897</td>
                            </tr>

HTML;

        if ($which_page == 'bank') {
            $HTML .= <<<HTML
<tr>
<td><strong>{$trans_func("Amount to be paid")}:</strong></td>
<td>$price</td>
</tr>
HTML;
        }
        $HTML .= <<<HTML
                            <tr>
                                <td><strong>{$trans_func("Company Name")}:</strong></td>
                                <td>EASY MOVE EUROPE S.R.L.</td>
                            </tr>
                        </table>
                        <p  style="text-align:center">
                            {$trans_func("If you have any questions or need to make any changes, do not hesitate to contact us.")}
                        </p>
                        <p style="text-align:center">
    {$trans_func("Phone:")} +40 317 801 214 || <a href="mailto:info@easymoveeurope.com">info@easymoveeurope.com</a>
    </p>
                    </div>
                </div>
            </div>
HTML;
    else:
        $HTML = <<<HTML
 <div class="col-lg-12">

 HTML;
 if ($type == 'Invoice') {
$HTML .= <<<HTML
 <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("Invoice payment is done!")}</h3><br>
HTML;
 }
 else
 {
     $HTML .= <<<HTML
     <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("Extra charge invoice payment is done!")}</h3><br>
HTML;
 }

 $HTML .= <<<HTML
 <p style="text-align:center"> {$trans_func("Your order number is")} $order_id. </p>

                <div class="card">

HTML;

        if ($which_content == 'web') {
            $HTML .= <<<HTML



  HTML;
        }
        $HTML .= <<<HTML
                    <div class="card-body">
                        <p class="card-text">
    {$trans_func("We have already started the preparation for your transport and we will contact you back between 24 and 48 hours before pick-up to provide you with the van and driver information.")}

                        </p>

                        <p style="text-align:center">
                            {$trans_func("If you have any questions or need to make any changes, do not hesitate to contact us.")}
                        </p>
                        <p style="text-align:center">
    {$trans_func("Phone:")} +40 317 801 214 || <a href="mailto:info@easymoveeurope.com">info@easymoveeurope.com</a>
    </p>
                    </div>
                </div>
            </div>
HTML;

    endif;

    return $HTML;
}


function sendDefferdMailContent($order_id)
{
    $price_get = \App\Models\Price::where('order_number', $order_id)->first()->total_price;
    $price = euroSymbol() . " " . $price_get;
    $trans_func = function ($input, $args = []) {
        return empty($args) ? __($input) : __($input, $args);
    };

        $HTML = <<<HTML
 <div class="col-lg-12">

                    <h3 style="color:#238cc7;text-align:center;font-size:24px"> {$trans_func("It is almost done!")}</h3><br>
                      <p style="text-align:center"> {$trans_func("Your order number is")} $order_id. </p>

                <div class="card">

                   <div class="card-body">
                        <p class="card-text" style="text-align: center">
     {$trans_func("The order total amount is deferred and we can start the preparation for your transport.", ['amount' => "<b>$price</b>"])}
                        </p>
                        <table class="table table-bordered" style="text-align: center">
                             <tr>
                                <td><strong>{$trans_func("Reference")}:</strong></td>
                                <td>$order_id</td>
                            </tr>
<tr>
<td><strong>{$trans_func("Amount deferred")}:</strong></td>
<td>$price</td>
</tr>
                            <tr>
                                <td><strong>{$trans_func("Company Name")}:</strong></td>
                                <td>EASY MOVE EUROPE S.R.L.</td>
                            </tr>
                        </table>
                        <p  style="text-align:center">
                            {$trans_func("If you have any questions or need to make any changes, do not hesitate to contact us.")}
                        </p>
                        <p style="text-align:center">
    {$trans_func("Phone:")} +40 317 801 214 || <a href="mailto:info@easymoveeurope.com">info@easymoveeurope.com</a>
    </p>
                    </div>
                </div>
            </div>
HTML;

    return $HTML;
}



function allCountries($to_translate = null)
{
    if (!is_null($to_translate)) {
        return [
            '' => __("Select Country"),
            'AT' => __('Austria'),
            'BE' => __('Belgium'),
            'BG' => __('Bulgaria'),
            'HR' => __('Croatia'),
            'CZ' => __('Czech Republic'),
            'DK' => __('Denmark'),
            'EE' => __('Estonia'),
            'FI' => __('Finland'),
            'FR' => __('France'),
            'DE' => __('Germany'),
            'GR' => __('Greece'),
            'HU' => __('Hungary'),
            'IE' => __('Ireland'),
            'IT' => __('Italy'),
            'LV' => __('Latvia'),
            'LT' => __('Lithuania'),
            'LU' => __('Luxembourg'),
            'NL' => __('Netherlands'),
            'NO' => __('Norway'),
            'PL' => __('Poland'),
            'PT' => __('Portugal'),
            'RO' => __('Romania'),
            'RS' => __('Serbia'),
            'SK' => __('Slovakia'),
            'SI' => __('Slovenia'),
            'ES' => __('Spain'),
            'SE' => __('Sweden'),
            'CH' => __('Switzerland'),
            'GB' => __('United Kingdom'),
        ];
    }
    return
        [
            '' => "Select Country",
            'AT' => 'Austria',
            'BE' => 'Belgium',
            'BG' => 'Bulgaria',
            'HR' => 'Croatia',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'EE' => 'Estonia',
            'FI' => 'Finland',
            'FR' => 'France',
            'DE' => 'Germany',
            'GR' => 'Greece',
            'HU' => 'Hungary',
            'IE' => 'Ireland',
            'IT' => 'Italy',
            'LV' => 'Latvia',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'NL' => 'Netherlands',
            'NO' => 'Norway',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'RO' => 'Romania',
            'RS' => 'Serbia',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'ES' => 'Spain',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'GB' => 'United Kingdom',
        ];


}

function EuropeanCountries($value)
{
    $eu_countries = array("Austria", "Belgium", "Bulgaria", "Croatia", "Cyprus", "Czech Republic", "Denmark", "Estonia", "Finland", "France", "Germany", "Greece", "Hungary", "Ireland", "Italy", "Latvia", "Lithuania", "Luxembourg", "Malta", "Netherlands", "Poland", "Portugal", "Romania", "Slovakia", "Slovenia", "Spain", "Sweden", "United Kingdom");

}


function getFlag()
{

    $flag = 'img/flags/usa.png';
    switch (session('locale')) {


        case "de":
            $flag = 'img/flags/germany.png';
            break;
        case "pl":
            $flag = 'img/flags/poland.png';
            break;
        case "pt":
            $flag = 'img/flags/portugal.png';
            break;
        case "ro":
            $flag = 'img/flags/romania.png';
            break;

        case "it":
            $flag = 'img/flags/italy.png';
            break;
        case "es":

            $flag = 'img/flags/spain.png';
            break;


    }


    return $flag;

}

function getCountryCode($country = null)
{

    $countryPhoneCodes = array(
        "AT" => "+43",
        "BE" => "+32",
        "BG" => "+359",
        "HR" => "+385",
        "CZ" => "+420",
        "DK" => "+45",
        "EE" => "+372",
        "FI" => "+358",
        "FR" => "+33",
        "DE" => "+49",
        "GR" => "+30",
        "HU" => "+36",
        "IE" => "+353",
        "IT" => "+39",
        "LV" => "+371",
        "LT" => "+370",
        "LU" => "+352",
        "NL" => "+31",
        "NO" => "+47",
        "PL" => "+48",
        "PT" => "+351",
        "RO" => "+40",
        "RS" => "+381",
        "SK" => "+421",
        "SI" => "+386",
        "ES" => "+34",
        "SE" => "+46",
        "CH" => "+41",
        "GB" => "+44"
    );

    return $countryPhoneCodes[$country];
}

function getJson()
{

    $file_get = file_get_contents(resource_path('lang/it.json'));

    $json = json_decode($file_get, true);

    $array = (array_keys($json));

    $filtered_array = array_splice($array, 316);
    $filtered_array['hi'] = "Please deposit the total amount of in the following bank account via direct bank transfer, so we can start the preparation for your transport.";

    echo file_put_contents(base_path("new_array.json"), json_encode($filtered_array, JSON_PRETTY_PRINT));

}


function getCodeByFullCountryName($value)
{

    $country = array_search($value, allCountries());
    return getCountryCode($country);

}

function getAbbreviationByFullCountryName($value)
{

    $country = array_search($value, allCountries());
    return $country;

}

function getSubTotalPrice($price)
{


    if (!auth()->check() || (auth()->check() && auth()->user()->vat_check() == false)) {
        $price = round($price / 1.19, 2);
    }

    return $price;


}

function validVatOrNot($price){
    if(!auth()->check() || (auth()->check() && auth()->user()->vat_check() == false)){

        $minus_price =  round($price / 1.19, 2);
        return $price - $minus_price;

    }
    return 0;





}
function getWhoType(){

    if(auth()->check() && auth()->user()->type == 'company'){

        return 'Company';
    }
    elseif(auth()->check() && auth()->user()->type == 'user'){

        return 'Private';
    }
    return null;
}
