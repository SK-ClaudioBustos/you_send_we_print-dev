<?php if ($cfg->setting->domain == 'www.yousendweprint.com') { ?>
	<?php if ($app->page_key != 'Cart/work_order') { ?>

		<script type="text/javascript">
			try {
				let width = $(document).width();

				if ($('#body_home').length == 1 || ($('#body_home').length != 1 && width > 991)) {
					var Tawk_API = Tawk_API || {},
						Tawk_LoadStart = new Date();
					(function() {
						var s1 = document.createElement("script"),
							s0 = document.getElementsByTagName("script")[0];
						s1.async = true;
						s1.src = 'https://embed.tawk.to/5640318245f9fdd56b564d0f/default';
						s1.charset = 'UTF-8';
						s1.setAttribute('crossorigin', '*');
						s0.parentNode.insertBefore(s1, s0);
					})();
				}
			} catch (error) {
				window.location.reload();
				console.log('Error: ' + error);
			}
		</script>

		<script>
			/*(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-83940372-1', 'auto');
			ga('send', 'pageview');*/
		</script>

		<script>
			/*! function(f, b, e, v, n, t, s) {
				if (f.fbq) return;
				n = f.fbq = function() {
					n.callMethod ?
						n.callMethod.apply(n, arguments) : n.queue.push(arguments)
				};
				if (!f._fbq) f._fbq = n;
				n.push = n;
				n.loaded = !0;
				n.version = '2.0';
				n.queue = [];
				t = b.createElement(e);
				t.async = !0;
				t.src = v;
				s = b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t, s)
			}(window, document, 'script',
				'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '558318898037164');
			fbq('track', 'PageView');*/
		</script>
		<!-- <noscript>
			<img height="1" width="1" src="https://www.facebook.com/tr?id=558318898037164&ev=PageView
&noscript=1" />
		</noscript> -->

		<script>
			try {
				(function(h, e, a, t, m, p) {
					m = e.createElement(a);
					m.async = !0;
					m.src = t;
					p = e.getElementsByTagName(a)[0];
					p.parentNode.insertBefore(m, p);
				})(window, document, 'script', 'https://u.heatmap.it/log.js');
			} catch (error) {
				window.location.reload();
				console.log('Error: ' + error);
			}
		</script>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-203230195-1"></script>
		<script async src="https://www.googletagmanager.com/gtag/js?id=AW-334467008"></script>
		<script>
			try {
				window.dataLayer = window.dataLayer || [];

				function gtag() {
					dataLayer.push(arguments);
				}
				gtag('js', new Date());

				gtag('config', 'G-Z2YCDZX1DN');
				gtag('config', 'UA-203230195-1');
				gtag('config', 'AW-334467008');

				gtag('event', 'conversion', {
					'send_to': 'AW-334467008/6Od1CPmo9t0CEMCfvp8B'
				});
			} catch (error) {
				window.location.reload();
				console.log('Error: ' + error);
			}
		</script>

		<!-- Facebook Pixel Code -->
		<script>
			try {
				! function(f, b, e, v, n, t, s) {
					if (f.fbq) return;
					n = f.fbq = function() {
						n.callMethod ?
							n.callMethod.apply(n, arguments) : n.queue.push(arguments)
					};
					if (!f._fbq) f._fbq = n;
					n.push = n;
					n.loaded = !0;
					n.version = '2.0';
					n.queue = [];
					t = b.createElement(e);
					t.async = !0;
					t.src = v;
					s = b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t, s)
				}(window, document, 'script',
					'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '157033699831983');
				fbq('track', 'PageView');
			} catch (error) {
				window.location.reload();
				console.log('Error: ' + error);
			}
		</script>
		<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=157033699831983&ev=PageView&noscript=1" /></noscript>
		<!-- End Facebook Pixel Code -->

		<!-- Start of HubSpot Embed Code -->
			<!--  <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/20499502.js"></script> -->
		<!-- End of HubSpot Embed Code -->

	<?php } ?>
<?php } ?>