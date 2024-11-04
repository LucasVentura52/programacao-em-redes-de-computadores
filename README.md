Desenvolvido com: | HTML & CSS | JavaScript | PHP |

Projeto de Programação via Sockets
O intuito deste projeto é aplicar os conhecimentos conquistados durante a disciplina de Redes de Computadores à programação de uma aplicação cliente para se comunicar com um servidor via sockets, seguindo um protocolo customizado para o projeto em si.

Cenário da Aplicação
O servidor não possui uma finalidade específica, mas para dar um motivo à aplicação iremos simular uma autenticação do cliente para com o servidor, ou seja, o cliente se autentica para o servidor a fim de utilizar algum serviço específico que o servidor oferece e exige tal autenticação.

Para esta autenticação acontecer algumas informações do cliente devem ser passadas ao servidor, para que o servidor salve suas credenciais e, posteriormente, possa requisitar pela palavra chave/secreta.

Instruções Gerais
Abaixo estão as instruções mais genéricas sobre o projeto:
O aluno poderá utilizar qualquer linguagem de programação para o desenvolvimento da aplicação do cliente.
O funcionamento da aplicação cliente fica totalmente a critério do aluno, desde que a interação com o servidor não seja comprometida:
pode ou não ter uma interface e interação com o usuário;
pode ser executado de maneira standalone ou diretamente de um ambiente de desenvolvimento;
ser desenvolvimento para ambiente web, desktop ou mobile.
A sequência de mensagens entre cliente e servidor deverá ser salva de alguma maneira para ser enviada ao professor pelo sistema do aluno posteriormente, AVA.

Instruções Específicas
Nesta seção há as instruções que devem ser seguidas de forma exata para uma comunicação bem sucedida com o servidor.

Protocolo de aplicação
O protocolo que será utilizado será um protocolo desenvolvido especialmente para este projeto, sendo que este é desenvolvido sobre o protocolo de transporte TCP (com garantias de conexão) e utiliza o conceito de mensagens para comunicação, onde cada mensagem deve ser ou uma requisição ou uma resposta. O cliente constrói mensagens de requisição que comunica sua intenção e direciona essas mensagens a um servidor identificado pelo seu endereço IP e porta. O servidor, por sua vez, escuta por requisições, analisa cada uma das mensagens recebidas e interpreta a intenção daquela mensagem, respondendo esta requisição com uma ou mais mensagens de resposta. O cliente, então, examina as respostas recebidas para ver se as intenções originais foram atingidas, determinando o que deve ser feito no próximo passo baseado no que foi recebido.

Requisições
As requisições que o cliente poderá produzir seguem um formato específico:

<MÉTODO> <ENDPOINT> <PARÂMETROS>

Sendo que cada parte é separada por um espaço em branco.

Método
Os métodos indicam a intenção do cliente com aquela requisição, podendo ser uma das 2 seguintes:

ASK <ENDPOINT> <PARÂMETROS> REG <ENDPOINT> <PARÂMETROS>

ASK e REG possuem finalidades distintas:

ASK: requisitar ao servidor alguma informação, que será definido pelo ENDPOINT;
REG: registrar alguma informação ao servidor.

Endpoint
Indica qual recurso/função/informação deseja requisitar ao servidor, sendo que cada método tem umas gama específica de ENDPOINTS que podem ser utilizados:
ASK IP
ASK SECRET <PARÂMETROS> REG USER <PARÂMETROS>

Os ENDPOINTS que não possuem parâmetros acima podem ser executados diretamente, sem a necessidade de passar nada após a definição dele. Por exemplo:

ASK IP

Retorna o endereço IPv4 do cliente que abriu a conexão com o servidor.

ASK SECRET 1234 minha_senha

Retorna um valor secreto daquele usuário (1234) em específico registrado no servidor.

REG USER 1234 minha_senha

Registra usuário 1234 com senha minha_senha no servidor, para depois ser utilizado com outro método que requisite usuário e senha, como é o caso do ASK SECRET.

Parâmetros
Os endpoints que exigem um parâmetro terão sempre o seguinte formato:

<ID> <SENHA>

Sendo que para este trabalho o ID deve ser seu número de Registro Acadêmico (RA). Os exemplos apresentados na sessão anterior de endpoints apresenta exatamente como uma requisição deverá ser enviada ao servidor.

Respostas
Por outro lado, toda vez que o cliente enviar uma requisição ao servidor, este responderá com mensagens formatadas da seguinte maneira:

RESPONSE <STATUS> <VALOR>

A primeira parte da resposta, RESPONSE, sempre estará presente, porém o status irá variar de acordo com o que o usuário enviar ao servidor.

O servidor funciona de forma síncrona, ou seja, para cada mensagem que o cliente enviar ao servidor, o cliente poderá esperar por apenas uma resposta do servidor. Não haverá respostas espontâneas por parte do servidor, ou seja, o servidor apenas enviará respostas para requisições que o cliente enviou anteriormente.

O campo de status pode conter vários valores numéricos, onde cada um tem um significado específico:

200: OK, tudo certo!
400: parâmetros inválidos
401: usuário não autorizado

404: usuário não encontrado
405: endpoint não permitido
500: erro interno do servidor
501: método não implementado

Por exemplo, abaixo estão algumas das requisições que o usuário pode efetuar com as respectivas respostas:

ASK IP
RESPONSE 200 203.102.42.3

Acima, temos o cliente requisitando pelo IP dele próprio ao servidor e o servidor respondendo com o código 200 (OK) e o endereço IP.

REG USER 231 RAPADURA RESPONSE 200

Acima, temos o cliente registrando a senha RAPADURA para o usuário com registro acadêmico 231, supondo que esse RA existe no banco de dados, a responsa do servidor é simplesmente 200 (OK), caso contrário, a resposta seria 404 (usuário não encontrado).

ASK SECRET 231 RAPADURA RESPONSE 200 afdd98aed245892324bc

Acima, temos o cliente requisitando pela palavra secreta para o usuário 231, APÓS o registro da senha. O servidor respondeu com 200 (OK) e a palavra secreta em seguida, afdd98aed245892324bc.

BLA IP RESPONSE 501

Acima, o cliente requisita por um método inexistente BLA, o servidor responde com 501 (método não implementado).

ASK IPV6 RESPONSE 405

Acima, o cliente requisita um método ASK para um endpoint inexistente. O servidor responde com 405 (endpoint não permitido).

REG USER 231
RESPONSE 400

Acima, o cliente tenta registrar uma senha VAZIA para o usuário 231, o que não é permitido, sendo assim o servidor responde com 400 (parâmetros inválidos).

ASK SECRET 231 MINHASENHA RESPONSE 401

Acima, o cliente pede pela palavra secreta utilizando a senha errada para o usuário 231, o servidor responde com 401 (não autorizado).

Servidor
O código do servidor está pronto e disponível para consulta dos alunos em https://gitlab.com/bmeneg/umfg-projects/-/tree/main/redes/sockets, sendo que durante o desenvolvimento do cliente as informações do servidor são:

Endereço IP: 144.22.201.166
Porta TCP: 9000

É possível que o servidor não esteja operante na hora que for testar. Em caso de problemas ou dúvidas, por favor me avisem!

Objetivo Final
O objetivo do aluno é desenvolver um cliente que execute a seguinte ordem de requisições:

REG USER <RA> <SENHA> ASK SECRET <RA> <SENHA>

Desta forma, deverá ser submetido ao sistema do aluno (AVA) tanto o código do cliente como a palavra secreta final recebida pela resposta do servidor:

RESPONSE 200 <PALAVRA-SECRETA>

A requisição ASK IP poderá ser utilizada para testes durante o desenvolvimento, para basicamente testar a conexão com o servidor e também testar se o servidor está entendendo corretamente a requisição, assim como se o cliente recebe a resposta do servidor de maneira correta.
