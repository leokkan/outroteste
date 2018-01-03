<pre><?= var_dump($data); ?></pre>

<?php /* !!! IMPORTANTE !!! Se trocarem o ID do form, atualizem no default.js também */ ?>
<h3>Enviar mensagem</h3>
<form id="form_contato" method="POST" action="<?= Lib\App::getRouter()->getUrl('site', 'contato') ?>">
	<div id="contato-msg" class="hidden"></div>
    <div class="form-group">
        <label for="nome">Nome:*</label>
        <input type="text" name="nome" id="nome" class="form-control" value="" placeholder="Nome" required="" />
    </div>    
    
    <div class="form-group">
        <label for="email">Email:*</label>
        <input type="email" name="email" id="email" class="form-control" value="" placeholder="Email" required="" />
    </div>
    <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="tel" name="telefone" id="telefone" class="form-control" value="" placeholder="Telefone"/>
    </div>
    <div class="form-group">
        <label for="mensagem">Mensagem:*</label>
        <textarea style="width: 600px; height: 200px" name="mensagem" id="mensagem" class="form-control" 
                  placeholder="Mensagem" required=""/></textarea>
    </div>
    <input type="submit" class="btn btn-success" value="Enviar"/>
</form>