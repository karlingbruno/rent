<?php
include "../includes/conexao.php";
if(isset($_POST['cadastrar'])){
	// botão cadastrar foi acionado, podemos inserir os dados
	$nome = addslashes($_POST['nome']);
	$fabricante = ($_POST['fabricante'] == '') ? 'NULL' : $_POST['fabricante'];
	$imagem = (empty($_FILES['arquivo']['name']))? 'NULL' : "'{$_FILES['arquivo']['name']}'"; 
	$descricao = addslashes($_POST['descricao']);
	$tensao = $_POST['tensao'];
	$catMarcenaria = isset($_POST['marcenaria'])? 1 : 0;
	$catJardinagem = isset($_POST['jardinagem'])? 1 : 0;
	$catLimpeza = isset($_POST['limpeza'])? 1 : 0;
	$catEscritorio = isset($_POST['escritorio'])? 1 : 0;
	$catMecanica = isset($_POST['mecanica'])? 1 : 0;
	$catOutros = isset($_POST['outros'])? 1 : 0;
	$quantidade = $_POST['quantidade'];
	$valor = str_replace(",", ".", $_POST['valor']);
	$desconto = str_replace(",", ".", $_POST['desconto']);

	$erros = array();

	if(empty($nome)){
		$erros[] = "O nome do produto não pode ser vazio";
	}

	if($catMarcenaria == 0 & $catJardinagem == 0 & $catLimpeza == 0 & $catEscritorio == 0 & $catMecanica == 0 & $catOutros == 0){
		$erros[] = "É necessário selecionar pelo menos 1 categoria";
	}

	if(!is_numeric($valor)){
		$erros[] = "Valor da locação inválido";
		$valor = 0;
	}

	if(!is_numeric($desconto)){
		$erros[] = "Valor do desconto inválido";
		$desconto = 0;
	}

	if($valor - $desconto <=0){
		$erros[] = "O valor final deve ser maior do que zero";
	}

	if($imagem <> 'NULL'){
		$destino = "../img/produtos/".$_FILES['arquivo']['name'];
		if(!move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)){
			$erros[] = "Falha no upload do arquivo";
		}
	}

	if (count($erros) == 0){ // nenhum erro encontrado
	 	echo $sql = "INSERT INTO produto (nome, idFabricante, imagem, descricao, tensao, catMarcenaria, catJardinagem, catLimpeza, catEscritorio, catMecanica, catOutros, qtde, valor, desconto) VALUES
	('$nome', $fabricante, $imagem, '$descricao', $tensao, $catMarcenaria, $catJardinagem, $catLimpeza, $catEscritorio, $catMecanica, $catOutros, $quantidade, $valor, $desconto)";
		$resultado = mysqli_query($conexao, $sql);
		if($resultado){
			$mensagem = "O produto <strong>$nome</strong> foi inserido com sucesso";
		}
		else{
			$mensagem = "Erro. O produto não pôde ser cadastrado. ";
			$mensagem .= mysqli_error($conexao); // para debug
		}
	} // count erros
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>Área de Administração - Rent a Tool</title>
	<link rel="stylesheet" type="text/css" href="../css/rent.css">
	<link rel="stylesheet" type="text/css" href="../css/adm.css">
	<link rel="stylesheet" type="text/css" href="../css/forms.css">	
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> <!-- web font Lobster -->
</head>
<body>
	<!-- cabeçalho -->
	<header>
		<h1><a href="index.php">Administração do site</a></h1>
		<h1>Rent a Tool</h1>
	</header>
    <nav class="navbar">
      <ul>
        <li>
          <a href="#">Página inicial</a>
        </li>
        <li>
          <a href="#">Produtos</a>
        </li>
        <li>
          <a href="#">Clientes</a>
        </li>
        <li>
          <a href="#">Pedidos</a>
        </li>
        <li>
          <a href="#">Log off</a>
        </li>
      </ul>
    </nav>

		<div class="container">
			<main>
				<h2>Cadastro de Produtos</h2>
				<?php
				if (isset($mensagem)){
					echo "<p>$mensagem</p>";
				}
				else{ // carrega form
					if(isset($erros)){
						echo "<ul>";
						foreach ($erros as $erro){
							echo "<li style='color: red;'>$erro</li>";
						}
						echo "</ul>";
					}
				?>
				<form action="" method="post" id="form-cadastro" enctype="multipart/form-data">
					<div>
						<fieldset>
							<legend><strong>Dados do Produto</strong></legend>
							<div class="form-item">
								<label for="nome" class="label-alinhado">Nome:</label>
								<input type="text" id="nome" name="nome" size="50" autofocus 
								value="<?=isset($_POST['nome']) ? $_POST['nome'] : '';?>">								
							</div>
							
							<div class="form-item">
								<label for="fabricante" class="label-alinhado">Fabricante:</label>
									<select name="fabricante" id="fabricante">
										<option value="">Não informado</option>
										<?php										
										$sql = "select * from fabricante order by nome";
										$resultado = mysqli_query($conexao, $sql);
										while ($registro = mysqli_fetch_array($resultado)){	
											echo "<option value='{$registro['id']}'";
											if(isset($_POST['fabricante'])){
												if($_POST['fabricante'] == $registro['id'])  
												  echo " selected";	
											}	  
											echo ">{$registro['nome']}</option>";
										}

										?>									
									</select>
							</div>
							
							<div class="form-item">
								<label for="arquivo" class="label-alinhado">Selecione uma imagem:</label>
								<input type="file" name="arquivo" id="arquivo">
							</div>

							<div class="form-item">
								<label for="desc" class="label-alinhado">Descrição:</label>
								<textarea name="descricao" rows="5" cols="30" id="desc"><?=isset($_POST['descricao']) ? $_POST['descricao'] : '';?></textarea>
							</div>
							<div class="form-item">
								<label class="label-alinhado">Tensão: </label>
								<?php
								if (isset($_POST['tensao'])){
									$tensao = $_POST['tensao']; 
								}
								else{
									$tensao = 0;
								}
								// $tensao = (isset($_POST['tensao']))? $_POST['tensao'] : 0;
								?>
								<label><input type="radio" name="tensao" value="110" id="volt110" 
									<?=($tensao == 110) ? "checked" : '';?>>110v</label>
								<label><input type="radio" name="tensao" value="220" id="volt220"
								<?=($tensao == 220) ? "checked" : '';?>>220v</label>							
								<label><input type="radio" name="tensao" value="0" id="voltNone" 
								<?=($tensao == 0) ? "checked" : '';?>>Não se aplica</label>
							</div>
							<div class="form-item">
								<label class="label-alinhado">Categorias:</label>
								<label><input type="checkbox" id="marcenaria" name="marcenaria" 
									<?=isset($_POST['marcenaria'])? "checked":'';?>>Marcenaria</label>
								<label><input type="checkbox" id="jardinagem" name="jardinagem"
									<?=isset($_POST['jardinagem'])? "checked":'';?>>Jardinagem</label>
								<label><input type="checkbox" id="limpeza" name="limpeza"
									<?=isset($_POST['limpeza'])? "checked":'';?>>Limpeza</label>
								<label><input type="checkbox" id="escritorio" name="escritorio"
									<?=isset($_POST['escritorio'])? "checked":'';?>>Escritório</label>
								<label><input type="checkbox" id="mecanica" name="mecanica"
									<?=isset($_POST['mecanica'])? "checked":'';?>>Mecânica</label>
								<label><input type="checkbox" id="outros" name="outros"
									<?=isset($_POST['outros'])? "checked":'';?>>Outros</label>
							</div>						
						</fieldset>
						<fieldset>
							<legend><strong>Dados da locação</strong></legend>
							<div class="form-item">
								<label for="qntDis" class="label-alinhado">Quantidade Disponível:</label>
								<input type="number" id="quantidade" name="quantidade" value="<?=isset($_POST['quantidade'])? $_POST['quantidade']:1;?>" min="1">
							</div>
							<div class="form-item">
								<label for="valor" class="label-alinhado">Valor da locação:</label>
								<input type="text" id="valor" name="valor" placeholder="0.00" value="<?=isset($_POST['valor'])? $_POST['valor']:'';?>">
							</div>
							<div class="form-item">
								<label for="desconto" class="label-alinhado">Desconto promocional:</label>
								<input type="text" id="desconto" name="desconto" value="<?=isset($_POST['desconto'])? $_POST['desconto']:'0.00';?>">
							</div>
							<div class="form-item">						
								<label for="total" class="label-alinhado">Total:</label>
								<div id="total">0.00</div>
							</div>

							<div class="form-item">
						    	<label class="label-alinhado"></label>
						    	<input type="submit" id="botao" value="Cadastrar" 
						    	name="cadastrar">
						    	<input type="reset" value="Limpar">
						    </div>						
						</fieldset>
					</div>
				</form>
				<?php
			} // fecha else
			?>
			</main>	
			<aside>
				<ul class='itens'>
					<li>Total de Produtos: 150</li>
					<li>Locados: 99</li>
					<li>Disponíveis: 51</li>
				</ul>
			</aside>
		
		</div>
		<section class="ultimos">
			<h4>Últimos produtos cadastrados:</h4>
			<table>
				<tr>
					<th>Nome</th>
					<th>Fabricante</th>
					<th>Valor da locação</th>
				</tr>
				<tr>
					<td>Serra Elétrica</td>
					<td>Makita</td>
					<td>35.00</td>
				</tr>
				<tr>
					<td>Lava a Jato</td>
					<td>Trapp</td>
					<td>28.00</td>
				</tr>
				<tr>
					<td>Martelo</td>
					<td>Bosch</td>
					<td>6.00</td>
				</tr>
			</table>
		</section>

	<!-- rodape -->
	<footer><p>Último acesso em: 17/09/2018</p>	</footer>
	<script src="../js/functionsAdm.js"></script>
</body>
</html>
