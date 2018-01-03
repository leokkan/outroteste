<?php   
   // var_dump(Lib\App::getRouter()->getUrl('parceiro', 'atualiza', [1]));
?>
<h3>Parceiros</h3>
<table class="table table-striped" style="width: 400px;">
    <tbody>
        <?php foreach ($data['parceiros'] as $parceiro): ?>
            <tr>
                <td>  <?= $parceiro->getNome() ?> </td>
                <td class="text-right"> 
                    <a href="<?=Lib\App::getRouter()->getUrl('parceiro', 'atualiza', [$parceiro->getIdParceiro()]) ?>"
                       class="btn btn-sm btn-primary"> Editar
                    </a> 
                    <a href="<?= Lib\App::getRouter()->getUrl('parceiro', 'deleta', [$parceiro->getIdParceiro()]) ?>"
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
    <a href="<?= Lib\App::getRouter()->getUrl('parceiro', 'insere') ?>"
        class="btn btn-sm btn-success"> Novo Parceiro  
    </a> 
</div>
