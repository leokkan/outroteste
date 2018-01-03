<?php
$funcionario = $data['funcionario'];
?>
<h3>Editar Funcionário</h3>
<form method="POST" action="">
    <input type="hidden" name="idFuncionário" value="<?= $funcionario->getIdFuncionario() ?>"/>
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $funcionario->getNome() ?>" placeholder="Nome do Funcionário"/>
    </div>
   <div class="form-group">
        <label for="imagem">Imagem:</label>
        <input type="text" name="imagem" id="imagem" class="form-control" value="<?= $funcionario->getImagem() ?>" placeholder="IMAGEM"/>
    </div>
    <div class="form-group">
        <label for="cargo">Cargo:</label>
        <input type="text" name="cargo" id="cargo" class="form-control" value="<?= $funcionario->getCargo() ?>" placeholder="Cargo"/>
    </div>
    <input type="submit" class="btn btn-success" value="Editar"/>
</form>
