<script data-sdk-integration-source="integrationbuilder_sc" src="https://www.paypal.com/sdk/js?client-id=AbO3vAU-R778paouDo1_eQ_XCKyULEEZ9tyvTeKWxFClXjwBIKyi0s6UxSwCoZ7233y4xxuD7RfYRaR-&components=buttons&enable-funding=venmo,paylater&disable-funding=card&integration-date=2023-09-28"></script>
</script>

 <div id="paypal-button-container"></div>

 <span id="paypal_error" style="color: red; display:none">There was an error with the process.</span>
 
<script>
var statSend = false;
function checkSubmit() {
    if (!statSend) {
        statSend = true;
        return true;
    } else {
        alert("Process in progress. Please wait.");
        return false;
    }
}
</script>