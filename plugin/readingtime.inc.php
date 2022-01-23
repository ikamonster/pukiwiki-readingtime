<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
readingtime.inc.php, v1.02 2019 M.Taniguchi
License: GPL v3 or (at your option) any later version

ユーザーがページを読むのに要するおおよその時間を表示するプラグイン。

1分未満は15秒単位、1分以上60分未満は分単位、60分以上は時間と分単位で表します。
時間は、ページ内の文字数を500（変更可）で割った値を1分とします。
高速化のため文章以外の文字も区別せずに数えてしまうので、あくまで目安と考えてください。

【使い方】
&readingtime();

【使用例】
この記事は約&readingtime();で読めます。
*/

/////////////////////////////////////////////////
// 読了時間表示プラグイン設定（readingtime.inc.php）
if (!defined('PLUGIN_READINGTIME_PERMINUTE')) define('PLUGIN_READINGTIME_PERMINUTE', 500); // 1分間に読める文字数


function plugin_readingtime_inline() {
	return plugin_readingtime_output(func_get_args());
}

function plugin_readingtime_convert() {
	return plugin_readingtime_output(func_get_args(), false);
}

function plugin_readingtime_output($args, $inline = true) {
	list($perMin, $str) = $args;
	$perMin = (float)$perMin;

	$time = plugin_readingtime_gettime($perMin);

	if (!$str) $str = '%TIME%';
	$str = strip_htmltag($str);
	$str = str_replace('%TIME%', $time, $str);

	return ($inline)? '<span class="plugin-readingtime">' . $str . '</span>' : '<p class="plugin-readingtime-message">' . $str . '</p>';
}

function plugin_readingtime_gettime($perMin = PLUGIN_READINGTIME_PERMINUTE, $space = '') {
	global $vars;

	$time = null;

	if (isset($vars['page'])) {
		$page = get_source($vars['page']);

		unset($page[0]);
		$text = '';
		foreach ($page as $row) if (strpos($row, '#') !== 0) $text .= $row;
		$page = preg_replace('(&.+;|\s|\n|\r|\t)', '', $text);

		if ($perMin <= 0) $perMin = PLUGIN_READINGTIME_PERMINUTE;
		$time = mb_strlen($page) / $perMin;

		if ($time <= 0.75) {
			$time = (ceil($time / 0.25) * 15) . $space . '秒';
		} else {
			if ($time < 60) {
				$time = ceil($time) . $space . '分';
			} else {
				$hour = floor($time / 60);
				$min = floor($time % 60);
				$time = number_format($hour) . $space . '時間' . $space . $min . $space . '分';
			}
		}
	}

	return $space . $time . $space;
}
