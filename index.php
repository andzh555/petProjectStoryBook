<?php
session_start();
include 'htmlEL/head.php';
head();
require_once 'ConnectDB.php';//adding Connect Class with all DB functions

$localhostDB = new ConnectDB('localhost', 'root', 'root', 'stories');
$localhostDB->connect();
$localhostDB->exec_query("SET NAMES 'utf8mb4'");
?>

<body>
<div class="container">
    <?php
    include 'htmlEL/header.php';
    headerHTML();
    if (isset($_GET['page']) and $_GET['page'] != 0 and $_GET['page'] != '') { //Making pagination grid
        if(is_numeric($_GET['page'])){
            $page = $_GET['page'];
        }else{
            require_once 'htmlEL/alerts/wrongGET.php';
            wrongGET("<center>ERROR:404 'PageNOTfound' WRONG GET REQUEST</center>");
        }
    }
    else {
        $page = 1;
    }
    $notesOnPage = 15;
        $from = ($page - 1) * $notesOnPage;
        $query = "SELECT * FROM storyauthors WHERE id > 0 LIMIT $from,$notesOnPage"; //making query to get data
        $result = $localhostDB->exec_query($query);
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;
        $disablet = ''; //Prepairing disabling function for page switchers
        if ($page != 1) {
            $prevPage = $page - 1;
        } else {
            $prevPage = $page;
            $disablet = 'disablet';
        }

    ?>
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item">
                <?php echo '<a class="page-link ' . $disablet . '" href="?page=' . $prevPage . '"><<</a>'; //dynamic switch on/off
                ?>
            </li>
            <?php
            //Building page list dynamically
            $query = "SELECT COUNT(*) as count FROM storyauthors";
            $resultForCount = $localhostDB->exec_query($query);
            $count = mysqli_fetch_assoc($resultForCount)['count'];
            $pagesCount = ceil($count / $notesOnPage);
            for ($i = 1; $i <= $pagesCount; $i++) {
                if ($page == $i) {
                    echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
            }
            if ($page != $pagesCount) {
                $nextPage = $page + 1;
            } else {
                $nextPage = $page;
                $disablet = 'disablet';
            }
            ?>
            <li class="page-item">
                <?php echo '<a class="page-link ' . $disablet . '" href="?page=' . $nextPage . '">>></a>'; //dynamic switch on/off
                ?>
            </li>
        </ul>
    </nav>

    <div id="wrapper">
        <?php
        $result = '';

        foreach ($data as $elem) {
            $date = date_create($elem['datetime']); //formating date cause we want see it like day,month,year
            $formattedDate = date_format($date, 'd.m.Y H:i:s');
            $result .= '<div class="note"><p>';
            $result .= ' <span class="date">' . $formattedDate . '(GMT+3) </span>';
            $result .= '<span class="name"> ' . $elem['name'] . '</span></p>';
            $result .= '<p>' . $elem['message'] . '</p> </div>';
        }
        echo $result;
        ?>
        <div id="form">
            <?php
            if (isset($_POST['name'])) {
                if (!empty($_POST['name']) and !empty($_POST['message'])) {
                    $name = $localhostDB->queryDef($_POST['name']);
                    $message = $localhostDB->queryDef($_POST['message']);
                    $name = strip_tags($name);
                    $message = strip_tags($message);
                    $_SESSION['name'] = $name;
                    $query = "INSERT INTO storyauthors SET name='$name', datetime= NOW(), message='$message'";
                    $localhostDB->exec_query($query);
                    echo "<meta http-equiv='refresh' content='0'>";
                } else if (!empty($_POST['name']) and empty($_POST['message'])) {
                    require_once 'htmlEL/alerts/storyERROR.php';
                    storyERROR('Please type your story!');
                } else if (empty($_POST['name']) and empty($_POST['message'])) {
                    require_once 'htmlEL/alerts/emptyFORM.php';
                    emptyFORM('Enter your name and type your story!');
                } else {
                    require_once 'htmlEL/alerts/nameERROR.php';
                    nameERROR('Enter your name please!');
                }
            }
            include 'htmlEL/form.php';
            if (isset($_SESSION['name'])) {
                form($_SESSION['name']);
            } else {
                form('');
            }
            ?>


        </div>
    </div>

    <?php
    include 'htmlEL/footer.php';
    footer();
    ?>
</div>
</body>

</html>
