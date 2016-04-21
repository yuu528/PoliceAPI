# PoliceAPI
PoliceAPI is PocketMine-MP Plugin.

使用法: *これはAPIです!* が警察の追加、削除、一覧表示ができます。

##コマンド
`/police`
主なコマンドです。第一引数にdel,add,listが指定できます。
第二引数はdel,addでプレイヤー名を指定できます。

##APIとしての機能
**APIとしての機能は今後追加していきますので追加希望があればお知らせください**

1. getPolice() - 引数:なし
officer.ymlのgetAll(true)の短縮です

2. isPolice() - 引数:プレイヤー名
プレイヤー名が警察かを確かめます

3. setPolice() - 引数:同上
プレイヤー名を警察にします

4. removePolice() - 引数:同上
プレイヤー名を警察から削除します

5. broadcastPolice() - 引数:Text
警察全員にブロードキャストします

##Todo
□ API機能の追加

END