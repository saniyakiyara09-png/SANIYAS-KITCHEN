<?php
require_once __DIR__ . '/../includes/auth.php'; require_admin();
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $action=$_POST['action']??'';
 if($action==='add'){
  $stmt=$pdo->prepare("INSERT INTO menu_items(category_id,name,description,price,image_url,is_available) VALUES(?,?,?,?,?,1)");
  $stmt->execute([(int)$_POST['category_id'],trim($_POST['name']),trim($_POST['description']),max(0,(float)$_POST['price']),trim($_POST['image_url'])]);
  set_flash('success','Menu item added.');
 } elseif($action==='toggle') {
  $pdo->prepare("UPDATE menu_items SET is_available=1-is_available WHERE id=?")->execute([(int)$_POST['id']]); set_flash('success','Menu availability updated.');
 }
 redirect('admin/menu.php');
}
$pageTitle='Manage Menu'; $cats=$pdo->query("SELECT * FROM categories")->fetchAll();
$items=$pdo->query("SELECT m.*,c.name category_name FROM menu_items m LEFT JOIN categories c ON c.id=m.category_id ORDER BY m.id DESC")->fetchAll();
require __DIR__ . '/../includes/header.php';
?>
<section class="page-hero compact"><h1>Manage <em>menu</em></h1></section><section class="section">
<form class="form-card" method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="add"><h2>Add food item</h2><div class="form-row"><label>Name<input name="name" required></label><label>Price (INR)<input type="number" name="price" min="0" step=".01" required></label></div><label>Category<select name="category_id" required><?php foreach($cats as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></label><label>Description<textarea name="description"></textarea></label><label>Image URL<input name="image_url" type="url"></label><button class="btn btn-gold">Add item</button></form>
<div class="table-wrap"><table><tr><th>Item</th><th>Category</th><th>Price</th><th>Available</th><th>Action</th></tr><?php foreach($items as $i): ?><tr><td><?= e($i['name']) ?></td><td><?= e($i['category_name']??'') ?></td><td><?= money($i['price']) ?></td><td><?= $i['is_available']?'Yes':'No' ?></td><td><form method="post"><input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$i['id'] ?>"><button class="btn btn-small btn-outline">Toggle</button></form></td></tr><?php endforeach; ?></table></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
