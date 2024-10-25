 <script src="https://www.paypal.com/sdk/js?client-id=AQnut69fo9fHIh2a8DVMDPjLvuzHcmoTqEblZOHu61-Gi7eBM8HSE-xOCZBF_7EuwdYtfocnIHmaeWwx&disable-funding=card">
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