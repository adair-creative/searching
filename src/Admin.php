<?php

namespace AdairCreative\Searching {
	use SilverStripe\Admin\ModelAdmin;

	class SearchingAdmin extends ModelAdmin {
		private static $url_segment = "searching-data";
		private static $menu_title = "Searching";
		private static $menu_icon_class = "font-icon-search";
		private static $managed_models = [
			Record::class,
			TermLink::class
		];
	}
}
