<?php 
	// Start the session
	session_start();

	// Ensure user is logged in
	if(!isset($_SESSION['user'])) header('Location: login.php');


	// Get all products
	$show_table = 'products';
	$products = include('database/show.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Products  - Data Management Tool</title>
	<?php include('partials/app-header.php'); ?>
</head>
<body> 
	<div id="dashboardMainContainer">
		<!-- Sidebar -->
		<?php include('partials/app-sidebar.php') ?>
		<div class="dashboard_content_container" id="dashboard_content_container">
			<!--Topnav  -->
			<?php include('partials/app-topnav.php') ?>
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					<div class="row">
						<div class="column column-12">
							<h1 class="section_header"><i class="fa fa-list"></i> List of Products</h1>
							<div class="section_content">
								<div class="users">
									<table>
										<thead>
											<tr>
												<th>#</th>
												<th>Image</th>
												<th>Product Name</th>
												<th>Stock</th>
												<th width="20%">Description</th>
												<th width="15%">Product Suppliers</th>
												<th>Created By</th>
												<th>Created At</th>
												<th>Updated At</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($products as $index => $product){ ?>
												<tr>
													<td><?= $index + 1 ?></td>
													<td class="firstName">
														<img class="productImages" src="uploads/products/<?= $product['img'] ?>" alt="" />
													</td>
													<td class="lastName"><?= $product['product_name']?></td>
													<td class="lastName"><?= number_format($product['stock']) ?></td>
													<td class="email"><?= $product['description']?></td>
													<td class="email">
														<?php
															$supplier_list = '-';
															$pid = $product['id'];
															$stmt = $conn->prepare("SELECT supplier_name FROM suppliers, productsuppliers WHERE productsuppliers.product = $pid
																AND productsuppliers.supplier = suppliers.id ");
															$stmt->execute();
															$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

															if ($row) {
																$supplier_arr = array_column($row, 'supplier_name');
																$supplier_list = '<li>' . implode("</li><li>", $supplier_arr);
															}
															
															echo ($supplier_list);
															
														?>
													</td>
													<td>
														<?php
															$uid = $product['created_by'];

															$stmt = $conn->prepare("SELECT * FROM users WHERE id = $uid");
															$stmt->execute();
															$row = $stmt->fetch(PDO::FETCH_ASSOC);
															$created_by_name = $row['first_name'] . ' ' . $row['last_name'];
															echo($created_by_name);
														?>
													</td>
													<td><?=date('M, d, y - h:i:s A', strtotime($product['created_at'])) ?></td>
													<td><?=date('M, d, y - h:i:s A', strtotime($product['updated_at'])) ?></td>
													<td>
														<a href="" class="updateProduct" data-productid="<?= $product['id'] ?>"> <i class="fa fa-pencil"></i>Edit</a>
														<a href="" class="deleteProduct" data-name="<?= $product['product_name'] ?>"  data-productid="<?= $product['id'] ?>"> <i class="fa fa-trash"></i>Delete</a>
													</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
									<p class="userCount"><?= count($products) ?> products</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
<?php 
	include('partials/app-scripts.php'); 
	$show_table = 'suppliers';
	$suppliers = include('database/show.php');

	$suppliers_arr = [];

	foreach($suppliers as $supplier) {

		$suppliers_arr[$supplier['id']] = $supplier['supplier_name'];
	}

	$suppliers_arr = json_encode($suppliers_arr);
?>
<script>
	var suppliersList = <?= $suppliers_arr ?>;

	function script(){
		var vm = this;
		this.registerEvents = function(){
			document.addEventListener('click', function(e){
				targetElement = e.target;
				classList = targetElement.classList;

				if(classList.contains('deleteProduct')){
					e.preventDefault();
					productid = targetElement.dataset.productid;
					name = targetElement.dataset.name;

					BootstrapDialog.confirm({
						type: BootstrapDialog.TYPE_DANGER,
						title: 'Delete Product',
						message: 'Are you sure you want to delete <strong> '+ name + '</strong>?',
						callback: function(isDelete){
							if(isDelete){

								$.ajax({
									method: 'POST',
									data: {
										id: productid, 
										table: 'products'
									},
									url: 'database/delete.php',
									dataType: 'json',
									success: function(data){
										message = data.success ?
											name + ' successfully deleted.' : ' Error processing your request.';

										BootstrapDialog.alert({
											type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
											message: message,
											callback: function(){
												if(data.success) location.reload();
											}
										});
									}
								});	
							}

						}
					});	
				}

				if(classList.contains('updateProduct')){
					e.preventDefault();

					productid = targetElement.dataset.productid;
					vm.showEditDialog(productid);
				}
				
			});	

			document.addEventListener('submit', function(e){
				e.preventDefault();
				targetElement = e.target;

				if(targetElement.id === 'editProductForm'){
					vm.saveUpdatedData(targetElement);
				}
			})

		},

		this.saveUpdatedData = function(form){
			$.ajax({
				method: 'POST',
				data: new FormData(form),
				url: 'database/update-product.php',
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function(data){
					BootstrapDialog.alert({
						type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
						message: data.message,
						callback: function(){
							if(data.success) location.reload();
						}
					});
				}
			});
		},

		this.showEditDialog = function(id) {
			$.get('database/get-product.php', {id: id}, function(productDetails){
				let curSuppliers = productDetails['suppliers']; 
				let supplierOption = '';


				for(const [supId, supName] of Object.entries(suppliersList)){
					selected = curSuppliers.indexOf(supId) > -1 ? 'selected': '';
					supplierOption += "<option "+ selected +" value='"+ supId +"'>"+ supName +"</option>";
				}


				BootstrapDialog.confirm({
					title: 'Update <strong>' + productDetails.product_name + '</strong>',
					message: '<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editProductForm">\
						<div class="appFormInputContainer">\
							<label for="product_name">Product Name</label>\
							<input type="text" class="appFormInput" id="product_name"  value="'+ productDetails.product_name +'" placeholder="Enter product name..." name="product_name"/>\
						</div>\
						<div class="appFormInputContainer">\
							<label for="description">Suppliers</label>\
							<select name="suppliers[]" id="suppliersSelect" multiple="">\
								<option value="">Select Supplier</option>\
								' + 	supplierOption + '\
							</select>\
						</div>\
						<div class="appFormInputContainer">\
							<label for="description">Description</label>\
							<textarea class="appFormInput productTextAreaInput" placeholder= "Enter product description..." id="description" name="description"> '+ productDetails.description +'</textarea>\
						</div>\
						<div class="appFormInputContainer">\
							<label for="product_name">Product Image</label>\
							<input type="file" name="img" />\
						</div>\
						<input type="hidden" name="pid" value="'+ productDetails.id +'" />\
						<input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
						</form>\
					',
					callback: function(isUpdate){
						if(isUpdate){ 

							document.getElementById('editProductSubmitBtn').click();
						} 
					}
				});
			}, 'json');
		},

		this.initialize = function(){
			this.registerEvents();
		}
	}
	var script = new script;
	script.initialize();
</script>

</body>
</html> 