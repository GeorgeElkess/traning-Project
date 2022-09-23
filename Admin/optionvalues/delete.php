<?php
if (session_id() == '') {
    session_start();
}
include_once "../header.php";
include_once "../../includes.php";
if (!isset($_GET["Id"])) {
    echo "<script>
            location.replace('index.php');
        </script>";
    exit;
}
OptionValuesManger::Delete(new OptionValues(Encryption::Decrypt($_GET["Id"])));
?>
<script>
    location.replace('index.php');
</script>