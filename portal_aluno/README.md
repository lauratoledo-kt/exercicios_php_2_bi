# Portal do Aluno — Desafio da Noite

**Disciplina:** Tecnologias para Internet · **Tecnologias:** PHP 8+, HTML e CSS.

Implementação completa do desafio de cadastro de estudante com **sessões PHP** (sem banco de dados e sem frameworks).

> **Sobre o material original:** o arquivo disponibilizado continha somente o enunciado. Por isso, os scripts foram criados com a estrutura solicitada, em vez de serem reorganizados a partir da pasta original `arquivos_desorganizados`.

## Estrutura

```text
portal_aluno/
├── index.php
├── cadastro.php
├── processar_cadastro.php
├── resultado.php
├── logout.php
├── includes/
│   ├── cabecalho.php
│   ├── rodape.php
│   └── funcoes.php
├── assets/
│   └── estilos.css
├── scripts/
│   └── testar_portal.py
├── TESTES.md
├── .gitignore
└── README.md
```

## Como executar

### Opção 1 — XAMPP com Apache

1. Copie a pasta `portal_aluno` para `C:\xampp\htdocs\portal_aluno`.
2. Inicie **Apache** no Painel de Controle do XAMPP (não é necessário MySQL).
3. Abra `http://localhost/portal_aluno/`.

### Opção 2 — Servidor embutido do PHP (PowerShell)

Abra o PowerShell **dentro da pasta `portal_aluno`**, execute:

```powershell
& "C:\xampp\php\php.exe" -S localhost:8000
```

Acesse `http://localhost:8000/`. Se `php` estiver configurado no PATH, também é possível executar `php -S localhost:8000`.

## Fluxo de funcionamento

```text
index.php → cadastro.php → processar_cadastro.php
                                ├── dados inválidos → sessão (erro e campos) → cadastro.php
                                └── dados válidos → sessão (aluno + mensagem) → resultado.php
resultado.php → atualização → dados permanecem, mensagem desaparece
logout.php → limpa/destroi sessão → index.php
```

### Onde estão os TODOs?

- **01–03:** `index.php` — iniciar a sessão e carregar os componentes compartilhados.
- **04–08:** `cadastro.php` — iniciar sessão, recuperar/remover aviso e dados temporários, incluir cabeçalho e rodapé.
- **09–15:** `processar_cadastro.php` — iniciar sessão, `require_once`, conferir POST, receber, validar, redirecionar e salvar aluno.
- **16–20:** `resultado.php` — iniciar sessão, recuperar aluno, mostrar sucesso uma vez, incluir cabeçalho e rodapé.
- **21–24:** `logout.php` — iniciar, limpar e destruir a sessão e redirecionar.
- **25–26 (bônus):** `includes/funcoes.php` — validar e-mail, limpar espaços e reutilizar funções.

## Validações

- Nome não pode estar vazio após `trim()`.
- E-mail precisa ter formato válido com `filter_var(..., FILTER_VALIDATE_EMAIL)`.
- Idade deve ser um **inteiro maior que zero**, validado com `filter_input(..., FILTER_VALIDATE_INT)`.
- Mensagens de erro, formulário, nome, e-mail e idade são exibidos com `htmlspecialchars(..., ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`.
- `$_SESSION['erro']`, `$_SESSION['dados_anteriores']` e `$_SESSION['mensagem_sucesso']` são mensagens/dados **temporários** recuperados e removidos na página de destino.
- `$_SESSION['aluno']` mantém os dados até o encerramento da sessão.

> No formulário, `novalidate` permite que os testes de erro sejam tratados pelo **PHP**, e não bloqueados previamente pelo navegador. A validação real ocorre no servidor.

## Enviar para o GitHub

Se quiser manter este projeto dentro do repositório de exercícios PHP, copie a **pasta inteira `portal_aluno`** para a raiz dele e execute no terminal dessa raiz:

```bash
git add portal_aluno
git commit -m "Adiciona Portal do Aluno com sessoes PHP"
git push
```

Se preferir criar um repositório separado, abra o terminal dentro de `portal_aluno`, crie antes um repositório vazio no GitHub e execute:

```bash
git init -b main
git add .
git commit -m "Implementa Portal do Aluno com sessoes PHP"
git remote add origin https://github.com/SEU-USUARIO/portal_aluno.git
git push -u origin main
```

## Testes

Os cenários exigidos e os resultados da validação estão em [TESTES.md](TESTES.md).

Para executar os testes automatizados, com PHP e Python 3 disponíveis, no diretório `portal_aluno`:

```bash
python scripts/testar_portal.py
```
