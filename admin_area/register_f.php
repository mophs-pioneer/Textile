<?php

if(isset($_POST['register'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $country = $_POST['country'];
    $farmerid = $_POST['farmerid'];
    $farmerphone = $_POST['farmerphone'];
    
    if(!empty($firstname) && !empty($lastname) && !empty($country) && !empty($farmerid) && !empty($farmerphone)){
        //database connection
        $con = new mysqli('localhost', 'root', '', 'ecom_store');
        if($con->connect_error){
            die('connection failed:'.$con->connect_error);
        }
        
        $SELECT = "SELECT farmerid FROM farmers WHERE farmerid = ? LIMIT 1";
        $insert = "INSERT INTO farmers (firstname, lastname, country, farmerid, farmerphone)
                   VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($SELECT);
        $stmt->bind_param("s", $farmerid);
        $stmt->execute();
        $stmt->bind_result($farmerid);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        
        if($rnum == 0){
            $stmt->close();
            $stmt = $con->prepare($insert);
            $stmt->bind_param("ssssi", $firstname, $lastname, $country, $farmerid, $farmerphone);
            $stmt->execute();
            echo "Registration successful.";
        }else{
            echo "Someone already registered using this ID.";
        }
        
        $stmt->close();
        $conn->close();
        
    }else{
        echo "All fields are required.";
        die();
    }
}
?>