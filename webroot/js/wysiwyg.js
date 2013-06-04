//Croogo.Wysiwyg.Tinymce = {
//
//	setup: function(el, config) {
//		var preset = null;
//		var defaults = {
//		  selector: el
//		};
//		if (config.preset === false) {
//			delete config.preset;
//		} else {
//			if (typeof config.preset == 'undefined') {
//				config.preset = 'standard';
//			}
//			preset = Croogo.Wysiwyg.Tinymce.presets[config.preset];
//			delete config.preset;
//		}
//		$.extend(defaults, preset);
//		$.extend(defaults, config);
//		$.extend(config, defaults);
//		console.log(config);
//	  
//	  tinymce.init(config);
//	}
//
//}

/**
 * This function is called when you select an image file to be inserted in your editor.
 */
Croogo.Wysiwyg.choose = function(url, title, description) {
	if (url == '') return false;
	url = Croogo.Wysiwyg.uploadsPath + url;

	desc_field = window.top.opener.browserWin.document.forms[0].elements[2];
	if (typeof description !== 'undefined') {
		desc_field.value = description;
	}

	title_field = window.top.opener.browserWin.document.forms[0].elements[3];
	if (typeof title !== 'undefined') {
		title_field.value = title;
	}

	field = window.top.opener.browserWin.document.getElementById(window.top.opener.browserField);
	field.value = url;
	
	if (field.onchange != null) {
		field.onchange();
	}
	window.top.close();
	window.top.opener.browserWin.focus();
}

/**
 * This function is responsible for integrating attachments/file browser in the editor.
 */
Croogo.Wysiwyg.browser = function() {
  window.fileBrowserCallback = function(field_name, url, type, win) {
		browserField = field_name;
		browserWin = win;
		window.open(Croogo.Wysiwyg.attachmentsPath, 'browserWindow', 'modal,width=960,height=700,scrollbars=yes');
	}
};