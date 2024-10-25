<?php
class LangCtrl extends SystemCtrl {

	public function run($args) {

		$expires = 31536000;
		header("Pragma: public");
		header("Cache-Control: maxage=" . $expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT');
		header('content-type:text/javascript;charset=utf-8');

		echo 'var lang_tmp = {}; if (typeof lang !== "undefined") { lang_tmp = lang; } ';
		echo 'var lang = ' . json_encode($this->cfg->lang->get_lang_texts()) . ';';
		echo 'for (var prop in lang) { lang_tmp[prop] = lang[prop]; } lang = lang_tmp;';

		echo 'if (typeof(lng_text) !== "function") { ';
		echo 'var lng_text = function(prop) { ';
		echo 'if (!prop) { return ""; } ';
		echo 'return (typeof lang[prop] === "undefined") ? "{" + prop.substr(0, 11) + "»}" : lang[prop]; }; }';

	}

}
?>
