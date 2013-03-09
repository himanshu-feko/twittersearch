<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MoolcodeTweetTest</title>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
<script>
  $(function() {
    $( "#dialog" ).dialog({
      autoOpen: true,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });
  });
  </script>
</head>
<body>
 
<div id="dialog" title="Message by Himanshu">
  <p>This is the test code for twitter API by Himanshu Srivastava and the code is free for every one. If some one want to share some knowledge with me then he/she is free to talk to me @ "himanshu@himanshusrivastava.in"</p>
</div>
<div id="header"><a href="http://himanshusrivastava.in"><center><img src="logo.png" width="300" height="80" border="0" /></center></a></div>
<div id="container" style="width:550px;margin-left:auto;margin-right:auto;">
 
<?php
// Turn off all error reporting
error_reporting(0);
// The require_once statement will check if the file has already been included, and if so, not include (require) it again.
require_once('search.php');
 
//Search API Script
$searchtag=$_GET['query'];
 
if($_GET['query']==''){
$searchtag = 'Twitter Search API';}
$search = "http://search.twitter.com/search.atom?lang=en&page=1&rpp=50&src=hash&q=".$searchtag."";
 
// CURL implementation
// create a new cURL resource into tw
$tw = curl_init();
// set URL an option for a cURL transfer
curl_setopt($tw, CURLOPT_URL, $search);
//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
curl_setopt($tw, CURLOPT_RETURNTRANSFER, TRUE);
// grab URL and pass it to the browser
$twi = curl_exec($tw);
//Creates a new SimpleXMLElement object
$search_res = new SimpleXMLElement($twi);
 
echo "<h3>Search results for '".$searchtag."'</h3>";
echo "<div style='border-bottom:#000000 thin dotted'></div>";
 
## Echo the Search Data
//foreach is used for iterate
foreach ($search_res->entry as $twit1) {
 
$description = $twit1->content;
 
// preg_replace to perform a regular expression search and replace
//#ise is used for phototagging 
$description = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\50\" >@\\150</a>'", $description); 
// The \w RegExp metacharacter is used to find a word character. 
//\n\r\t means new line,carriage return, horizontal tab respectivily
$description = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\50\" >\\150</a>'", $description);
$description = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\50\" >\\150</a>'", $description);
 
// strip_tags used for strip HTML and PHP tags from a string"< >"
$retweet = strip_tags($description);
//startotime is used for parse about any English textual datetime description into a Unix timestamp
$date =  strtotime($twit1->updated);
//date is a format of local time/date
$dayMonth = date('d M', $date);
$year = date('y', $date);
$message = $row['content'];
//theDate is for startdate and date only is used for end date.
$datediff = date_diff($theDate, $date);
 
$message = $row['content'];
 
echo "<div class='user'><a href=\"",$twit1->author->uri,"\" target=\"_blank\"><img border=\"0\" width=\"48\" class=\"twitter\" src=\"",$twit1->link[1]->attributes()->href,"\" title=\"", $twit1->author->name, "\" /></a>\n";
echo "<div class='text'>".$description."<div class='description'>From: ", $twit1->author->name," <a href='http://twitter.com/home?status=RT: ".$retweet."' target='_blank'><img src='retweet.png' style='border:none;' /></a></div><strong>".$datediff."</strong></div><div class='clear'></div></div>";
 
}
 
// close cURL resource, and free up system resources
curl_close($tw);
 
?>
</div>
<div id="footer"><center><a href="http://himanshusrivastava.in/contact-me">MyFirstTweetApp</a> | <a href="http://himanshusrivastava.in">Home</a></center></div>
 
</body>
</html>
