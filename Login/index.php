<?php
include_once "../models/user.php";
if(session_id()==''){
    session_start();
    session_destroy();
}
