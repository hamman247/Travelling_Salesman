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

        $x = escape($x);
		$y = escape($y);
        
        if ($x === FALSE || $y === FALSE) {
        die();
        }

settype($x, "integer");
settype($y, "integer");

if ($x !== null) {
if ($x !== 0) {

$testfile = 'textfiles/' . $x . 'test.txt';

$testpoints = new SplFileObject($testfile, 'r+');

  $testpoints->seek(0);
  $dim = rtrim($testpoints);

  $dimension = explode(" ",$dim);

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

<script src="parallel.js"></script>

<script>

	canv=document.getElementById("gc");
	ctx=canv.getContext("2d");
var audio = document.getElementById("aud"); 


gs = 10;
numpoints = 100;

xstart = 0;
ystart = 0;

startpoint = 0; //false

numtop = 10;
numtested = numtop*numtop/2 + numtop/2;

recordrun = 100;
totalruns = 1;
evolvechance = 5;

numtest = 0;
numrun = 0;

bias = 1/10;

timestamp1 = 0;
timestamp2 = 0;
timetaken = 0;

<?php
$numvariables = 16;
echo 'numvariables = '.$numvariables.';';

?>

bestdistance = 0;

distance = 0;
n = 0;

filler = 0;
loop = 1;
distarray = [];
unorganizeddist = [];
xdistarray = [];
ydistarray = [];

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

gameon = false;
on = false;
endgame = false;
opt = false;
cred = false;
best = false;
var interval;

for(var i = 0; i < numpoints; i++) {

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

for ($h = 0; $h < sizeof($weightsarray[$i]); $h++) {
echo 'weights['.$i.']['.$h.'] = '.$weightsarray[$i][$h].';';
}

$i++;
}

}
}

 if ($x !== null) {
 if ($x !== 0) {
 echo "xpoint = [];\n";
 echo "ypoint = [];\n";
 
 $testfile = 'textfiles/' . $x . 'test.txt';


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

xsaved = xpoint.slice(0, xpoint.length);
ysaved = ypoint.slice(0, ypoint.length);

if (startpoint === false) {
a = Math.floor(Math.random()*xpoint.length);
}
else {
a = startpoint; 
}

xstart = xpoint[a];
ystart = ypoint[a];
			oldx.push(xpoint[a]);
    		oldy.push(ypoint[a]);
			xpoint.splice(a,1);
    		ypoint.splice(a,1);

window.onload=function() {
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


transitiontime = 1000;

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

}


function startgame() {
ctx.fillStyle="green";
ctx.fillRect(0,0,canv.width,30);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";
ctx.fillText("Generation",canv.width - 200,10);
ctx.fillText("Total Distance",canv.width - 100,10);

ctx.font = "20px Arial";
ctx.fillText("Travelling Salesman Problem",10,20);

ctx.fillText(numrun,canv.width - 200,25);

on = false;
gameon = true;

workerurl = "parallelworker.js";

startworker(workerurl, numtested);
}


function startworker(workerurl, numworkers) {

(function() {
    var n, worker, running;

worknumtest = 0;

    for (n = 0; n < numworkers; ++n) {

        workers = new Worker(workerurl);
        workers.onmessage = workerdone;
        workers.postMessage({id: n, xsaved: xsaved, ysaved: ysaved, weights: weights[n], bias: bias, startpoint: startpoint});

    }


function workerdone(event) {

        totaltestdistance[event.data.id] = event.data.workerdistance;
		worknumtest++
	if (worknumtest === numtested) {
		worknumtest = 0;
		numrun++;
    
if ((numrun % recordrun) === 0) {

        filedata = "";
        for (var i=0;i<numtested;i++) {
        for (var h=0; h < numvariables; h++) {
        filetemp = '"' + weights[i][h] + '",';
        filedata = filedata.concat(filetemp);
        }
        filedata = filedata.slice(0, -1);
        filedata = filedata.concat("\r\n");
        }
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
	setTimeout(startgame(), 50); 
	}
}  
}
})();
}


function startworkergame(worknumtest) {

workx = [];
worky = [];

workxpoint = xsaved.slice(0, xsaved.length);
workypoint = ysaved.slice(0, ysaved.length);

if (startpoint === false) {
h = Math.floor(Math.random()*xpoint.length);
}
else {
h = startpoint; 
}

workxstart = workxpoint[h];
workystart = workypoint[h];
			workx.push(workxpoint[h]);
    		worky.push(workypoint[h]);
			workxpoint.splice(h,1);
    		workypoint.splice(h,1);

	setTimeout(workergame(workxpoint, workypoint, workx, worky, worknumtest),1);
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

if (xpoint.length == 0) {
drawline(oldx[oldx.length - 1], oldy[oldy.length - 1], xstart, ystart);
disttraveled();
distance = distance + Math.sqrt(((oldx[oldy.length - 1]-xstart) * (oldx[oldy.length - 1]-xstart)) + ((oldy[oldy.length - 1]-ystart) * (oldy[oldy.length - 1]-ystart)));
newline = 0;

if (best === true) {
best = false;

setTimeout(bestgameover, 3); 
}
else {
totaltestdistance[numtest] = distance;
setTimeout(gameover, 3); 
}

}

ctx.fillStyle="white";

ctx.fillRect(canv.width - 101,14,100,14);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";

ctx.fillText(distance,canv.width - 100,25);
}


function workergame(workxpoint, workypoint, workx, worky, worknumtest) {

if (workxpoint.length == 0) {

workerdistance = workerdist(workx, worky).w;
workerdistance = workerdistance + Math.sqrt(((workx[workx.length - 1]-workx[0]) * (workx[workx.length - 1]-workx[0])) + ((worky[worky.length - 1]-worky[0]) * (worky[worky.length - 1]-worky[0])));

if (best === true) {
best = false;

setTimeout(bestgameover, 3); 
}
else {

totaltestdistance[worknumtest] = workerdistance;
setTimeout(workgameover(worknumtest), 3); 
}
}
else {
workerlearn(workxpoint, workypoint, workx, worky, worknumtest);
}
}


function drawline(xk, yk, xa, ya) {
ctx.beginPath();
ctx.lineWidth=1;
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


function workerdist(workx, worky) {
workdistance = 0;

if (workx.length > 1) {
for(var i=0;i<workx.length-1;i++) {

workdistance = workdistance + Math.sqrt(((workx[i]-workx[i+1])*(workx[i]-workx[i+1]))+((worky[i]-worky[i+1])*(worky[i]-worky[i+1])));
}
}
return {
w : workdistance
}
}


function gameover() {
xpoint = xsaved.slice(0, xsaved.length);
ypoint = ysaved.slice(0, xsaved.length);
oldx = [];
oldy = [];
clearInterval(learninterval);
clearInterval(interval);

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

if ((numrun % recordrun) === 0) {

        filedata = "";
        for (var i=0;i<numtested;i++) {
        for (var h=0; h < numvariables; h++) {
        filetemp = '"' + weights[i][h] + '",';
        filedata = filedata.concat(filetemp);
        }
        filedata = filedata.slice(0, -1);
        filedata = filedata.concat("\r\n");
        }
	    download(filedata, "weights", "csv");
}
breed();
if (numrun === totalruns) {
setTimeout(gamescreen, 3); 
numrun = 0;
}
else {

setTimeout(startgame, 50); 
}
}
else {
setTimeout(startgame, 3);  
}
}


function workgameover(worknumtest) {
xpoint = xsaved.slice(0, xsaved.length);
ypoint = ysaved.slice(0, xsaved.length);
oldx = [];
oldy = [];
clearInterval(learninterval);
clearInterval(interval);

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

worknumtest++;

if (worknumtest === numtested) {
worknumtest = 0;
numrun++;

if ((numrun % recordrun) === 0) {

        filedata = "";
        for (var i=0;i<numtested;i++) {
        for (var h=0; h < numvariables; h++) {
        filetemp = '"' + weights[i][h] + '",';
        filedata = filedata.concat(filetemp);
        }
        filedata = filedata.slice(0, -1);
        filedata = filedata.concat("\r\n");
        }

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

setTimeout(startworkergame(worknumtest), 50); 
}
}
else {
setTimeout(startworkergame(worknumtest), 3);  
}

}


function besttest() {
ctx.fillStyle="green";
ctx.fillRect(0,0,canv.width,30);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";

ctx.fillText("Total Distance",canv.width - 100,10);

ctx.font = "20px Arial";
ctx.fillText("Travelling Salesman Problem",10,20);

on = false;
gameon = true;
best = true;

	interval = setInterval(game,500);
    learninterval = setInterval(learn,1);

}


function bestgameover() {
xpoint = [];
ypoint = [];
xpoint = xsaved.slice(0, xsaved.length);
ypoint = ysaved.slice(0, xsaved.length);
oldx = [];
oldy = [];
clearInterval(learninterval);
clearInterval(interval);

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

xpos = getMousePos(canv, evt).x;
ypos = getMousePos(canv, evt).y;

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

xvector = oldx[oldx.length-1] + (bias)*(xavdist*weights[numtest][0] + xmediandist*weights[numtest][2] + avdistance*weights[numtest][4] + mediandist*weights[numtest][6] + (numpoints - xpoint.length)*weights[numtest][8] + xpoint.length*weights[numtest][10] + oldx[oldx.length-1]*weights[numtest][12]) + bias*weights[numtest][14];
yvector = oldy[oldy.length-1] + (bias)*(yavdist*weights[numtest][1] + ymediandist*weights[numtest][3] + avdistance*weights[numtest][5] + mediandist*weights[numtest][7] + (numpoints - ypoint.length)*weights[numtest][9] + ypoint.length*weights[numtest][11] + oldy[oldy.length-1]*weights[numtest][13]) + bias*weights[numtest][15];

wevolve = vectorpoint(xvector, yvector).w;


if (xpoint.length !== 0) {

   			k = wevolve;

    		oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);

    		disttraveled();
 
}

}



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


function download(data, filename, type) {
    var file = new Blob([data], {type: type});
    if (window.navigator.msSaveOrOpenBlob) 
        window.navigator.msSaveOrOpenBlob(file, filename);
    else { 
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
