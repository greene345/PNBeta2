<?php
$eventcheck = mysql_query("SELECT * FROM events WHERE nation='$nation' ORDER BY date DESC");
while($eventrow = mysql_fetch_array($eventcheck)) {
if($eventrow['name'] == "earthquake") {
$nationnews .= "<span id='red'>Your nation was hit by an earthquake on ".date('m/d/y',strtotime($eventrow['date'])).". Many roads in your nation have been destroyed, and average income is down $0.02.</span><br />";
$avgincome = $avgincome-0.02;
} if($eventrow['name'] == "drought") {
$nationnews .= "<span id='red'>A great drought has hit your nation and your people are thirsty. Happiness -1%</span><br />";
$happiness = $happiness-1;
} if($eventrow['name'] == "sheep") {
$nationnews .= "<span id='green'>A great migration has left your nation flooded with sheep. In response, many citizens have become shepherds. Average Income +$0.05</span><br />";
$avgincome = $avgincome+0.05;
} if($eventrow['name'] == "tsunami") {
$nationnews .= "<span id='red'>Your nation was hit by a tsunami on ".date('m/d/y',strtotime($eventrow['date'])).". Your coastline has been left devastated and average income is down $0.05.</span><br />";
$avgincome = $avgincome-0.05;
} if($eventrow['name'] == "tornado") {
$nationnews .= "<span id='red'>Your nation was hit by a tornado on ".date('m/d/y',strtotime($eventrow['date'])).". Houses and building have been destroyed, leaving your citizens unhappy by 1%.</span><br />";
$happiness = $happiness-1;
} if($eventrow['name'] == "housing") {
$nationnews .= "<span id='green'>The housing industry in your nation is booming! Average income is up $0.03.</span><br />";
$avgincome = $avgincome+0.03;
} if($eventrow['name'] == "wildfire") {
$nationnews .= "<span id='red'>Wildfires are burning all across your nation! Homes and businesses have been destroyed, lowering average income by $0.03.</span><br />";
$avgincome = $avgincome-.03;
} if($eventrow['name'] == "reserve") {
$nationnews .= "<span id='green'>A large reserve of fossil fuels was discovered in your nation! Average income has spiked $0.02.</span><br />";
$avgincome = $avgincome+.02;
} if($eventrow['name'] == "spill") {
$nationnews .= "<span id='red'>There was a great oil spill off the coast of your nation on ".date('m/d/y',strtotime($eventrow['date'])).". This has added an extra 20,000 tons of pollution to your nation.</span><br />";
$pollution = $pollution+20000;
} if($eventrow['name'] == "lead") {
$nationnews .= "<span id='green'>A large lead deposit was found within your nation. Vehicle, Naval, and Aircraft upkeep is down 2%.</span><br />";
$leadevent = 1;
} if($eventrow['name'] == "food") {
$nationnews .= "<span id='green'>New fertilizers have increased food production and your population has grown 3%!</span><br />";
$population = round($population*1.03);
} if($eventrow['name'] == "criminal") {
$nationnews .= "<span id='green'>An infamous criminal has been convicted in your nation! The people are celebrating, and happiness is up 1%!</span><br />";
$happiness = $happiness+1;
} if($eventrow['name'] == "manufacturing") {
    $nationnews .= "<span id='green'>A minor breakthrough in manufacturing occurred on ".date('m/d/y',strtotime($eventrow['date'])).". Average income has spiked $0.03.</span><br />";
    $avgincome = $avgincome+0.03;
    } if($eventrow['name'] == "sporting") {
    $nationnews .= "<span id='green'>Your nation has been chosen to host an international sporting event. Population happiness has increased 3%.</span><br />";
    $happiness = $happiness+3;
    } if($eventrow['name'] == "celebrity") {
    $nationnews .= "<span id='red'>A very famous celebrity in your nation has passed away. Population happiness has fallen 2%.</span><br />";
    $happiness = $happiness-2;
    } if($eventrow['name'] == "hitsong") {
    $nationnews .= "<span id='green'>An annoying but catchy hit song is sweeping your nation. Population happiness has increased 1%, though some are tiring of it quickly.</span><br />";
    $happiness = $happiness+1;
    } if($eventrow['name'] == "nobel") {
    $nationnews .= "<span id='green'>A public intellectual has been awarded the Nobel Prize, bringing pride to your nation. Population happiness has increased 2%.</span><br />";
    $happiness = $happiness+2;
    } if($eventrow['name'] == "reading") {
    $nationnews .= "<span id='green'>A major philanthropist has donated a large sum of money to a national reading initiative. Literacy has increased by 1%.</span><br />";
    $literacy = $literacy+1;
	$happiness = $literacy+1;
    } if($eventrow['name'] == "druguse") {
    $nationnews .= "<span id='green'>Incidence of addictive drug use is down slightly and, with it, violent crimes. Crime has decreased by 2%.</span><br />";
    $crime = $crime-2;
	$happiness = $happiness+2;
    } if($eventrow['name'] == "influenza") {
    $nationnews .= "<span id='red'>A recent outbreak of a frightening new strain of influenza has struck your nation hard. Population has decreased by 2%.</span><br />";
    $population = round($population*.98);
    } if($eventrow['name'] == "antibiotic") {
    $nationnews .= "<span id='green'>Some of your most brilliant scientific minds have released a new antibiotic. Population has increased by 2%.</span><br />";
    $population = round($population*1.02);
    } if($eventrow['name'] == "river") {
    $nationnews .= "<span id='green'>Creative river management has freed up some fertile new land. Land has increased by 2%.</span><br />";
    $land = round($land*1.02);
    } if($eventrow['name'] == "cold") {
    $nationnews .= "<span id='green'>A recent bout of cold weather has kept families locked in their homes with nothing to do. Population has increased by 2%.</span><br />";
    $population = round($population*1.02);
    }
}