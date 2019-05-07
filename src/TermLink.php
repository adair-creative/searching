<?php

namespace AdairCreative\Searching {
	use SilverStripe\ORM\DataObject;
    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\TreeDropdownField;
    use SilverStripe\Forms\LiteralField;

	/**
	 * @property string $Term
	 * @property int $Type
	 * @property string $Substitute
	 * 
	 * @method SiteTree Redirect()
	 */
	class TermLink extends DataObject {
		private static $table_name = "ACG_Searching_TermLink";
		private static $db = [
			"Term" => "Varchar(512)",
			"Type" => "Int",
			"Substitute" => "Varchar(512)"
		];

		private static $has_one = [
			"Redirect" => SiteTree::class
		];

		private static $searchable_fields = [
			"Term"
		];

		private static $summary_fields = [
			"Term",
			"getTypeName" => "Type"
		];

		private static function getJavascript() {
			return '';
		}

		public function getTypeName() {
			return $this->Type == 0 ? "Substitute" : "Redirect";
		}

		public function onAfterWrite() {
			parent::onAfterWrite();

			$recordTerm = strtolower(trim($this->Term));
			if ($recordTerm != $this->Term) {
				$this->Term = $recordTerm;
				$this->write();
			}
		}

		public function getCMSFields() {
			$fields = parent::getCMSFields();
			$fields->addFieldsToTab("Root.Main", [
				TextField::create("Term", "Term"),
				DropdownField::create("Type", "Type", [
					0 => "Substitute",
					1 => "Redirect"
				])
					->addExtraClass("acg-searching-termlink-type")
					->setAttribute("onchange", 'jQuery(".acg-searching-termlink").addClass("hidden").filter(".field-" + this.value).removeClass("hidden")'),
					
				TextField::create("Substitute", "Substitute")
					->addExtraClass("acg-searching-termlink field-0" . ($this->Type != 0 ? " hidden" : "")),

				TreeDropdownField::create("RedirectID", "Redirect", SiteTree::class)
					->addExtraClass("acg-searching-termlink field-1" . ($this->Type != 1 ? " hidden" : "")),

				LiteralField::create("", TermLink::getJavascript())
			]);

			return $fields;
		}
	}
}
