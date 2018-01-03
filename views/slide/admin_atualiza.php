<?php
    /* @var $slide Models\Slide */
    $slide = $data['slide'];
?>

<h3>Editar Slide</h3>
<form method="POST" action="">
    <input type="hidden" name="idSlide" value="<?= $slide->getIdSlide() ?>"/>
    <div class="form-group">
        <label for="img">imagem</label>
        <input type="text" name="img" id="img" class="form-control" value="<?= $slide->getImagem() ?>" placeholder="imagem"/>
    </div>
    <div class="form-group">
        <label for="ordem">Ordem</label>
        <input type="text" name="ordem" id="ordem" class="form-control" value="<?= $slide->getOrdem() ?>" placeholder="Ordem"/>
    </div>
    <input type="submit" class="btn btn-sucess" value="atualizar"/>
</form>
