<?php
include "includes/cabecalho.php";
?>

	<!-- area central com 3 colunas -->
	<div class="container">
		<?php
		include "includes/menu_lateral.php";
		?>

		<section class="col-2">
			<form class="login" action="verificacao.php" method="post">
				<div class="form-item">
					<label for="login" class="label-alinhado">Login:</label>
					<input type="text" id="login" name="login" placeholder="Mínimo 6 caracteres">
					<span class="msg-erro" id="msg-login"></span>
				</div>
				<div class="form-item">
					<label for="senha" class="label-alinhado">Senha:</label>
					<input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres">
					<span class="msg-erro" id="msg-senha"></span>
				</div>
				<input type="submit" id="botao" value="Entrar">
			</form>
			<div class="teste">
				<a href="cad_cliente.php"><br>Quero me Cadastrar<br></a>
				<a href="#">Esqueci minha senha<br></a>
			</div>
		</section>
	<?php
	include "includes/mais_pedidos.php";
	?>
	</div>
	<!-- fim area central -->
<?php
include "includes/rodape.php";
?>
