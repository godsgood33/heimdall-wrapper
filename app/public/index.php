<?php
require_once dirname(__DIR__).'/src/Config.php';

$conf = new Config(file_get_contents(dirname(__DIR__).'/config/conf.json'));

$user = ($_COOKIE['user'] ?? "");

$hometag = htmlentities(strtolower(str_replace(' ', '-', $conf->getUserHomeTag($user))));
$tag = '/tag/'.$hometag;
if(isset($_GET['tag']) && $_GET['tag']) {
    $tag = '/tag/'.htmlentities(strtolower(str_replace(' ', '-', $_GET['tag'])));
}

?>

<html>

<head>
    <title><?php print $conf->getTitle(); ?></title>
    <link href='/css/style.css' rel='stylesheet' />
    <script src="https://kit.fontawesome.com/f15a79324f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id='categories'>
        <select id='user' onchange='javascript:setCookie("user", this.value);location.reload();'>
            <option value=''>User...</option>
            <?php
                foreach($conf->getUsers() as $u) {
                    $selected = null;
                    if ($user == ucfirst($u)) {
                        $selected = " selected";
                    }
                    print "<option val='$u'{$selected}>".ucfirst($u)."</option>".PHP_EOL;
                }
?>
        </select>
        <ul>
            <?php
foreach($conf->getUserTags($user) as $t) {
    $selected = null;
    $taglink = htmlentities(strtolower(str_replace(' ', '-', $t)));
    if (isset($_GET['tag']) && $taglink == $_GET['tag']) {
        $selected = 'active';
    } elseif (!isset($_GET['tag']) && $taglink == $hometag) {
        $selected = 'active';
    }
    print "<li><a class='myButton {$selected}' href='/?tag={$taglink}'>{$t}</a></li>\n";
}
?>
        </ul>
        <div style='float:right;'>
            <a href='/config.php'><i class='fa-solid fa-gears'></i></a>
        </div>
    </div>
    <iframe id='heimdall'
        src="<?php print $conf->getHeimdallString().$tag; ?>"></iframe>
    <script type='text/javascript'>
        // Set a Cookie
        function setCookie(cName, cValue) {
            document.cookie = cName + "=" + cValue + "; path=/";
        }
    </script>
</body>

</html>