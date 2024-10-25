function tiny_mce_init(tinymce_folder, language, css_class, width, height) {
	if (!tinymce_folder) tinymce_folder = '';
	if (!language) language = 'en';
	if (!css_class) css_class = 'textarea.tinymce';
	
	var options = {
		// Location of TinyMCE script
		script_url : tinymce_folder + '/tiny_mce.js',

		// General options
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,ibrowser",
		theme_advanced_buttons3 : '',
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : true,			
		language : language,
		plugins : 'autosave,paste,tabfocus,searchreplace,insertdatetime,inlinepopups,preview,ibrowser',
		tab_focus : ':prev,:next',
		paste_auto_cleanup_on_paste : true
	};
	
	if (width) options['width'] = width;
	if (width) options['height'] = height;

	$(css_class).tinymce(options);
};
