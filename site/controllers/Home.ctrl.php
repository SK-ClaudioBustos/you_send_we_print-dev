<?php
class HomeCtrl extends CustomCtrl {

	protected function run_default($args = array(), $action) {
		switch ($action) {
			case 'sitemap':
				$this->run_sitemap($args);
				break;

			default:
				$this->run_home($args);
		}
		/*if ($action) {
			$this->run_not_found($args);
		} else {
			$this->run_home($args);
		}*/

	}


	protected function run_home($args) {
		$detect = new Mobile_Detect;
		$isMobile = $detect->isMobile();
		$isTablet = $detect->isTablet();

		$title = $this->lng->text('home');
		$meta_title = $this->utl->get_property('home_meta_title', $title);
		$meta_keywords = $this->utl->get_property('home_meta_keywords', "");
		$meta_description = $this->utl->get_property('home_meta_description', "");

		$user_type = 'wholesaler';
		/*$user_type = 'visitor';
		if ($this->app->wholesaler_ok) {
			$user_type = 'wholesaler';
		}*/
		$user_id = 0;
		if ($this->app->user_id) {
			$user_id = $this->app->user_id;
		}
		
		//$isMobile = true;
		//error_log("is mobile: " . var_export($isMobile, true));

		if ($isMobile && !$isTablet) {
			$slides = [];
			$slides_mobile = $this->utl->get_property('home_slideshow_mobile_' . $user_type, array());
		} elseif (!$isMobile && $isTablet) {
			$slides = $this->utl->get_property('home_slideshow_' . $user_type, array());
			$slides_mobile = $this->utl->get_property('home_slideshow_mobile_' . $user_type, array());
		}
		else {
			$slides = $this->utl->get_property('home_slideshow_' . $user_type, array());
			$slides_mobile = [];
		}

		//error_log("mobile: " . var_export($isMobile, true) . " tablet: " . var_export($isTablet, true));
		//error_log("slides: " . print_r($slides, true));
		//error_log("slides_mobile: " . print_r($slides_mobile, true));
		
		

		$info = $this->utl->get_property('home_info_' . $user_type, array());
		$banner = $this->utl->get_property('home_banner', array());
		$tags_menu = $this->utl->get_property('home_tags', array());
		
		$promos = $this->utl->get_property('home_promos_' . $user_type, array());

		$products = $this->utl->get_property('home_products_' . $user_type, array());
		$experiences = $this->utl->get_property('home_experience', array());
		$slide_speed = $this->utl->get_property('home_slideshow_speed', 6000);
		$what_we_do2 = $this->utl->get_property('home_what_we_do', array());

		$what_we_do = new Document();
		$what_we_do->retrieve_by(
				array('document_key', 'lang_iso'),
				array('what_we_do', $this->cfg->setting->language)
			);

		$page_args = array(
				'meta_title' => $meta_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'title' => $title,
				'body_id' => 'body_home',
				'user_type' => $user_type,
				'slides' => $slides,
				'slides_mobile' => $slides_mobile,
				'info' => $info,
				'banner' => $banner,
				'tags_menu' => $tags_menu,
				'promos' => $promos,
				'products' => $products,
				'experiences' => $experiences,
				'what_we_do' => $what_we_do,
				'what_we_do2' => $what_we_do2,
				'slide_speed' => $slide_speed,
				'user_id' => $user_id,
			);

		//var_dump($this->tpl->get_view('home/home', $page_args, true));die;
		$page_args = array_merge($page_args, $this->tpl->get_view('home/home', $page_args));
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}
		$this->tpl->page_draw($page_args, 'home');
	}

	protected function run_sitemap($args) {
		$title = $this->lng->text('home:sitemap');
		$page_args = array(
			'meta_title' => $title,
			'title' => $title,
			'body_id' => 'body_sitemap',
		);

		$page_args = array_merge($page_args, $this->tpl->get_view('home/sitemap', $page_args));
		if ($args) {
			$page_args = array_merge($page_args, $args);
		}
		$this->tpl->page_draw($page_args);

	}

}
