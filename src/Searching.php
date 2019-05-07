<?php

namespace AdairCreative {
    use AdairCreative\Searching\Record;
    use SilverStripe\ORM\ArrayList;
    use AdairCreative\Searching\TermLink;

	class Searching {
		private static function convertQuery(string $query): string {
			return strtolower(trim($query));
		}

		private static function recordQuery(string $query) {
			$recordQuery = Searching::convertQuery($query);

			$record = null;
			if ($record = Record::get()->filter("Query", $recordQuery)->first()) {
				$record->Count++;
			}
			else {
				$record = new Record();
				$record->Query = $recordQuery;
				$record->Count = 1;
			}

			$record->LastSearched = date("Y-m-d");
			$record->write();
		}

		/**
		 * @param string|string[] $from
		 * @param string|string[] $fieldName
		 */
		public static function search($from, $fieldName, string $query, TermLink &$term = null, bool $useSubstitute = false): ArrayList {
			$recordQuery = Searching::convertQuery($query);
			$term = TermLink::get()->filter("Term", $recordQuery)->first();

			if ($useSubstitute && $term != null && $term->Type == 0) $recordQuery = $term->Substitute;

			Searching::recordQuery($query);

			$models = [];
			if (is_array($from)) $models = $from;
			else $models = [$from];
			
			$return = new ArrayList([]);

			$index = 0;
			foreach ($models as $model) {
				if ($res = $model::get()->filter((is_array($fieldName) ? (count($fieldName) > $index ? $fieldName[$index] : $fieldName[0]) : $fieldName) . ":PartialMatch", $recordQuery)->toArray()) $return->merge($res);
				
				$index++;
			}
			
			return $return;
		}
	}
}


