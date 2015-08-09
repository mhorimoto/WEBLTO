#! /bin/sh
LBLF=/tmp/mkltfslbl.$$
sudo /usr/local/bin/ltfsck /dev/nst0 |& grep Volser > $LBLF
# LTFS16024I Volser (bar code) : LTFS02
LBLN=`awk '{print $6}' $LBLF`
echo $LBLN
sudo /usr/local/bin/ltfs /lto6-1
sudo /bin/echo $LBLN > /lto6-1/LABELNAME
sync;sync;sync
sudo /bin/chmod 444 /lto6-1/LABELNAME
/bin/ls -l /lto6-1/LABELNAME
/bin/rm $LBLF
if [ "$1" = "" ]; then
    exit
elif [ "$1" = "-u" ]; then
    sudo /bin/umount /lto6-1
    exit
elif [ "$1" = "-e" ]; then
    sudo /bin/umount /lto6-1
    sudo /bin/mt -f /dev/nst0 eject
    exit
else
    echo Option Error
    exit
fi
