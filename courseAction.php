<?php
@session_start();
include_once ("connection.php");

if(isset($_POST["signup"]))
{

    $username=$_POST["username"];
    $password=$_POST["password"];
    $fullname=$_POST["fullname"];
    $mobile=$_POST["mobile"];

    $query="select * from users where username='$username'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0)
    {
        echo 0;
    }
    else
    {

        $query="insert into users values(null,'$username','$password','$fullname','$mobile')";

        if(mysqli_query($con,$query))
        {
            echo 1 ;
        }
        else
        {
            echo 2;
        }
    }
}

if(isset($_POST["loginAdmin"]))
{
    $username=$_POST["username"];
    $password=$_POST["password"];
    $query="Select * from users where username='$username' and password='$password'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0)
    {

        $query="select id from users where username='$username'";
        $result=mysqli_query($con,$query);
        if(mysqli_query($con,$query))
        {
            $id=mysqli_fetch_assoc($result)['id'];
            $_SESSION["name"]=$username;
            $_SESSION["username"]=$id;
            $_SESSION["password"]=$password;
            echo "3";
        }


    }
    else
    {
        echo "4";

    }

}

if(isset($_POST["preferenceSelection"]))
{
    $college=$_POST["college"];
    $course=$_POST["course"];
    $userid=$_SESSION["username"];
    $query="insert into preferences values(null,'$college','$course','$userid')";
    if(mysqli_query($con,$query))
    {
        echo 1;

    }
    else
    {
        echo 2;

    }
}


if(isset($_POST["getPreference"]))
{
    $userid=$_SESSION["username"];
    $query="select * from preferences where userid=$userid";
    $result=mysqli_query($con,$query);
    $data=array();
    while($row=mysqli_fetch_array($result))
    {
        array_push($data,$row);

    }

    echo json_encode($data);

}


if(isset($_POST["deletePreference"]))
{
    $prefid=$_POST["prefid"];
    $query="delete from preferences where prefid=$prefid";
    if(mysqli_query($con,$query))
    {
        echo "3";
    }
    else
    {
        echo "2";
    }
}
?>

