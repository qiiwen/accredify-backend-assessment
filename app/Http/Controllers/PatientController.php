<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Jekk0\laravel\Iso3166\Validation\Rules\Iso3166Alpha2;
use App\Models\Patient;
use App\Rules\Nric;
use Throwable;

class PatientController extends Controller
{
    public function createPatient(Request $request)
    {
        // extract array from request
        $request_arr = $request->all();
        // get country code mappings
        $country_codes = load_countries_array();
        // format patient gender to lowercase for case-insensitive validation, format country code
        foreach ($request_arr['patients'] as $key => $req) {
            $request_arr['patients'][$key]['patientGender'] = strtolower($req['patientGender']);
            $request_arr['patients'][$key]['patientNationality'] = map_country($country_codes, $req['patientNationality']);
        }
        print_r($request_arr);
        foreach ($request_arr['patients'] as $key => $req) {
            $req = new Request($req);
            try { // define validation rules
                $rules = [
                    'patientNationality' => ['required', new Iso3166Alpha2()],
                    'patientNric' => ['required', new Nric()],
                    'patientName' => 'required',
                    'patientGender' => ['required', Rule::in('female', 'male')],
                    'patientBirthDate' => ['date_format:Y-m-d', 'before:today'],
                    'patientEmail' => ['required', 'email'],
                    'sampleUniqueId' => 'required',
                    'sampleResults' => 'required',
                    'collectedDateTime' => ['required', 'iso_date'],
                    'effectiveDateTime' => 'required'
                ];
                $this->validate($req, $rules);
                // insert into model
                $patient = new Patient;
                $patient->patientNationality = $req['patientNationality'];
                $patient->patientNric = $req['patientNric'];
                $patient->patientName = $req['patientName'];
                $patient->patientGender = $req['patientGender'];
                $patient->patientBirthDate = $req['patientBirthDate'];
                $patient->patientEmail = $req['patientEmail'];
                $patient->sampleUniqueId = $req['sampleUniqueId'];
                $patient->sampleResults = $req['sampleResults'];
                $patient->collectedDateTime = $req['collectedDateTime'];
                $patient->effectiveDateTime = $req['effectiveDateTime'];
                // save to database
                $patient->save();
            } catch (Throwable $e) {
                echo ($e);
            }
        }
    }
    public function testNric(Request $request)
    {
        $rules = [
            'data.*' => new Nric()
        ];
        $this->validate($request, $rules);
        echo ("All test cases successful");
    }
    public function testNationality(Request $request)
    {
        // extract array from request
        $request_arr = $request->all();
        // get country code mappings
        $country_codes = load_countries_array();
        // format patient gender to lowercase for case-insensitive validation, format country code
        foreach ($request_arr['data'] as $key => $req) {
            $request_arr['data'][$key] = map_country($country_codes, $req);
        }
        $rules = [
            'data.*' => new Iso3166Alpha2()
        ];
        $this->validate(new Request($request_arr), $rules);
        print_r($request_arr);
        echo ("All test cases successful");
    }
    public function testGender(Request $request)
    {
        // extract array from request
        $request_arr = $request->all();
        // format patient gender to lowercase for case-insensitive validation
        foreach ($request_arr['data'] as $key => $req) {
            $request_arr['data'][$key] = strtolower($req);
        }
        $rules = [
            'data.*' => Rule::in('female', 'male')
        ];
        $this->validate(new Request($request_arr), $rules);
        echo ("All test cases successful");
    }
    public function testBirthdate(Request $request)
    {
        $rules = [
            'data.*' => ['date_format:Y-m-d', 'before:today']
        ];
        $this->validate($request, $rules);
        echo ("All test cases successful");
    }
    public function testEmail(Request $request)
    {
        $rules = [
            'data.*' => 'email'
        ];
        $this->validate($request, $rules);
        echo ("All test cases successful");
    }
}
