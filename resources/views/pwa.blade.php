<!-- PWA Web App Manifest & Mobile Meta Tags -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#e60000">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="USV">
<link rel="apple-touch-icon" href="{{ asset('icon-192.png') }}">
<link rel="apple-touch-icon" sizes="512x512" href="{{ asset('icon-512.png') }}">

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register("{{ asset('sw.js') }}")
        .then(function(reg) {
          console.log('PWA Service Worker registered successfully:', reg.scope);
        })
        .catch(function(err) {
          console.log('PWA Service Worker registration failed:', err);
        });
    });
  }
</script>
