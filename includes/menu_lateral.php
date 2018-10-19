		<section class="col-1">
			<section class="busca">
				<form>
					<input type="search" placeholder="Busca..." name="busca" 
					value="<?=isset($_GET['busca']) ? $_GET['busca'] : '';?>">
					<button>OK</button>
				</form>
			</section>

			<section class="menu-categorias">
				<h2>Categorias</h2>
				<nav>
					<ul>
						<?php
						include "includes/categorias.php";
						foreach ($CATEGORIAS as $indice => $nomeCategoria){
							echo "<li><a href='index.php?secao=$indice'>$nomeCategoria</a></li>";
						}
						?>						
					</ul>
				</nav>
			</section>
		</section>