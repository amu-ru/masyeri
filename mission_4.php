<html> 
<?php

//DBに接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

//DBのテーブルを作成
$sql="CREATE TABLE tbl_4"
."("
."id INT primary key auto_increment,"
."name char(32),"
."comment TEXT,"
."date char(64),"
."pass TEXT"
.");";
$stmt = $pdo->query($sql);


//SQLにデータ入力
$sql=$pdo->prepare("INSERT INTO tbl_4 (id,name,comment,date,pass) VALUES (:id,:name,:comment,:date,:pass)");
$sql->bindParam(':id',$id,PDO::PARAM_INT);
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':date', $date, PDO::PARAM_STR);
$sql->bindParam(':pass',$pass,PDO::PARAM_STR);

//ここまでで変数を書き込む形が完成。$id,$name,$commentを以下で指定していく

//変数定義
$button1=$_POST['button1'];
$delete=$_POST['delete'];
$button2=$_POST['button2'];
$edit=$_POST['edit'];
$button3=$_POST['button3'];
$pass_delete=$_POST['pass1'];
$pass_edit=$_POST['pass2'];
//編集フォームの受け取り
$editnumber=$_POST['editnumber'];



//送信ボタン
if($button1 and !$editnumber) {
	if($_POST['comment'] and $_POST['name'] and $_POST['pass']){
		$comment=$_POST['comment'];
		$name=$_POST['name'];
		$pass=$_POST['pass'];
		$date=date("Y年m月d日 H時i分s秒");
		$sql->execute();//SQLへの書き込み実行（書き込む変数後に持ってくる		
  		}
  	if(!($_POST['comment'] and $_POST['name'] and $_POST['pass'])){
  		echo '入力事項が不足しています';
  		}
}

//削除ボタン
if($button2 and $delete){

	$sql = "SELECT * FROM tbl_4 WHERE id = '$delete'";
	$rows = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);//配列として行を取得
	$pass = $rows['pass'];//配列内の指定箇所を変数にする
	$id = $rows['id'];
	if(($delete == $id) and ($pass_delete == $pass)){
		$sql="delete from tbl_4 where id=$id";
		$result=$pdo->query($sql);
		}
	if(($pass_delete != $pass) and $pass_delete){
		echo 'パスワードが違います';
		}
	if(!$pass_delete){
		echo 'パスワードが入力されていません';
		}

}


//編集フォーム

if($button3 and $edit){
	$sql = "SELECT * FROM tbl_4 WHERE id = '$edit'";
	$rows = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);//配列として行を取得
	$name = $rows['name'];
	$comment = $rows['comment'];
	$pass = $rows['pass'];//配列内の指定箇所を変数にする
	$id = $rows['id'];
	if($edit==$id){
		if($pass_edit==$pass){
			$editname_value = $name;
			$editcomment_value = $comment;
			$editnumber_value = $id;
			}//パスが同じだったらの終わり
		}
	//パスがないか違うとき
	if(($pass_edit != $pass) and $pass_edit){
		echo 'パスワードが違います';
		 }
	if(!$pass_edit){
		echo 'パスワードが入力されていません';
		}
}//ボタン3と編集番号受け取ったら、の終わり

//編集モードのフォームから送信されたら
if($editnumber){
	$sql = "SELECT * FROM tbl_4 WHERE id = $editnumber";
	$rows = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC|PDO::FETCH_UNIQUE);//配列として行を取得
	$name = $rows['name'];
	$comment = $rows['comment'];
	$pass = $rows['pass'];//配列内の指定箇所を変数にする
	$id = $rows['id'];
	if(($editnumber == $id) and $_POST['pass'] and $_POST['comment'] and $_POST['name']){
		$id==$editnumer;
		$kome=$_POST['comment'];
		$nm=$_POST['name'];
		$pass=$_POST['pass'];
		$date=date("Y年m月d日 H時i分s秒");
		$sql="update tbl_4 set name='$nm',comment='$kome',date='$date',pass='$pass' where id=$id";
		$result=$pdo->query($sql);
		}
	if(!$_POST['pass'] or !$_POST['comment'] or !$_POST['name']){
		echo '入力事項が不足しています';
		$editname_value = $name;
		$editcomment_value = $comment;
		$editnumber_value = $id;
		$editnumber == $id;
		}
}

		


//フォーム
?>		
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head> 
　<form action="mission_4.php" method="POST">
    <input type="text" name="name" placeholder="名前" value= <?php echo $editname_value; ?> ><br/>
    <input type="text" name="comment" placeholder="コメント" value= <?php echo $editcomment_value; ?> ><br/>
    <input type="password" name="pass" placeholder="パスワード" />
    <input type="hidden" name="editnumber" value= <?php echo $editnumber_value; ?> >	
    <input type="submit" name="button1" value="送信"/><br/><br/>
    <input type="text" name="delete" placeholder="削除対象番号" /><br/>
    <input type="password" name="pass1" placeholder="パスワード" />
    <input type="submit" name="button2" value="削除"/><br/><br/>
    <input type="text" name="edit" placeholder="編集対象番号" /><br/>
    <input type="password" name="pass2" placeholder="パスワード" />
    <input type="submit" name="button3" value="編集"/>
</form>

<?php
//表示
$sql='SELECT*FROM tbl_4 ORDER BY id ASC';
$results=$pdo->query($sql);
foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	}
?>
</html>