<?php
function arr2xml($data, $root = true) {
	$str = '';
	if ($root)
		$str .= '<?xml version="1.0" encoding="UTF-8"?><xml>';
	foreach ($data as $key => $val) {
		$key = preg_replace('/\[\d*\]/', '', $key);
		if (is_numeric($key)) {
			$key = "item" . $key;
		}
		if (is_array($val)) {
			$child = arr2xml($val, false);
			$str .= "<$key>$child</$key>";
		} else {
			if (preg_match('/[<\/>]/', $key)) {
				$str .= "<$key><![CDATA[$val]]></$key>";
			} else {
				$str .= "<$key>$val</$key>";
			}
		}
	}
	if ($root)
		$str .= "</xml>";
	return $str;
}
