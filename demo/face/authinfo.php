<?php
require '../../vendor/autoload.php';

use evondu\wechat\WeChatClient;

date_default_timezone_set('PRC');

$config = include("../config/qiyi.php");
$client = new WeChatClient($config);
$authinfo = $client->face->getAuthinfo([
    "store_id"      => "S000001",
    "store_name"    => "测试店铺1",
    "device_id"     => "D000001",
    "rawdata"       => "AwKaPMiwSGp4u9hiEfVw7xdeJ8vPdzsBeRaFC5kg7BDo93or2F2T49aoQLXWnn1tKN+sN/fSIXNbXB+Sa9R5EoRiedifPq8+lCEsHiIvTZnRS1+8REGCHlG2QWy7eKFyH2CFRmbVglmMGwvsK/nl8dOaaQXe/COKTz5Bw9rRpyVuJoRBqAItx2Fn6RStvEqyY83tNrsqDmZ6X+sLCaZcktWaLi83qgswLkDVXJqoXk/HFOZ0oxGn0TGJvIxWWhyp4enecaBs9YcTbS0A34/PZnwo1HtrG9HC+iPB48Dlto0KjjcXLV9OW4VuNFL14jKciG06mGAs2WRjWb38V7EmcqIz6W9MMwox5kFPVbTc+GZYVqf9NezXlOSpPErsfyDwFI3FDQvUSGA9LkIWTfp6Q9ZyiEpqHcVoSi0gMuQUCnQEg5cB2sdo917sAROGcTHEanwkOJhFzCQ5FPHw3Pa81x/uiczOcOY4HvCo2c1+Lh8vFjPEbYnSDExbFwcGxD2AqZjFPJA9DecCAxnEF9hMb6VLzJ4AvjFY7SGrHS89iNAM2jCMcC2mOUgNfMf34ZidcQ0ElZHzgQo7RR3lKrprk3D7XL5dl1ZZtgU=",
]);

var_dump($authinfo);