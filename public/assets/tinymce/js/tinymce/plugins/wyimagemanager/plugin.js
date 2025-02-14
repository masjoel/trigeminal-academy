/*
--------------------------------------------
WebYurt.com - Resource license terms
---------------------------------------------
The Web Yurt TinyMCE Image Manager plugin is free for use in personal website projects.
For use in commercial websites, a donation is required to the PayPal email address: info@webyurt.com

You can modify this resource to your requirements to fit into your own projects, however we do not accept responsibility for any misuse.

We would appreciate a link back to WebYurt.com, in order to help spread the word about us so we can continue our work.

Redistribution, reselling, leasing, licensing, sub-licensing or offering this resource to any third party is strictly prohibited. This includes uploading our resources to another website, marketplace or media-sharing tool, and offering our resources as a separate attachment from any of your work. If you do plan to include this resource on any project that will be sold on a website or marketplace, please contact us first to determine the proper use of our resource.

HOTLINKING is strictly prohibited i.e. you cannot make a direct link to the actual download file for this resource. For any attribution, please link to the page where the resource can be downloaded from on WebYurt.com.

These license terms are subject to change at any time without prior notice.

---------------------------------------------
Regards,
The WebYurt.com Team.
---------------------------------------------
http://www.webyurt.com

*/
tinymce.PluginManager.add('WYImageManager', function(editor, url) {
  
 	//------------------------------------------------
	// OPEN WINDOW
	//------------------------------------------------
	function OpenWYImageManager() {
		var width = window.innerWidth-20;
		var height = window.innerHeight-20;
		if (width > 1800)  { width = 1800; }
		if (height > 1200) { height = 1200; }

		editor.focus(true);

		var fileUrl = editor.settings.pthManager+'images.php?';

		// VERSION 5
		editor.windowManager.openUrl({
			title: "Web Yurt Image Manager",
			url: fileUrl,
			width: width,
			height: height,
			inline: 1,
			resizable: true,
			maximizable: true
		});
	}

 	//------------------------------------------------
	// TOOLBAR BUTTONS
 	//------------------------------------------------
	editor.ui.registry.addButton('WYImageManager', {
		icon: 'browse',
		tooltip: 'Insert file',
		shortcut: 'Ctrl+E',
		onAction: OpenWYImageManager
	});
	editor.addShortcut('Ctrl+E', '', OpenWYImageManager);

 
});