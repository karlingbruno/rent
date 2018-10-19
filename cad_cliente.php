<?php
include "includes/cabecalho.php";
?>
<div class="container">
  <?php
  include "includes/menu_lateral.php";
  ?>

  <section class="col-2">
    <?php
      if(isset($_POST["nome"]) || isset($_POST["email"]) || isset($_POST["endereco"]) || isset($_POST["bairro"]) ||
      isset($_POST["perfil"]) || isset($_POST["login"]) || isset($_POST["senha"]) || isset($_POST["senha2"]) ||
      isset($_POST["concordo"])){// se post não estiver null
         $vetErros = "";
         // Válidar Nome
         if ($_POST["nome"] == "" || !strstr($_POST["nome"]," ")) {
           $vetErros.="Por favor digite seu nome completo!<br>";
         }else{
           $nome = $_POST["nome"];
           $nome = htmlspecialchars($nome);
           $nome = addslashes($nome);
         }
         // Válidar Email
         if($_POST["email"] == "" || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
           $vetErros.="Digite um email válido!<br>";
         }else{
           $email = $_POST["email"];
         }
         //Validar Endereço
         if($_POST["endereco"] == ""){
           $vetErros.="Digite um endereço válido!<br>";
         }else{
           $endereco = $_POST["endereco"];
           $endereco = htmlspecialchars($endereco);
           $endereco = addslashes($endereco);
         }
         //Validar bairro
         if($_POST["bairro"] == ""){
           $vetErros.="Por favor selecione o bairro!<br>";
         }else{
           $bairro = $_POST["bairro"];
           $bairro = htmlspecialchars($bairro);
           $bairro = addslashes($bairro);
         }
         //Validar perfil
         if(!isset($_POST["perfil"])){
           $vetErros.= "Por favor marque uma opção de perfil!<br>";
         }else{
           $perfil = $_POST["perfil"];
         }
         //Validar login
         if($_POST["login"] == "" || strlen($_POST["login"]) < 6 ){
           $vetErros.= "Por favor digite um login com no mínimo 6 caracteres!<br>";
         }else{
           $login = $_POST["login"];
           $login = htmlspecialchars($login);
           $login = addslashes($login);
         }
         //Validação senha
         if(strlen($_POST["senha"]) < 6){
           $vetErros.="Por favor digite uma senha com no mínimo 6 caracteres!<br>";
         }else{
           if($_POST["senha2"] == $_POST["senha"]){
             $senha1 = md5($_POST["senha"]);
           }else{
             $vetErros.= "A senha não confere!<br>";
           }
         }
         //Validação termos de uso
         if(!isset($_POST["concordo"]))
           $vetErros.="Você deve aceitar os termos de uso do site!<br>";
         //Conclusão de cadastro
         if($vetErros != ""){// se houve algum erro
           echo "$vetErros";
         }else{//se não houve nenhum erro
          include "includes/conexao.php";
          $sql = "INSERT INTO cliente (nome,email,endereco,bairro,perfil,login,senha) VALUES ('$nome','$email','$endereco',
          '$bairro','$perfil','$login','$senha1');";
          mysqli_query($conexao,$sql);
          echo "Cadastro concluído!<br>";
         }
      } // Mostrar form pra preencher
        ?>
        <h2>Cadastre-se</h2>
        <div>
          <form action="cad_cliente.php" method="post" id="form-contato">
              <div class="form-item">
                <label for="nome" class="label-alinhado">Nome:</label>
                <input type="text" id="nome" name="nome" size="50" placeholder="Nome completo">
                <span class="msg-erro" id="msg-nome"></span>
              </div>
              <div class="form-item">
                <label for="email" class="label-alinhado">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="fulano@dominio" size="50">
                <span class="msg-erro" id="msg-email"></span>
              </div>
              <div class="form-item">
                <label for="endereco" class="label-alinhado">Endereço:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, número, complemento" size="50">
                <span class="msg-erro" id="msg-endereco"></span>
              </div>
              <div class="form-item">
                <label for="bairro" class="label-alinhado">Bairro:</label>
                <select name="bairro" id="bairro">
                <option value="">Selecione o bairro</option>
                <option>Centro</option>
                <option>Efapi</option>
                <option>Presidente Médici</option>
                <option>Jardim Itália</option>
                <option>Maria Goretti</option>
              </select>
              <span class="msg-erro" id="msg-bairro"></span>
              </div>
              <div class="form-item">
                <label class="label-alinhado">Perfil:</label>
                <label><input type="radio" name="perfil" value="m" id="perfilC">Consumidor final</label>
                <label><input type="radio" name="perfil" value="f" id="perfilP">Prestador de serviço</label>
              <span class="msg-erro" id="msg-perfil"></span>
              </div>
              <div class="form-item">
                <label for="empresa" class="label-alinhado">Nome da empresa:</label>
                <input type="text" id="empresa" name="empresa" disabled> <span id="mensagem-empresa"></span>
                <span class="msg-erro" id="msg-empresa"></span>
              </div>
              <div class="form-item">
                <label for="senha" class="label-alinhado">Login:</label>
                <input type="text" id="login" name="login" placeholder="Mínimo 6 caracteres">
                <span class="msg-erro" id="msg-login"></span>
              </div>
              <div class="form-item">
                <label for="senha" class="label-alinhado">Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres">
                <span class="msg-erro" id="msg-senha"></span>
              </div>
              <div class="form-item">
                <label for="senha2" class="label-alinhado">Repita a Senha:</label>
                <input type="password" id="senha2" name="senha2" placeholder="Mínimo 6 caracteres">
                <span class="msg-erro" id="msg-senha2"></span>
              </div>
              <div class="form-item">
                <label class="label-alinhado"></label>
                <label><input type="checkbox" id="concordo" name="concordo"> Li e estou de acordo com os termos de uso do site</label>
                <span class="msg-erro" id="msg-concordo"></span>
              </div>
              <div class="form-item">
                <label class="label-alinhado"></label>
              <input type="submit" id="botao" value="Confirmar">
              </div>
          </form>
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
