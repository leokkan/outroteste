<?php   
    $email = $data['email'];
    $telefone = $data['telefone']; 
?>
<h3>Editar contato</h3>
<form method="POST" action="">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" class="form-control" value="<?= $email->getConteudo() ?>" placeholder="Email"/>
    </div>
    <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" class="form-control" value="<?= $telefone->getConteudo() ?>" placeholder="Telefone"/>
    </div>
    <input type="submit" class="btn btn-success" value="Editar"/>
</form>