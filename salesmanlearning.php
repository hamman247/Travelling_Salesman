<!DOCTYPE html>
<html>
<head>
<title>
Travelling Salesman
</title>
<link rel="icon" type="image/png" href="gamepics/cover.png" />

</head>
<body>

<audio id="aud" autoplay="autoplay">
  <source src="sound/salesmansong.mp3" type="audio/mpeg">
</audio>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<canvas id="gc" <?php  

        require_once ("hidden/escape.php");
        parse_str($_SERVER['QUERY_STRING']);
//        echo $x;
        $x = escape($x);
		$y = escape($y);
        
        if ($x === FALSE || $y === FALSE) {
        die();
        }

settype($x, "integer");
settype($y, "integer");

if ($x !== null) {
if ($x !== 0) {

/*
 $xfile = 'textfiles/' . $x . 'x.txt';
 $yfile = 'textfiles/' . $x . 'y.txt';
 
// echo $xfile . " " . $yfile;
 
        $xpointfile = new SplFileObject($xfile, 'r+');
        $ypointfile = new SplFileObject($yfile, 'r+');

  $xpointfile->seek(0);
  $xlength = intval(str_replace(' ', '', str_replace('\n', '', $xpointfile)));
  $ypointfile->seek(0);
  $ylength = intval(str_replace(' ', '', str_replace('\n', '', $ypointfile)));

  echo 'width = "'.$xlength.'" ' . 'height = "'.$ylength.'"';
*/

$testfile = 'textfiles/' . $x . 'test.txt';
//echo $testfile;

$testpoints = new SplFileObject($testfile, 'r+');

  $testpoints->seek(0);
  $dim = rtrim($testpoints);
//echo $dim;
  $dimension = explode(" ",$dim);
//  echo $dimension[0].' '.$dimension[1];
echo 'width = "'. $dimension[0].'" ' . 'height = "'. str_replace('\n', '', $dimension[1]).'"';

}
else {
echo 'width = "1000" ' . 'height = "1000"';
}
}
else {
echo 'width = "1000" ' . 'height = "1000"';
}

?> style="border:1px solid #d3d3d3;" onmousedown="clicked(event)"></canvas>

<!--

<input type="text" onkeydown="keyPush()" onkeyup="clearmove()">
-->



<script>

	canv=document.getElementById("gc");
	ctx=canv.getContext("2d");
var audio = document.getElementById("aud"); 

transitiontime = 1000;
gs=10;
numpoints = 200;
a = 0;
k = 0
xstart = 0;
ystart = 0;

startpoint = 0; //false
recordrun = 100000;

numtop = 10;
numtested = numtop*numtop/2 + numtop/2;
//alert(numtested);

//bias = (1*canv.width + canv.height)/(gs*1000);
bias = 1/10;

numtest = 0;
numrun = 0;
totalruns = 1;
evolvechance = 5;

timestamp1 = 0;
timestamp2 = 0;
timetaken = 0;

<?php
$numvariables = 16;
echo 'numvariables = '.$numvariables.';';

?>

bestdistance = 0;

newline = 0;
distance = 0;
n = 0;

filler = 0;
loop = 1;
distarray = [];
unorganizeddist = [];
xdistarray = [];
ydistarray = [];
xevolve = 0;
yevolve = 0;

totaltestdistance = new Array(numtested);


weights = new Array(numtested);
for (var i=0; i < numtested; i++) {
  weights[i] = new Array(numvariables);
}

for (var i=0; i < numtested; i++) {
for (var h=0; h < numvariables; h++) {
a = Math.random();
if (a < 0.5) {
weights[i][h] = 2*a;
}
else {
weights[i][h] = 0 - 2*(a-0.5);
}

}
}
a = 0;

oldx = [];
oldy = [];
xpoint = [];
ypoint = [];
xsaved = [];
ysaved = [];

xsumdist = 0.0;
ysumdist = 0.0;
sumdistance = 0.0;

xavdist = 0.0;
yavdist = 0.0;
avdistance = 0.0;

ymediandist = 0.0;
xmediandist = 0.0;
mediandist = 0.0;

gameon = false;
on = false;
endgame = false;
opt = false;
cred = false;
best = false;
var interval;


for(var i = 0; i < numpoints; i++) {
//l = Math.floor(Math.random()*canv.width/gs);
//t = Math.floor(Math.random()*(canv.height - 30)/gs);
xpoint.push(Math.floor(Math.random()*canv.width/gs));
ypoint.push(Math.floor(Math.random()*(canv.height - 30)/gs));
}

<?php

if ($y !== null) {
if ($y !== 0) {
 $csvfile = 'textfiles/weights' . $y . '.csv';

$i = 0;
$handle = fopen($csvfile, "r");
while (($data = fgetcsv($handle)) !== FALSE) {
 $weightsarray[$i] = $data;
//echo 'alert("'.sizeof($weightsarray[$i]).'");';

//echo 'alert("'.sizeof($weightsarray[$i]).'");';
//$k = sizeof($weightsarray[$i]);
//settype($k, "integer");
for ($h = 0; $h < sizeof($weightsarray[$i]); $h++) {
echo 'weights['.$i.']['.$h.'] = '.$weightsarray[$i][$h].';';
}

$i++;
}
// 'alert("'.$weightsarray.'");';

}
}

 if ($x !== null) {
 if ($x !== 0) {
 echo "xpoint = [];\n";
 echo "ypoint = [];\n";
 
 /*
 $xfile = 'textfiles/' . $x . 'x.txt';
 $yfile = 'textfiles/' . $x . 'y.txt';
 
// echo $xfile . " " . $yfile;
 
        $xpointfile = new SplFileObject($xfile, 'r+');

  $xpointfile->seek(1);
  $numpoints = intval(str_replace(' ', '', str_replace('\n', '', $xpointfile)));
//  echo $numpoints;
 
         $ypointfile = new SplFileObject($yfile, 'r+');
 
 $i = 0;
 for ($i = 0; $i < $numpoints; $i++) {
 $xpointfile->seek($i+2);
        $xpoint = intval(str_replace(' ', '', str_replace('\n', '', $xpointfile)));
 $ypointfile->seek($i+2);
        $ypoint = intval(str_replace(' ', '', str_replace('\n', '', $ypointfile)));
 echo "xpoint[". $i ."] = ".$xpoint.";\n";
 echo "ypoint[". $i ."] = ".$ypoint.";\n"; 
 
 }
 */
 
 $testfile = 'textfiles/' . $x . 'test.txt';
//echo $testfile;

 $lines = file($testfile);
 $last_line = $lines[count($lines)-2];
 
 $numpoints = explode(" ",$last_line);
echo "numpoints = " . $numpoints[0].";";
 
$testpoints = new SplFileObject($testfile, 'r+');

 
 for ($i = 0; $i < $numpoints[0]; $i++) {
 $testpoints->seek($i+1);
 $dim = rtrim($testpoints);
 $dimension = explode(" ",$dim);
        $xpoint = intval(str_replace(' ', '', str_replace('\n', '', $dimension[1])));
        $ypoint = intval(str_replace(' ', '', str_replace('\n', '', $dimension[2])));
 echo "xpoint[". $i ."] = ".$xpoint.";\n";
 echo "ypoint[". $i ."] = ".$ypoint.";\n"; 
 
 }
 
 }
 }
 

?>

//alert(xpoint.length);

/*
xpoint[0] = 0;
xpoint[1] = 10;
xpoint[2] = 30;
xpoint[3] = 4;
xpoint[4] = 50;

ypoint[0] = 0;
ypoint[1] = 12;
ypoint[2] = 3;
ypoint[3] = 40;
ypoint[4] = 50;
*/

xsaved = xpoint.slice(0, xpoint.length);
ysaved = ypoint.slice(0, ypoint.length);
//alert(xpoint);


if (startpoint === false) {
k = Math.floor(Math.random()*xpoint.length);
}
else {
k = startpoint; 
}

xstart = xpoint[k];
ystart = ypoint[k];
			oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);

//a = Math.floor(Math.random()*xpoint.length);


window.onload=function() {
//	canv=document.getElementById("gc");
//	ctx=canv.getContext("2d");
//    document.addEventListener("keyup",clearmove);
//	setTimeout(playmus, transitiontime);
    setTimeout(transition, 0);

}



function transition() {
ctx.fillStyle="black";
ctx.fillRect(0,0,canv.width,canv.height);


ctx.fillStyle="white";
ctx.fillRect(canv.width/2-100,canv.height/2-125,200,250);

ctx.fillStyle="black";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,190);

ctx.fillStyle="white";
ctx.fillRect(canv.width/2-60,canv.height/2-85,120,150);

ctx.fillStyle="black";

ctx.font = "190px Arial";
ctx.fillText("H",canv.width/2 - 68,canv.height/2 + 60);

ctx.font = "bold 22px Arial";
name = "Horrible Games";
ctx.fillText(name,canv.width/2 - 82,canv.height/2 + 110);

/*
ctx.beginPath();
ctx.moveTo(75, 50);
ctx.lineTo(100, 75);
ctx.lineTo(100, 25);
ctx.fill();
*/

//	setTimeout(playmus, transitiontime);
	setTimeout(setInterval(music,42000),transitiontime);
	setTimeout(gamescreen, transitiontime);

}



function gamescreen() {
ctx.fillStyle="green";
ctx.fillRect(0,0,canv.width,canv.height);


ctx.fillStyle="white";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2-50,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2+5,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2+60,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Start Game",canv.width/2 - 40,canv.height/2 - 85);
ctx.fillText("Weights",canv.width/2 - 30,canv.height/2 - 30);
ctx.fillText("scores",canv.width/2 - 30,canv.height/2 + 25);
ctx.fillText("Best",canv.width/2 - 30,canv.height/2 + 80);

ctx.font = "bold 30px Arial";
ctx.fillText("The",canv.width/2 - 30,canv.height/2 - 200);
ctx.fillText("Travelling Salesman",canv.width/2 - 140,canv.height/2 - 160);
ctx.fillText("Problem",canv.width/2 - 60,canv.height/2 - 120);

on = true;
endgame = false;
gameon = false;
opt = false;
cred = false;
//document.addEventListener("keydown",clicked);

//setTimeout(startgame, 3000);


}

function options() {
on = false;
opt = true;

ctx.fillStyle="white";
ctx.fillRect(0,0,canv.width,canv.height);

ctx.fillStyle="green";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2-50,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2+5,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Main Menu",canv.width/2 - 40,canv.height/2 - 85);
ctx.fillText("Sound On/Off",canv.width/2 - 50,canv.height/2 - 30);
ctx.fillText("Download",canv.width/2 - 40,canv.height/2 + 25);


for (var i=0; i < numtested; i++) {
for (var h=0; h < numvariables; h++) {
ctx.font = "bold 8px Arial";
ctx.fillText(weights[i][h], 5 + 90*h,20 + 30*i);

}
}

}

function credits() {
on = false;
cred = true;

ctx.fillStyle="white";
ctx.fillRect(0,0,canv.width,canv.height);

ctx.fillStyle="green";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Main Menu",canv.width/2 - 40,canv.height/2 - 85);
ctx.fillText("This game was created by our worst (and only) developer",canv.width/2 - 200,canv.height/2 - 40);
ctx.fillText("REDACTED",canv.width/2 - 20,canv.height/2 - 10);

ctx.fillText("Best distance so far is",canv.width/2 - 40,canv.height/2 + 20);
ctx.fillText(bestdistance,canv.width/2 - 40,canv.height/2 + 50);
ctx.fillText("Worst distance so far is",canv.width/2 - 40,canv.height/2 + 80);
ctx.fillText(totaltestdistance[totaltestdistance.length-1],canv.width/2 - 40,canv.height/2 + 100);

ctx.fillText("Time taken in milliseconds",canv.width/2 - 40,canv.height/2 + 130);
ctx.fillText(timetaken,canv.width/2 - 40,canv.height/2 + 150);

for (var i=0; i < totaltestdistance.length; i++) {
ctx.fillText(totaltestdistance[i],5,20 + 20*i);
}

}

function runinfo() {
on = false;


ctx.fillStyle="white";
ctx.fillRect(0,0,canv.width,canv.height);

ctx.fillStyle="green";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2-50,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Main Menu",canv.width/2 - 40,canv.height/2 - 85);
ctx.fillText("Sound On/Off",canv.width/2 - 50,canv.height/2 - 30);


//document.addEventListener("keydown",clicked);

}

function startgame() {
ctx.fillStyle="green";
ctx.fillRect(0,0,canv.width,30);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";
//ctx.fillText("Line Length",canv.width - 200,10);
ctx.fillText("Total Distance",canv.width - 100,10);

ctx.font = "20px Arial";
ctx.fillText("Travelling Salesman Problem",10,20);

on = false;
gameon = true;

//	document.addEventListener("keydown",keyPush);
//	setTimeout(learn, 500);

	interval = setInterval(game,200);
    learninterval = setInterval(learn,1);
    
}

function game() {

	ctx.fillStyle="white";
	ctx.fillRect(0,30,canv.width,canv.height);

	ctx.fillStyle="black";

for(var i=0;i<xpoint.length;i++) {

ctx.beginPath();
ctx.arc(xpoint[i]*gs + gs/2, ypoint[i]*gs + gs/2 + 30, gs/2-1, 0, 2 * Math.PI);
ctx.fill();
}
ctx.fillStyle="lime";

for(var i=0;i<oldx.length;i++) {

ctx.beginPath();
ctx.arc(oldx[i]*gs + gs/2, oldy[i]*gs + gs/2 + 30, gs/2-1, 0, 2 * Math.PI);
ctx.fill();

}
if (oldx.length > 1) {
for(var i=0;i<oldx.length-1;i++) {
    drawline(oldx[i], oldy[i], oldx[i+1], oldy[i+1]);

}
}
ctx.fillStyle="red";

ctx.beginPath();
ctx.arc(xstart*gs + gs/2, ystart*gs + gs/2 + 30, gs/2-1, 0, 2 * Math.PI);
ctx.fill();

//drawline(oldx[oldx.length - 1], oldy[oldy.length - 1], xpoint[a], ypoint[a]);



if (xpoint.length == 0) {
drawline(oldx[oldx.length - 1], oldy[oldy.length - 1], xstart, ystart);
disttraveled();
distance = distance + Math.sqrt(((oldx[oldy.length - 1]-xstart) * (oldx[oldy.length - 1]-xstart)) + ((oldy[oldy.length - 1]-ystart) * (oldy[oldy.length - 1]-ystart)));
newline = 0;

//on = true;
//endgame = true;
//alert(numtest);
/*
ctx.fillStyle="green";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("New Game",canv.width/2 - 40,canv.height/2 - 85);
*/
if (best === true) {
best = false;
//endgame = true;
setTimeout(bestgameover, 3); 
}
else {
totaltestdistance[numtest] = distance;
setTimeout(gameover, 3); 
}

}
/*else {
newline = Math.sqrt(((oldx[oldy.length - 1]-xpoint[a]) * (oldx[oldy.length - 1]-xpoint[a])) + ((oldy[oldy.length - 1]-ypoint[a]) * (oldy[oldy.length - 1]-ypoint[a])));
}
*/

ctx.fillStyle="white";
//ctx.fillRect(canv.width - 202,14,99,14);
ctx.fillRect(canv.width - 101,14,100,14);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";
//ctx.fillText(newline,canv.width - 200,25);
ctx.fillText(distance,canv.width - 100,25);


//learn();

}

function drawline(xk, yk, xa, ya) {
ctx.beginPath();
ctx.moveTo(xk*gs + gs/2, yk*gs + gs/2 + 30);

ctx.lineTo(xa*gs + gs/2, ya*gs + gs/2 + 30);
ctx.stroke();

}


function disttraveled() {
distance = 0;

if (oldx.length > 1) {
for(var i=0;i<oldx.length-1;i++) {
    drawline(oldx[i], oldy[i], oldx[i+1], oldy[i+1]);
distance = distance + Math.sqrt(((oldx[i]-oldx[i+1])*(oldx[i]-oldx[i+1]))+((oldy[i]-oldy[i+1])*(oldy[i]-oldy[i+1])));
}
}


}


function keyPush(evt) {
/*
	switch(evt.keyCode) {
		case 37:

            break;
    
		case 38:  // up arrow key
			if (a == xpoint.length - 1) {
			a = 0;
            }
    		else {   
            a++;
 		    }

    		break;
    
		case 13:  //enter key
   		
    		if (xpoint.length == 0) {
            break;
            }
    		k = a;
    		oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);
    		a = Math.floor(Math.random()*xpoint.length);
    		disttraveled();
    
			break;
    
		case 40:  // down arrow key
			if (a == 0) {
			a = xpoint.length - 1;
            }
    		else {   
            a--;
 		    }

			break;
    

}
*/
}



function gameover() {
xpoint = xsaved.slice(0, xsaved.length);
ypoint = ysaved.slice(0, xsaved.length);
oldx = [];
oldy = [];
clearInterval(learninterval);
clearInterval(interval);
document.removeEventListener("keydown",keyPush);

if (startpoint === false) {
k = Math.floor(Math.random()*xpoint.length);
}
else {
k = startpoint; 
}

xstart = xpoint[k];
ystart = ypoint[k];
			oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);

a = Math.floor(Math.random()*xpoint.length);

numtest++;

if (numtest === numtested) {
numtest = 0;
numrun++;

//    alert((numrun % recordrun));
if ((numrun % recordrun) === 0) {
//alert("yes");
        filedata = "";
        for (var i=0;i<numtested;i++) {
        for (var h=0; h < numvariables; h++) {
        filetemp = '"' + weights[i][h] + '",';
        filedata = filedata.concat(filetemp);
        }
        filedata = filedata.slice(0, -1);
        filedata = filedata.concat("\r\n");
        }
//        alert(filedata);
	    download(filedata, "weights", "csv");

}

breed();
if (numrun === totalruns) {
timestamp2 = Date.now();
timetaken = timestamp2 - timestamp1;
setTimeout(gamescreen, 3); 
numrun = 0;
}
else {
//alert("yes");
setTimeout(startgame, 50); 
}
}
else {
setTimeout(startgame, 3);  
}


}

function besttest() {
ctx.fillStyle="green";
ctx.fillRect(0,0,canv.width,30);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";
//ctx.fillText("Line Length",canv.width - 200,10);
ctx.fillText("Total Distance",canv.width - 100,10);

ctx.font = "20px Arial";
ctx.fillText("Travelling Salesman Problem",10,20);

on = false;
gameon = true;
best = true;

//	document.addEventListener("keydown",keyPush);
//	setTimeout(learn, 500);
	interval = setInterval(game,200);
    learninterval = setInterval(learn,1);


}

function bestgameover() {
xpoint = xsaved.slice(0, xsaved.length);
ypoint = ysaved.slice(0, xsaved.length);
oldx = [];
oldy = [];
clearInterval(learninterval);
clearInterval(interval);
document.removeEventListener("keydown",keyPush);


if (startpoint === false) {
k = Math.floor(Math.random()*xpoint.length);
}
else {
k = startpoint; 
}

xstart = xpoint[k];
ystart = ypoint[k];
			oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);

a = Math.floor(Math.random()*xpoint.length);

ctx.fillStyle="green";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Main Menu",canv.width/2 - 40,canv.height/2 - 85);

endgame = true;


}

function clicked(evt) {
//alert(getMousePos(canv, evt).x);
xpos = getMousePos(canv, evt).x;
ypos = getMousePos(canv, evt).y;
//alert(xpos + " " + ypos);

if (on == true) {
	if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {
            timestamp1 = Date.now();
        	setTimeout(startgame, 3);        
        }   
    	else if ((ypos > canv.height/2-50) && (ypos < canv.height/2-20)) {
        setTimeout(options, 3);
        }
    	else if ((ypos > canv.height/2+5) && (ypos < canv.height/2+35)) { 
        setTimeout(credits, 3);
        }
    	else if ((ypos > canv.height/2+60) && (ypos < canv.height/2+90)) { 
        setTimeout(besttest, 3);
        }
    
    }

}
else if (endgame == true) {
if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {

        	setTimeout(gamescreen, 3);        
        }   
}
}
else if (gameon == true) {
/*
for(var i=0;i<xpoint.length;i++) {
if ((xpos > xpoint[i]*gs) && (xpos < xpoint[i]*gs+gs)) {
    	if ((ypos > ypoint[i]*gs+30) && (ypos < ypoint[i]*gs+gs+30)) {
			k = i;
    		oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);
    		a = Math.floor(Math.random()*xpoint.length);
    		disttraveled();
        	     
        }   
}

}
*/
}
else if (opt == true) {
if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {
        	setTimeout(gamescreen, 3);        
        }   
    	else if ((ypos > canv.height/2-50) && (ypos < canv.height/2-20)) {
        setTimeout(volume, 3);
        }
    	else if ((ypos > canv.height/2+5) && (ypos < canv.height/2+35)) {
        filedata = "";
        for (var i=0;i<numtested;i++) {
        for (var h=0; h < numvariables; h++) {
        filetemp = '"' + weights[i][h] + '",';
        filedata = filedata.concat(filetemp);
        }
        filedata = filedata.slice(0, -1);
        filedata = filedata.concat("\r\n");
        }
//        alert(filedata);
	    download(filedata, "weights", "csv");
        }
    }

}
else if (cred == true) {
if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {
        	setTimeout(gamescreen, 3);        
        }   
    
    }

}



}

function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top
    };
}

function volume() {

if (!aud.paused) {
    aud.pause(); 
}
else {
 aud.currentTime = 10000;
    aud.play();  
}

}

function music() {
if (!aud.paused) {
 aud.currentTime = 10000;
    aud.play(); 
}

}

function playmus() {
 aud.currentTime = 10000;
aud.play();
}



function learn() {
distarray = [];
xdistarray = [];
ydistarray = [];
unorganizeddist = [];

sumdistance = 0.0;
xsumdist = 0.0;
ysumdist = 0.0;

xvector = 0.0;
yvector = 0.0;

for(var i=0;i<xpoint.length;i++) {
distarray.push(Math.sqrt(((xpoint[i]-oldx[oldx.length-1])*(xpoint[i]-oldx[oldx.length-1]))+((ypoint[i]-oldy[oldy.length-1])*(ypoint[i]-oldy[oldy.length-1]))));
unorganizeddist.push(Math.sqrt(((xpoint[i]-oldx[oldx.length-1])*(xpoint[i]-oldx[oldx.length-1]))+((ypoint[i]-oldy[oldy.length-1])*(ypoint[i]-oldy[oldy.length-1]))));
xdistarray.push(xpoint[i]-oldx[oldx.length-1]);
ydistarray.push(ypoint[i]-oldy[oldy.length-1]);
}

loop = 1;
while (loop === 1) {
loop = 0;
for(var i=1;i<xpoint.length;i++) {
if (distarray[i-1] > distarray[i]) {
filler = distarray[i-1];
distarray[i-1] = distarray[i];
distarray[i] = filler;
loop = 1;
}
}
}

loop = 1;
while (loop === 1) {
loop = 0;
for(var i=1;i<xpoint.length;i++) {
if (xdistarray[i-1] > xdistarray[i]) {
filler = xdistarray[i-1];
xdistarray[i-1] = xdistarray[i];
xdistarray[i] = filler;
loop = 1;
}
}
}

loop = 1;
while (loop === 1) {
loop = 0;
for(var i=1;i<xpoint.length;i++) {
if (ydistarray[i-1] > ydistarray[i]) {
filler = ydistarray[i-1];
ydistarray[i-1] = ydistarray[i];
ydistarray[i] = filler;
loop = 1;
}
}
}

h = Math.floor(xpoint.length/2);
mediandist = distarray[h];
ymediandist = xdistarray[h];
xmediandist = ydistarray[h];

for(var i=0;i<xpoint.length;i++) {
sumdistance = sumdistance + distarray[i];
xsumdist = xsumdist + xdistarray[i];
ysumdist = ysumdist + ydistarray[i];
}
avdistance = sumdistance/xpoint.length;
xavdist = xsumdist/xpoint.length;
yavdist = ysumdist/xpoint.length;

//bias = (1*canv.width + canv.height)/(gs*1000);
//alert(bias);
//alert(numpoints);
//alert(weights[numtest]);
xvector = oldx[oldx.length-1] + (bias)*(xavdist*weights[numtest][0] + xmediandist*weights[numtest][2] + avdistance*weights[numtest][4] + mediandist*weights[numtest][6] + (numpoints - xpoint.length)*weights[numtest][8] + xpoint.length*weights[numtest][10] + oldx[oldx.length-1]*weights[numtest][12]) + bias*weights[numtest][14];
yvector = oldy[oldy.length-1] + (bias)*(yavdist*weights[numtest][1] + ymediandist*weights[numtest][3] + avdistance*weights[numtest][5] + mediandist*weights[numtest][7] + (numpoints - ypoint.length)*weights[numtest][9] + ypoint.length*weights[numtest][11] + oldy[oldy.length-1]*weights[numtest][13]) + bias*weights[numtest][15];
//alert(xsaved.length);
//xsaved.length*weights[numtest][0] + xpoint.length*weights[numtest][1] +
//ysaved.length*weights[numtest][7] + ypoint.length*weights[numtest][8] +
//(weights[numtest][0])*
//(weights[numtest][1])

/*
for(var i=0;i<xpoint.length;i++) {

unorganizeddist.push(Math.sqrt(((xpoint[i]-xvector)*(xpoint[i]-xvector))+((ypoint[i]-yvector)*(ypoint[i]-yvector))));

}
*/

//xevolve = vectorpoint(xvector, yvector).x;
//yevolve = vectorpoint(xvector, yvector).y;
wevolve = vectorpoint(xvector, yvector).w;

//alert(wevolve);
//xevolve = -1;

/*
for (var i=0; i < xpoint.length; i++) {

if (xpoint[i] === xevolve) {
 if (ypoint[i] === yevolve) {
// 		alert(i);
    		k = i;
    		oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);
//    		a = Math.floor(Math.random()*xpoint.length);
    		disttraveled();
}
}

}
*/

if (xpoint.length !== 0) {

   			k = wevolve;
// alert(k);
    		oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);
//    		a = Math.floor(Math.random()*xpoint.length);
    		disttraveled();
 
}

}


/*
 * 
 * Vectorpoint function is not giving correct output!
 * 
 * 
 */



function vectorpoint(xinput, yinput) {
w = 0;
vectordist = [];

for(var i=0;i<xpoint.length;i++) {
vectordist.push(Math.sqrt(((xpoint[i]-xinput)*(xpoint[i]-xinput))+((ypoint[i]-yinput)*(ypoint[i]-yinput))));
}

mindist = vectordist[0];

for(var i=1;i<xpoint.length;i++) {
if (vectordist[i] < mindist) {
mindist = vectordist[i];
w = i;
}
}
//alert(w);
return {
x: xpoint[w],
y: ypoint[w],
w: w
}

}


function breed() {
loop = 1;
while (loop === 1) {
loop = 0;

for(var i=1;i<totaltestdistance.length;i++) {
if (totaltestdistance[i-1] > totaltestdistance[i]) {
filler = totaltestdistance[i-1];
totaltestdistance[i-1] = totaltestdistance[i];
totaltestdistance[i] = filler;

filled = 0;

for (var h=0; h < numvariables; h++) {
filled = weights[i-1][h];
weights[i-1][h] = weights[i][h];
weights[i][h] = filled;
}



/*
filled = weights[i-1];
weights[i-1] = weights[i];
weights[i] = filled;
*/
//alert("yes");
loop = 1;
}
}
}

bestdistance = totaltestdistance[0]
z = 0;

for (var i=numtop; i < numtested; i++) {

	for (var l=(z+1); l < numtop; l++) {

		for (var h=0; h < numvariables; h++) {
		a = Math.random();

		if (a < 0.5) {
		weights[i][h] = weights[l][h];
        weights[i][h] = evolve(weights[i][h]);
		}
		else {
		weights[i][h] = weights[z][h];
        weights[i][h] = evolve(weights[i][h]);
		}
		}

	i++;
	}

i--;
z++;
}

}

function evolve(weightin) {
v = Math.floor(evolvechance*Math.random());
//alert(z);
if (v === 0) {
	v = Math.random();
	if (v < 0.5) {
	weightout = 2*v;
	}
	else {
	weightout = 0 - 2*(v-0.5);
	}
}
else {
weightout = weightin;
}

return weightout;

}

// Function to download data to a file
function download(data, filename, type) {
    var file = new Blob([data], {type: type});
    if (window.navigator.msSaveOrOpenBlob) // IE10+
        window.navigator.msSaveOrOpenBlob(file, filename);
    else { // Others
        var a = document.createElement("a"),
                url = URL.createObjectURL(file);
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        setTimeout(function() {
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);  
        }, 0); 
    }
}


</script>
</body>
</html>
