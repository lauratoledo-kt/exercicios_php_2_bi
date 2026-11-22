# Exercício da Noite — Cadastro de Produtos (PHP + PDO + MySQL)

Projeto acadêmico de **cadastro de produtos** com formulário HTML, validação PHP e persistência em MySQL. Não utiliza frameworks ou bibliotecas externas.

## Análise obrigatória antes do código

| Pergunta do enunciado | Resposta |
|---|---|
| Quais dados chegam pelo formulário? | `nome`, `categoria`, `preco` e `quantidade`, enviados por `POST`. |
| Quais campos são obrigatórios? | Os quatro campos. Nome e categoria não podem estar vazios; preço precisa ser maior que zero; quantidade precisa ser inteiro não negativo. |
| Quais valores precisam ser convertidos? | `preco`, recebido como texto, é normalizado para decimal com ponto e duas casas; `quantidade` é validada e convertida para inteiro. |
| Quais regras são verificadas antes de gravar? | Nome e categoria não vazios (com limite de tamanho), preço numérico > 0 com até duas casas decimais e estoque inteiro >= 0. |
| O que permanece preenchido após erro? | Todos os quatro campos, inclusive os que estiverem inválidos. |
| Quais parâmetros nomeados são utilizados? | `:nome`, `:categoria`, `:preco`, `:quantidade`. |
| Em qual momento o banco é acessado? | **Somente depois de todas as validações terem passado**; em caso de erro, não se cria conexão nem se executa `INSERT`. |

### Fluxo da aplicação

`FORMULÁRIO → POST → RECEBER → LIMPAR → VALIDAR → [ERRO: EXIBIR / SUCESSO: PDO → PREPARE → BIND → EXECUTE → INSERT]`

## Arquivos

```text
cadastro_produtos/
├── index.php                   # Formulário e fluxo POST → PDO
├── database.sql                # Criação do banco e da tabela
├── config/
│   └── conexao.php             # Conexão PDO reutilizável
├── includes/
│   └── funcoes.php             # Limpeza, escape e validação
├── assets/
│   └── estilo.css              # Estilo responsivo
├── testes/
│   └── testar_validacoes.php   # Testes sem MySQL
├── TESTES.md                   # Checklist de verificações
├── README.md
└── .gitignore
```

## Configuração com XAMPP (Windows)

1. Inicie o **MySQL** pelo painel do XAMPP. Para executar pelo Apache, inicie também o **Apache**.
2. Abra `http://localhost/phpmyadmin/`, acesse a guia **SQL** e execute o conteúdo de `database.sql` (ou use **Importar** para importar esse arquivo). Esse script cria o banco `loja_produtos` e a tabela `produtos`.
3. A conexão em `config/conexao.php` utiliza os padrões do XAMPP local: host `127.0.0.1`, porta `3306`, usuário `root`, senha vazia, banco `loja_produtos`. Se seu MySQL usa outra configuração, defina as variáveis de ambiente `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` e `DB_PASSWORD`. Não inclua senhas reais no Git.
4. Coloque a pasta `cadastro_produtos` dentro de `C:\xampp\htdocs\exercicios-php\` e acesse `http://localhost/exercicios-php/cadastro_produtos/`.

**Alternativa sem Apache:** abra o PowerShell **dentro** da pasta `cadastro_produtos` e rode:

```powershell
& "C:\xampp\php\php.exe" -S localhost:8000
```

Acesse `http://localhost:8000/`. **Mesmo usando o servidor PHP embutido, o MySQL do XAMPP deve estar iniciado** e o arquivo SQL deve ter sido executado.

## Teste manual sugerido

- Nome vazio → não grava; apresenta erro.
- Categoria vazia → não grava; apresenta erro.
- Preço zero, negativo ou letras → não grava; apresenta erro.
- Quantidade negativa ou decimal → não grava; apresenta erro.
- Campos inválidos → valores preenchidos permanecem no formulário.
- `Teclado Mecânico` / `Informática` / `250,00` / `10` → grava e mostra `Produto cadastrado com sucesso!`.
- Atualizar a página após sucesso → não duplica o registro (POST/Redirect/GET).
- Consultar o banco após cadastro com `SELECT * FROM loja_produtos.produtos;`.

Para rodar os testes isolados de validação:

```powershell
& "C:\xampp\php\php.exe" testes\testar_validacoes.php
```

## Segurança e observações

- Todos os valores de entrada são tratados como dados não confiáveis; a validação **ocorre no PHP**, sem depender do navegador.
- Textos são limpos com `trim()` e `preg_replace()`; a exibição utiliza `htmlspecialchars()` com `ENT_QUOTES`.
- PDO usa `prepare()`, `bindValue()` e `execute()` sem interpolar os dados enviados no SQL.
- O preço é salvo como `DECIMAL(10,2)`, evitando tipo de ponto flutuante para o valor armazenado.
- Aceita `250,00` e `250.00`, mas **não aceita separadores de milhar** (ex.: `1.250,00`); digite `1250,00`.
- O estoque pode ser `0`, mas não negativo; campos grandes demais também são rejeitados antes da gravação.
- Mensagens técnicas de erros PDO são enviadas ao log do servidor, não exibidas com detalhes ao usuário.
- No XAMPP, confira que a extensão `pdo_mysql` está habilitada (normalmente já vem habilitada).

## Envio para o GitHub

Se `exercicios-php` já é seu repositório, abra um terminal na **pasta raiz** dele:

```bash
git add cadastro_produtos
git commit -m "Adiciona cadastro de produtos com PHP PDO e MySQL"
git push origin main
```

Os dados do MySQL **não são enviados ao GitHub**; o arquivo `database.sql` permite recriar a estrutura do banco em outro computador.
