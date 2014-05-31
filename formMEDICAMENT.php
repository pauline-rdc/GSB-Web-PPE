<?php
	session_start(); 
	if(empty($_SESSION)){ 
		header('location:Accueil.php'); 
	}

		$repInclude = './include/';
	 include ('include/top.php');
		$vis_matri_session = $_SESSION['id'];
		$nom_session = $_SESSION['nom'];
?> 
<html> 
	<head>
		<title>formulaire MEDICAMENT</title>
		<link href="boostrap.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
	</head>
	<body>
		<?php 
			include('include/connexionBase.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php 
						include('include/menuVertical.php');
						$req = $bdd->query("SELECT * FROM medicament ORDER BY MED_NOMCOMMERCIAL ASC");
						$donnees = $req-> fetch();
					?>
				</div>
				<div class="col-md-9" class="form col-md-12 center-block" >
					<div class="well bs-component">
						<div class="thumbnail">
							<h2>Médicament</h2>
						</div>
						<form name="formMEDICAMENT" method="post" action="formMEDICAMENT.php">
							<?php echo'<legend>M&eacute;dicament &agrave; s&eacute;lectionner :</legend>';	?>
								<tr>
									<td>
										<select name="lstmnt"  class="form-control" style="max-width:300px;float:left;" >
											<option>Choisissez un médicament</option>
											<?php 
												while ($donnees = $req-> fetch()){?>
												<option  value="<?php echo $donnees['compteur']; ?>" 
													<?php if ((isset($_POST['lstmnt'])) && ($donnees['MED_NOMCOMMERCIAL']==$_POST['lstmnt'])) { ?> selected='selected'<?php } ?> >
													<?php	echo $donnees['MED_NOMCOMMERCIAL'];?><br>
												</option>
											<?php
												} ;
											?>
										</select>
									</td>
									<td>
										<input type='submit' value='Valider' style="margin-top:8px;"/>
									</td>
								</tr>
								<br/>
							
							<br><br>
							<?php 
								if(isset($_GET['medicament'])) {
									$medicament=$_GET['medicament'];
								}else if(isset($_POST['lstmnt'])) {
									$medicament=$_POST['lstmnt'];
								}
								if (isset($medicament)){
									if(($medicament < '1') ){
										$medicament=0;
									}
									elseif	($medicament > '28'){
										$medicament=29;
									}
									else{
										$afficherMedicament = $bdd->query("SELECT * FROM medicament WHERE compteur = '".$medicament."'");
										$donneesMed = $afficherMedicament -> fetch();
										
							?>
								<div>
									<legend>Pharmacie</legend>
										<!--<h1> Pharmacopee </h1>-->
									<label>DEPOT LEGAL :</label><br/>
										<input type="text" size="10"  name="MED_DEPOTLEGAL" class="form-control" style="max-width:300px;float:left;" 
										readonly value="<?php echo $donneesMed['MED_DEPOTLEGAL']; ?>" /><br/><br/><br/>
									<label>NOM COMMERCIAL :</label><br/>
										<input type="text" size="25" name="MED_NOMCOMMERCIAL" class="form-control" style="max-width:300px;float:left;" 
										readonly value="<?php echo $donneesMed['MED_NOMCOMMERCIAL']; ?>" /><br/><br/><br/>
									<?php 
										$famille = $bdd->query("SELECT FAM_LIBELLE FROM famille WHERE  FAM_CODE= '".$donneesMed['FAM_CODE']."'");
										$donneesFam = $famille -> fetch();
									?>
									<label>FAMILLE :</label><br/>
										<input type="text" size="3" name="FAM_CODE" class="form-control" style="max-width:600px;float:left;" 
										readonly value="<?php echo $donneesFam['FAM_LIBELLE']; ?>" /></div><br/><br/><br/>
									<label>COMPOSITION :</label><br/>
										<textarea rows="5" cols="50" name="MED_COMPOSITION" class="form-control" style="max-width:600px;max-height:34px;float:left;" 
										readonly ><?php echo $donneesMed['MED_COMPOSITION']; ?></textarea><br/><br/><br/>
									<label>EFFETS INDESIRABLE:</label><br/>
										<textarea rows="5" cols="50" name="MED_EFFETS" class="form-control" style="max-width:600px;max-height:75px;float:left;" 
										readonly ><?php echo $donneesMed['MED_EFFETS']; ?></textarea><br/><br/><br/><br/><br/>
									<label>CONTRE INDICATION :</label><br/>
										<textarea rows="5" cols="50" name="MED_CONTREINDIC" class="form-control" style="max-width:600px;max-height:75px;float:left;" 
										readonly ><?php echo $donneesMed['MED_CONTREINDIC']; ?></textarea><br/><br/><br/><br/><br/>
									<!--label>PRIX ECHANTILLON :</label><br/>
										<!--input type="text" size="7" name="MED_PRIXECHANTILLON" class="form-control" style="max-width:300px;float:left;" 
										readonly value="<?php echo $donneesMed['MED_PRIXECHANTILLON']; ?>" /-->
									
								</div>
							
							<?php 
									}
							?>
							<br/><br/>
							<div class="piedForm">
								<p>
									<div class="zone">
										<?php  $medicament=$medicament-1; ?>
										<?php  echo "<a href='formMEDICAMENT.php?medicament=$medicament'>";	?>
											<input class="zone" type="button" value="Pr&eacute;c&eacute;dent"></input></a>
										<?php $medicament=$medicament+2; ?>
										<?php  echo "<a href='formMEDICAMENT.php?medicament=$medicament'>";	?>
											<input class="zone" type="button" value="Suivant"></input></a>
										<a href='menuCR.php'><input class="zone" type='button' value='Fermer' /></a>
									</div>
								</p>
							</div>
							<?php 
								}
								?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>