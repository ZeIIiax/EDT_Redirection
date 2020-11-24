<?php include("Group.php")?>
<?php
$tomorrow = date("D", strtotime("+1 day"));
$affichage = "Plus de cours pour Aujourd'hui";
$Flink = 'None';
$refresh_link= 'https://progfox.fr'.$_SERVER['REQUEST_URI'];
$Pamphi = True;
$Pcours = True;
$actuelHeure = [date(G),date(i),date(s)];
$on_cours=False;
$prochan_cours=['24','24','None','link'];
foreach($cours as $ue => $info){
    foreach($info['horaire'] as $horaires ){
        $day = $horaires['jour'];
        if ($day == date(D))
        {
            $heure = $horaires['heure'];
            
            if($heure[0][0]==date(G) && $heure[0][1]<=date(i) || $heure[0][0]<date(G) && $heure[1][0]>date(G) || $heure[1][0]==date(G) && $heure[1][1]>date(i)){
                
                $Flink = $info['link'];
                if(($_GET['without_amphi']=="True")){
                    if(strtok($ue, " ") == 'amphi'){
                        ;
                    }else if(!($_GET['without_redirection']=="True")){
                        $refresh_link=$Flink;
                    }}
                else if(!($_GET['without_redirection']=="True")){
                    $refresh_link=$Flink;
                }
                $affichage = $ue;
                $on_cours=True;
                
                }
            

            if(!($on_cours)){
                if($heure[0][0]>date(G) || $heure[0][0]==date(G) && $heure[0][1]>=date(i)){
                    if($prochan_cours[0]>$heure[0][0]){
                        $prochan_cours=[$heure[0][0],$heure[0][1]];
                        $prochan_cours[2] = $ue;
                        $prochan_cours[3] = $info['link'];
                        $affichage='Prochain Cours';
                    }
                    else if($prochan_cours[0] == $heure[0][0] && $prochan_cours[1]>$heure[0][1]){
                        $prochan_cours=[$heure[0][0],$heure[0][1]];
                        $prochan_cours[2] = $ue;
                        $prochan_cours[3] = $info['link'];
                        $affichage='Prochain Cours';
                    }
                }
            }
        }
        if ($day == $tomorrow){
            $heure = $horaires['heure'];
            if(!($on_cours)){
                if($heure[0][0]>0|| $heure[0][0]==0 && $heure[0][1]>0){
                    if($prochan_cours[0]>$heure[0][0]){
                        $prochan_cours=[$heure[0][0],$heure[0][1]];
                        $prochan_cours[2] = $ue;
                        $prochan_cours[3] = $info['link'];
                        $affichage='Prochain Cours Demain';
                    }
                    else if($prochan_cours[0] == $heure[0][0] && $prochan_cours[1]>$heure[0][1]){
                        $prochan_cours=[$heure[0][0],$heure[0][1]];
                        $prochan_cours[2] = $ue;
                        $prochan_cours[3] = $info['link'];
                        $affichage='Prochain Cours Demain';
                    }
                }
            }
        }
    }
    
}
?>

<html>
<head>
    <meta charset="utf-8" />
    <title>Cours <?= $groupe ?></title>
    <link rel="shortcut icon" type="image/png" href="logo.png"/>
    <meta http-equiv="refresh" content="<?php if($on_cours){echo('5');}else{echo('30');}?>; url='<?= $refresh_link ?>'" />
    <link rel="stylesheet" href="style.css">
</head>


<body>
<div class="bgimg-1">
  <div class="caption" id='page'>
    <span class="border"><?php echo ($actuelHeure[0].':');echo ($actuelHeure[1]);?></span><br>
    
    <span class="border"><a <?php if($Flink != 'None'):?>href="<?= $Flink ?>"<?php endif?>><?= $affichage ?></a></span>
    <?php if (!($affichage=="Prochain Cours") && !($affichage=="Prochain Cours Demain") && !($affichage=="Plus de cours pour Aujourd'hui")){?>
        </br><span class="border">de <?= $heure[0][0] ?>H<?= $heure[0][1] ?> à <?= $heure[1][0] ?>H<?= $heure[1][1] ?> </span>
    <?php }else if($affichage=="Prochain Cours" || $affichage=="Prochain Cours Demain") {?>
        </br><span class="border"><a href="<?= $prochan_cours[3] ?>"><?= $prochan_cours[2] ?></a> à <?= $prochan_cours[0] ?>H<?= $prochan_cours[1] ?></span>
    <?php }?>
    </br></br>

    
    <?php
    if($_GET['without_amphi']=="True"){
        //Activer amphi
        $linkin = str_replace("&without_amphi=True",'',$_SERVER['QUERY_STRING']);
        $linkin = str_replace("without_amphi=True&",'',$linkin);
        $linkin = str_replace("without_amphi=True",'',$linkin);

        ?><a style="color: #ff0000; font-weight: bold; background-color: #162a42;opacity: 0.75;" href="https://progfox.fr/cours/?<?=$linkin?>">Amphi Désactiver</a><?php
        }
    else{
        //Désactiver amphi
        if($_SERVER['QUERY_STRING']!=""){$linkin="?".$_SERVER['QUERY_STRING']."&without_amphi=True";}
        else{$linkin="?without_amphi=True";}
        ?><a style="color: #008000; font-weight: bold; background-color: #162a42;opacity: 0.75;" href="https://progfox.fr/cours/<?=$linkin?>">Amphi Activer</a><?php
    }?>
    </br>

    
    <?php
    if($_GET['without_redirection']=="True"){
        //Activer redirection
        $linkin = str_replace("&without_redirection=True",'',$_SERVER['QUERY_STRING']);
        $linkin = str_replace("without_redirection=True&",'',$linkin);
        $linkin = str_replace("without_redirection=True",'',$linkin);
        ?><a style="color: #ff0000; font-weight: bold; background-color: #162a42;opacity: 0.75;" href="https://progfox.fr/cours/?<?=$linkin?>">Redirection auto Désactiver</a><?php
        }
    else{
        //Désactiver redirection
        if($_SERVER['QUERY_STRING']!=""){$linkin="?".$_SERVER['QUERY_STRING']."&without_redirection=True";}
        else{$linkin="?without_redirection=True";}
        ?><a style="color: #008000; font-weight: bold; background-color: #162a42;opacity: 0.75;" href="https://progfox.fr/cours/<?=$linkin?>">Redirection auto Activer</a><?php
    }?>
    </br>
    <?php
    if($_GET['without_sound']=="True"){
        //Activer son
        $linkin = str_replace("&without_sound=True",'',$_SERVER['QUERY_STRING']);
        $linkin = str_replace("without_sound=True&",'',$linkin);
        $linkin = str_replace("without_sound=True",'',$linkin);
        ?><a style="color: #ff0000; font-weight: bold; background-color: #162a42;opacity: 0.75;" href="https://progfox.fr/cours/?<?=$linkin?>">Notification Désactiver</a><?php
        }
    else{
        //Désactiver son
        if($_SERVER['QUERY_STRING']!=""){$linkin="?".$_SERVER['QUERY_STRING']."&without_sound=True";}
        else{$linkin="?without_sound=True";}
        ?><a style="color: #008000; font-weight: bold; background-color: #162a42;opacity: 0.75;" href="https://progfox.fr/cours/<?=$linkin?>">Notification Activer</a><?php
    }?>
  </div>
</div>

<?php if($on_cours && !($_GET['without_sound']=="True")):?>
    <embed name="ping" src="ping.mp3" loop="false" width="0" height="0" autostart="true">
<?php endif?>
</body>


</html>

