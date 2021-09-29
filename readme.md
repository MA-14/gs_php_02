①課題内容（どんな作品か）  
プロ野球の巨人戦のスコア予想を投稿できる掲示板を作りました。  
名前、得点/失点予想、コメントが書き込めて、  
それに応じて円グラフと掲示板コメントが更新されます。  
今週仕事が忙しくてあまり時間が取れなかった為、  
前回の課題でテキストファイルでデータ保持していた部分を  
DBで保持して取り出してくるように変更したものとなります。
  
②工夫した点・こだわった点  
・投稿ごとに円グラフが更新される点
・点数の予想（勝ち負け引き分け）に応じて、コメントを表示させる場所を変えた点  
・リセットボタンを押すと投稿履歴が削除される点
  
③質問・疑問（あれば）  
SQLとJSを完全に連携させることが出来ないまま終わってしまいました。  
（なので前回同様一部DBではなくテキストファイルで代用しています。）  
「getscore ＝ 2となっているレコード数を数えて、JSチャートのdataに入れる」  
みたいなことがやりたかったですが、一向に５００errorが解消出来ずタイムアップになりました。  
JSとSQLうまく連携出来た部分はSQLから取ってきた後にJSONエンコードして、  
JSに入れる時にデコードする、みたいなことをしていたので、  
恐らく同じやり方でできるのかな、、、、と考えていましたが、結局原理がよく分かりませんでした。  
あと、今回学んだことですが、ギリギリまで課題が出来ないと日々のストレスが溜まってしまうので、  
早いうちに最低限提出できるものを作っておいて心の余裕を保てるようにしたいと思いました笑
