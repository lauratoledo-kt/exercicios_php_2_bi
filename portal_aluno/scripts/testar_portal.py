#!/usr/bin/env python3
"""Teste de integração, apenas biblioteca padrão: inicia PHP, usa cookies e valida os fluxos."""
from http.cookiejar import CookieJar
from pathlib import Path
from urllib.parse import urlencode
from urllib.request import build_opener, HTTPCookieProcessor, Request
from urllib.error import URLError
import socket
import subprocess
import sys
import time

ROOT = Path(__file__).resolve().parents[1]
RESULTADOS = []


def verificar(condicao, descricao):
    if not condicao:
        raise AssertionError(descricao)
    RESULTADOS.append(descricao)
    print('OK —', descricao)


def cliente():
    return build_opener(HTTPCookieProcessor(CookieJar()))


def acessar(opener, base, pagina, dados=None):
    corpo = urlencode(dados).encode('utf-8') if dados is not None else None
    req = Request(f'{base}/{pagina}', data=corpo)
    with opener.open(req, timeout=5) as resp:
        return resp.read().decode('utf-8'), resp.geturl()


def main():
    with socket.socket() as s:
        s.bind(('127.0.0.1', 0))
        porta = s.getsockname()[1]
    base = f'http://127.0.0.1:{porta}'
    try:
        servidor = subprocess.Popen(['php', '-S', f'127.0.0.1:{porta}', '-t', str(ROOT)],
                                    stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    except FileNotFoundError:
        print('PHP não encontrado no PATH. Execute o teste com PHP instalado.')
        return 2
    try:
        for _ in range(35):
            try:
                acessar(cliente(), base, 'index.php')
                break
            except (URLError, ConnectionError):
                time.sleep(.1)
        else:
            raise RuntimeError('Servidor PHP não iniciou')

        c = cliente()
        html, _ = acessar(c, base, 'index.php')
        verificar('Seu espaço começa aqui.' in html and 'Encerrar sessão' in html,
                  'Cenário 1 — primeiro acesso, menu e conteúdo')

        comum = {'nome': 'Ana Souza', 'email': 'ana@senac.br', 'idade': '22'}
        for campo, valor, esperado, nome in [
            ('nome', '', 'O nome é obrigatório.', 'Cenário 2 — nome vazio'),
            ('email', 'sem-arroba.com', 'Informe um e-mail válido.', 'Cenário 3 — e-mail inválido'),
            ('idade', '0', 'Informe uma idade inteira maior que zero.', 'Cenário 4 — idade zero')
        ]:
            dados = dict(comum)
            dados[campo] = valor
            html, url = acessar(c, base, 'processar_cadastro.php', dados)
            verificar(esperado in html and url.endswith('/cadastro.php'), nome)

        html, url = acessar(c, base, 'processar_cadastro.php', comum)
        verificar('Cadastro realizado com sucesso!' in html and 'Ana Souza' in html
                  and 'ana@senac.br' in html and url.endswith('/resultado.php'),
                  'Cenário 5 — cadastro válido e dados apresentados')

        html, _ = acessar(c, base, 'resultado.php')
        verificar('Ana Souza' in html and 'Cadastro realizado com sucesso!' not in html,
                  'Cenário 6 — mensagem flash some, aluno permanece')

        html, url = acessar(c, base, 'logout.php')
        resultado, _ = acessar(c, base, 'resultado.php')
        verificar(url.endswith('/index.php') and 'Nenhum aluno cadastrado' in resultado,
                  'Cenário 7 — logout apaga cadastro da sessão')

        dados = dict(comum)
        dados['nome'] = '<h1>Ana</h1>'
        html, _ = acessar(c, base, 'processar_cadastro.php', dados)
        verificar('&lt;h1&gt;Ana&lt;/h1&gt;' in html and '<dd><h1>Ana</h1>' not in html,
                  'Cenário 8 — HTML digitado é exibido como texto')

        dados = dict(comum)
        dados['email'] = 'invalido'
        dados['nome'] = '  Mariana Oliveira  '
        html, _ = acessar(c, base, 'processar_cadastro.php', dados)
        verificar('value="Mariana Oliveira"' in html and 'value="invalido"' in html
                  and 'value="22"' in html,
                  'Cenário 9 — campos preservados; nome passa por trim')

        html, _ = acessar(c, base, 'cadastro.php')
        verificar('Informe um e-mail válido.' not in html and 'value="invalido"' not in html,
                  'Extra — erro e valores anteriores desaparecem após serem recuperados')

        html, url = acessar(c, base, 'processar_cadastro.php')
        verificar(url.endswith('/cadastro.php') and 'Cadastro realizado com sucesso!' not in html,
                  'Extra — GET direto não processa cadastro')

        dados = dict(comum)
        dados['idade'] = '3.5'
        html, _ = acessar(c, base, 'processar_cadastro.php', dados)
        verificar('Informe uma idade inteira maior que zero.' in html,
                  'Extra — idade decimal é recusada')
        print(f'\n{len(RESULTADOS)} verificações passaram.')
        return 0
    finally:
        servidor.terminate()
        try:
            servidor.wait(timeout=5)
        except subprocess.TimeoutExpired:
            servidor.kill()


if __name__ == '__main__':
    try:
        sys.exit(main())
    except Exception as exc:
        print('FALHA:', exc, file=sys.stderr)
        sys.exit(1)
