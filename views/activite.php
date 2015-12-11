<li>
  <div class="activite">
    <h2> L'activité</h2>
    <p>Titre de l'activité :<? echo $activite->titre(); ?></p>
    <p>Déscriptif :<? echo $activite->descriptif(); ?></p>
    <p>Aura lieu le :<? echo date("d-m-y",$activite->dateDeb()); ?></p>
    <p> A:<? echo date("H",$activite->dateDeb()); ?></p>
    <p>Jusqu'au :<? echo date("d-m-y",$activite->dateFin()); ?></p>
    <p> A:<? echo date("H",$activite->dateFin()); ?></p>
    <? if($activite->occurences()>0)
      {
          if($activite->periodicite()=="S")
          {
            ?>
            <p>Toutes les semaines (sauf exception) pendant <? $activite->occurences; ?> semaines</p>
            <?
          }
          else if($activite->periodicite()=="J")
          {
            ?>
            <p>Tous les jours (sauf exception)) pendant <? $activite->occurences; ?> jours</p>
            <?
          }
          else if($activite->periodicite()=="M")
          {
            ?>
            <p>Tous les mois (sauf exception) pendant <? $activite->occurences; ?> mois</p>
            <?
          }
      }
    ?>
    <p>Date de création : <? echo date("d-m-y",$activite->dateCreation()); ?></p>
    <p>Dernière modification : <? echo date("d-m-y",$activite->dateUpdate()); ?></p>
  </div>
  <div class="commentaires">
    <h2> Les commentaires</h2>
