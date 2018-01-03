<h3>Funcion�rios</h3>	
<table class="table table-striped" style="width: 400px;">
    <tbody>
        <?php foreach ($data['funcionarios'] as $funcionario): ?>	    	
			<tr>
                <td><?= $funcionario->getNome() ?></td>
                <td class="text-right">
                    <a href="<?= Lib\App::getRouter()->getUrl('funcionario', 'atualiza', [$funcionario->getIdFuncionario()]) ?>"
                       class="btn btn-sm btn-primary">Editar</a>
                    <a href="<?= Lib\App::getRouter()->getUrl('funcionario', 'deleta', [$funcionario->getIdFuncionario()]) ?>"
                       class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
		</tbody>
</table>
<br/>
<div>
    <a href="<?= Lib\App::getRouter()->getUrl('funcionario', 'insere') ?>" class="btn btn-sm btn-success">Novo funcion�rio</a>
</div>

