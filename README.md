
# ReviewMe

## Overview

**ReviewMe** is a worldwide place review application. It allows users to search for and discover places to eat, walk, engage in sports, and much more. Users can share their experiences by reviewing these places, helping others make informed decisions.

## Collaborators

- **NOURINE Abdelmalek**
    - **Email**: nourinemalek01@gmail.com
    - **GitHub**: [github.com/maliko18](https://github.com/maliko18)

- **Souhila BENACHOUR**
    - **Email**: souhila.benachour@etudiant.univ-lr.fr
    - **GitHub**: [github.com/SouhilaBENACHOUR](https://github.com/SouhilaBENACHOUR)

- **HADDADO Lina**
    - **Email**: lina.haddado@etudiant.univ-lr.fr
    - **GitHub**: [github.com/Lina-Hadd](https://github.com/Lina-Hadd)

- **Nesrine REKAI**
    - **Email**: nesrine.rekai@etudiant.univ-lr.fr
    - **GitHub**: [github.com/NesrineREKAI](https://github.com/https://github.com/NesrineREKAI)

- **GOUIRAH Farid**
    - **Email**: farid.gouirah@etudiant.univ-lr.fr
    - **GitHub**: [github.com/GouirahFarid](https://github.com/GouirahFarid)


## Features

- Search for places based on activity (eating, walking, sports, etc.)
- Review and rate places
- Server-side routing with Laravel
- Reactive UI powered by Vue 3
- Single-page application (SPA) experience using Inertia.js
- TailwindCSS for modern styling
- Easy-to-configure and extend architecture

## Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- npm or Yarn
- MySQL or any supported database

## Installation

1. Clone the repository:

   ```bash
   git clone git@github.com:GouirahFarid/review-me.git
   cd review-me
   ```

2. Install dependencies:

   ```bash
   composer install
   npm install
   ```

3. Configure the environment:

   Copy the `.env.example` file to `.env` and update the database and other configuration variables:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Migrate and seed the database:

   Before running the migration command, ensure that the application is connected to the database by verifying the `.env` file configuration.

   Run the following command to refresh and seed the database:

   ```bash
   php artisan migrate:fresh --seed
   ```

   **Note**: Running the seeder is mandatory.

5. Build assets (optional for local development):

   ```bash
   npm run dev
   ```

6. Start the development server:

   ```bash
   php artisan serve
   ```

   The application should now be running at `http://localhost:8000`.

## Default User Login

- **Email**: `super@admin.com`
- **Password**: `password`

## Project Structure

- **Backend**: Laravel handles the server-side logic, routes, and database interactions.
- **Frontend**: Vue 3 provides the reactive user interface.
- **Inertia.js**: Bridges the backend and frontend, allowing seamless communication without traditional API endpoints.

## Usage
## Routes

- `/` : Home page
- `/login` : Login page
- `/register` : Register page
- `/places` : List places page
- `/places/{place_id}` : Place details page
- `/admin` : Admin dashboard

### Running in Development

- Watch for frontend changes:

  ```bash
  npm run watch
  ```

### Production Build

1. Build the frontend assets:

   ```bash
   npm run build
   ```

2. Serve the application:

   ```bash
   php artisan serve --env=production
   ```



  ```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your improvements.



