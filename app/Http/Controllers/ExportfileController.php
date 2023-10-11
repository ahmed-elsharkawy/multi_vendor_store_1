<?php
namespace App\Http\Controllers;
// require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Intl\Data\Provider\RegionDataProvider;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Currencies;



class ExportfileController extends Controller{
    public function index(){
        // $countries = Intl::getRegionBundle()->getCountryNames();

    // \Locale::setDefault('en');

    // Fetch the list of countries names
    $countries_name_en = Countries::getNames('en');
    $countries_name_ar = Countries::getNames('ar');
    $countries_name_ur = Countries::getNames('ur');

    $currencies_name_en = Currencies::getSymboles('en');
    // $currencies_name_ar = Currencies::getSymbol('ar');
    // $currencies_name_ur = Currencies::getSymbol('ur');
    dd($currencies_name_en);


    // Create an array to store country data
    $countryData = [];

    // Fetch additional data for each country and format it
    foreach ($countries as $countryCode => $countryName) {
        $regionData = RegionDataProvider::getCountry($countryCode);
        $countryData[$countryCode] = [
            'name' => [
                'ar' => $countryName, // You may need to translate country names yourself
                'en' => $countryName,
            ],
            'phone_code' => $regionData['phoneCode'] ?? '',
            'code' => $countryCode,
            'currency_name' => [
                'ar' => $regionData['currencies'][0]['name'] ?? '', // You may need to translate currency names yourself
                'en' => $regionData['currencies'][0]['name'] ?? '',
            ],
            'currency_symbol' => $regionData['currencies'][0]['symbol'] ?? '',
            'is_active' => 1, // You can set the default value as needed
        ];
    }

    // Convert the data to JSON
    $jsonData = json_encode($countryData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // Save the JSON data to a file
    file_put_contents('countries.json', $jsonData);

    echo "Country data has been exported to countries.json.\n";
    }
}
