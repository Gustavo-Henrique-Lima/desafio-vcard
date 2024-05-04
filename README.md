<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Como Rodar o Projeto
### Pré-requisitos

- PHP 8.2 ou superior
- Composer 2.0 ou superior
- MySQL 5.7 ou superior

### Passos

1. **Clonar o Repositório:**

   ## Caso esteja com a chave SSH configurada no seu computador
   ```bash
   git clone git@github.com:Gustavo-Henrique-Lima/desafio-vcard.git
   ````

   ## Caso não esteja com a chave SSH configurada no seu computador
    ```bash
    git clone git@github.com:Gustavo-Henrique-Lima/desafio-vcard.git
     ````

2. **Navegue até o diretório do projeto:**

    ```bash
    cd desafio-vcard/vcardProject
    ````

3. **Instale as dependências:**

    ```bash
    composer install
4. **Crie arquivo .env:**
    ```bash
    cp .env.example .env
5. **Atualize as variáveis de ambiente do arquivo .env:**  
    ### As variáveis que precisam ser atualizadas para rodar o projeto estão nas linhas 23 a 28 do arquivo .env, altere ela conforme as configurações da sua máquina (certifique-se de que a base de dados que você irá informar aqui já exista)
    ```bash
    DB_CONNECTION=seuSgbd
    DB_HOST=127.0.0.1
    DB_PORT=3306 (Porta padrão de alguns SGBDs, verifique o seu e veja se é necessário alterar algo)
    DB_DATABASE=suaBaseDados
    DB_USERNAME=seuUsuario
    DB_PASSWORD=senhaDoSeuUsuario
    ```
6. **Rodar as migrations:**
    ### Após configurar suas variáveis rode as migrations que irão criar as tabelas no sua base de dados
    ```bash
    php artisan key:generate
    php artisan migrate
    ```
    
7. **Inicie o servidor de desenvolvimento:**
    ```bash
   php artisan serve
   ```
    
### Agora o servidor está rodando na porta 8000
## Funcionalidades
   ### Contatos

  #### Importar uma lista de contatos a partir de um arquivo .vcf:
    A aplicação dispõe de uma view que permite ao usuário anexar um arquivo .vcf para realizar a importação de todos os 
    contatos presentes no arquivo para a base de dados.
    Com o servidor rodando acesse http://127.0.0.1:8000/contacts através do seu navegador para importar o arquivo com os contatos.
      
  #### Visualizar contatos existentes:
    A aplicação dispõe de uma view que permite ao usuário visualizar todos os contatos que foram salvos na base de dados 
    através da importação.
    Com o servidor rodando acesse http://127.0.0.1:8000/contacts/view através do seu navegador para visualizar todos os contatos.

  ### API
    A aplicação dispõe de uma API para permitir a integração com outros sistemas, essa API retorna uma lista de 
    contatos salvos na base dados.
    Com o servidor rodando acesse o endpoint http://127.0.0.1:8000/api/contacts/getall através do seu navegador ou outro software
    de preferência como postman ou thunderclient.
    Esse endpoint retorna um JSON com todos os contatos e suas informações.
        
## Documentação

  O projeto inclui documentação detalhada para facilitar o entendimento e a interação com a aplicação.
  A seguir estão os recursos de documentação disponíveis.

  ### Swagger

   A API é documentada usando o Swagger, que fornece uma interface interativa para explorar os endpoints 
  da aplicação.
  ### Acesso ao Swagger:
  **Com o projeto rodando**
  
  O Swagger pode ser acessado através do link: [Swagger UI](http://localhost:8000/api/documentation#/).
  
  A interface do Swagger oferece uma visão interativa dos endpoints, permitindo testar as operações
  diretamente na documentação.

## Testes 
  ### A aplicação conta com alguns testes unitários e de integração que são responsáveis por verificar e validar as funcionalidades do sistema, os testes estão na pasta /tests, para executar os testes execute o seguinte comando
  ```bash
  php artisan test
  ```
    

