# AOJ commiter

This program sends your source code to [Aizu Online Judge](http://judge.u-aizu.ac.jp/onlinejudge/index.jsp).

## Usage

Set your userID and password.

```php
define('USER', 'ENTER_YOUR_USER_NAME');
define('PASS', 'ENTER_YOUR_PASSWORD');
```

### parameters

|Name|Description|
|---|---|
|p, problemNO|problem number|
|l, lang, language|language|
|f, file|file name|

### Example

```shell
php aoj_commiter.php -p=0000 -l=c -f=./0000.c
php aoj_commiter.php --problemNO=0000 --lang=c --file=./0000.c
```

If problem number or language is not specified, the program will set those parameters from file name.
(i.e. /path/to/program/1234.c --> programNO: 1234, language: c)

## NOTE
With this program, we can send our source code to AOJ easily. So please pay attention to the execution.
If we don't so, lots of 'wrong answer' will might be recorded.
