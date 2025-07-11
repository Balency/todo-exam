# Todo (exam)

Une API REST simple de gestion de tâches (todos) en PHP et MySQL, sans authentification.

## Installation

1. **Cloner le dépôt**  
   Placez le dossier dans le répertoire `htdocs` de XAMPP.

2. **Créer la base de données**  
   Importez le fichier [`init.sql`](init.sql) dans phpMyAdmin ou via la ligne de commande MySQL.

3. **Configurer l'accès à la base**  
   Vérifiez les identifiants dans [`config/Database.php`](config/Database.php).

4. **Lancer le serveur**  
   Démarrez Apache et MySQL via XAMPP.  
   Accédez à [http://localhost/todo-exam](http://localhost/todo-exam).

## Utilisation de l'API

- **GET /**  
  Message de bienvenue.

- ** Endpoints à implémenter**  
  - `GET /todos` : Retourne la liste des todos **publics** et **secrets accessibles** si une clé est fournie.  
    - Pour afficher un todo secret, ajoutez un header : `Secret-Key: votre_clé_secrète`
  - `POST /todos` : Crée un nouveau todo.
  - `PUT /todos/{id}` : modifier une todo
  - `DELETE /todos/{id}` : supprimer une todo 
