<?php
//{{COREUPS
/**
* Core UPS Class
*
* Used internally to send data, set debug information, change
* urls, and build xml
*/
class ups extends carrier {
    public $xmlResponse;

    function __Construct($license='', $username='', $password='') {

        // Grab the license, username, password from defaults if they
        // are not set manually.
        if ($license == '') {
            $this->license = getUPSDefault('license');
        } else {
            $this->license = $license;
        }

        if ($username == '') {
            $this->username = getUPSDefault('username');
        } else {
            $this->username = $username;
        }

        if ($password == '') {
            $this->password = getUPSDefault('password');
        } else {
            $this->password = $password;
        }

        $this->debugMode = getGenericDefault('debugMode');
        $this->setTestingMode($this->debugMode);

        $this->xmlResponse = '';
        // Create a new xmlObject to be used by access and other classes
        // This object will be used all the way through, until the final xmlObject
        // is converted to a string just before sending to UPS
        $this->xmlObject = new xmlBuilder(false);
        //$this->access();
    }

    // Build the access XML to be used in EVERY request to UPS
    function access() {
        $xml = $this->xmlObject;
        $xml->push('AccessRequest',array('xml:lang' => 'en-US'));
            $xml->element('AccessLicenseNumber', $this->license);
            $xml->element('UserId', $this->username);
            $xml->element('Password', $this->password);
        $xml->pop();

        $this->xmlObject = $xml;

        $this->accessRequest = true; // Old check, probably safe to remove later
        return $this->xmlObject->getXml(); // returns xmlstring, but probably not used
    }

    function request($type, $xml, $isMultiRequest=0){
        // This function is the only function that actually transmits and recieves data
        // from UPS. All classes use this to send XML to UPS servers.
        if ($this->accessRequest != true) {
            die('access function has not been set');
        } else {
            $this->xmlSent = $xml;
            $output = preg_replace('/[\s+]{2,}/', '', $xml);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->upsUrl.'/ups.app/xml/'.$type);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch,CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $output);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            if ($isMultiRequest) {
                return $ch;
            }
            $curlReturned = curl_exec($ch);
            curl_close($ch);
            $this->curlReturned = $curlReturned;
            error_log("Curl returned:" . $curlReturned);
            // exit ($curlReturned);
            //error_log($curlReturned);

            // Find out if the UPS service is down
            $matches = [];
            preg_match_all('/HTTP\/2\s(\d+)/',$curlReturned,$matches);
            error_log("Matches: " . print_r($matches,true));
            foreach($matches[1] as $key=>$value) {
                error_log(1);
                if ($value != 100 && $value != 200) {
                    //throw new RuntimeException("The UPS service seems to be down with HTTP/1.1 $value");
                    error_log("The UPS service seems to be down with HTTP/1.1 $value");
                    return false;
                } else {
                    $response = strstr($curlReturned, '<?'); // Separate the html header and the actual XML because we turned CURLOPT_HEADER to 1
                    $this->xmlResponse = $response;
                    error_log('Response 1: ' . $response);
                    return $response;
                }
            }
        }
    }

    // This function checks the value of debugMode and changes the UPS url accordingly.  This is because
    // UPS has a testing and production server.
    function setTestingMode($bool){
        if($bool == 1){
            $this->debugMode = true;
            $this->upsUrl = 'https://wwwcie.ups.com'; // Don't put a trailing slash here or world will collide.
            //Real testing on dev
            //$this->upsUrl = 'https://www.ups.com';
        }else{
            $this->debugMode = false;
            $this->upsUrl = 'https://www.ups.com';
        }
        return true;
    }

    // I am not sure why this is in here or if anything actually uses it.  Maybe in the future?
    function throwError($error) {
        if($this->debugMode) {
            die($error);
        }else{
            return $error;
        }
    }

    function getServiceDescriptionFromCode($code) {
        switch($code) {
            case '01':
                return 'UPS Next Day Air';
            case '02':
                return 'UPS 2nd Day Air';
            case '03':
                return 'UPS Ground';
            case '07':
                return 'UPS Worldwide Express';
            case '08':
                return 'UPS Worldwide Expedited';
            case '11':
                return 'UPS Standard';
            case '12':
                return 'UPS 3 Day Select';
            case '13':
                return 'UPS Next Day Air Saver';
            case '14':
                return 'UPS Next Day Air Early AM';
            case '54':
                return 'UPS Worldwide Express Plus';
            case '59':
                return 'UPS Second Day Air AM';
            case '65':
                return 'UPS Saver';
            case '82':
                return 'UPS Today Standard';
            case '83':
                return 'UPS Today Dedicated';
            case '84':
                return 'UPS Today Intercity';
            case '85':
                return 'UPS Today Express';
            case '86':
                return 'UPS Today Express Saver';
            default:
                return 'Unknown service code';
        }
    }

}
//}}
?>
