# Mercado

## Requisitos para iniciar o sistema
- Executar o pg_restore com o arquivo localizado em:
    db/market_test.backup

- Caso algum problema ocorra com o backup, um arquivo com a criação das tabelas está em:
    db/migration.sql
- Depois será necessário definir as credenciais do banco de dados no arquivo:
    config.php

- Iniciar o servidor na raiz do projeto:
```
php -S localhost:8080
```