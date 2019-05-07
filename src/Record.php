<?php

namespace AdairCreative\Searching {
	use SilverStripe\ORM\DataObject;

	/**
	 * @property string $Query
	 * @property int $Count
	 * @property \DateTime $LastSearched
	 */
	class Record extends DataObject {
		private static $table_name = "ACG_Searching_Record";
		private static $db = [
			"Query" => "Varchar(512)",
			"Count" => "Int"
		];

		private static $searchable_fields = [
			"Query"
		];

		private static $summary_fields = [
			"Query",
			"Count",
			"LastSearchString" => "Last Searched"
		];

		public function LastSearchString(): string {
			return $this->LastEdited ? date("d-m-Y", strtotime($this->LastEdited)) : "N/A";
		}
	}
}
