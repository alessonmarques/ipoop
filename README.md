# 🚽 IPoop – Sistema Web de Avaliação e Ranqueamento de Banheiros Públicos

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat&logo=laravel)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-blue?style=flat)](https://livewire.laravel.com)
[![Leaflet.js](https://img.shields.io/badge/Leaflet.js-Map-green?style=flat)](https://leafletjs.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-blueviolet?style=flat&logo=tailwind-css)](https://tailwindcss.com)

---

## 📌 Sobre o Projeto

**IPoop** é um sistema web que permite o **cadastro, ranqueamento, avaliação e denúncia de banheiros públicos e privados** com foco em acessibilidade, localização e qualidade. A aplicação oferece um mapa interativo que exibe banheiros próximos e permite aos usuários colaborarem com informações valiosas para quem depende desses espaços, como pessoas com deficiência, entregadores, turistas e motoristas.

Este projeto foi desenvolvido como parte do **Trabalho de Conclusão de Curso (TCC)** por **Alesson Marques da Silva** para a obtenção do título de **Pós-Graduado em Desenvolvimento Full Stack** pela **PUCRS**.

---

## 🎯 Funcionalidades

- 📍 Mapa interativo com localização em tempo real
- 📝 Cadastro de banheiros com foto, descrição, tipo e acessibilidade
- ⭐ Avaliação com estrelas e comentários
- 🖼️ Upload de múltiplas imagens (carrossel)
- 🧼 Filtros por tipo e acessibilidade
- 🔒 Sistema de autenticação (login e cadastro)
- 📊 Painel administrativo com aprovação de banheiros, denúncias e moderação de conteúdo
- 🧾 Histórico do usuário: avaliações e contribuições
- 🚨 Denúncia de banheiros com justificativa

---

## 🧰 Tecnologias Utilizadas

- **Back-end:** Laravel 12 (PHP 8+)
- **Front-end:** Blade, Livewire, Tailwind CSS
- **Banco de dados:** MySQL
- **Mapas:** Leaflet.js + HTML Geolocation API
- **Ambiente local:** Docker com Lando
- **Upload de arquivos:** Laravel Storage (público)

---

## 📦 Instalação Local (Lando)

### Pré-requisitos
- Docker
- Lando

### Passos:

```bash
git clone git@github.com:alessonmarques/ipoop.git
cd ipoop
lando start
lando composer install
lando artisan migrate:fresh --seed
```

Acesse o projeto em: [http://ipoop.lando.site](http://ipoop.lando.site)

---

## 🔐 Tipos de Usuário

| Tipo           | Permissões                                                                   |
|----------------|------------------------------------------------------------------------------|
| **Anônimo**    | Visualizar mapa e banheiros                                                  |
| **Usuário**    | Avaliar, denunciar, cadastrar banheiros                                      |
| **Administrador** | Moderar banheiros, denúncias, excluir fotos e aprovar/rejeitar avaliações |

---

## 👨‍🎓 Créditos

Este projeto foi desenvolvido como parte do **Trabalho de Conclusão de Curso** de:

**Alesson Marques da Silva**  
**Pós-graduação em Desenvolvimento Full Stack – PUCRS**  
Ano: **2024/2025**

---

## 📄 Licença

Este é um projeto acadêmico, desenvolvido com fins educacionais.  
Licenciamento conforme orientação institucional.
