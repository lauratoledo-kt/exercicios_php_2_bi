# Registro de testes — Cadastro de Produtos

## Testes automatizados de validação

Execute em um terminal com PHP: `php testes/testar_validacoes.php`.

Cenários cobertos:

1. Nome vazio → rejeição.
2. Categoria vazia → rejeição.
3. Preço zero → rejeição.
4. Preço negativo → rejeição.
5. Preço não numérico → rejeição.
6. Preço com três casas decimais → rejeição.
7. Quantidade negativa → rejeição.
8. Quantidade decimal → rejeição.
9. Quantidade ausente/vazia → rejeição.
10. Nome com mais de 150 caracteres → rejeição.
11. Categoria com mais de 100 caracteres → rejeição.
12. Produto válido com vírgula → preço normalizado como `250.00`.
13. Estoque zero → permitido.
14. Preço com ponto → permitido.
15. Preço com uma casa decimal → normalizado para duas casas.
16. Texto com espaços repetidos → normalizado.
17. HTML como texto → escapado na saída.

## Testes de integração (executar no XAMPP)

Estes cenários exigem um servidor MySQL acessível; marque os resultados depois da execução manual:

- [ ] Importar `database.sql` no phpMyAdmin e verificar a tabela `loja_produtos.produtos`.
- [ ] Enviar formulário com nome vazio; confirmar erro e **nenhum INSERT**.
- [ ] Enviar preço inválido e confirmar manutenção dos quatro campos.
- [ ] Enviar `Teclado Mecânico` / `Informática` / `250,00` / `10`; confirmar mensagem de sucesso.
- [ ] Executar `SELECT * FROM loja_produtos.produtos;` e conferir preço `250.00` e quantidade `10`.
- [ ] Atualizar a página após sucesso; verificar que não existe registro duplicado.
- [ ] Desligar MySQL e tentar um cadastro válido; confirmar mensagem amigável sem expor senha ou SQL.

**Observação:** os testes automatizados verificam validação, transformação e escape de dados; por si sós **não comprovam o INSERT no MySQL**. O teste de integração precisa ser feito com o banco disponível.
