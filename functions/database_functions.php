<?php
include 'dataconnection.php';

$conn = db_connect();

function select4LatestBook($conn,$isbn){
    $row = array();
    $query = "SELECT book_isbn, book_image FROM books ORDER BY book_isbn DESC LIMIT 4";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Can't retrieve data " . mysqli_error($conn);
        exit;
    }
    while($row[] = mysqli_fetch_assoc($result));
    array_pop($row);
    return $row;
}

function getBookByIsbn($conn, $isbn){
    $query = "SELECT book_title, book_author, book_price FROM books WHERE book_isbn = '$isbn'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Can't retrieve data " . mysqli_error($conn);
        exit;
    }
    return $result;
}

function getOrderId($conn, $customerid){
    $query = "SELECT orderid FROM orders WHERE customerid = '$customerid'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Retrieve data failed!" . mysqli_error($conn);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['orderid'];
}

function insertIntoOrder($conn, $customerid, $total_price, $date, $ship_name, $ship_address, $ship_city, $ship_zip_code, $ship_country){
    $query = "INSERT INTO orders VALUES 
    ('', '" . $customerid . "', '" . $total_price . "', '" . $date . "', '" . $ship_name . "', '" . $ship_address . "', '" . $ship_city . "', '" . $ship_zip_code . "', '" . $ship_country . "')";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Insert orders failed " . mysqli_error($conn);
        exit;
    }
}

function getBookPrice($conn, $isbn){
    $query = "SELECT book_price FROM books WHERE book_isbn = '$isbn'";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Get book price failed! " . mysqli_error($conn);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    return $row['book_price'];
}

function getCustomerId($conn, $name, $address, $city, $zip_code, $country){
    $query = "SELECT customerid FROM customers WHERE 
    username = '$name' AND 
    address = '$address' AND 
    city = '$city' AND 
    zip_code = '$zip_code' AND 
    country = '$country'";
    $result = mysqli_query($conn, $query);
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        return $row['customerid'];
    } else {
        return null;
    }
}

function setCustomerId($conn, $name, $address, $city, $zip_code, $country){
    $query = "INSERT INTO customers (username, address, city, zip_code, country) VALUES 
        ('$name', '$address', '$city', '$zip_code', '$country')";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Insert customers failed! " . mysqli_error($conn);
        exit;
    }
}

function insertIntoOrderDetails($conn, $orderid, $isbn, $quantity, $price){
    $query = "INSERT INTO order_details VALUES 
    ('" . $orderid . "', '" . $isbn . "', '" . $quantity . "', '" . $price . "')";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Insert order details failed! " . mysqli_error($conn);
        exit;
    }
}

$latestBooks = select4LatestBook($conn);
foreach($latestBooks as $book){
    echo "ISBN: " . $book['book_isbn'] . ", Image: " . $book['book_image'] . "<br>";
}

mysqli_close($conn);
?>
