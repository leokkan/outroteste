<h3>Informações Sobre</h3>
<?php   $sobre = $data['sobre']; ?>
<h3>Editar Sobre</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="sobre">Campo Sobre:</label>
        <input type="text" name="sobre" id="sobre" class="form-control" value="<?= $sobre->getConteudo() ?>" placeholder="Conteúdo"/>
    </div>
    <input type="submit" class="btn btn-success" value="Editar"/>
</form>