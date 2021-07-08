<h1 align="center">Special Price</h1>

<div align="center">
  <img src="https://github.com/tezusecommerce/Tezus_Suporte/blob/main/logo.png">
</div>
  
<hr>
Módulo para corrigir a integração dos pedidos da PluggTo que envia sem métodos de envio e quebra a loja na hora de "Enviar" o pedido.
<hr>

<p align="center">
  <a href="#dart-compatibilidade">Compatibilidade & Requisitos</a> &#xa0; | &#xa0; 
  <a href="#checkered_flag-instalação">Instalação, Desinstalação e Reinstalação</a> &#xa0; | &#xa0; 
  <a href="#wrench-arquivo">Arquivo</a>
</p>

<br>

## :dart: Compatibilidade ##
- [x] Magento 2.4.x & PHP 7.4 
- [x] Magento 2.3.3 & PHP 7.3

## :checkered_flag: Instalação ##

### Instalando
1. Baixe o arquivo .zip deste repositório
2. Crie as pastas `app/code/Tezus/Tezus_PluggToShipping` e extraia o .zip para essa pasta.
3. Habilite o módulo: `bin/magento module:enable Tezus_PluggToShipping`
4. Execute os seguintes comandos 
```bash
bin/mangento setup:upgrade && 
bin/magneto setup:di:compile && 
bin/magento setup:static-content:deploy -f && 
bin/magneto c:c && bin/magento c:f
```

### Desinstalando
1. Desabilite o módulo: `bin/magento module:disable Tezus_PluggToShipping`
2. Remova os arquivos e a pasta `app/code/Tezus/Tezus_PluggToShipping`;
3. Deletar o registro antigo na tabela `setup_module`
`delete from setup_module where module = 'Tezus_PluggToShipping'`
4. Execute os seguintes comandos 
```bash
bin/mangento setup:upgrade && 
bin/magneto setup:di:compile && 
bin/magento setup:static-content:deploy -f && 
bin/magneto c:c && bin/magento c:f
```

### Reinstalando
1. Deletar o registro antigo na tabela `setup_module`
`delete from setup_module where module = 'Tezus_PluggToShipping'`
2. Caso necessário, remova a pasta do módulo `rm -rf app/code/Tezus/Tezus_PluggToShipping`
3. Baixe o arquivo .zip deste repositório
4. Crie as pastas `app/code/Tezus/Tezus_PluggToShipping` e extraia o .zip para essa pasta.
5. Habilite o módulo: `bin/magento module:enable Tezus_PluggToShipping`
6. Execute os seguintes comandos 
```bash
bin/mangento setup:upgrade && 
bin/magneto setup:di:compile && 
bin/magento setup:static-content:deploy -f && 
bin/magneto c:c && bin/magento c:f
```
