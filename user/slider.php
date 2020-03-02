<?php
    include ('../pdo_connection.php');
    $slider_html='';
    $thumb_html = '';
    $button_html='';
    $folderId=isset($_GET['folderId'])?$_GET['folderId']:'';
    $hidden = (isset($_GET['hidden']) && ((int)$_GET['hidden'] === 1 || (int)$_GET['hidden'] === 0))? (int)$_GET['hidden'] :0 ;
    
    $query="Select imageId, path, filename from images where folderId=? and hide=?";

    $image_count=0;
    $stmt=$pdo->prepare($query);
    $stmt->execute(array($folderId,$hidden));
while( $arr=$stmt->fetch(PDO::FETCH_ASSOC)){
    $active_class = "";
    if(!$image_count) {
        $active_class = 'active';
        $image_count = 1;
    } 
        $image_count++;
        $path=$arr['path'];
    $filename=$arr['filename'];
    $slider_html.="<div id='".$arr['imageId']."'  data-slide-number='$image_count' class='item carousel-item ".$active_class."'>
                   <img src='$path' class='d-block w-100' style='height:500px' class='rounded mx-auto d-block' class='center' alt='$filename'>
                   <div class='carousel-caption'></div></div>";
    $thumb_html.= "<li data-slide='$image_count'>
                    <img src='images/thumbnail/$filename' alt='$filename'></li>";
    $button_html.= "<li data-target='#carouselExampleIndicators' data-slide-to='$image_count' class='$active_class'></li>";
}
    $stmt = null;
?>