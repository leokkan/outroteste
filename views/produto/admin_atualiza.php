<?php
    /* @var $produto Models\Produto */
    $produto = $data['produto'];
?>

<h3>Editar Produto</h3>
<form method="POST" action="">
    <input type="hidden" name="idProduto" value="<?= $produto->getIdProduto() ?>"/>
    <div class="form-group">
        <label for="nome">Nome do Produto</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $produto->getNome() ?>" placeholder="Nome"/>         
    </div>
    <div class="form-group">
        <label for="img">imagem</label>
        <input type="text" name="img" id="img" class="form-control" value="<?= $produto->getImagem() ?>" placeholder="imagem"/>
    </div>
    <div class="form-group">
        <label for="descricao">descrição</label>
        <input type="text" name="descricao" id="descricao" class="form-control" value="<?= $produto->getDescricao() ?>" placeholder="Descriçao"/>
    </div>
    <input type="submit" class="btn btn-sucess" value="atualizar"/>
</form>
