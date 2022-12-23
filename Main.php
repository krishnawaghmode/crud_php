<?php
if(session_status() === PHP_SESSION_NONE) session_start();
include 'db.php';
class Main{

//Login
public function Login($email,$password)
{
	try{
	 global $pdo;
     	$sql="SELECT * FROM users WHERE email=:email AND password=:password";
     	$stmt=$pdo->prepare($sql);
      $stmt->execute(array("email"=>$email,"password"=>$password));
	
	if($stmt->rowCount()){
     $res= $stmt->fetch();
	   $_SESSION['isLogin']=1;
	   $_SESSION['userId'] = $res['id'];
       return true;
	}

}catch(PDOException $e){
  echo $e->getMessage();
  return false;
}
}	
public function fetch_data($table,$field='',$order='')
{
	try{
     global $pdo;
	 $sql="SELECT * FROM ".$table;

	if(!empty($order) && !empty($field)){
		$sql.= " ORDER BY ".$field." ".$order;
	}

	$stmt=$pdo->prepare($sql);
	$stmt->execute();
    return $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo $e->getMessage();
     return false;
	}
}

public function fetch_students()
{
	try{
     global $pdo;
	 $sql="SELECT s.*,c.name as city_name, GROUP_CONCAT(q.name) as qualifications FROM students as s INNER JOIN cities as c ON s.city_id = c.id LEFT JOIN qualification as q ON FIND_IN_SET(q.id,s.qualification_ids) > '0' GROUP BY s.id";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
    return $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo $e->getMessage();
     return false;
	}
}

public function show_post($page,$show_page,$not_null = '',$admin_post = '')
{
	try{
     global $pdo;

        if(!empty($not_null)){
		  // user_show_post
		$sql="SELECT users.username,post.post,post.user_id,post.id FROM `post` INNER JOIN users on post.user_id = users.id WHERE `user_id` IS NOT NULL ORDER BY `id` DESC";

        }else if(!empty($admin_post)){
        	// admin_show_post
		   $sql="SELECT * FROM `post` WHERE `user_id` IS NULL ORDER BY `show_page` DESC";
        }else{
		   $sql="SELECT * FROM `post` WHERE `page` LIKE '".$page."' AND `show_page` LIKE '".$show_page."'";

        }

	$stmt=$pdo->prepare($sql);
	$stmt->execute();
    return $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo $e->getMessage();
     return false;
	}
}



//add Student
public function addStudent($name,$address,$dob,$city_id,$qualification_ids,$photo)
{
try{
	global $pdo,$TodayDate;
	$sql ="INSERT INTO `students`(`name`, `address`, `dob`, `city_id`, `qualification_ids`, `photo`) VALUES (?,?,?,?,?,?)";
   $stmt=$pdo->prepare($sql);
	$stmt->execute([$name,$address,$dob,$city_id,$qualification_ids,$photo]);
	return true;
}catch(PDOException $e){
   echo $e->getMessage();
   return false;
}
}

//get data specific id
public function specific_id_data($table,$id)
{
global $pdo;
	$query="SELECT * FROM $table WHERE id = ?";
   $stmt4=$pdo->prepare($query);
	$stmt4->execute([$id]);
    if($stmt4->rowCount()>0){
       return $result5=$stmt4->fetch();
	}
}
//update student
public function updateStudent($id,$name,$address,$dob,$city_id,$qualification_ids,$photo)
{
	global $pdo,$TodayDate;
	$query ="UPDATE `students` SET `name`=?,`address`=?,`dob`=?,`city_id`=?,`qualification_ids`=?,`photo`=? WHERE id = ?";
	$stmt = $pdo->prepare($query);
	if($stmt->execute([$name,$address,$dob,$city_id,$qualification_ids,$photo,$id])){
		return true;
	}else {
		return false;
	}
}

//delete 
public function delete($table,$id)
{
    global $pdo;
  	$query="DELETE FROM $table WHERE `id` = ?";
    $stmt4=$pdo->prepare($query);
  	$stmt4->execute([$id]);
  	 if($stmt4->rowCount()>0){
       return $stmt4->rowCount();
	   }else{
	   	return false;
	   }
}

}