var system = require('system');
var args = system.args;

var webPage = require('webpage');
var page = webPage.create();

page.addCookie({
  'name'     : 'JSESSIONID',   /* required property */
  'value'    : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',  /* required property */
  'domain'   : 'jira.hh.ru',
  'path'     : '/',                /* required property */
  'httponly' : true,
  'secure'   : false,
  'expires'  : (new Date()).getTime() + (1000 * 60 * 60 * 24)   /* <-- expires in 24 hours */
});

page.addCookie({
  'name'     : 'atlassian.xsrf.token',   /* required property */
  'value'    : 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',  /* required property */
  'domain'   : 'jira.hh.ru',
  'path'     : '/',                /* required property */
  'httponly' : true,
  'secure'   : false,
  'expires'  : (new Date()).getTime() + (1000 * 60 * 60 * 24)   /* <-- expires in 24 hours */
});

page.open(args[1], function (status) {
    if (status !== 'success') {
        console.log('Unable to access network');
    } else {
        var p = page.evaluate(function () {
            return document.getElementsByTagName('html')[0].innerHTML
        });
        var fs = require('fs');
	var path = 'page.html';
	fs.write(path, p, 'w');
    }
    phantom.exit();
});