# Projeto IPoop

Sistema web para ranqueamento e avaliação de banheiros públicos.

## 🚀 Tecnologias
- Laravel 10
- PHP 8.2
- MySQL 8
- Lando (Docker)
- Blade + Livewire
- Tailwind CSS
- Leaflet.js (Mapas)

## ⚙️ Setup Local com Lando

### 1. Instalar dependências
```bash
composer install
npm install
```

### 2. Iniciar o ambiente
```bash
lando start
```

### 3. Gerar chave da aplicação
```bash
lando artisan key:generate
```

### 4. Rodar migrations
```bash
lando artisan migrate
```

### 5. Acessar a aplicação
[http://ipoop.lando.site](http://ipoop.lando.site)