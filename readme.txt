=== GetResponse Sending Platform ===
Contributors: joerunweb
Tags: getresponse, email, newsletter
Requires at least: 4.0.1
Tested up to: 4.5.2
Stable tag: 4.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



This plugin allows users to send an email through the email service GetResponse from the WordPress backend.



== Description ==

This plugin allows users to send an email through the email service GetResponse from the WordPress backend. It does so by
scraping the html from a designated page on the site, and then passing that over to GetResponse based on the options and
campaign that are selected.

Companies that send a weekly or monthly email newsletter through GetResponse will find that this plugin streamlines the
sending process, and can help automate the process of producing a newsletter.

A typical use-case for this plugin might look something like this:
1) You create a new page in WordPress. That page uses a custom template that is essentially an HTML email (your newsletter) with custom info
pulled into it using WordPress loops.
2) You install this plugin and click on the GetResponse Sending Platform menu.
3) You enter your GetResponse info, Message Name, Message Subject, select a Campaign, and select your newly created Email Template Page.
4) You click "Send Message" to send your Email Template Page to the selected Campaign.



== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `getresponse-sending-platform` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your GetResponse API key in the settings area.



== Frequently Asked Questions ==

= How do I get my GetResponse API key? =

If you're having trouble finding your key, reach out to GetResponse and they will provide you with the key. Also see:
https://support.getresponse.com/faq/where-i-find-api-key



== Changelog ==

= 0.5 =
Project is functional.

= 0.1 =
Initial Project. Still in testing phase.



== Features Roadmap ==

Planned Features:

* Scheduled Sending
* Message Send Log
