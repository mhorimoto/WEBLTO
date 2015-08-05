# LTO Drive Control Over the http

C130Tに塔載されているLTOドライブのテープ状態や残容量などをhttpによる問合せでそれに答える。

# 判定方法

## テープ挿入の有無確認

    sudo mt -f /dev/nst0 status

コマンドにより

    SCSI 2 tape drive:
    File number=0, block number=0, partition=0.
    Tape block size 0 bytes. Density code 0x5a (no translation).
    Soft error count since last status=0
    General status bits on (41010000):
     BOT ONLINE IM_REP_EN

という応答の最後の行のONLINEを確認します。

## mountの有無確認

    grep ^ltfs:/dev/nst0 /etc/mtab

コマンドによってmount pointの有無がわかります。  
もし、mountされていたらdfコマンドで容量を調べます。

