<?php

printf("<pre>\n");
$cmnd = "sudo /bin/mt -f /dev/nst0 status";
printf("\n%s\n",$cmnd);
$ret  = exec($cmnd,$output,$retval);
if ($ret) {
  if (strpos(end($output),"ONLINE")!==FALSE) {
    printf("Tape in onloading\n");
    $cmnd = "sudo /usr/local/bin/ltfs /lto6-1";
    unset($output);
    $ret2 = exec($cmnd,$output,$retval);
    if ($retval==0) {
      printf("Success with %s-%s\n",$ret2,$retval);
    } else if ($retval==1) {
      printf("Already mounted\n");
    } else {
      printf("Fail with %s-%s\n",$ret2,$retval);
      print_r($output);
      exit;
    }
  } else {
    printf("Tape is out going\n");
    exit;
  }
} else {
  printf("Fail with %s\n",$retval);
  print_r($output);
  exit;
}
$cmnd = "grep ^ltfs:/dev/nst0 /etc/mtab";
$ret  = system($cmnd,$retval);

if ($ret) {
  printf("Success with %s<br>\n",$retval);
} else {
  printf("Fail with %s<br>\n",$retval);
}
echo "</pre>\n";
?>
