<h3>Contato</h3>
<table class="table table-striped" style="width: 400px;">
    <tbody>
        <tr>
            <td>  <?= $data['email']->getChave(); ?> </td>
            <td>  <?= $data['email']->getConteudo(); ?> </td>
        </tr>
        <tr>
            <td>  <?= $data['telefone']->getChave(); ?> </td>
            <td>  <?= $data['telefone']->getConteudo(); ?> </td>
        </tr>
    </tbody>
</table>

<br/>
<div>
    <a href="<?=Lib\App::getRouter()->getUrl('contato', 'atualiza') ?>"
        class="btn btn-sm btn-primary"> Editar
    </a> 
</div>