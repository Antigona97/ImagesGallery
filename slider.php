<?php 
    include "pdo_connection.php";
    
    $folderId=$_SESSION['folderId'];
;   $image_count=0;
    $slider_html='';
    $thumb_html = '';
    $button_html='';
    $qry="Select path, filename from images where folderId= :folderId";
    $stmt=$pdo->prepare($qry);
    $stmt->bindValue(':folderId', $folderId);
    $stmt->execute();
    while( $arr=$stmt->fetch(PDO::FETCH_ASSOC)){
        $active_class = "";
        if(!$image_count) {
            $active_class = 'active';
            $image_count = 1;
        } 
          $image_count++;
          $path=$arr['path'];
          $filename=$arr['filename'];
          $slider_html.="<div class='item carousel-item ".$active_class."'>";
          $slider_html.="<img src='$path' class='d-block w-100' style='height:500px' class='rounded mx-auto d-block' class='center' alt='$filename'>";
          $slider_html.="<div class='carousel-caption'></div></div>";
          $thumb_html.= "<img src='images/thumbnail/$filename' alt='$filename'>";
          $button_html.= "<li data-target='#carouselExampleIndicators' data-slide-to='$image_count' class='$active_class'></li>";
    }
    $stmt = null;
?>