# Registro de testes — Portal do Aluno

Este arquivo registra os cenários do enunciado. Os testes são executados por `scripts/testar_portal.py` com servidor PHP local e um cliente HTTP com cookies, simulando a navegação de um estudante.

## Checklist

| Cenário | Entrada/ação | Resultado esperado | Resultado |
| --- | --- | --- | --- |
| 1. Primeiro acesso | Abrir `index.php` | Conteúdo, cabeçalho, navegação e rodapé | APROVADO |
| 2. Nome vazio | Nome vazio, outros campos válidos | Erro de nome obrigatório | APROVADO |
| 3. E-mail inválido | E-mail `sem-arroba.com` | Erro de e-mail válido | APROVADO |
| 4. Idade inválida | Idade `0` | Bloqueio do cadastro e aviso | APROVADO |
| 5. Cadastro válido | Ana Souza, ana@senac.br, 22 | Página de resultado, sucesso e dados | APROVADO |
| 6. Atualizar resultado | Abrir novamente `resultado.php` | Dados permanecem; sucesso desaparece | APROVADO |
| 7. Encerrar sessão | Abrir `logout.php` e consultar dados | Nenhum aluno cadastrado | APROVADO |
| 8. Entrada HTML | Nome `<h1>Ana</h1>` | Exibir tags como texto, não como título | APROVADO |
| 9. Preservar campos | E-mail inválido, demais válidos | Outros valores permanecem no formulário | APROVADO |

**Resultado da execução:** 12 de 12 verificações aprovadas no PHP 8.4.24 (CLI), com navegação HTTP real, redirecionamentos e cookies de sessão. Todas as 8 páginas/arquivos PHP também passaram por `php -l` sem erros de sintaxe.

**Testes adicionais:** erro/valores temporários usados uma única vez; GET direto bloqueado no processamento; idade decimal inválida.

### Como executar

Dentro da pasta `portal_aluno`:

```bash
python scripts/testar_portal.py
```

O script requer PHP no PATH para iniciar seu próprio servidor. A documentação de execução manual está em `README.md`.
