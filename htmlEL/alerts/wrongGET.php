<?php
function wrongGET($str){
    echo '<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>'.$str.'</strong></div>';
    header("Refresh:2.5; url=index.php?page=");
}