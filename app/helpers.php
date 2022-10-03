<?php
function load_countries_array()
{
    $filename = storage_path('app/public/countries_codes_and_coordinates.csv');
    $file = fopen($filename, "r");
    # 2 character iso
    $correct_data = array();
    # 3 character iso
    $character_data = array();
    # numeric iso
    $numeric_data = array();
    while (($row = fgetcsv($file, 200, ",")) !== FALSE) {
        $correct_data[] = trim(str_replace('"', '', $row[0]));
        $character_data[trim(str_replace('"', '', $row[1]))] = trim(str_replace('"', '', $row[0]));
        $numeric_data[trim(str_replace('"', '', $row[2]))] = trim(str_replace('"', '', $row[0]));
    }
    return array($character_data, $numeric_data, $correct_data);
}

function map_country(array $countryarray, string $countrycode)
{
    if (in_array($countrycode, $countryarray[2])) {
        return $countrycode;
    }
    try {
        (int) $countrycode;
        return $countryarray[1][$countrycode];
    } catch (exception $e) {
        try {
            return $countryarray[0][$countrycode];
        } catch (exception $e) {
            return "SG";
        }
    }
}
