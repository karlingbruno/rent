<?php
include "includes/cabecalho.php";
?>
<div class="container">
  <?php
  include "includes/menu_lateral.php";
  ?>
  <section class="col-2">
  <?php
  	include "includes/conexao.php";
    include "includes/functions.php";
    $sql = "select * from produto";
    if(isset($_GET['id'])){
      $sql.= " where id = '".$_GET['id']."' ";
      // echo "$sql";
    }
    $resultado = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($resultado) == 0){
      echo "<p>Nenhum produto encontrado</p>";
    }
    else{
      $produto = mysqli_fetch_array($resultado);
      $titulo = $produto['nome'];
      $preco =  mostraPreco($produto['valor'],$produto['desconto']);
      echo "<h2>$titulo<h2>";
      ?>

      <div class="produtos">
        <img src="img/produtos/<?=mostraImagem($produto['imagem']);?>" alt="<?=$produto['nome'];?>">
        <!-- <p>teste</p> -->

        <!-- <div class="lista-produtos"> -->
        <!-- </div> -->
      </div>
      <div class="teste">
        <?=$preco?>
      <!-- <div class="lista-produtos"> -->
        <form action="adiciona.php" method="post" id = "quantidade">
          <label for="quantidade" class="label-alinhado">Quantidade:</label>
          <input type="number" name="quantidade">
          <button>Adicionar Ao carrinho</button>
        </form>
      <!-- </div> -->
      </div>
      <header class="detalhes-produto">
          <!-- <?php
          $produto = mysqli_fetch_array($resultado);
          $fabricante = $produto['idFabricante'];
          $desc = $produto['descricao'];
          $tensao = $produto['tensao'];
          echo "$fabricante";
          echo "$desc";
          echo "$tensao";
          // echo "Categorias : ";
          if($produto['catMarcenaria'] == true)
            echo "<p>Marcenaria<p> ,";
          if($produto['catJardinagem'] == true)
            echo "Jardinagem ,";
          if($produto['catLimpeza'] == true)
            echo "Limpeza ,";
          if($produto['catEscritorio'] == true)
            echo "Escritório ,";
          if($produto['catMecanica'] == true)
            echo "Mecânica ,";
          if($produto['catOutros'] == true)
            echo "Outros ,";
         ?> -->
         <!-- <?=$fabricante?> -->
      </header>
      <?php
  }

      ?>
  </section>

  <?php
  include "includes/mais_pedidos.php";
  ?>
  </div>
<!-- fim area central -->
<?php
include "includes/rodape.php";
?>
