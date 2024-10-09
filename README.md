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
    Simple REST API in <a href="https://docs.mezzio.dev/mezzio/">Laminas Mezzio</a> for managing book loans.
    <br>
    <b>Portuguese version of this README.md <a href="https://github.com/Arekushi/library-management-api/blob/master/README.pt-br.md">here</a></b>
</p>

## 📌 About the Project
Technical test proposed by [Live eCommerce][liveecommerce], being one of the first stages to be performed.

In this stage, the project needs to meet certain specifications, and I did my best to address them. [Here][test_repo] is the link to the repository with the specifications.

The project consists of a book management system, specifically for book loans, allowing people to borrow and return books.

In this README document, I will detail some points I found interesting to comment on, in addition to documenting all the work I have done, thus serving as a repository for reference and personal portfolio.

## 🔨 Built with
- [PHP v8.2.0][php]
- [Laminas Mezzio v3.7][laminas_mezzio]
- [Cycle ORM v2.9][cycle]

## 🌠 Getting Started
To test the project, some prerequisites are necessary.

### 📜 Prerequisites
* Docker
    1. You can download it here: [Docker][docker_url]
    2. Here is a step-by-step tutorial. [(Windows)][docker_tutorial_windows] [(Linux)][docker_tutorial_linux]

### 📥 Installation
1. Clone the repository
    ```sh
    git clone https://github.com/Arekushi/library-management-api.git
    ```
2. Run this command in the terminal
    ```sh
    docker-compose up -d --build
    ```
3. Everything is set, the application is up and running 🎉
4. Run this command in the terminal to perform **UNIT TESTS**
    ```sh
    composer run test
    ```

## 📑 Swagger
You can see all the routes by going to the endpoint: [`http://127.0.0.1:8080/api`](http://127.0.0.1:8080/api)
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

This is the database schema developed, consisting of only 4 entities: `book`, `loan`, `person`, and `telephone`.

Since no ER (entity-relationship) diagram was provided, I created one that made sense and met the requirements.

The `telephone` entity did not necessarily need to exist, but I used it to test the use of the mapper, to see how to use it when there is a collection of objects in one entity.

The `book` entity is also quite simple, with nothing special.

The `loan` entity could have been more complex, potentially managing the loan of multiple books at once, but this way it works for the purpose of the exercise.

## 📦 Relevant Directories
Here are some directories and files that may help in the analysis.

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


## 🤔 Why Laminas Mezzio?
When faced with the challenge in PHP, I knew I would need a robust framework to handle the requests. Initially, I thought of [Laravel][laravel], which is quite popular, robust, and easy to use. However, since the challenge was in PHP and the job description specified that knowledge of [Zend Framework][zendframework]/[Laminas Mezzio][laminas_mezzio] would be interesting, I decided to venture into this framework for this project.

Yes, it was quite a challenge; I hadn’t programmed in PHP for years, so getting used to PHP programming took me a little while, as well as understanding some elements that compose Laminas Mezzio. But it was an incredible experience, and I feel I learned a lot from it. It’s not my favorite framework by far, but it can meet the needs depending on the project.

I consider the documentation of Laminas Mezzio to be poor; it is not very explanatory for newcomers, and content on the internet is scarce. It’s as if no one uses this framework, or if they do, they don’t share any material online. So I’m happy to leave my repository here, open for anyone to consult and learn from it.

## ♾️ Why Cycle ORM
When considering an ORM to use with Laminas Mezzio, I initially thought of [Doctrine][doctrine], a famous and robust ORM. However, I encountered difficulties trying to integrate it with Laminas Mezzio. I’m not sure, but apparently, it was designed for [Laminas MVC][laminasmvc]. The only [repository][doc_mezzio_repo] I found that had an integration of Doctrine with Laminas Mezzio is quite outdated and did not work as expected.

So, thinking about this, I asked ChatGPT if there were other ORMs, and of course, it suggested several, including [LaminasDB][laminasdb] and [Cycle ORM][cycle].

The simplest choice would be to use LaminasDB, as it is already part of the Laminas ecosystem, making integration straightforward, which it was. However, in the first tests, I noticed that it is very basic; there aren’t many features to help and aid in development, which made me reconsider using it.

Cycle ORM does not have a page discussing its integration with Laminas Mezzio, but I tried to integrate it anyway, and I succeeded. Later, I found a repository that already had this integration in a more robust way, and I had to fork the project to fix some bugs and update the dependencies, and in the end, everything worked out.

Cycle ORM is packed with cool features; it seems quite robust and reminded me a bit of [Prisma][prisma], which I have used in previous projects.

The only thing I felt didn’t work well was the migration schema; they didn’t work as they should, so I always had to delete the last migration and recreate it to make it work. I also identified a bug in a line of code in the project, and to fix it, I ended up creating a [script][cycle_bug_script] to edit the line to correspond to the expected behavior.

The project has potential, but I feel it’s somewhat neglected, as it has been quite a while since there were any significant updates.

## 💻 Development
### ✅ Unit Tests
This is not something I do very often, and I confess that it’s a bit challenging to think of logic to create tests that make sense. I didn’t create the best tests; I recognize that. There is still a lot of room for improvement. Nevertheless, it was a learning experience and an additional practice in creating unit tests.

### 🌓 Aspect-Oriented Programming
A programming paradigm that isn’t very popular, but one I have a certain appreciation for is [**Aspect-Oriented Programming**][aop_url]. It is interesting due to the possibility of modularization and code reuse.

In this project, I created an [aspect][json_aspect] that validated the JSON body when present. This could be done within the method itself without the aid of an **aspect**, but from a development standpoint, I see it as beneficial to separate the business logic from certain actions that somewhat *“pollute”* the code. The goal is always to achieve a high level of code maintainability, and aspect-oriented programming can facilitate this.

### 🐋 Docker and Containers
Docker seems like a complex beast, but it is not quite so; it is a robust tool that provides greater ease in working, making the project scalable, portable, and ultimately deployable.

My current implementation has only two services: the API and the database. However, if I were to add a *frontend*, for instance, it would just be another *built* image inside this project’s container.

### ❌ Validations and Exception Handler
As requested, I paid attention to the expected output at each endpoint and in every response given some context.

In this, the [Symfony][symfony] library helped quite a bit. In a very simple way, it is possible to add validations in a class, and thus, when a validation fails, it will throw an exception that can be caught and handled in the *ExceptionHandler*.

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
Here is a simple example of the request object when creating a person. Each [**attribute**](https://www.php.net/manual/en/language.attributes.overview.php) allows you to add a validation, and if it fails, an exception is thrown.

### 🔎 Swagger (OpenAPI)
As is customary, I always document my routes using Swagger, which is a robust tool that facilitates the documentation of routes and communication between developers.

To implement Swagger, it was necessary to create a [fork](https://github.com/Arekushi/php-swagger-module) of an implementation of Swagger with Laminas Mezzio and fix the dependencies and some bugs caused by the new versions.

### 😜 Commits
All commits have an emoji as a prefix that indicates the type of change, along with a message that describes it.

These emojis were based on this site [here](https://gitmoji.dev/), which presents several emojis and some meanings for their use.

## 👍 Acknowledgments
Here is a [link](https://arekushi.notion.site/Acknowledgements-1149471ad92280b68520df4db368e0df?pvs=4) to a page on Notion, where you can find materials that supported me in the development of this application. 😉

## 👨‍💻 Contributors
| [<div><img width=115 src="https://avatars.githubusercontent.com/u/54884313?v=4"><br><sub>Alexandre Ferreira de Lima</sub><br><sub>alexandre.ferreira1445@gmail.com</sub></div>](https://github.com/Arekushi) <div title="Code">💻</div> |
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
[cycle_fork]: https://github.com/Arekushi/cycle-orm-factory
[swagger_fork]: https://github.com/Arekushi/php-swagger-module
[aop_url]: https://en.wikipedia.org/wiki/Aspect-oriented_programming
[emojigit]: https://gitmoji.dev/
[docker_url]: https://www.docker.com/products/docker-desktop/
[docker_tutorial_windows]: https://www.simplilearn.com/tutorials/docker-tutorial/install-docker-on-windows
[docker_tutorial_linux]: https://www.chakray.com/complete-guide-to-installing-docker-in-linux-simple-steps-and-useful-tips/
[acknowledgments]: https://arekushi.notion.site/Acknowledgements-1149471ad92280b68520df4db368e0df?pvs=4

<!-- [Contributors] -->
[arekushi]: https://github.com/Arekushi
