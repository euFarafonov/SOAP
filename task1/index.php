<?php
include ('config.php');

/*
* First soap request
*/

if ($_POST["numb"]) {
	$urlNumb = "http://www.dataaccess.com/webservicesserver/numberconversion.wso?WSDL";
	$clientNumb = new SoapClient($urlNumb);
	$param = [
		"ubiNum" => $_POST["numb"]
	];
	$resNumb = $clientNumb->NumberToWords($param);
}

/*
* Second soap request
*/
$urlCountrys = "http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL";
$countrys = new SoapClient($urlCountrys);
$resCountrys = $countrys->ListOfCurrenciesByName()->ListOfCurrenciesByNameResult->tCurrency;

if ($_POST["country"]) {
	$param = [
		"sCountryISOCode" => $_POST["country"]
	];
	$info = $countrys->FullCountryInfo($param);
}

require_once TEMPLATES.TEMPLATE;
?> 