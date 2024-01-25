<?php

if(isset($_POST['config']) && $_POST['config']) {
    file_put_contents(dirname(__DIR__).'/config/conf.json', $_POST['config']);
}

?>

<html>

<head>
    <title>Config Update</title>
</head>

<body>
    <form method='post' action='config.php'>
        <input type='submit' name='submit' value='Save' />&nbsp;&nbsp;<a href='/' name='cancel'>Home</a><br /><br />
        <textarea name='config' rows='50' cols='100'><?php print file_get_contents(dirname(__DIR__).'/config/conf.json');?></textarea>
    </form>
</body>
</html>