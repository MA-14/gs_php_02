<!-- リセットがうまく機能しない！！！ -->

<?php
require_once('funcs.php');
include('header.php');

//勝敗に応じて書き込み用ファイル作成
$score0="score0.txt";
$score1="score1.txt";
$score2="score2.txt";
$score3="score3.txt";
$score4="score4.txt";
$score5="score5.txt";
$score6="score6.txt";
$score7more="score7more.txt";

//DB接続
try {
  //ID:'root', Password: 'root'
  $pdo = new PDO('mysql:dbname=baseball;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
  exit('DBConnectError:' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD']=='POST'){

  if (isset($_POST["getscore"]) && isset($_POST["lostscore"])){
    $name= trim($_POST['name']);
    $name = ($name==='')? '名無し':$name;
    $name = str_replace("\t", " ",$name);

    $comment= trim($_POST['comment']);
    $comment = str_replace("\t", " ",$comment);

    $getscore= $_POST["getscore"];
    $lostscore= $_POST["lostscore"];
    $postedAt = date('Y/m/d H:i:s');

    if ($getscore>$lostscore){
      $winlose = "win";
    }elseif($getscore<$lostscore){
      $winlose = "lose";
    }else{
      $winlose = "draw";
    }
  }else{
    $getscore= "";
    $lostscore= "";
  }

  if ($getscore!=="" && $lostscore!==""){

    //得点に応じて、該当ファイルに０を記入
      if ((int)$getscore===0){
        $fp = fopen($score0, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==1){
        $fp = fopen($score1, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==2){
        $fp = fopen($score2, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==3){
        $fp = fopen($score3, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==4){
        $fp = fopen($score4, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==5){
        $fp = fopen($score5, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore==6){
        $fp = fopen($score6, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }elseif($getscore>=7){
        $fp = fopen($score7more, 'a');
        fwrite($fp, 0);
        fclose($fp);
      }

      //失点に応じて、該当ファイルに１を記入
      if ((int)$lostscore===0){
        $fp = fopen($score0, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==1){
        $fp = fopen($score1, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==2){
        $fp = fopen($score2, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==3){
        $fp = fopen($score3, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==4){
        $fp = fopen($score4, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==5){
        $fp = fopen($score5, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore==6){
        $fp = fopen($score6, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }elseif($lostscore>=7){
        $fp = fopen($score7more, 'a');
        fwrite($fp, 1);
        fclose($fp);
      }
  }
    //DB接続
    // try {
    //   //ID:'root', Password: 'root'
    //   $pdo = new PDO('mysql:dbname=baseball;charset=utf8;host=localhost', 'root', 'root');
    // } catch (PDOException $e) {
    //   exit('DBConnectError:' . $e->getMessage());
    // }
  
    //データ登録SQL作成
    // 1. SQL文を用意
    $stmt = $pdo->prepare("INSERT INTO bb_predict(id, getscore, lostscore, winlose, name, comment, date)
    VALUES(NULL, :getscore, :lostscore, :winlose, :name, :comment, sysdate())");
  
    //  2. バインド変数を用意
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':getscore', $getscore, PDO::PARAM_STR);
    $stmt->bindValue(':lostscore', $lostscore, PDO::PARAM_STR);
    $stmt->bindValue(':winlose', $winlose, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
  
    //  3. 実行
    $status = $stmt->execute();
  
    //４．データ登録処理後
    if ($status == false) {
        //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        $error = $stmt->errorInfo();
        exit("ErrorMessage:" . $error[2]);
    } 
}

  $stmt = $pdo->prepare("SELECT * FROM bb_predict");
  $status = $stmt->execute();

  $win_view="";
  $win_view_count=0;
  $lose_view="";
  $lose_view_count=0;
  $draw_view="";
  $draw_view_count=0;

  if ($status==false) {
      //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
    }
    else{
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      if($result["winlose"]=="win"){
        $win_view .= "<li>".h($result["getscore"])." vs ".h($result["lostscore"])." - ".h($result["comment"])." (".h($result["name"]).")"."</li>";
        $win_view_json =json_encode($win_view); 
        $win_view_count ++ ;
      }elseif($result["winlose"]=="lose"){
        $lose_view .= "<li>".h($result["getscore"])." vs ".h($result["lostscore"])." - " .h($result["comment"])." (".h($result["name"]).")"."</li>";
        $lose_view_json =json_encode($lose_view); 
        $lose_view_count++;
      }else{
        $draw_view .= "<li>";
        $draw_view .= h($result["getscore"])." vs ".h($result["lostscore"])." - ".h($result["comment"])." (".h($result["name"]).")"; 
        $draw_view .= "</li>";
        $draw_view_json =json_encode($draw_view); 
        $draw_view_count ++;
      }
    }
  }

  //ファイル内の0、1の数を数える
  $find0 = '/0/';
  $find1 = '/1/';

  //得点それぞれの予想数
  $get_score_vote0 = preg_match_all($find0,file("score0.txt")[0]);
  $get_score_vote1 = preg_match_all($find0,file("score1.txt")[0]);
  $get_score_vote2 = preg_match_all($find0,file("score2.txt")[0]);
  $get_score_vote3 = preg_match_all($find0,file("score3.txt")[0]);
  $get_score_vote4 = preg_match_all($find0,file("score4.txt")[0]);
  $get_score_vote5 = preg_match_all($find0,file("score5.txt")[0]);
  $get_score_vote6 = preg_match_all($find0,file("score6.txt")[0]);
  $get_score_vote7more = preg_match_all($find0,file("score7more.txt")[0]);

  //失点それぞれの予想数
  $lost_score_vote0 = preg_match_all($find1,file("score0.txt")[0]);
  $lost_score_vote1 = preg_match_all($find1,file("score1.txt")[0]);
  $lost_score_vote2 = preg_match_all($find1,file("score2.txt")[0]);
  $lost_score_vote3 = preg_match_all($find1,file("score3.txt")[0]);
  $lost_score_vote4 = preg_match_all($find1,file("score4.txt")[0]);
  $lost_score_vote5 = preg_match_all($find1,file("score5.txt")[0]);
  $lost_score_vote6 = preg_match_all($find1,file("score6.txt")[0]);
  $lost_score_vote7more = preg_match_all($find1,file("score7more.txt")[0]);  

  //ファイルの中身を削除するファンクション
  function deleateContent($f){
    $fp = fopen($f, "w");
    fclose($fp);
  }

  if(isset($_POST['reset'])) {
      deleateContent($score0);
      deleateContent($score1);
      deleateContent($score2);
      deleateContent($score3);
      deleateContent($score4);
      deleateContent($score5);
      deleateContent($score6);
      deleateContent($score7more);
  }

?>

  <h1 class="title">みんなの巨人戦予想</h1>
  <div class="titlemessage">今日の巨人戦のスコアを予想しよう</div>
  <h2>投票</h2>
  <div class="form">
    <form action="" method ="post">
      名前　　：<input type="text" name="name">
      <br>
      得点　　：<input type="number" name="getscore" min="0" max="100">
      <br>
      失点　　：<input type="number" name="lostscore" min="0" max="100">
      <br>
      コメント：<input name="comment" size=40>
      <input type="submit" value="投票">
    </form>
  </div>

<h2>みんなの投票分析</h2>
<div class="allcharts">
  <div class="win_lose_rate chart_wrapper">
    <p>勝敗予想</p>
    <div id="vote_none1">・投稿はありません</div>
    <div class="result_figure figures" style="width:350px">
      <canvas id="mychart1" class="mychart1"></canvas>
    </div>
  </div>

  <div class="getScore_rate chart_wrapper">
    <p>得点数予想</p>
    <div id="vote_none2">・投稿はありません</div>
    <div class="getScore_figure figures" style="width:350px">
      <canvas id="mychart2" class="mychart2"></canvas>
    </div>
  </div>

  <div class="lostScore_rate chart_wrapper">
    <p>失点数予想</p>
    <div id="vote_none3">・投稿はありません</div>
    <div class="lostScore_figure figures" style="width:350px">
      <canvas id="mychart3" class="mychart3"></canvas>
    </div>
  </div>

</div>

<h2 class="commentall">みんなの投票一覧</h2>
  <div class="vote_all">
      <div class="win_vote comment">
        <p class="vote_title">勝ち予想（<?= $win_view_count ?>件）</p>
        <ul class="win_vote_content">
          <?php if ($win_view !== ""): ?>
          <?= $win_view ?>
          <?php else: ?>
          <li>投稿はありません</li>
          <?php endif ?>
        </ul>
      </div>
      <div class="lose_vote comment">
        <p class="vote_title">負け予想（<?= $lose_view_count ?>件）</p>
        <ul class="lose_vote_content">
        <?php if ($lose_view !== ""): ?>
         <?= $lose_view ?>
          <?php else: ?>
          <li>投稿はありません</li>
          <?php endif ?>
        </ul>
      </div>
      <div class="draw_vote comment comment">
        <p class="vote_title">引き分け予想（<?= $draw_view_count ?>件）</p>
        <ul class="draw_vote_content">
          <?php if ($draw_view !== ""): ?>
          <?= $draw_view ?>
          <?php else: ?>
          <li>投稿はありません</li>
          <?php endif ?>
        </ul>
      </div>
  </div>

  <form  method="post">
    <button type="submit" name="reset">リセット</button>
  </form>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    <?php  if ($win_view !=="") :?>
    var win_view= JSON.parse('<?php echo $win_view_json ?>')
    <?php endif ?>
    <?php  if ($lose_view !=="") :?>
    var lose_view= JSON.parse('<?php echo $lose_view_json ?>')
    <?php endif ?>
    <?php  if ($draw_view !=="") :?>
    var draw_view= JSON.parse('<?php echo $draw_view_json ?>')
    <?php endif ?>

    // 予想がある時に図を表示
    <?php if($win_view !=="" || $lose_view !=="" || $draw_view !==""): ?>
      document.getElementById("vote_none1").style.display ="none";
      document.getElementById("vote_none2").style.display ="none";
      document.getElementById("vote_none3").style.display ="none";

      var ctx = document.getElementById('mychart1');
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['勝ち', '引き分け', '負け'],
          datasets: [{
            data: [<?= $win_view_count ?>, <?= $draw_view_count ?>, <?= $lose_view_count ?>],
            backgroundColor: ['#f88', '#484', '#48f'],
            weight: 100,
          }],
        },
      });
      var ctx = document.getElementById('mychart2');
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['0点', '1点', '2点', '3点', '4点','5点','6点', '7点以上'],
          datasets: [{
            data: [<?php echo $get_score_vote0 ?>,<?php echo $get_score_vote1 ?>,<?php echo $get_score_vote2 ?>,<?php echo $get_score_vote3 ?>,<?php echo $get_score_vote4 ?>,<?php echo $get_score_vote5 ?>,<?php echo $get_score_vote6 ?>,<?php echo $get_score_vote7more ?>],
            backgroundColor: ['#e6b8c2','#f88','#e68a9e','#e65c7a','#e62e56','#ff0037','#cc002c','#990021'],
            weight: 100,
          }],
        },
      });
      var ctx = document.getElementById('mychart3');
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['0点', '1点', '2点', '3点', '4点','5点','6点', '7点以上'],
          datasets: [{
            data: [<?php echo $lost_score_vote0 ?>,<?php echo $lost_score_vote1 ?>,<?php echo $lost_score_vote2 ?>,<?php echo $lost_score_vote3 ?>,<?php echo $lost_score_vote4 ?>,<?php echo $lost_score_vote5 ?>,<?php echo $lost_score_vote6 ?>,<?php echo $lost_score_vote7more ?>],
            backgroundColor: ['#abcbd9', '#82bdd9', '#57b0d9','#2ba2d9','#0095d9','#00aeff','#008bcc','#006999'],
            weight: 100,
          }],
        },
      });
    //予想がない時は図を非表示
    <?php else: ?>  
      document.getElementById("vote_none1").style.display ="block";
      document.getElementById("vote_none2").style.display ="block";
      document.getElementById("vote_none3").style.display ="block";
    <?php endif ?>
  </script>

<?php 
include('footer.php');