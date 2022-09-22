<?php
include_once "../header.php";
include_once "../../includes.php";
if (session_id() == '') {
    session_start();
}
if (!isset($_GET["Id"])) {
    echo "<script>
            location.replace('index.php');
        </script>";
    exit;
}
OrderDetailsManger::Delete(new OrderDetails(Encryption::Decrypt($_GET["Id"])));
?>
<script>
    location.replace('index.php');
</script>