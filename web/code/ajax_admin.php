<?php
session_start();
if(!isset($_SESSION['administrator']))
	die('Not administrator');
if(!isset($_POST['op']))
	die('error');
$op=$_POST['op'];
require('inc/database.php');
if($op=="list_priv"){ ?>
	<table class="table table-condensed table-striped" style="width:480px">
		<caption>Privilege List</caption>
		<thead>
			<tr>
				<th>User</th>
				<th>Privilege</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$res=mysql_query("select user_id,rightstr from privilege");
				while($row=mysql_fetch_row($res)){
					echo '<tr><td>',$row[0],'</td><td>',$row[1],'</td><td><a href="#"><i class="icon icon-remove"></i></a></td></tr>';
				}
			?>
		</tbody>
	</table>
<?php
}else if($op=="add_priv"){
	isset($_POST['user_id']) ? $uid=mysql_real_escape_string(trim($_POST['user_id'])) : die('');
	if($uid=='')
		die('');
	isset($_POST['right']) ? $right=$_POST['right'] : die('');
	if($right!='administrator'&&$right!='source_browser')
		die('Invalid privilege');
	mysql_query("insert into privilege VALUES ('$uid','$right','N')");
}else if($op=="del_priv"){
	isset($_POST['user_id']) ? $uid=mysql_real_escape_string(trim($_POST['user_id'])) : die('');
	isset($_POST['right']) ? $right=mysql_real_escape_string($_POST['right']) : die('');
	mysql_query("delete from privilege where user_id='$uid' and rightstr='$right'");
}else if($op=='update_index'){
	$index_text=isset($_POST['text']) ? mysql_real_escape_string(str_replace("\n", "<br>", $_POST['text'])) : '';
	if(mysql_query("insert into news (news_id,content) VALUES (0,'$index_text') ON DUPLICATE KEY UPDATE content='$index_text'"))
		echo "success";
	else
		echo "fail";
}
?>