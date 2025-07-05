<?php require_once __SITE_PATH . '/view/_header.php'; ?>

<table>
	<tr>
        <th>Autor</th>
        <th>Naslov</th>
    </tr>
	<?php 
		foreach($lista_knjiga as $knjiga) {
			echo '<tr>' .
			     '<td>' . $knjiga->autor . '</td>' .
			     '<td>' . $knjiga->naziv . '</td>' .
			     '</tr>';
		}
	?>
</table>

<?php require_once __SITE_PATH . '/view/_footer.php'; ?>