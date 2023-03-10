<div id="top"></div>

<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
<div align="center">

[![License][license-shield]][license-url]
[![PHP][php-shield]](#)
[![Symfony][symfony-shield]](#)

</div>


<!-- PROJECT LOGO -->
<br />
<div align="center">

<h3 align="center">Tests développeurs - API</h3>

  <p align="center">
    Tests technique pour le recrutement des développeurs
    <br />
    <a href="#"><strong>Documentation »</strong></a>
    <br />
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

Ce projet est utilisé en tant que test technique pour le recrutement de nouveau développeurs fullstack Symfony/React.js

Il s'agit ici du projet "API" développé sous symfony 5.4

<p align="right">(<a href="#top">back to top</a>)</p>


### Built With

* [Symfony](https://symfony.com/)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

Ce projet est basé sur symfony, suivre les instructions ci-dessous pour toute nouvelle installation du projet

### Prerequisites

Installer Composer et PHP 8.1:
* [https://getcomposer.org/download/](https://getcomposer.org/download/)
* [https://www.php.net/downloads](https://www.php.net/downloads)


* Mettre à jour composer
  ```sh
  composer selfupdate
  ```

### Installation

1. Cloner le repo
   ```sh
   git clone [depot-url]
   ```
2. Installer les vendor Symfony
   ```sh
   composer install
   ```
3. créer un .env.local à partir du .env présent à la racine du dossier
   ```sh
   cp .env .env.local
   ```
4. Modifier les lignes suivantes dans le .env.local
   ```
   - DATABASE_URL
   - JWT_PASSPHRASE
   ```
5. Générer les fichiers **config/jwt/private.pem** et **config/jwt/public.pem**
   
   > *Attention à bien noter le mot de passe utilisé pour générer ces fichiers*
   ```sh
   openssl genrsa -out config/jwt/private.pem -aes256 4096
   openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
   ```
6. Créer la base de données
   ```sh
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
7. Exécuter le fichier create_basic_data.sql pour ajouter les utilisateurs par défaut
   ```sh
   mysql -u root -p testdevs < create_basic_data.sql
   ```
<p align="right">(<a href="#top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

#### TODO: Remplir cette section

_Pour plus d'exemples, voir la [Documentation](/)_

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [x] Endpoint utilisateurs
- [x] Connexion avec JWT
- [ ] Ajouter un endpoint pour gérer les produits

Pour plus de détails, voir [le cahier des charges](#) ou [la maquette](#)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- LICENSE -->
## License

Licence Nextaura, voir le fichier `LICENSE.md` pour plus d'informations.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Contact principal :
- Jean-Marc JACQUOT - [jmjacquot@nextaura.com](mailto:jmjacquot@nextaura.com)

Développeurs :
- Sébastien RINGOT - [sringot@nextaura.com](mailto:sringot@nextaura.com)


<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[license-shield]: https://img.shields.io/badge/License-Nextaura-00C5E6?style=flat-square
[license-url]: /LICENSE.md
[php-shield]: https://img.shields.io/badge/php-%3E%3D8.1.0-blue?style=flat-square
[symfony-shield]: https://img.shields.io/badge/Symfony-%5E5.4-1E3A8A?style=flat-square
[project-link]: /
