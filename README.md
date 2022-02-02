# PukiWiki用プラグイン<br>読了時間表示 readingtime.inc.php

ユーザーがページを読むのに要するおおよその時間を表示する[PukiWiki](https://pukiwiki.osdn.jp/)用プラグイン。

|対象PukiWikiバージョン|対象PHPバージョン|
|:---:|:---:|
|PukiWiki 1.5.3 ~ 1.5.4RC (UTF-8)|PHP 7.4 ~ 8.1|

## インストール

下記GitHubページからダウンロードした readingtime.inc.php を PukiWiki の plugin ディレクトリに配置してください。

[https://github.com/ikamonster/pukiwiki-readingtime](https://github.com/ikamonster/pukiwiki-readingtime)

## 使い方

```
&readingtime();
```

## 使用例

```
このページは約&readingtime();で読むことができます。
```

## 設定

ソース内の下記の定数で動作を制御することができます。

|定数名|値|既定値|意味|
|:---|:---:|:---:|:---|
|PLUGIN_READINGTIME_PERMINUTE|数値|500|1分間に読める文字数|
