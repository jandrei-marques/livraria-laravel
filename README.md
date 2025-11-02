# Sistema de Livraria - Laravel

Sistema completo de cadastro de livros, autores e assuntos desenvolvido em Laravel com Docker.

## 🚀 Tecnologias

- **Laravel 12**
- **Docker & Sail**
- **MySQL**
- **AdminLTE 3**
- **Bootstrap 5**
- **Select2**
- **SweetAlert2**

## 📋 Funcionalidades

- ✅ CRUD completo de Livros, Autores e Assuntos
- ✅ Relacionamentos muitos-para-muitos
- ✅ Interface administrativa com AdminLTE
- ✅ Validações customizadas em português
- ✅ Relatórios com views do banco
- ✅ Dockerização completa
- ✅ Buscas e filtros avançados

## 🛠️ Instalação

```bash
# Clonar repositório
git clone https://github.com/jandrei-marques/livraria-laravel.git

# Entrar no diretório
cd livraria-laravel

# Subir containers
./vendor/bin/sail up -d

# Instalar dependências
./vendor/bin/sail composer install

# Executar migrations
./vendor/bin/sail artisan migrate

# Acessar aplicação
http://localhost
