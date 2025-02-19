<?php 
$title = 'Réinitialisation du mot de passe';
include __DIR__ . "/../layout/header.php";
?>

<div class="container">
    
        <h2>Réinitialisation du mot de passe</h2>
           <p> Entrez votre adresse mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        <form class="ResetForm" method="POST" action="/reset">
            
                <label for="email">Adresse mail</label>
                <input class= "input" type="email" id="email" placeholder="Adresse mail" required>




                <button type="submit" class="button button--primary button--md ">Envoyer le lien</button>

           
               <a href="/login" class="button button--primary button--md"  >Connectez-vous ici</a>  


        </form>
    
</div>