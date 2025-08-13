<?php
session_start();
include("dbcon.php");
$userName = $userEmail = $userPassword = $userConfirmPassword = "";
$userNameErr = $userEmailErr = $userPasswordErr = $userConfirmPasswordErr = "";

 if(isset($_POST['addUser'])){
     $userName = $_POST['uName'];
     $userEmail = $_POST['uEmail'];
     $userPassword = $_POST['uPassword'];
    //  $userConfirmPassword = $_POST['userConfirmPassword'];      
     if(empty($userName)){
         $userNameErr = "Name Field Is Required";
     }
     if(empty($userEmail)){
         $userEmailErr = "Email Field Is Required" ; 
     }
     else{
          $query = $pdo->prepare("select * from user where email = :uEmail");
          $query->bindParam(':uEmail',$userEmail);
          $query->execute();
          $user = $query->fetch(PDO::FETCH_ASSOC); 
         // print_r($user);
         // die();
          if($user){
             $userEmailErr ="Email Already Exists";
          }
     }
     if(empty($userPassword)){
         $userPasswordErr = "Password Field Is Required";
     }
     if (empty($userNameErr) && empty($userEmailErr) && empty($userPasswordErr)){
         $query = $pdo->prepare("INSERT INTO user(username , email , password) values (:uName , :uEmail , :uPassword)");
          $query->bindParam(':uName', $userName);
          $query->bindParam(':uEmail', $userEmail);
          $query->bindParam(':uPassword' , $userPassword);
          $query->execute();
          echo "<script>alert('record added');location.assign('addUser.php')</script>";
     }
 }
//update user 
 if(isset($_POST['updateUser'])){
     $userName = $_POST['userName'];
     $userPassword = $_POST['userPassword'];
     $userEmail = $_POST['userEmail'];
     $userId = $_GET['userId'];
     $query = $pdo->prepare("update user set name = :uName , email = :uEmail , password = :uPassword where id = :uId");
     $query->bindParam(':uName',$userName);
     $query->bindParam(':uEmail',$userEmail);
     $query->bindParam(':uPassword', $userPassword);
     $query->bindParam(':uId', $userId);
     $query->execute();
     echo "<script>alert('record updated');location.assign('addUser.php')</script>";
 }
// delete 
//  if(isset($_GET['ID'])){     
//     $uId = $_GET['ID'];
//     //  <!-- echo $uId;
//     //  die(); -->
//    $query = $pdo->prepare("DELETE  FROM user WHERE id = :uId");
//      $query->bindParam(':uId',$uId);
//   $query->execute();
//   echo "<script>alert('Record deleted'); location.assign('viewUser.php')</script>";}

// add category
$categoryName = "" ;
$categoryNameErr =  "" ;
if(isset($_POST['addcategory'])){
    $categoryName = $_POST['cName'];
    if(empty($categoryName)){
        $categoryNameErr = "Name is required";
    }
    if(empty($categoryNameErr) ){
            $query = $pdo->prepare("INSERT INTO categories (categoryname) value (:cName )");
            $query->bindParam(':cName' , $categoryName);
            $query->execute();
            echo "<script>alert('category added');location.assign('viewCategory.php')</script>";
    }
}


// DELETE CATEGORY
if (isset($_GET['cId'])) {
    $cId = $_GET['cId'];

    $query = $pdo->prepare("DELETE FROM categories WHERE category_id = :cId");
    $query->bindParam(':cId', $cId, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "<script>alert('Record deleted'); location.assign('viewCategory.php');</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting record');</script>";
    }
}

                                        // DELETE Product


if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = $pdo->prepare("DELETE FROM product WHERE product_id = :product_id");
    $query->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($query->execute()) {
        echo "<script>alert('Record deleted successfully'); location.assign('viewproduct.php');</script>";
    } else {
        echo "<script>alert('Error deleting record'); location.assign('viewproduct.php');</script>";
    }
}





// $productName = $productPrice = $productQuantity = $categoryId = $productImageName = $productDes = "";
// $productNameErr = $productPriceErr = $productQuantityErr = $categoryIdErr = $productImageNameErr = $productDesErr = "";

// if (isset($_POST['addProduct'])) {
//     $productName     = $_POST['pName'] ?? '';
//     $productPrice    = $_POST['pPrice'] ?? '';
//     $productQuantity = $_POST['pQuantity'] ?? '';
//     $productDes      = $_POST['pDes'] ?? '';
//     $categoryId      = $_POST['category_Id'] ?? ''; // ✅ name fixed

//     // File upload check
//     if (!empty($_FILES['pImage']['name']) && $_FILES['pImage']['error'] === UPLOAD_ERR_OK) {
//         $productImageName    = $_FILES['pImage']['name'];
//         $productImageTmpName = $_FILES['pImage']['tmp_name'];
//         $extension           = strtolower(pathinfo($productImageName, PATHINFO_EXTENSION));
//         $destination         = "images/" . $productImageName;
//     } else {
//         $productImageNameErr = "Image is Required";
//     }

//     // Validations
//     if (empty($productName)) $productNameErr = "Name is Required";
//     if (empty($productDes)) $productDesErr = "Description is Required";
//     if (empty($productPrice)) $productPriceErr = "Price is Required";
//     if (empty($productQuantity)) $productQuantityErr = "Quantity is Required";
//     if (empty($categoryId)) $categoryIdErr = "Category is Required";
//     if (!empty($productImageName)) {
//         $allowedFormats = ["png", "jpeg", "webp", "jpg", "svg"];
//         if (!in_array($extension, $allowedFormats)) {
//             $productImageNameErr = "Invalid Extension";
//         }
//     }

//     // Agar sab validation pass ho
//     if (
//         empty($productDesErr) && empty($productImageNameErr) && empty($productNameErr) &&
//         empty($productPriceErr) && empty($productQuantityErr) && empty($categoryIdErr)
//     ) {
//         if (move_uploaded_file($productImageTmpName, $destination)) {
//             $query = $pdo->prepare("INSERT INTO product 
//                 (productname, c_Id, price, description, quantity, image) 
//                 VALUES (:name, :cId, :price, :description, :quantity, :image)");

//             $query->bindParam(':name', $productName);
//             $query->bindParam(':cId', $categoryId);
//             $query->bindParam(':price', $productPrice);
//             $query->bindParam(':description', $productDes);
//             $query->bindParam(':quantity', $productQuantity);
//             $query->bindParam(':image', $productImageName);

//             if ($query->execute()) {
//                 echo "<script>alert('Product added');location.assign('viewProduct.php')</script>";
//             } else {
//                 echo "<script>alert('Error adding product');</script>";
//             }
//         }
//     }
// }


                                            //USER DETAIL



// form submit check
if (isset($_POST['addUserDetails'])) {
    // session se user_id aur role lena
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        die("User is not logged in.");
    }

    $userId   = $_SESSION['user_id'];
    $role     = $_SESSION['role'];

    // form values
    $firstname     = $_POST['firstname'];
    $lastname      = $_POST['lastname'];
    $contactnumber = $_POST['contactnumber'];
    $address       = $_POST['address'];

    // validation
    if (empty($firstname) || empty($lastname) || empty($contactnumber) || empty($address)) {
        echo "<script>alert('All fields are required');</script>";
    } else {
        // query prepare
        $query = $pdo->prepare("
            INSERT INTO userdetail (user_id, role, firstname, lastname, contactnumber, address)
            VALUES (:user_id, :role, :firstname, :lastname, :contactnumber, :address)
        ");

        // bind parameters
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindParam(':role', $role, PDO::PARAM_STR);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':contactnumber', $contactnumber, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);

        // execute
        if ($query->execute()) {
            echo "<script>alert('User details added successfully');location.assign('userDetails.php');</script>";
        } else {
            echo "<script>alert('Failed to add details');</script>";
        }
    }
}




                                   //ADD DESIGNER

$dfirstname = $dlastname = $dcontactno = $daddress = $dexperience = $dspecialization = $dportfollio = "";
$dfirstnameErr = $dlastnameErr = $dcontactnoErr = $daddressErr = $dexperienceErr = $dspecializationErr = $dportfollioErr = "";


if (isset($_POST['addDesigner'])) {
    $dfirstname  = $_POST['dfName'];
    $dlastname   = $_POST['dlname'];
    $dcontactno = $_POST['dcnumber'];
    $daddress   = $_POST['daddress'];
    $dexperience   = $_POST['dexperience']; // updated name
    $dspecialization = $_POST['dspecialization'];
    $dportfollio = $_POST['dportfollio'];

    // Validation
    if (empty($dfirstname))  $dfirstnameErr = "Product Name is Required";
    if (empty($dlastname)) $dlastnameErr = "Product Price is Required";
    if (empty($dcontactno))   $dcontactnoErr = "Product Description is Required";
    if (empty($daddress))   $daddressErr = "Product Quantity is Required";
    if (empty($dexperience)) $dexperienceErr = "Product Brand Name is Required";
    if (empty($dspecialization)) $dspecializationErr = "Product Brand Name is Required";
    if (empty($dportfollio)) $dportfollioErr = "Product Brand Name is Required";
   
    if (
        empty($dfirstnameErr) &&
        empty($dlastnameErr) &&
        empty($dcontactnoErr) &&
        empty($daddressErr) &&
        empty($dexperienceErr) &&
        empty($dspecializationErr) &&
        empty($dportfollioErr)
    );{
    
            $query = $pdo->prepare("INSERT INTO interioirdesigner (firstname, lastname, contactnumber, address, yearofexperience, specialization, portfolio) 
                                    VALUES (:dfirstname, :dlastname, :dcontactnumber, :daddress, :dyearofexperience, :dspecialization, :dportfolio)");
            $query->bindParam(':dfirstname', $dfirstname);
            $query->bindParam(':dlastname', $dlastname);
            $query->bindParam(':dcontactnumber', $dcontactno);
            $query->bindParam(':daddress', $daddress);
            $query->bindParam(':dyearofexperience', $dexperience);
            $query->bindParam(':dspecialization', $dspecialization);
            $query->bindParam(':dportfolio', $dportfollio);
            $query->execute();
            echo "<script>alert('Designer added');location.assign('Interiordesigner.php');</script>";
        }
    }

                                 //Delete Designer



if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM interioirdesigner WHERE designer_id = ?");
    $stmt->execute([$id]);
    echo "<script>alert('Designer deleted'); location.href='ViewDesigner.php';</script>";
}

                            