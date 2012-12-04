<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

return array(
	'max_sessions' => 10,
	'timeout' => 30,
	'proxy_refresh_period' => 60,
	'redownload_limit' => 50,
	'debug_delay_min' => 5,
	'debug_delay_max' => 15,
	'user_agents' => array(
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Avant Browser [avantbrowser.com]; iOpus-I-M; QXW03416; .NET CLR 1.1.4322)',
		'Mozilla/5.0 (Macintosh; U; PPC Max OS X Mach-O; en-US; rv:1.8.0.7) Gecko/200609211 Camino/1.0.3',
		'Mozilla/5.0 (X11; U; Linux x86_64; en-GB; rv:1.8.0.4) Gecko/20060608 Ubuntu/dapper-security Epiphany/2.14',

		// Google Chrome
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.19 (KHTML, like Gecko) Chrome/0.4.154.25 Safari/525.19',
		'Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/532.9 (KHTML, like Gecko) Chrome/5.0.307.9 Safari/532.9',
		'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/532.5 (KHTML, like Gecko) Chrome/4.0.249.89 Safari/532.5',

		// IE
		'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)',
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)',
		'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0; .NET CLR 2.0.50727)',
		'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1)',
		'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)',
		'mozilla/4.0 (compatible; msie 7.0; windows nt 5.1; trident/4.0; ...)',
		
		// Firefox
		'Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.5 (like Gecko) (Debian|Debian)',
		'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.1) Gecko/20090715 Firefox/3.5.1',
		'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.1) Gecko/20090716 Ubuntu/9.04 (jaunty) Shiretoko/3.5.1',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.20) Gecko/20081217 Firefox/2.0.0.20',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7',
		'Mozilla/5.0 (Windows; U; Windows NT 5.2; ru; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3 (.NET CLR 3.5.30729)',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.2) Gecko/2008091620 Firefox/3.0.2',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9) Gecko/2008052906 Firefox/3.0',

		// Opera
		'Opera/9.80 (Windows NT 5.1; U; en) Presto/2.5.18 Version/10.50',
		'Opera/9.80 (Windows NT 6.1; U; ru) Presto/2.2.15 Version/10.00',
		'Opera/9.60 (Windows NT 5.1; U; en) Presto/2.1.1',
		'Opera/9.50 (Windows NT 6.0; U; en)',
		'Mozilla/5.0 (Windows NT 5.1; U; en) Opera 8.50',
		'Opera/9.0 (Windows NT 5.1; U; en)',
	),
);