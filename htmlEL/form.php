<?php
function form($str){
    if(!empty($str)){
        echo '   <form action="" method="POST">
                <p><input name="name" class="form-control" placeholder="Your name"
                          value="'.$_SESSION['name'].'"></p>
                <p><textarea name="message" class="form-control" placeholder="Your story"
                             value=""></textarea>
                </p>
                <p><input name="sent" type="submit" class="btn btn-info btn-block" value="Save"></p>
            </form>';
    }else{
        echo  '<form action="" method="POST">
                <p><input name="name" class="form-control" placeholder="Your name"
                          value=""></p>
                <p><textarea name="message" class="form-control" placeholder="Your story"
                             value=""></textarea>
                </p>
                <p><input name="sent" type="submit" class="btn btn-info btn-block" value="Save"></p>
            </form>';
    }
}
