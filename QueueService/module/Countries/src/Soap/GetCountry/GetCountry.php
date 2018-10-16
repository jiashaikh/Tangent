<?php
declare(strict_types = 1);

namespace Countries\Soap\GetCountry;

use stdClass;

class GetCountry
{
    public function get(array $code)
    {
        // Generate the XML request

	// TO DO - create view model
        $viewModel = [
            'code'     => $code,
            'username' => '',
	    'password' => '', 
        ];

	// TO DO - set to use template /Soap/GetCountry/GetCountryRQ.xml

	// TO DO - render the request content
        $xmlContent = '';

        // Send the HTTP requestr
        $httpResponse = $this->httpRequest(
            $url, // TO DO - get from config
            $xmlContent
        );

        if ($httpResponse->isSuccess()) {
            $soapResponse = $this->extractResponse($httpResponse->getBody(), 'getCountryResponse');

            if (isset($soapResponse->country)) {
		$countryResponse = $soapResponse->country;

                return [
		    'name' 	 => $countryResponse->name,
		    'code' 	 => $countryResponse->code,
		    'population' => $countryResponse->population,
		];
            } else {
            	// TO DO - log the request and response
	    }
        } else {
	    // TO DO - log the request and response
        }

        // Something went wrong
        return false;
    }
}
