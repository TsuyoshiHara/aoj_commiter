<?php
define('URI', 'http://judge.u-aizu.ac.jp/onlinejudge/servlet/Submit');
define('USER', 'ENTER_YOUR_USER_NAME');
define('PASS', 'ENTER_YOUR_PASSWORD');

$_params = getParams();
$_result = submit($_params);

var_dump($_result);

function getParams()
{
    $_short_opt = 'p:l:f:';
    $_long_opt  = array('problemNO:', 'language:', 'lang:', 'file:');

    $_input = getopt($_short_opt, $_long_opt);

    $_problem_no = null;
    $_language   = null;
    $_file_name  = null;

    foreach ($_input as $_key => $_value) {
        if ($_key == 'p' || $_key == 'problemNO') {
            $_problem_no = $_value;
        } elseif ($_key == 'l' || $_key == 'language' || $_key == 'lang') {
            $_language   = strtolower($_value);
        } elseif ($_key == 'f' || $_key == 'file') {
            $_file_name = $_value;
        }
    }

    if (!$_file_name) {
        printf("Please set file name\n");
        exit;
    }

    if ($_language === null) {
        $_language = getLang($_file_name);
    }

    if ($_problem_no === null) {
        $_problem_no = getProblemNO($_file_name);            
    }

    $_source = getSourceCode($_file_name);

    $_result = array(
        'problemNO'  => $_problem_no,
        'language'   => $_language,
        'sourceCode' => $_source
    );

    return $_result;
}

function getProblemNO($_file_name)
{
    preg_match('/(.*)\/([0-9a-zA-Z]+)\.(.+)/', $_file_name, $_match);
    return $_match[2];
}

function getLang($_file_name)
{
    $_temp = explode('.', $_file_name);
    return $_temp[count($_temp)-1];
}

function getSourceCode($_file_name)
{
    if (!file_exists($_file_name)) {
        printf("%s does not exists!\n", $_file_name);
        exit;
    }
    return file_get_contents($_file_name);
}

function submit($_info)
{
    $LANG = array(
        'c'          => 'C',
        'c++'        => 'C++',
        'java'       => 'JAVA',
        'c++11'      => 'C++11',
        'c#'         => 'C#',
        'd'          => 'D',
        'ruby'       => 'Ruby',
        'python'     => 'Python',
        'python3'    => 'Python3',
        'php'        => 'PHP',
        'javascript' => 'JavaScript'
    );

    $_parameter = array(
        'userID'     => USER,
        'password'   => PASS,
        'problemNO'  => $_info['problemNO'],
        'language'   => $LANG[$_info['language']],
        'sourceCode' => $_info['sourceCode']
    );

    $_ch = curl_init(URI);

    curl_setopt($_ch, CURLOPT_POST, true);
    curl_setopt($_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($_ch, CURLOPT_POSTFIELDS, http_build_query($_parameter));

    $_result = curl_exec($_ch);

    curl_close($_ch);

    return $_result;
}