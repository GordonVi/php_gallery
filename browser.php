<?PHP

// Browser.php add on for JPG Gallery 1.0
// Version: 1.2

// 1.1 = Added icon.gif support
// 1.2 = Fixed No JPEG in folder icon.gif support
//
//   by: Gordon Virasawmi
// site: http://www.mccanime.com/

// ----------------------------------------


// Set the gallery width.
$gallerywidth=6;

// Set the page header (HTML)
//$pageheader = '<h3 align="center"><b><u>MCCanime.com Photo Galleries / 2004-2010</u></b><br><a href="http://virasawmi.com/photos/MCCAnime.com/gallery.zip">Download entire archive (2.22 gigs)</a></h3>';


// ----------------------------------------

$filert='';

while (is_file($filert."gallery.php") == false) {

$filert=$filert.'../';

   } 

if (is_file($filert.'header.php')) { include $filert.'header.php'; }

echo '<span class="class2"><center>';

 $thumbcount=0;
 
if ($handle = opendir('.')) {
   while (false !== ($file = readdir($handle))) {



       if (substr_count(strtolower($file), '.jpg') == 1) {

           $thumbcount++;

       }

   }

   closedir($handle);

 }

$dirname = array();
$dirtime = array();

if ($handle = opendir('.')) {

  $basecount=0;
  $thumbcount=0;


   while (false !== ($file = readdir($handle))) {

       if ($file != "." && $file != "..") {

       if (is_dir($file)) {


        $dirname[$basecount] = $file;



           $times=0;


         if (is_file($file."/timestamp.txt")) {

           chdir ($file);

           $timestamp=file("timestamp.txt");
           $timestamparr=explode(" ",$timestamp[0]);

           chdir ("..");

           $times=$timestamparr[1];

           } else {

           chdir ($file);

            if (is_file("timestamp.txt")==false) {

//               $fp = fopen("timestamp.txt", "w", 0); #open for writing
//               fputs($fp, microtime()); #write all of $data to our opened file
//               fclose($fp); #close the file

              $timestamparr=explode(" ",microtime());
              $times=$timestamparr[1];


               }

           chdir ("..");

           }

           chdir ($file);

            if (is_file("index.php")==false) {

               $fp = fopen("index.php", "w", 0); #open for writing

               fputs($fp, "<?PHP"."\r\n"); #write all of $data to our opened file
               fputs($fp, "\$filert='';"."\r\n"); 
               fputs($fp, "while (is_file(\$filert.'gallery.php') == false) { "."\r\n"); 
               fputs($fp, "\$filert=\$filert.'../'; "."\r\n"); 
               fputs($fp, "   } "."\r\n"); 
               fputs($fp, " \$thumbcount=0; "."\r\n"); 
               fputs($fp, "if (\$handle = opendir('.')) { "."\r\n"); 
               fputs($fp, "   while (false !== (\$file = readdir(\$handle))) { "."\r\n"); 
               fputs($fp, "   if (substr_count(strtolower(\$file), '.jpg') == 1) {"."\r\n"); 
               fputs($fp, "            \$thumbcount++;"."\r\n"); 
               fputs($fp, "        }"."\r\n"); 
               fputs($fp, "    }"."\r\n"); 
               fputs($fp, "    closedir(\$handle);"."\r\n"); 
               fputs($fp, "  }"."\r\n"); 
               fputs($fp, " if (\$thumbcount>0) {"."\r\n"); 
               fputs($fp, "    include(\$filert.'gallery.php'); "."\r\n"); 
               fputs($fp, "    } else {"."\r\n"); 
               fputs($fp, "    include(\$filert.'browser.php'); "."\r\n"); 
               fputs($fp, "   } "."\r\n"); 
               fputs($fp, "?> "."\r\n"); 

               fclose($fp); #close the file
               }

           chdir ("..");


        $dirtime[$basecount] = $times;


        $basecount++;



        }

   }
   }
   closedir($handle);
  }

echo $pageheader;

echo '<table><tr>';

$tablerow=0;

array_multisort($dirtime, SORT_DESC, $dirname);

for ($a=0; $a<$basecount; $a++) {

           echo '<td align="center"><a href="';
           echo $dirname[$a];
           echo '/">';

  chdir($dirname[$a]);

  if (is_dir("thumb")) {

  $remotedir = $dirname[$a];
  $thumbcount=0;
 
if ($handle = opendir('.')) {
   while (false !== ($file = readdir($handle))) {



       if (substr_count(strtolower($file), '.jpg') == 1) {

           $thumbcount++;

       }

   }

   closedir($handle);

 }

  $galtempthumb=true;
  $genrand = rand(1, $thumbcount);
  $thumbcount=0;

if ($handle = opendir('.')) {
   while ($galtempthumb == true && false !== ($file = readdir($handle))) {


      if (isset($remotedir)) {$filed=$remotedir."/".$file;
                              $filet=$remotedir."/thumb/".$file;
                                } else {
                              $filed=$file;
                              $filet="thumb/".$file;
                             }


       if (substr_count(strtolower($file), '.jpg') == 1) {

           $thumbcount++;

       if ($genrand == $thumbcount) {

           $galtempthumb=false;

           echo "<img border=0 src=";
           echo '"';
           $temp = $filet;
           $temp = str_replace(" ", "%20", $temp);
           echo $temp;
           echo '"';
           echo "><br>";
           } 


       }


   }

   closedir($handle);

 }

//      if (is_file("icon.gif")) { echo '<img border=0 src="'.$filedrt.$dirname[$a].'/'.$remotedir.'/icon.gif"><br>';}
      if (is_file("icon.gif")) { echo '<img border=0 src="'.$remotedir.'/icon.gif"><br>';}

} else {

             
              if (is_file("icon.gif")) {

             echo '<img border=0 src="'.$filert.$dirname[$a].'/icon.gif"><br>';

                } else {

             echo '<img border=0 src="'.$filert.'php.jpg"><br>';

                }


          }


      chdir("..");

           echo str_replace("_", " ", $dirname[$a]).'</a></td>';

       $tablerow++;
       if ($tablerow>$gallerywidth-1) {
          $tablerow=0;
          echo "</tr><tr>";
          }

} 


echo "</tr></table></span></center>";

if (is_file($filert.'footer.php')) { include $filert.'footer.php'; }


?>

