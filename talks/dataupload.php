<?php

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

$sFileName = $_FILES['upload_file']['name'];
$sFileType = $_FILES['upload_file']['type'];
$sFileSize = bytesToSize1024($_FILES['upload_file']['size'], 1);
$source = $_FILES['upload_file']['tmp_name'];
$path = './upload/';
$tname = $_FILES['upload_file']['name'];
$tname = str_replace(' ', '-', $tname);
$tname = preg_replace('/[^A-Za-z0-9\-\.\_]/', '', $tname);
$dFileName = preg_replace('/-+/', '-', $tname);
$destination = $path . $dFileName;
//$destination = $path . $_FILES['upload_file']['name'];
$error = "";

// CHECK IF FILE ALREADY EXIST
if (file_exists($destination)) {
  $error = "File \"" . $sFileName . "\"" . " already exist.";
}

// ALLOWED FILE EXTENSIONS
if ($error == "") {
  $allowed = ["ppt", "pptx", "avi", "mov", "mpeg", "mp4", "pdf", "jpg", "jpeg", "png", "gif"];
  $ext = strtolower(pathinfo($_FILES["upload_file"]["name"], PATHINFO_EXTENSION));
  if (!in_array($ext, $allowed)) {
    $error = "$ext file type not allowed - " . $_FILES["upload_file"]["name"];
  }
}

// FILE SIZE CHECK
if ($error == "") {
  // 1,000,000 = 1MB
  // if ($_FILES["upload_file"]["size"] > 1073741824) {
  if ($sFileSize > 1073741824) {
    $error = $_FILES["upload_file"]["name"] . " - file size too big!";
  }
}

// ALL CHECKS OK - MOVE FILE
if ($error == "") {
  if (!move_uploaded_file($source, $destination)) {
    $error = "Error moving $source to $destination";
  }
}

// ERROR OCCURED OR OK?
if ($error == "") {
echo <<<EOF
<p>Your file: {$sFileName} has been uploaded OK.</p>
<p>Type: {$sFileType}</p>
<p>Size: {$sFileSize}</p>
<p>Destination: https://sdm.lbl.gov/snta2020/talks/{$destination}</p>
EOF;
} else {
echo <<<EOF
<p>Error: {$error}</p>
<p>Your file: {$sFileName}</p>
<p>Type: {$sFileType}</p>
<p>Size: {$sFileSize}</p>
EOF;
}
