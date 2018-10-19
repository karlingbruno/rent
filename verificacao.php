<?php
  include "includes/conexao.php";
  $login = $_POST["login"];
  $sql = "select login from cliente where login = '$login';";
  $resultado = mysqli_query($conexao, $sql);
  if(mysqli_num_rows($resultado) == 0){
    header("Location: index.php?erro=1");
  }else{
    $senha2 = md5($_POST["senha"]);
    $sql = "select senha,nome from cliente where login = '$login';";
    $resultado = mysqli_query($conexao, $sql);
    $teste = mysqli_fetch_array($resultado);
    if($teste["senha"] == $senha2){
      session_start();
			$_SESSION["login"] = $login;
      $_SESSION["nome"] = $teste["nome"];
			header("Location: index.php");
    }else{
      header("Location: index.php?erro=2");
    }
  }
 ?>
