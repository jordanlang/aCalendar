<div class="comm" style="margin-left: <? echo $niveau ?>;">
  <a><? echo $commentateur->nom().' '$commentateur->prenom()?></a><p> : <? echo $comm->commentaire() ?></p>
  <p>Posté le : <? echo $comm->dateComm() ?></p>
  </br>
  <div class="aime">
  <?
    for($i=0;$i<count($UtilAime);$i++)
    {
      ?>
      <a><? echo $UtilAime->nom().' '$UtilAime->prenom()?></a><p>, <p>
      <?
    }
    if(count($UtilAime)>1)
    {
      ?>
      <p>aiment</p>
      <?
    }
    else if(count($UtilAime)==1)
    {
      ?>
      <p>aime</p>
      <?
    }
    ?>
  </div>
</div>
