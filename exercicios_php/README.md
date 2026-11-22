# Exercícios de PHP Web

Três formulários em PHP que recebem dados por `POST` e apresentam o resultado na mesma página. O projeto não usa banco de dados, JavaScript nem dependências externas.

## Análise antes do código

O fluxo comum é **receber → preservar → validar → processar → decidir → apresentar**. Os valores originais voltam aos campos. As versões tratadas são usadas para validação e cálculos.

### 1. Cadastro de Aluno

- **Receber e preservar:** nome, curso e idade.
- **Validar:** o nome não pode ficar em branco depois de remover os espaços das pontas. A idade, em anos completos, precisa ser um inteiro maior que zero. O curso pode ficar vazio, pois o enunciado não exige sua validação.
- **Apresentar:** se os dados forem válidos, mostrar nome, curso e idade. Se o curso estiver vazio, mostrar “Não informado”.

### 2. Calculadora de Média

- **Receber e preservar:** nome, primeira nota e segunda nota.
- **Converter e validar:** aceitar ponto ou vírgula nas notas decimais. Verificar o nome e validar separadamente cada nota no intervalo de 0 a 10, incluindo os extremos. A nota zero é válida. Em caso de erro, não calcular a média nem mostrar uma situação.
- **Calcular:** somar as notas e dividir por dois.
- **Decidir:** comparar a média sem arredondar. Verificar primeiro se é maior ou igual a 7 (APROVADO), depois se é maior ou igual a 4 (RECUPERAÇÃO). Caso contrário, é REPROVADO.
- **Apresentar:** formatar a média com duas casas decimais só na saída.

### 3. Simulador de Pedido

- **Receber e preservar:** cliente, produto, preço unitário, quantidade e tipo de cliente.
- **Converter e validar:** exigir cliente e produto, converter o preço em centavos e a quantidade em um inteiro. Os dois números devem ser maiores que zero. O preço aceita até duas casas decimais, com ponto ou vírgula e sem separador de milhares. O tipo só pode ser `comum` ou `premium`.
- **Calcular o subtotal:** preço unitário × quantidade.
- **Decidir:** testar primeiro se o subtotal chegou a R$ 500,00 (10%), depois se chegou a R$ 200,00 (5%). Abaixo de R$ 200,00, a taxa inicial é 0%. Para cliente premium, somar 2 pontos percentuais à taxa inicial.
- **Calcular e apresentar:** aplicar o percentual total ao subtotal, arredondar o desconto ao centavo mais próximo e subtrair o desconto do subtotal. Mostrar os dados do pedido, o percentual e todos os valores financeiros com duas casas decimais.

## Arquivos

| Arquivo | Finalidade |
| --- | --- |
| `index.php` | Menu para abrir os três exercícios |
| `cadastro-aluno.php` | Recebimento, validação e resumo do cadastro |
| `calculadora-media.php` | Validação, cálculo e classificação da média |
| `simulador-pedido.php` | Validação e simulação do pedido com descontos |
| `includes/` | Funções PHP, cabeçalho e exibição de erros reutilizáveis |
| `assets/estilo.css` | Estilos do projeto |

## Como rodar

### XAMPP no Windows

1. Extraia o ZIP. Coloque a pasta `exercicios-php` em `C:\xampp\htdocs\`.
2. Abra o painel do XAMPP e inicie o **Apache**. Não é necessário iniciar o MySQL.
3. No navegador, abra [http://localhost/exercicios-php/](http://localhost/exercicios-php/).

### Servidor integrado do PHP

Com o PHP disponível no terminal, abra a pasta `exercicios-php` e execute:

```bash
php -S localhost:8000
```

Depois abra [http://localhost:8000/](http://localhost:8000/).

## Casos para testar

| Exercício | Entrada | Resultado esperado |
| --- | --- | --- |
| Cadastro | Ana, ADS, 19 | Mostra nome, curso e idade |
| Cadastro | Nome em branco, ADS, 0 | Dois erros, mantém ADS e 0, sem resumo |
| Cadastro | Ana, curso em branco, 19 | Mostra «Não informado» para o curso |
| Média | Ana, 8 e 6 | 7,00 e APROVADO |
| Média | Ana, 0 e 8 | 4,00 e RECUPERAÇÃO |
| Média | Ana, 3,50 e 4 | 3,75 e REPROVADO |
| Média | Ana, 10,01 e 5 | Erro na primeira nota, sem situação |
| Pedido | Comum, R$ 199,99 × 1 | 0% e total R$ 199,99 |
| Pedido | Comum, R$ 100,00 × 2 | 5% e total R$ 190,00 |
| Pedido | Comum, R$ 250,00 × 2 | 10% e total R$ 450,00 |
| Pedido | Premium, R$ 100,00 × 1 | 2% e total R$ 98,00 |
| Pedido | Premium, R$ 100,00 × 2 | 7% e total R$ 186,00 |
| Pedido | Premium, R$ 250,00 × 2 | 12% e total R$ 440,00 |
| Pedido | Premium, R$ 250,00 × 0 | Erro na quantidade, mantém campos e tipo, sem resumo |

Nos testes de pedido, preencha o nome e o produto para isolar a regra testada.

## Como enviar ao GitHub

Crie um repositório vazio no GitHub chamado `exercicios-php`, sem marcar as opções de adicionar README, licença ou `.gitignore`. Abra o Git Bash **dentro da pasta extraída**, onde está este README, e troque `SEU-USUARIO` pelo seu usuário do GitHub:

```bash
git init -b main
git add .
git status
git commit -m "Adiciona três exercícios de PHP web"
git remote add origin https://github.com/SEU-USUARIO/exercicios-php.git
git push -u origin main
```

O GitHub guarda o código. Para executar as páginas PHP, use o XAMPP ou outro servidor com PHP.

[Guia oficial do GitHub para enviar um projeto local](https://docs.github.com/en/migrations/importing-source-code/using-the-command-line-to-import-source-code/adding-locally-hosted-code-to-github)
