<?php   
   // var_dump(Lib\App::getRouter()->getUrl('slide', 'atualiza', [1]));
?>
<h3>Slides</h3>
<table class="table table-striped" style="width: 400px;">
    <tbody>
        <?php foreach ($data['slides'] as $slide): ?>
            <tr>
                <td>  <?= $slide->getImagem() ?> </td>
                <td class="text-right"> 
                    <a href="<?=Lib\App::getRouter()->getUrl('slide', 'atualiza', [$slide->getIdSlide()]) ?>"
                       class="btn btn-sm btn-primary"> Editar
                    </a> 
                    <a href="<?= Lib\App::getRouter()->getUrl('slide', 'deleta', [$slide->getIdSlide()]) ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirmaExcluir()"> Excluir
                    </a> 
                <td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br/>
<div>
    <a href="<?= Lib\App::getRouter()->getUrl('slide', 'insere') ?>"
        class="btn btn-sm btn-success"> Novo Slide  
    </a> 
</div>
