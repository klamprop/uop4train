<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "";
$username = "";
$password = "";
$dbname = "";

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    printf("Connect failed: %s\n");
    die("Connection failed: " . $conn->connect_error);
}


if ($input["api_type"] == "1"){
    $sql= "SELECT tbl_courses.id,tbl_courses.title FROM tbl_project INNER JOIN tbl_project_course ON tbl_project_course.project_id = tbl_project.id ";
    $sql .= "INNER JOIN tbl_courses ON tbl_project_course.course_id = tbl_courses.id WHERE tbl_project_course.project_id = 2 AND ";
    $sql .= " tbl_courses.course_item_id = 1 ORDER BY tbl_courses.create_date DESC ";
    $result = mysqli_query($conn,$sql);
while ($obj=mysqli_fetch_object($result)){
    $resultArr[] = $obj;
}

if ($resultArr != null){
    echo json_encode($resultArr);
} else{
    echo "[{}]";
}

}
elseif ($input["api_type"]== "2"){
    $sql = "SELECT id_user,name_user,surname_user,email_user FROM tbl_users WHERE (  tbl_users.company='".$input["company"]."' )";
   
    $result = mysqli_query($conn,$sql);
while ($obj=mysqli_fetch_object($result)){
    $resultArr[] = $obj;
}
    if ($resultArr != null){
        echo json_encode($resultArr);
    } else{
        echo "[{}]";
    }


}
elseif ($input["api_type"]== "3"){
    if($input["course_id"]!= null){
        $sql = "SELECT tbl_courses.id, tbl_courses.title, tbl_match_course_user.percentage  ";
        $sql .= "FROM tbl_match_course_user INNER JOIN tbl_users ON tbl_users.id_user = tbl_match_course_user.user_id ";
        $sql .= "INNER JOIN tbl_courses ON tbl_match_course_user.course_id = tbl_courses.id WHERE ( tbl_users.email_user = '".$input["email_user"]."'  AND tbl_courses.id ='".$input["course_id"]."' )";
    }
    else{
        $sql = "SELECT tbl_courses.id, tbl_courses.title, tbl_match_course_user.percentage  ";
        $sql .= "FROM tbl_match_course_user INNER JOIN tbl_users ON tbl_users.id_user = tbl_match_course_user.user_id ";
        $sql .= "INNER JOIN tbl_courses ON tbl_match_course_user.course_id = tbl_courses.id WHERE tbl_users.email_user = '".$input["email_user"]."'";
    }

     
    $result = mysqli_query($conn,$sql);
while ($obj=mysqli_fetch_object($result)){
    $resultArr[] = $obj;
}
//print_r($result->fetch_array(MYSQLI_BOTH));
if ($resultArr != null){
    echo json_encode($resultArr);
} else{
    echo "[{}]";
}
}
elseif ($input["api_type"]== "4"){

    $sql = "SELECT tbl_users.email_user FROM tbl_users INNER JOIN tbl_match_course_user ON tbl_users.id_user = tbl_match_course_user.user_id ";
    $sql .= "WHERE (tbl_users.company = '".$input["company"]."' AND tbl_match_course_user.course_id ='".$input["course_id"]."' AND tbl_match_course_user.percentage = 100)";
    $result = mysqli_query($conn,$sql);
    while ($obj=mysqli_fetch_object($result)){
        $resultArr[] = $obj;
    }
    if ($resultArr != null){
        echo "[{\"total of users\":\"".count($resultArr)."\"}]";
    } else{
        echo "[{\"total of users\":\"0\"}]";
    }
    

}
elseif ($input["api_type"]== "5"){
    //I am receiving all the users for this company
    $sql_user = "SELECT id_user FROM tbl_users WHERE (  tbl_users.company='".$input["company"]."' )";
    $result_user = mysqli_query($conn,$sql_user);
    while ($obj=mysqli_fetch_array($result_user,MYSQLI_NUM)){
        $resultArr_user[] = $obj;
    } 
    
    $num_of_users = count($resultArr_user,0);
    
    $sql_course= "SELECT tbl_courses.id FROM tbl_project INNER JOIN tbl_project_course ON tbl_project_course.project_id = tbl_project.id ";
    $sql_course .= "INNER JOIN tbl_courses ON tbl_project_course.course_id = tbl_courses.id WHERE tbl_project_course.project_id = 2 AND ";
    $sql_course .= " tbl_courses.course_item_id = 1 ORDER BY tbl_courses.create_date  ";
    $result_course = mysqli_query($conn,$sql_course);
    while ($obj=mysqli_fetch_array($result_course,MYSQLI_NUM)){
        $resultArr_course[] = $obj;
    }
    
    $num_of_courses = count($resultArr_course,0);

    echo "[";
    for ($x =0; $x < $num_of_courses; $x++){
       $num_of_users_finished = 0;
       if ($x > 0){
           echo ",";
       }
        for ($y =0; $y < $num_of_users; $y++){
            $sql = "SELECT tbl_match_course_user.percentage  ";
            $sql .= "FROM tbl_match_course_user INNER JOIN tbl_users ON tbl_users.id_user = tbl_match_course_user.user_id ";
            $sql .= "INNER JOIN tbl_courses ON tbl_match_course_user.course_id = tbl_courses.id WHERE ( tbl_users.id_user = '".$resultArr_user[$y][0]."'  AND tbl_match_course_user.percentage = 100 AND tbl_courses.id ='".$resultArr_course[$x][0]."' )";
            $result = mysqli_query($conn,$sql);
            
            while ($obj=mysqli_fetch_object($result)){
                 $resultArr[] = $obj;
            }
            $num_of_users_finished = $num_of_users_finished + count($resultArr);
            unset($resultArr);    
       }
       
       echo "{\"course_id\":\"".$resultArr_course[$x][0]."\",\"completed\":\"".$num_of_users_finished."\"}";
    }
    echo "]";

    
    
    
}


?>


