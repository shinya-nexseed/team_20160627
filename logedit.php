<?php 

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>log</title>
 </head>
 <body>
 <form action="" method="post">
 	<label>水深</label>
 	<div>
 	<input type="text" name="depth">
 	<?php if (isset($error['depth'])): ?>
 		<?php if ($error['depth']=='blank'): ?>
 			<p class="error">水深を入力してください</p>
 		<?php endif; ?>
 	<?php endif; ?>
 </div>
 </form>
 
 	
 </body>
 </html>