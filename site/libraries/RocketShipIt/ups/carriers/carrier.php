<?php

class carrier {

    function debug() {
        $debugInfo = '<pre>';
        $debugInfo .= '--------------------------------------------------'. "\n";
        $debugInfo .= 'RocketShipIt Debug Information'. "\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        if (isset($this->debugMode)) {
            $debugInfo .= "debugMode = $this->debugMode";
        }
        $debugInfo .= "\n\n";
        if (isset($this->xmlPrevSent)) {
            $debugInfo .= '--------------------------------------------------'. "\n";
            $debugInfo .= 'XML Prev Sent'. "\n";
            $debugInfo .= '--------------------------------------------------'. "\n";
            if(php_sapi_name() == "cli") {
                $debugInfo .= rocketshipit_xmlPrettyPrint($this->xmlPrevSent) . "\n";
            } else {
                $debugInfo .= htmlentities(rocketshipit_xmlPrettyPrint($this->xmlPrevSent)) . "\n";
            }
            $debugInfo .= "\n\n";
        }
        if (isset($this->xmlPrevResponse)) {
            $debugInfo .= '--------------------------------------------------'. "\n";
            $debugInfo .= 'XML Prev Response'. "\n";
            $debugInfo .= '--------------------------------------------------'. "\n";
            if(php_sapi_name() == "cli") {
                $debugInfo .= $this->xmlPrevResponse . "\n";
            } else {
                $debugInfo .= htmlentities($this->xmlPrevResponse) . "\n";
            }
            $debugInfo .= "\n\n";
        }
        $debugInfo .= '--------------------------------------------------'. "\n";
        $debugInfo .= 'XML Sent'. "\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        if (isset($this->xmlSent)) {
            if(php_sapi_name() == "cli") {
                $debugInfo .= rocketshipit_xmlPrettyPrint($this->xmlSent) . "\n";
            } else {
                $debugInfo .= htmlentities(rocketshipit_xmlPrettyPrint($this->xmlSent)) . "\n";
            }
        } else {
            $debugInfo .= 'xmlSent was not set'. "\n";
        }
        $debugInfo .= "\n\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        $debugInfo .= 'XML Response'. "\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        if (isset($this->xmlResponse)) {
            if(php_sapi_name() == "cli") {
                $debugInfo .= rocketshipit_xmlPrettyPrint($this->xmlResponse) . "\n";
            } else {
                $debugInfo .= htmlentities(rocketshipit_xmlPrettyPrint($this->xmlResponse)) . "\n";
            }
        } else {
            $debugInfo .= 'xmlResponse was not set'. "\n";
        }
        $debugInfo .= "\n\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        $debugInfo .= 'PHP Information'. "\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        $debugInfo .= phpversion();
        $debugInfo .= "\n\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        $debugInfo .= 'cURL Return Information'. "\n";
        $debugInfo .= '--------------------------------------------------'. "\n";
        if (isset($this->curlReturned)) {
            if(php_sapi_name() == "cli") {
                $debugInfo .= $this->curlReturned;
            } else {
                $debugInfo .= htmlentities($this->curlReturned);
            }
        }
        $debugInfo .= "\n\n";
        $debugInfo .= '</pre>';
        return $debugInfo;
    }
}
