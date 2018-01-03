<?php
    /* @var $parceiro Models\Parceiro */
    $parceiro = $data['parceiro'];
?>

<h3>Editar Parceiro</h3>
<form method="POST" action="">
    <input type="hidden" name="idParceiro" value="<?= $parceiro->getIdParceiro() ?>"/>
    <div class="form-group">
        <label for="nome">Nome do parceiro</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $parceiro->getNome() ?>" placeholder="Nome"/>         
    </div>
    <div class="form-group">
        <label for="img">imagem</label>
        <input type="text" name="img" id="img" class="form-control" value="<?= $parceiro->getImagem() ?>" placeholder="imagem"/>
    </div>
    <div class="form-group">
        <label for="site">Site</label>
        <input type="text" name="site" id="site" class="form-control" value="<?= $parceiro->getSite() ?>" placeholder="Site"/>
    </div>
    <div class="form-group">
        <label for="ordem">Ordem</label>
        <input type="text" name="ordem" id="ordem" class="form-control" value="<?= $parceiro->getOrdem() ?>" placeholder="Ordem"/>
    </div>
    <input type="submit" class="btn btn-sucess" value="atualizar"/>
</form>
