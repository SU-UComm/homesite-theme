// Canary Token for Stanford Homesite
// Detects when our site has been cloned or copied and uses a canary token to alert us.
// The token is configured to send email to homepage-team@stanford.edu, and to send an
// alert to the #commstech-alerts Slack channel.
// See https://docs.canarytokens.org/guide/cloned-web-token.html for info abou the
// Cloned Website Canarytoken.
// Manage the tokend at https://canarytokens.org/nest/manage/6bdcc11830fadfc8894144febef62870/8p3ubbrvzxxnc2mpe3wfh0rkn

'use strict';
if (!window.location.hostname.endsWith('stanford.edu') && !window.location.hostname.endsWith('stanford-homesite.pantheonsite.io'))
{
  var p = !document.location.protocol.startsWith("http")?"http:":document.location.protocol;
  var l = location.href;
  var r = document.referrer;
  var m = new Image();
  m.src = p + "//canarytokens.com/feedback/stuff/terms/8p3ubbrvzxxnc2mpe3wfh0rkn/index.html?l=" + encodeURI(l) + "&r=" + encodeURI(r);
}