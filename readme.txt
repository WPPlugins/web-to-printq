=== Web To PrintQ - Product Designer ===
Contributors: CloudLab AG
Donate link: http://en.web-to-printq.com/contact/
Tags: printq,personalization,designer,web to print, printing,woocommerce
Requires at least: 4.4
Tested up to: 4.7.4
Stable tag: 1.2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

PrintQ Designer is a WooCommerce extension for creating awesome personalized products

== Description ==

<h4>Pro version</h4>
<ul>
	<li><a href="http://en.web-to-printq.com/wp-designer/" target="blank">Pro</a></li>
</ul>

Web To PrintQ is a woocommerce extension which allows your customers to personalize any type of print product: from business cards, brochures, flyers, envelopes, 
postcards to wedding cards, packages, large format print, labels, T-shirts, photo books and many more.
Our online design tools are fully responsive and work on any mobile device.

Our editor includes:

*   HTML5 based product editor
*   3D Preview
*   Print ready production files
*   Easy to create personalization templates (Drag&Drop)
*   Mobile friendly online editor
*   Full support and helpdesk
*   Facebook, Instagram, Unsplash integration
*   Curved text tool
*   Opacity for texts, images and cliparts
*   Google Fonts
*   Easy to use color picker

Interested in more functionalities and options? Contact us on <a href="http://en.web-to-printq.com/wp-designer/" target="blank">Web to print </a>

Check out our 3D Product Designer:

https://www.youtube.com/watch?v=xPqmz0swvRw

== Installation ==

<h4>Installation</h4>
1. Make sure you have WooCommerce plugin installed and active before activating this plugin
2. Upload the plugin files to the `[wordpress installation dir]/wp-content/plugins/printq_designer` directory, or install the plugin through the WordPress plugins screen directly by searching for PrintQ Designer.
3. Activate the plugin through the 'Plugins' screen in WordPress
4. Use the WooCommerce->Settings->PrintQ Designer screen to configure the plugin

<h4>Use</h4>
1. Navigate to Admin Screen and create a new template by selecting "PrintQ Templates" -> "Add new" from the left hand side menu
2. Enter a template title, width and height of the drawing canvas and click "Edit template" button( Please be aware that by changing the canvas sizes after you have edited the template you might get weird output ). 
A popup will open and will allow you to personalize the template.
	* Here, you can add backgrounds, shapes, text areas and draw predefined and custom shapes.
	* Also, you can add new pages, delete existing ones or switch to another page by selecting the dropdown arrow located in the left top side of the popup and then by choosing the needed action
	( "+" sign for adding new page, "-" for deleting current page or one of the page items for changing currently editing page ).
	* Our plugin provides with an "undo/redo" functionality, so don't be afraid if you changed your template and all the things are messy. Just click on the "Undo" or "Redo" buttons to revert the page state.
	* You can also (un)lock the blocks in template and prevent accidental move, resize and rotate by clicking on the "Blocks" menu item and (un)checking desired option.
	* You can add your own images to designer either by "drag&drop" or by clicking the cloud button in the bottom right corner. All uploaded images will appear in the bottom toolbar. 
	Further more, you can delete these images or place them in your design by "drag&drop".
	* Our plugin supports social media integration( Facebook and Instagram ), so all you have to do to enable this feature is to configure your apps and fill in the credentials in the settings page of our plugin and you are free to use images imported from social media.
3. When you finish editing the template, click "Save" button. The popup window will close.
4. Don't forget to click "Publish"/"Update" button to save your changes.
5. Navigate to WooCommerce products screen and add new product or select one of the existing ones.
	* The product type must be "Simple Product" and non-downloadable.
	* Configure your product according to your needs(price, inventory etc.).
	* Click on the "PrintQ Personalization" tab.
	* Check "Enable" and select one of the templates you created earlier and save/update product.
6. Navigate to product page in frontend and click on the "Personalize", create the desired design and click "Add to cart" button.
7. Complete the order.
8. Navigate to Admin Screen -> WooCommerce -> Orders and click on the previously created order.
9. In the order item list you should see a list of preview images for the personalized product. Click on them for a better view/download.
If you have the basic license, then you should see a "Download PDF" link. Click on it and a download prompt will ask you to save the PrintReady PDF.
10. That's it. If you have problems using our plugin or you have any suggestion of making it better, please let us know.





== Frequently Asked Questions ==

= Does the Designer plugin require WooCommerce =

Yes. You must have WooCommerce installed.

= Is Web To PrintQ free of charge to use =

Yes and no. This plugin is free-of-charge to install and configure products, but you will only have preview images of what your clients configure and order.
However, if you want print-ready PDF and 3D Preview features you have to visit us <a href="http://en.web-to-printq.com/wp-designer/" target="blank">here</a>

= My file upload does not work =

Please check that the [wp_install_dir]/wp-content/uploads/pqd folder exists and make sure that the webserver user has write permissions
Also, please make sure there is a line in wp-config.php with : define("FS_METHOD", 'direct');

= Customized PDFs are not generated =

Please visit us <a href="http://en.web-to-printq.com/wp-designer/" target="blank">here</a> for further details.

= No 3D model provided =

Please visit us <a href="http://en.web-to-printq.com/wp-designer/" target="blank">here</a> for further details.

= Facebook integration is not working =

* First step is to have a Facebook App created. If you haven't created on yet, you can go to https://developers.facebook.com and create one.
* Then make sure that you go to PrintQ Designer settings page ( WP admin area -> WooCommerce -> Settings -> PrintQ )
and enter the facebook app id in *App ID* field under *Facebook* section.
* The last step is to make sure that you entered your website domain name in Facebook App settings page ( e.g: for http://www.your-site-url.com/blog  you should enter your-site-url.com ).
There is also an info message on plugin settings page which will show you the exact domain name to use.

= Instagram integration is not working =

* Make sure you have an Instagram client created. You can create one here: https://www.instagram.com/developer/
* Make sure you entered right redirect URI into *Valid redirect URIs* field under *Security* tab
* Enter the *Client ID* and *Client Secret* in PrintQ Designer settings page under *Instagram* section

= Unsplash backgrounds do not work =

* Make sure you have an Unsplash application created. You can create one here: https://unsplash.com/oauth/applications/new
* Make sure you entered right redirect URI into *Redirect URI* field
* Enter the *Unsplash ID* in PrintQ Designer settings page under *Unsplash* section
There is also a helper message which will provide you the redirect uri to enter in application edit page

== Screenshots ==

1. Custom background, svg, text
2. Responsive view
3. Backend order item details
4. Custom rotate, expanded sidebar
5. Multiple pages
6. Pdf Result
7. 3D preview sample 1
8. 3D preview sample 2
9. 3D preview sample 3

== Changelog ==

= 1.2.6 =
* Added Arial font
* WooCommerce 3.0.0 fix
* Various bug fixes

= 1.2.5 =
* Fix for nonlogged users image gallery

= 1.2.4 =
* Added compatibility with PHP7

= 1.2.3 =
* Fix for cart product preview save

= 1.2.2 =
* Various bug fixes

= 1.2.1 =
* Added helpers, static blocks, various bug fixes

= 1.1.0 =
* Added user images

= 1.0.0 =
* Initial version

== Upgrade Notice ==

= 1.2.4 =
* Added compatibility with PHP7

= 1.1.0 =
Added user images

== Bugs & Sugestions ==

If you discovered a bug or have any sugestions regarding improvements of this plugin please visit us <a href="http://printq.eu/contact" target="blank">here</a> and leave us a message.
