<?php

/*$supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
$supplier_location = isset($_POST['supplier_location']) ? $_POST['supplier_location'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';*/

$supplier_name = $_POST['supplier_name'];
$supplier_location = $_POST['supplier_location'];
$email = $_POST['email'];
$sid = $_POST['sid'];

// Update suppliers Records
try {
	$sql = "UPDATE suppliers 
			SET 
			supplier_name = ?, supplier_location = ?, email = ?, updated_at=?
			WHERE id=?"; 
 
	include('connection.php');
	$stmt= $conn->prepare($sql);
	$stmt->execute([$supplier_name, $supplier_location, $email, date('Y-m-d h:i:s '), $sid]);

	// Delete the old values. 
	$sql = "DELETE FROM productsuppliers WHERE supplier=?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$sid]);



	// loop through the products and add record

	// Get products
	$products = isset($_POST['products']) ? $_POST['products'] : [];
/*	foreach($products as $product){
		$supplier_data = [ 
			'supplier_id' => $products,
			'product_id' => $product,
			'updated_at' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s')  
		];*/

	foreach($products as $product){
			$product_data = [ 
				'supplier_id' => $sid,
				'product_id' => $product,
				'updated_at' => date('Y-m-d H:i:s'),
				'created_at' => date('Y-m-d H:i:s')  
			];

		$sql = "INSERT INTO productsuppliers 
			(supplier, product, updated_at, created_at) 
		VALUES 
			(:supplier_id, :product_id, :updated_at, :created_at)"; 

		$stmt= $conn->prepare($sql);

		//$stmt->execute($supplier_data);
		$stmt->execute($product_data);
	}
	

	$response = [
		'success' => true,
		'message' => "<strong>$supplier_name</strong> Successfully updated to the system." 
	];
} catch (\Exception $e) {
	$response = [
		'success' => false,
		'message' => "Error Processing Request." 
	];
}

echo json_encode($response);



