<% $this->beginContent('/layouts/base'); %>
<%= $content; %>
<script>
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
    WeixinJSBridge.call('hideOptionMenu');
});
</script>
<% $this->endContent(); %>
