<?php
declare(strict_types = 1);

namespace Countries\Soap;

use SimpleXMLElement;

abstract class CountriesAbstract
{
    protected function getContent(): SimpleXMLElement
    {
	// TO DO - get request content
        $content     = '';

        $soapRequest = simplexml_load_string($content);
        $namespaces  = $soapRequest->getDocNamespaces();

        $soapBody = $soapRequest->children(key($namespaces), true)->Body;

        return $soapBody->children('', true);
    }
}
