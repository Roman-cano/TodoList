# TodoList

Une application de gestion de tâches construite avec Symfony, utilisant XAMPP et MySQL pour la gestion de la base de données.

## Fonctionnalités

- Ajouter de nouvelles tâches.
- Modifier des tâches existantes.
- Supprimer des tâches.
- Marquer les tâches comme terminées.
- Affichage de la liste de tâches avec un statut de chaque tâche (terminée ou en cours).

## Prérequis

Avant de pouvoir exécuter ce projet, assurez-vous d'avoir installé :

- [Symfony](https://symfony.com/)
- [XAMPP](https://www.apachefriends.org/index.html) pour la gestion de l'environnement local (serveur Apache et MySQL).
- [MySQL](https://www.mysql.com/) (inclus dans XAMPP).
- [Composer](https://getcomposer.org/) pour la gestion des dépendances PHP.

### Installation de Composer

Composer est un gestionnaire de dépendances pour PHP. Il permet de gérer les bibliothèques dont Symfony et d'autres composants PHP ont besoin pour fonctionner.

1. Rendez-vous sur la [page de téléchargement de Composer](https://getcomposer.org/download/).
2. Suivez les instructions d'installation pour votre système d'exploitation :
   - Pour **Windows**, vous pouvez télécharger l'installeur `.exe` et suivre les étapes.
   - Pour **macOS** ou **Linux**, vous pouvez installer Composer via le terminal en exécutant la commande suivante :
     ```bash
     curl -sS https://getcomposer.org/installer | php
     mv composer.phar /usr/local/bin/composer
     ```

3. Après l'installation, vous pouvez vérifier que Composer est bien installé en exécutant la commande suivante dans le terminal :
   ```bash
   composer --version
