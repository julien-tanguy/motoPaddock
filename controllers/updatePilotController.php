<?php
$regexpName = '/^[A-ÿ\'\ \-\_]+$/'; 
$regexpSize = '/^((1[5-9][0-9])|(2[0-1][0-9])) cm$/';
$regexpweight = '/^(([4-9][0-9])|(1[0-3][0-9])) kg$/';
$regexpDate = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
$countries = array('Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antarctica', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegowina', 'Botswana', 'Bouvet Island', 'Brazil', 'British Indian Ocean Territory', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Congo, the Democratic Republic of the', 'Cook Islands', 'Costa Rica', 'Cote d\'Ivoire', 'Croatia (Hrvatska)', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands (Malvinas)', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'France Metropolitan', 'French Guiana', 'French Polynesia', 'French Southern Territories', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and Mc Donald Islands', 'Holy See (Vatican City State)', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran (Islamic Republic of)', 'Iraq', 'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea, Democratic People\'s Republic of', 'Korea, Republic of', 'Kuwait', 'Kyrgyzstan', 'Lao, People\'s Democratic Republic', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libyan Arab Jamahiriya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia, The Former Yugoslav Republic of', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia, Federated States of', 'Moldova, Republic of', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Reunion', 'Romania', 'Russian Federation', 'Rwanda', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia (Slovak Republic)', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia and the South Sandwich Islands', 'Spain', 'Sri Lanka', 'St. Helena', 'St. Pierre and Miquelon', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen Islands', 'Swaziland', 'Sweden', 'Switzerland', 'Syrian Arab Republic', 'Taiwan, Province of China', 'Tajikistan', 'Tanzania, United Republic of', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'United States Minor Outlying Islands', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Venezuela', 'Vietnam', 'Virgin Islands (British)', 'Virgin Islands (U.S.)', 'Wallis and Futuna Islands', 'Western Sahara', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe');
$formErrors = array();
if (isset($_GET['id'])){
    $teams = new team;
    $teamsList = $teams->teamsList();

    $detailPilot = new pilot();
    $detailPilot->id = htmlspecialchars($_GET['id']);
    $displayDetailPilot = $detailPilot->detailPilots();
}

if(isset($_POST['updatePilot'])){
    //instancier notre requete de la class patients
    if (!empty($_POST['lastname'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['lastname'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpName)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $detailPilot->lastname = htmlspecialchars($_POST['lastname']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['lastname'] = 'Le Nom n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['lastname'] = 'Veuillez entrer le Nom.';
    }

    // On verifie que le fichier a bien été envoyé.
  if (!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    // On stock dans $fileInfos les informations concernant le chemin du fichier.
    $fileInfos = pathinfo($_FILES['photo']['name']);
    // On crée un tableau contenant les extensions autorisées.
    $fileExtension = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
    // On verifie si l'extension de notre fichier est dans le tableau des extension autorisées.
    if (in_array($fileInfos['extension'], $fileExtension)) {
      //On définit le chemin vers lequel uploader le fichier
      $path = '../assets/img/photos-pilotes/';
      //On crée une date pour différencier les fichiers
      $date = date('Y-m-d_H-i-s');
      //On crée le nouveau nom du fichier (celui qu'il aura une fois uploadé)
      $fileNewName = $pilot->lastname . '_' . $pilot->firstname . '_' . $date;
      //On stocke dans une variable le chemin complet du fichier (chemin + nouveau nom + extension une fois uploadé) Attention : ne pas oublier le point
      $pilotPhoto = $path . $fileNewName . '.' . $fileInfos['extension'];
      //move_uploaded_files : déplace le fichier depuis son emplacement temporaire ($_FILES['photo']['tmp_name']) vers son emplacement définitif ($fileFullPath)
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $pilotPhoto)) {
        //On définit les droits du fichiers uploadé (Ici : écriture et lecture pour l'utilisateur apache, lecture uniquement pour le groupe et tout le monde)
        chmod($pilotPhoto, 0644);
        $detailPilot->photo = $pilotPhoto;
      } else {
        $formErrors['photo'] = 'Votre fichier ne s\'est pas téléversé correctement';
      }
    } else {
      $formErrors['photo'] = 'Votre fichier n\'est pas du format attendu';
    }
  } else {
    $formErrors['photo'] = 'Veuillez selectionner un fichier';
  }
    
    if (!empty($_POST['firstname'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['firstname'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpName)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $detailPilot->firstname = htmlspecialchars($_POST['firstname']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['firstname'] = 'Le Prénom n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['firstname'] = 'Veuillez entrer le Prénom.';
    }
    if (!empty($_POST['birthdate'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['birthdate'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpDate)))) {
            if(checkdate($dateExplode[1],$dateExplode[2],$dateExplode[0])){
                $detailPilot->birthDate = $_POST['birthdate'];
            }else{
                $formErrors['birthdate'] = 'Veuillez renseigner une date au format : jj/mm/aaaa.';
            }
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['birthdate'] = 'La date de naissance n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['birthdate'] = 'Veuillez entrer la date de naissance.';
    }
    if (!empty($_POST['number'])) {
        $detailPilot->number = htmlspecialchars($_POST['number']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
    }else {
        $formErrors['number'] = 'Veuillez entrer le numéro de course du pilote.';
    }
    if (!empty($_POST['country'])) {
        if (in_array($_POST['country'], $countries)){
            $detailPilot->country = htmlspecialchars($_POST['country']);
        }else{
            $formErrors['country'] = 'une erreur est survenue';
        }  
    }else {
        $formErrors['country'] = 'Veuillez choisir un pays dans la liste déroulante.';
    }
    if (!empty($_POST['size'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['size'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpSize)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $detailPilot->size = htmlspecialchars($_POST['size']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['size'] = 'La taille n\'est pas valide. format : 175 cm';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['size'] = 'Veuillez entrer une taille.';
    }
    if (!empty($_POST['weight'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['weight'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpweight)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $detailPilot->weight = htmlspecialchars($_POST['weight']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['weight'] = 'Le poid n\'est pas valide. format : 70 kg';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['weight'] = 'Veuillez entrer un poid.';
    }
    if (!empty($_POST['description'])) {
        $detailPilot->description = htmlspecialchars($_POST['description']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
    }else {
        $formErrors['description'] = 'Veuillez entrer une description.';
    }
    if (!empty($_POST['pilotTeam'])) {
        $detailPilot->id_ap29f_teams = htmlspecialchars($_POST['pilotTeam']);
    }else {
        $formErrors['pilotTeam'] = 'Veuillez choisir l\'équipe du pilote dans la liste déroulante.';
    }
    if(empty($formErrors)){
        //on appelle la methode de notre updatePilot pour modifier un pilote dans la base de données
        if($detailPilot->updatePilot()){
            $formMessageSuccess = 'LE PILOTE A BIEN ETE MODIFIÉ';
        }else {
            $formMessageFail = 'UNE ERREUR EST SURVENUE PENDANT L\'ENREGISTREMENT. VEUILLEZ CONTACTER LE SERVICE INFORMATIQUE.';
        } 
    }
}