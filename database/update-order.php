<?php
	$purchase_orders = $_POST['payload'];
	include('connection.php');


try {

	foreach ($purchase_orders as $po) {
		$delivered = (int) $po['qtyDelivered'];
		

		// We dont save the data if 'qtyReceived' is zero 
		if($delivered > 0) {
			$cur_qty_received = (int) $po['qtyReceived'];
			$status = $po['status'];
			$row_id = $po['id'];
			$qty_ordered = (int) $po['qtyOrdered'];
			$product_id = (int) $po['pid'];

			// Update quantity received & quantity remaining
			$updated_qty_received = $cur_qty_received + $delivered;
			$qty_remaining = $qty_ordered - $updated_qty_received;

			$sql = "UPDATE order_product 
					SET 
					quantity_received=?, status=?, quantity_remaining=?
					WHERE id=?"; 

			$stmt= $conn->prepare($sql);
			$stmt->execute([$updated_qty_received, $status, $qty_remaining, $row_id]);


			// Insert script adding to the order_product_history table
			$delivery_history = [
				'order_product_id' => $row_id,
				'qty_received' => $delivered,
				'date_received' => date('Y-m-d H:i:s'),
				'date_updated' => date('Y-m-d H:i:s')  
			];

			$sql = "INSERT INTO order_product_history (order_product_id, qty_received, date_received, date_updated) VALUES (:order_product_id, :qty_received, :date_received, :date_updated)"; 

			$stmt= $conn->prepare($sql);
			$stmt->execute($delivery_history);

			// Script for updating the main product quantity
			// Select statement to pull the correct quantity of product


			$stmt = $conn->prepare("
				SELECT products.stock 	FROM products WHERE id = $product_id
				");
			$stmt->execute();
			$product = $stmt->fetch();

			$cur_stock = (int) $product['stock'];

			// Update statement - to add the delivered product to our quantity
			$updated_stock = $cur_stock + $delivered;
			$sql = "UPDATE products 
					SET 
					stock=?
					WHERE id=?"; 

			$stmt= $conn->prepare($sql);
			$stmt->execute([$updated_stock, $product_id]);

		}
	}

	$response = [
		'success' => true,
		'message' => "Purchase order successfully updated."
	];

} catch (Exception $e) {
	$response = [
		'success' => false,
		'message' => "Error Processing Request." 
	];
}

echo json_encode($response);

