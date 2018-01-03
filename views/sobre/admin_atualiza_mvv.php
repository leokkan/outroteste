<h3>Informações Sobre</h3>
<?php   $missao = $data['missao'];
        $visao = $data['visao'];
        $valores = $data['valores'] ?>
<h3>Editar MVV</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="missao">Missão:</label>
        <input type="text" name="missao" id="missao" class="form-control" value="<?= $missao->getConteudo() ?>" placeholder="Missão"/>
    </div>
    <div class="form-group">
        <label for="visao">Visão:</label>
        <input type="text" name="visao" id="visao" class="form-control" value="<?= $visao->getConteudo() ?>" placeholder="Visão"/>
    </div>
    <div class="form-group">
        <label for="valores">Valores:</label>
        <input type="text" name="valores" id="valores" class="form-control" value="<?= $valores->getConteudo() ?>" placeholder="Valores"/>
    </div>
    <input type="submit" class="btn btn-success" value="Editar"/>
</form>