<?php
include("../dbConnector.php");
include("../messageManager.php");
//  $result = createMessage(6,7,"Fuckers in school telling me, always in the barber shop Chief Keef ain’t bout this, Chief Keef ain’t bout that My boy a BD on fucking Lamron and them He, he they say that nigga don’t be putting in no work SHUT THE FUCK UP! Y'all niggas ain’t know shit All ya motherfuckers talk about Chief Keef ain’t no hitta Chief Keef ain’t this Chief Keef a fake SHUT THE FUCK UP Y'all don’t live with that nigga Y'all know that nigga got caught with a ratchet Shootin' at the police and shit Nigga been on probation since fuckin, I don’t know when! Motherfuckers stop fuckin' playin' him like that Them niggas savages out there If I catch another motherfucker talking sweet about Chief Keef I’m fucking beating they ass! I’m not fucking playing no more You know those niggas role with Lil' Reese and them");
//  if($result){
//      echo "Successful!";
//  }
$message_List = getMessage(42,43);

foreach ($message_List as $messageQuery) {
    $output = "";
    if (is_array($messageQuery))
    {
    foreach ($messageQuery as $key => $value) {
        $output .= "Key: $key; Value: $value";
    }
    echo $output . "</br>";
}
}
?>