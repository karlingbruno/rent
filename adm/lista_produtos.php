<?php
include "cabecalhoAdm.php";
?>

<div class="container">
	<main>
		<h2>Relatório de Produtos</h2>
		<p>| <a href="cad_produtos.php">inserir novo</a> |</p>
		<table>
			<tr>
				<th>Nome <a href="?campo=nome&ordem=asc">&and;</a><a href="?campo=nome&ordem=desc">&or;</a></th>
				<th>Fabricante <a href="?campo=fabricante&ordem=asc">&and;</a><a href="?campo=fabricante&ordem=desc">&or;</a></th>
				<th>Valor da locação <a href="?campo=valorFinal&ordem=asc">&and;</a><a href="?campo=valorFinal&ordem=desc">&or;</a></th>
				<th>Ação</th>
			</tr>
			<?php
			include "../includes/conexao.php";
			include "../includes/functions.php";
			$sql = " ";
			if(isset($_GET['campo']) & isset($_GET['ordem']))
				$sql .= " ";
			else
				$sql .= " order by nome asc";
			$resultado = mysqli_query($conexao, $sql);				
			if( == 0){
				?>
				<tr>
					<td colspan="4">Nenhum produto encontrado.</td>
				</tr>
				<?php	
			}
			else{
				while($prod = ){
					?>				
					<tr>
						<td><?= ?></td>
						<td><?= ?></td>
						<td><?= ?></td>
						<td>| <a href="alterar_produto.php?id=<?= ?>">alterar</a> | 
							  <a href="excluir_produto.php?id=<?= ?>" onclick="return confirmaExclusao()">excluir</a> |</td>
					</tr>
					<?
				} // while
			} // else
			?>
			</table>
		</section>

	</main>	
	<?php
	include "asideAdm.php";
	?>
</div>

<?php
include "rodapeAdm.php";
?>
