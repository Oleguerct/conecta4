# Conecta4

Aquest projecte és una implementació del joc Conecta 4 utilitzant Symfony per al backend i React per al frontend.

## Característiques
- Joc de Conecta 4 multijugador.
- Backend desenvolupat amb Symfony (PHP).
- API RESTful per a la gestió de partides i usuaris.
- Frontend desenvolupat amb React.
- Comunicació en temps real mitjançant Mercure.
- Gestió d'usuaris i partides.
- Sistema de comprovació de guanyador automàtic.

## Estructura del projecte
- `src/` - Codi font del backend Symfony (controladors, entitats, serveis, etc.).
- `assets/react_app/` - Codi font del frontend React.
- `public/` - Arrel pública del projecte (arxius accessibles via web).
- `config/` - Configuració de Symfony i paquets.
- `migrations/` - Migracions de base de dades.
- `tests/` - Tests automatitzats.

## Requisits
- PHP >= 8.1
- Composer
- Node.js i npm
- Symfony CLI (opcional però recomanat)
- Docker (opcional, per a desenvolupament fàcil)

## Instal·lació
1. Clona el repositori.
2. Instal·la les dependències del backend:
   ```bash
   composer install
   ```
3. Instal·la les dependències del frontend:
   ```bash
   cd assets/react_app
   npm install
   ```
4. Configura la base de dades i l'entorn segons la documentació de Symfony.
5. Executa les migracions:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```
6. Inicia el servidor de desenvolupament:
   ```bash
   symfony serve
   # o utilitza docker-compose
   docker-compose up
   ```
7. Compila el frontend:
   ```bash
   cd assets/react_app
   npm run dev
   ```

## Tests
- Per executar els tests del backend:
  ```bash
  ./bin/phpunit
  ```

## Autor
Projecte desenvolupat per Oleguer.
