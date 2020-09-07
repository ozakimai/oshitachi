<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>5-1</title>
</head>
<body>

<form action="" method="post">
                        
                        お名前<input type="text" name="name" >
                        <br>
                        コメント<input type="comment" name="comment" >
                        <br>
                        パスワード<input type="pass" name="pass">
                        <input type="submit" name="submit" value="送信">
            </form>
            <br>
<form action="" method="post">
                        削除対象番号<input type="deleteid" name="deleteid" >
                        <br>
                        パスワード<input type="deletepass" name="deletepass">
                        <input type="submit" name="delete" value="削除">
        </form>
        <br>
        <form action="" method="post">
                        編集対象番号<input type="editid" name="editid" >
                        <br>
                        お名前<input type="edittext" name="editname" >
                        <br>
                        コメント<input type="editcomment" name="editcomment" >
                        <br>
                        パスワード<input type="editpass" name="editpass">
                        <input type="submit" name="edit" value="編集">


<?php
    $dsn='mysql:dbname=***********;host=localhost';
    $user='*********';
    $password='***********';
    $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));    

    
    
if(!empty($_POST["submit"])){
    $sql=$pdo->prepare("insert into oshitachi(name,comment,pass)values(:name,:comment,:pass)");
      $sql->bindParam(':name',$name,PDO::PARAM_STR);
      $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
      $sql->bindParam(':pass',$pass,PDO::PARAM_STR);

      $name=$_POST["name"];
      $comment=$_POST["comment"];
      $pass=$_POST["pass"];
      
      $sql->execute();//実行

      echo "<br>";
     echo "投稿完了";
      
  }

  

elseif(!empty($_POST["delete"])){
    
    $deleteid=$_POST["deleteid"];    
    $deletepass=$_POST["deletepass"];
    
    $id = $deleteid;


    $sql = 'SELECT * FROM oshitachi where id = :id ';
	$stmt = $pdo->prepare($sql);  
    $stmt->bindParam(':id', $deleteid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();  //配列にする
	$record=$results[0];


    if($record["pass"]==$deletepass){
    
    $sql = 'DELETE from oshitachi where id=:id';
	$stmt = $pdo->prepare($sql);//prepareしたものを実行する時はexecute、queryはそれ以外の時の実行
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

    echo "<br>";
    echo "削除完了";
    }else{
        echo "<br>";
        echo "パスワードが違います";
    }
}
	

elseif(!empty($_POST["edit"])){
    $editid=$_POST["editid"];
    $editname=$_POST["editname"];
    $editcomment=$_POST["editcomment"];
    $editpass=$_POST["editpass"];
    
    $sql = 'SELECT * FROM oshitachi where id = :id ';
	$stmt = $pdo->prepare($sql);  
    $stmt->bindParam(':id', $editid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();  //配列にする
	$record=$results[0];


    if($record["pass"]==$editpass){
    
        $sql = 'UPDATE oshitachi SET name=:name , comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);

        $id = $editid;
        $name = $editname;
        $comment = $editcomment; 

	    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->execute();
    
        echo "<br>";
        echo "編集完了";

    }else{
        echo "<br>";
        echo "パスワードが違います";
    }    
}


	

?>




            


</body>
</html>