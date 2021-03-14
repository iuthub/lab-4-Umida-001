<?php
$playlist = $_REQUEST['playlist'];
$shuffle = $_REQUEST['shuffle'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Viewer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="http://www.cs.washington.edu/education/courses/cse190m/09sp/labs/3-music/viewer.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <div id="header">

    <h1>190M Music Playlist Viewer</h1>
    <h2>Search Through Your Playlists and Music</h2>
   </div>
   <div id="listarea">
      <?php
      $files = [];
      if (isset($shuffle)&& $shuffle&& $shuffle !=NULL && $shuffle !="")
      {
          $shuffle = "songs/". $shuffle;
          if($file){
              while(!feof($file)) {

                  $string = trim(fgets($file));
                  if (preg_match("/(\.mp3)$/", $string))
                      $files[] = "songs/" . $string;

              }
              shuffle($files);

          }
      }
      else{
          $files= glob("songs/*.mp3");
      }

      if (isset($playlist) && $playlist && $playlist != NULL && $playlist != "")
      {
      $playlist = "songs/" . $playlist;
      $file = fopen($playlist,"r");
      if ($file)
      {
          while(!feof($file)) {
              $string = trim(fgets($file));
              if (preg_match("/(\.mp3)$/", $string))
                  $files[] = "songs/" . $string;
          }
          fclose($file);
      }
      ?>
          <button onclick="history.go(-1);">Back </button>
          <?php
      }else {
          $files = glob("songs/*.mp3");
      }
      foreach ($files as $file){
          $filename=basename($file); ?>
        <ul>
            <li class="mp3item">
           <a href="<?= $file ?>"><?= $filename ?>
                   <?php
                   $size=filesize(trim($file));
                   if($size <1023){
                       $size= round($size, 2);
                       print(" " . $size . "b");
                   }
                   elseif ($size>1023 && $size <1048575){
                       $size/=1024;
                       $size=round($size, 2);
                       print(" " . $size . "Kb");
                   }
                   elseif ($size>1048576){
                       $size=$size/pow(1024, 2);
                       $size=round($size, 2);
                       print(" " . $size . "Mb");
                   }
                   ?>
               </a>
             </li>
          </ul>
      <?php }
          if (!isset($playlist) || !$playlist || $playlist == NULL || $playlist == "")
          $files = glob("songs/*.m3u");
         foreach ($files as $file){
      $filename = basename($file);  ?>
      <ul>
          <li class= "playlistitem">
              <a href="<?= $file ?>"><?= $filename ?></a>
          </li>
      </ul>
      <?php } ?>
    </div>
</body>
</html>