# Tank-wars

# 📝 Projet Tank-Wars - Nicolas Molduch  

Bienvenue dans le projet **Tank-Wars** réalisé dans le cadre d'un exercice de développement dans mon but MMI.L'objectif était de concevoir un jeu de combat en respectant l'architecture MVC et la programmation orientée objet en PHP.

---
## 🌐 URL du projet  

- **Site public** :  
  [🔗 https://tankwars.molduch.butmmi.o2switch.site/index.php?action=home](https://tankwars.molduch.butmmi.o2switch.site/index.php?action=home)  

---

## 💻 Fonctionnalités développées  

- 🌟 **Création/Modification et suppresion des tanks** :  
  - Création possible depuis la page d'accueil.
  - Modification et suppression accessibles via le back-office
  - Si l'image du tank est invalide (ex. : mauvais format), la création est annulée.

- ⚙️ **Fonctionnalités techniques** : 
  - Vérification en PHP pour éviter les erreurs, comme la sélection d’un seul tank ou deux fois le même.
  - Stockage des id des tanks en combat dans des variables de session
  - Réinitialisation automatique des points de vie en quittant la partie.

- ✅ **Amélioration UX** :  
  - Mise à jour dynamique des barres de vie en fonction des dégâts reçus.
  - Apparition d’icônes de dégâts et de soins pendant le combat.
  - Ajout d’un bouton "Fuir" permettant de revenir à l’accueil.
  - Affichage d’un message indiquant la victoire ou la défaite, avec redirection automatique vers l’accueil après 3 secondes.
