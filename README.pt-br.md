<h1 align="center">
    Library Management API
</h1>

<p align="center">
    <img
        src="https://i.imgur.com/6qUVWfx.png"
        width="200"
        title="Library Management API Logo"
        alt="Library Management API Logo"
    />
</p>

<p align="center">
    API Rest simples em <a href="https://docs.mezzio.dev/mezzio/">Laminas Mezzio</a> que realiza o gerenciamento de empréstimos de livros.
    <br>
    <b>English version of this README.md <a href="https://github.com/Arekushi/library-management-api/blob/master/README.md">here</a></b>
</p>

## 📌 Sobre o Projeto
Teste técnico proposto pela [Live eCommerce][liveecommerce], sendo uma das primeiras etapas a serem realizadas.

Nessa etapa é necessário que o projeto atenda algumas específicações, e que dei o meu melhor para atendê-las. [Aqui][test_repo] está o link do repositório com as especificações.

O projeto consiste em um sistema de gerenciamento de livros, para ser mais específico, empréstimos de livros, então pessoas podem pegar livros emprestados e devolver-los.

Nesse documento de *README*, irei detalhar alguns pontos que achei interessante comentar, além de claro, deixar documentado todo meu trabalho realizado, assim, servindo como repositório para consulta e portifólio pessoal.

## 🔨 Construído com
- [PHP v8.2.0][php]
- [Laminas Mezzio v3.7][laminas_mezzio]
- [Cycle ORM v2.9][cycle]

## 🌠 Primeiros passos
Para testar o projeto, alguns pré-requisitos são necessários.

### 📜 Pré-requisitos
* Docker
    1. Você pode baixar aqui: [Docker][docker_url]
    2. Aqui tem um tutorial passo-a-passo. [(Windows)][docker_tutorial_windows] [(Linux)][docker_tutorial_linux]


### 📥 Instalação
1. Faça um clone do repositório
    ```sh
    git clone https://github.com/Arekushi/library-management-api.git
    ```
2. Rode este comando no terminal
    ```sh
    docker-compose up -d --build
    ```
    > Espere até que as migrações sejam realizadas e que o Apache seja inicialiado
    ![Docker example](https://i.imgur.com/nHx3U1K.png)
3. Tudo certo, a aplicação já está no ar 🎉
4. Rode este comando no terminal para realizer os testes **UNITÁRIOS**
    ```sh
    composer run test
    ```

## 📑 Swagger
Você pode ver todas as rotas indo para o endpoint: [`http://127.0.0.1:8080/api`](http://127.0.0.1:8080/api)
<p align="center">
    <img
        src="https://i.imgur.com/QhUJxb2.png"
        width="800"
        title="Swagger Image"
        alt="Swagger Image"
    />
</p>

## 🗃️ Schema
<p align="center">
    <img
        src="https://i.imgur.com/rxGEjDJ.png"
        width="1000"
    />
</p>

Esse é o esquema do banco de dados desenvolvido, somente com 4 entidades: `book`, `loan`, `person` e `telephone`.

Como não foi fornecido um diagrama ER (entidade-relacionamento), criei um que fizesse sentido e atendesse os requisitos.

A entidade `telephone` realmente não precisava existir, mas usei ela para testar o uso do mapper, para ver como usar ele quando há uma coleção de objetos em uma entidade.

A entidade `book` também está bem simples, não havendo nada de especial.

A entidade `loan` sinto que poderia ser mais complexa, podendo manejar o empréstimos de N livros de uma só vez, mas dessa forma funciona para o propósito do exercício.

## 📦 Diretórios relevantes
Aqui deixarei alguns diretórios e arquivos que podem ajudar na análise

* src/Abstract/
    * [BaseHandler.php](https://github.com/Arekushi/library-management-api/blob/main/src/App/src/Abstract/BaseHandler.php)
    * [BaseModel.php](https://github.com/Arekushi/library-management-api/blob/main/src/App/src/Abstract/BaseModel.php)
    * [BaseRepository.php](https://github.com/Arekushi/library-management-api/blob/main/src/App/src/Abstract/BaseRepository.php)
    * [BaseService.php](https://github.com/Arekushi/library-management-api/blob/main/src/App/src/Abstract/BaseService.php)
* src/Aspect/
    * [JsonBodyValidatorAspect.php](https://github.com/Arekushi/library-management-api/blob/main/src/App/src/Aspect/JsonBodyValidatorAspect.php)
* src/Person/src/
    * Model/
        * [Person.php](https://github.com/Arekushi/library-management-api/blob/main/src/Person/src/Model/Person.php)
        * [Telephone.php](https://github.com/Arekushi/library-management-api/blob/main/src/Person/src/Model/Telephone.php)
* src/Library/src
    * Model/
        * [Book.php](https://github.com/Arekushi/library-management-api/blob/main/src/Library/src/Model/Book.php)
        * [Loan.php](https://github.com/Arekushi/library-management-api/blob/main/src/Library/src/Model/Loan.php)
    * Handler/
        * [LoanHandler.php](https://github.com/Arekushi/library-management-api/blob/main/src/Library/src/Handler/LoanHandler.php)
    * Service/
        * [LoanService.php](https://github.com/Arekushi/library-management-api/blob/main/src/Library/src/Service/LoanService.php)
    * Repository/
        * [LoanRepository.php](https://github.com/Arekushi/library-management-api/blob/main/src/Library/src/Repository/LoanRepository.php)


## 🤔 Por que Laminas Mezzio?
Ao me deparar com o desafio sendo em PHP,  eu sabia que precisaria de um framework robusto para lidar com as requisições, nisso inicialmente pensei no [Laravel][laravel], que é bem popular, bastante  robusto e fácil de usar, mas como o desafio era em PHP, além disso, na descrição da vaga específicava que seria interessante conhecimento em [Zend Framework][zendframework]/[Laminas Mezzio][laminas_mezzio], tentei me aventurar nesse framework para este projeto.

Sim, foi um desafio e tanto, eu não programava em PHP há anos, então ter que me acostumar como a forma de programar em PHP demorou um pouqinho, além de entender alguns elementos que compõem o Laminas Mezzio.  Mas, foi uma experiência incrível, e eu acho que consegui aprender bastante com isso, não é o meu framework favorito, nem de longe, mas é capaz de atender as necessidades dependendo do projeto.

A documentação do Laminas Mezzio eu considero ruim, não é muito explicativa para novatos, e conteúdo na internet é escasso, é como se ninguém usasse esse framework, ou se usa, não divulga nenhum material na internet. Então fico feliz em deixar meu repositório aqui, aberto para que qualquer um consiga consultar e aprender com ele.


## ♾️ Por que Cycle ORM
Pensando em um ORM para usar com o Laminas Mezzio, pensei inicialmente no [Doctrine][doctrine], um ORM famoso e bem robusto, porém encontrei dificuldades em tentar integrar ele com o Laminas Mezzio. Não tenho certeza, mas aparentemente ele foi pensado para o [Laminas MVC][laminasmvc]. O único [repositório][doc_mezzio_repo] que encontrei que tinha uma integração do Doctrine com o Laminas Mezzio, está bem desatualizado, e não funcionou como esperado.

Então pensando nisso, perguntei ao ChatGPT, se haviam outros ORMs, e claro que ele me sugeriu alguns, sendo o [LaminasDB][laminasdb] e o [Cycle ORM][cycle].

A escolha mais simples, seria usar o LaminasDB, pois ele já faz parte do ecossistema do Laminas, então a integração seria simples, e foi, porém, nos primeiros testes notei que ele é muito cru, não há muitas features que ajudem e auxiliem no desenvolvimento, o que me fez repensar no uso dele.

O Cycle ORM não tem uma página falando sobre a integração dele com o Laminas Mezzio, mas mesmo assim tentei integrar ele, consegui, e depois encontrei um repositório que já realizava essa integração de maneira mais robusta, tive que fazer um [fork][cycle_fork] do projeto para arrumar alguns bugs e atualizar as dependências, e no fim, deu tudo certo.

Cycle ORM é recheado de features legais para se usar, ele parece bem robusto, me lembrou um pouco do [Prisma][prisma], que eu já usei em projetos anteriores.

Única coisa que senti que não ficou bom, foi o schema de migrações, elas não funcionam muito bem, ou como deveriam, então eu sempre tive que apagar a última migrate e recriar, assim funcionava. Também reconheci um bug em uma linha de código do projeto, e que para arrumar acabei fazendo um [script][cycle_bug_script] para editar a linha, para uma que correspondesse ao comportamento esperado.

O projeto tem potencial, mas sinto que ele tá meio largado as traças, fazendo um bom tempo que não há grandes atualizações.

## 💻 Desenvolvimento
### ✅ Testes Unitários
Isso não é algo que faço com tanta frequência, e confesso que é até um pouco difícil de pensar em lógica para criar testes que façam sentido. Não fiz os melhores testes, isso eu reconheço, ainda dá pra melhorar bastante, de todo modo, foi um aprendizado e prática adicional na criação de testes unitários.

### 🌓 Orientação a Aspecto
Um paradigma de programação não tão popular, mas que tenho um certo apreço é a [**Orientação a Aspecto**][aop_url]. Ela é interessante pela possibilidade de modularização e reutilização de código.

Nesse projeto, fiz um [aspecto][json_aspect], que realizava a validação do corpo JSON quando houvesse. O que pode ser feito dentro do próprio método, sem o auxílio de um **aspecto**, porém, pensando em desenvolvimento, vejo como algo benéfico, separar a regra de negócio de determinadas ações que de certa forma *"poluem"* o código. O objetivo sempre é atingir um nível alto de manutenção de código, e com orientação a aspectos isso pode ser facilitado.

### 🐋 Docker e containers
Docker parece um bicho de 7 cabeças, mas não é exatamente assim, ele é uma ferramente bem robusca e que proporciona maior facilidade na hora de trabalhar, tornar o projeto escalável, portabilizar ele, por fim, implantar.

Minha implementação atualmente tem somente dois serviços, sendo eles, a API e o banco de dados, mas se for adicionar o *front-end*, por exemplo, é mais uma imagem *'buildada'* para dentro do conteiner que é esse projeto.

### ❌ Validações e Exception Handler
Como solicitado, permaneci atento a saída esperada em cada endpoint, e em cada resposta dado algum contexto.

Nisso a lib [Symfony][symfony] ajudou bastante, de uma maneira bem simples, é possível adicionar validações em uma classe,  e assim, quando uma validação falhar, ela irá lançar uma exceção, que  pode ser capturada e tratada no *ExceptionHandler*.

```php
#[OAT\Schema(schema: 'CreatePersonRequest')]
class CreatePersonRequest
{
    #[Assert\NotBlank(message: "The name cannot be empty.")]
    #[Assert\Length(min: 3, minMessage: "The name must be at least 3 characters long.")]
    #[OAT\Property(type: 'string')]
    public string $name;

    #[Assert\NotBlank(message: "The email cannot be empty.")]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email address.")]
    #[OAT\Property(type: 'string')]
    public string $email;
}
```
Aqui um exemplo bobo do objeto de request quando se cria uma pessoa, cada [**attribute**][attribute] é possível adicionar uma validação, e se falhar, é lançado uma exceção.


### 🔎 Swagger (OpenAPI)
Como é de praxe, sempre documento minhas rotas usando o Swagger,  que é uma ferramenta bem robusta e que facilita a documentação das rotas, e também a comunicação entre os desenvolvedores.

Para implementar o Swagger, foi necessário criar um [fork][swagger_fork] de uma implementação do Swagger com o Laminas Mezzio e arrumar as dependências e alguns bugs ocasionados pelas novas versões.

### 😜 Commits
Todas as commits possuem um emoji como  prefixo, que indica o tipo de alteração, e também uma mensagem que descreve.

Esses emojis foram baseados nesse site [aqui][emojigit], que apresenta vários emojis e alguns significados para o uso.

## 👍 Reconhecimentos
Aqui está um [link][acknowledgments] de uma página no Notion, onde estão materiais que me apoiaram no desenvolvimento dessa aplicação. 😉

## 👨‍💻 Contribuidores
| [<div><img width=115 src="https://avatars.githubusercontent.com/u/54884313?v=4"><br><sub>Alexandre Ferreira de Lima</sub><br><sub>alexandre.ferreira1445@gmail.com</sub></div>][arekushi] <div title="Code">💻</div> |
| :---: |

<!-- [Build With] -->
[php]: https://www.php.net/releases/8.3/en.php
[laminas_mezzio]: https://docs.mezzio.dev/mezzio/
[cycle]: https://cycle-orm.dev/

<!-- [Some links] -->
[liveecommerce]: https://www.liveecommerce.com.br/
[test_repo]: https://github.com/liveecommerce/php-test-jr
[laravel]: https://laravel.com/
[swagger]: https://swagger.io/
[doctrine]: https://www.doctrine-project.org/
[postgres]: https://www.postgresql.org/
[laminasmvc]: https://docs.laminas.dev/mvc/
[doc_mezzio_repo]: https://github.com/skar/laminas-doctrine-orm
[laminasdb]: https://docs.laminas.dev/laminas-db/
[prisma]: https://www.prisma.io/
[cycle_bug_script]: https://github.com/Arekushi/library-management-api/blob/main/bin/file-line-editor.php
[zendframework]: https://framework.zend.com/
[json_aspect]: https://github.com/Arekushi/library-management-api/blob/main/src/App/src/Aspect/JsonBodyValidatorAspect.php
[symfony]: https://symfony.com/
[attribute]: https://www.php.net/manual/en/language.attributes.overview.php
[cycle_fork]: https://github.com/Arekushi/cycle-orm-factory
[swagger_fork]: https://github.com/Arekushi/php-swagger-module
[aop_url]: https://en.wikipedia.org/wiki/Aspect-oriented_programming
[emojigit]: https://gitmoji.dev/
[docker_url]: https://www.docker.com/products/docker-desktop/
[docker_tutorial_windows]: https://www.simplilearn.com/tutorials/docker-tutorial/install-docker-on-windows
[docker_tutorial_linux]: https://www.chakray.com/complete-guide-to-installing-docker-in-linux-simple-steps-and-useful-tips/
[acknowledgments]: https://arekushi.notion.site/Acknowledgements-1149471ad92280b68520df4db368e0df?pvs=4

<!-- [Constributors] -->
[arekushi]: https://github.com/Arekushi
