<?php
echo "<pre>\n";
$cmnd = "grep ^ltfs:/dev/nst0 /etc/mtab";
$pp  = popen($cmnd,"r");
$ret = fread($pp,2096);
pclose($pp);
if ($ret) {
  //
  // READ TAPE LABEL
  $fp = fopen("/lto6-1/LABELNAME","r");
  if ($fp===false) {
    printf("Illegal Tape\n");
    exit;
  }
  $lblname = trim(fgets($fp));
  fclose($fp);
  if ($lblname=="") {
    printf("Empty Tape LABEL\n");
    exit;
  }
  printf("Success\n%s\n",$ret);
  list($devname,$mountpoint,$others) = explode(" ",$ret);
  printf("%s\n",$mountpoint);
  $cmnd = sprintf("/bin/df -P %s | grep %s",$mountpoint,$mountpoint);
  $pp  = popen($cmnd,"r");
  $ret = fread($pp,2096);
  pclose($pp);
  printf("%s\n",$ret);
  $devname    = strtok($ret," \n\t");
  $fullsize   = strtok(" \n\t");
  $usedsize   = strtok(" \n\t");
  $remainsize = strtok(" \n\t");
  $capa       = strtok(" \n\t");
  $mp         = strtok(" \n\t");

  printf("lbl=:%s:\ndev=%s\nfull=%d\nused=%d\nremain=%d\ncapa=%s\nmountpoint=%s\n",
	 $lblname,$devname,$fullsize,$usedsize,$remainsize,$capa,$mp);
} else {
  printf("Not mounted\n");
}
echo "</pre>\n";
?>
