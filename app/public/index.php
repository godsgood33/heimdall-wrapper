<?php
require_once dirname(__DIR__).'/src/Config.php';

$conf = new Config(file_get_contents(dirname(__DIR__).'/config/conf.json'));

$user = ($_COOKIE['user'] ?? "");

$tag = '/tag/'.htmlentities(strtolower(str_replace(' ', '-', $conf->getUserHomeTag($user))));
if(isset($_GET['tag'])) {
    $tag = '/tag/'.htmlentities(strtolower(str_replace(' ', '-', $_GET['tag'])));
}

?>

<html>
    <head>
        <title><?php print $conf->getTitle(); ?></title>
        <link href='/css/style.css' rel='stylesheet' />
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
                    print "<option val='$u'{$selected}>".ucfirst($u)."</option>\n";
                }
                ?>
            </select>
            <ul>
                <?php
                foreach($conf->getUserTags($user) as $t) {
                    $taglink = htmlentities(strtolower(str_replace(' ', '-', $t)));
                    print "<li><a href='/?tag=$taglink'>$t</a></li>\n";
                } ?>
            </ul>
        </div>
        <iframe id='heimdall' src="<?php print $conf->getHeimdallString().$tag; ?>"></iframe>
        <script type='text/javascript'>
            // Set a Cookie
            function setCookie(cName, cValue) {
                    document.cookie = cName + "=" + cValue + "; path=/";
            }
        </script>
    </body>
</html>