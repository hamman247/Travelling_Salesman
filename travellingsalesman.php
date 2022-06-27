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
        
        if ($x === FALSE) {
        die();
        }

settype($x, "integer");

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
//px=py=10;
gs=10;
//tc=40;
//ax=ay=15;
//xv=yv=0;
//trail=[];
//tail = 1;
numpoints = 50;
a = 0;
k = 0
xstart = 0;
ystart = 0;

newline = 0;
distance = 0;
n = 0;
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
var interval;


for(var i = 0; i < numpoints; i++) {
//l = Math.floor(Math.random()*canv.width/gs);
//t = Math.floor(Math.random()*(canv.height - 30)/gs);
xpoint.push(Math.floor(Math.random()*canv.width/gs));
ypoint.push(Math.floor(Math.random()*(canv.height - 30)/gs));
}

<?php
/*
        require_once ("hidden/escape.php");
        parse_str($_SERVER['QUERY_STRING']);
//        echo $x;
        $x = escape($x);
        
        if ($x === FALSE) {
        die();
        }
        

 settype($x, "integer");
*/
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
// echo "alert(numpoints);";
 
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

k = Math.floor(Math.random()*xpoint.length);
xstart = xpoint[k];
ystart = ypoint[k];
			oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);

a = Math.floor(Math.random()*xpoint.length);


window.onload=function() {
//	canv=document.getElementById("gc");
//	ctx=canv.getContext("2d");
//    document.addEventListener("keyup",clearmove);
//	setTimeout(playmus, transitiontime);
    setTimeout(transition, 0);

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
endgame = true;

ctx.fillStyle="green";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("New Game",canv.width/2 - 40,canv.height/2 - 85);

}
else {
newline = Math.sqrt(((oldx[oldy.length - 1]-xpoint[a]) * (oldx[oldy.length - 1]-xpoint[a])) + ((oldy[oldy.length - 1]-ypoint[a]) * (oldy[oldy.length - 1]-ypoint[a])));
}


ctx.fillStyle="white";
//ctx.fillRect(canv.width - 202,14,99,14);
ctx.fillRect(canv.width - 101,14,100,14);

ctx.font = "10px sans-serif";
ctx.fillStyle="black";
//ctx.fillText(newline,canv.width - 200,25);
ctx.fillText(distance,canv.width - 100,25);


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

	document.addEventListener("keydown",keyPush);
	interval = setInterval(game,200);

}

function gamescreen() {
ctx.fillStyle="green";
ctx.fillRect(0,0,canv.width,canv.height);


ctx.fillStyle="white";
ctx.fillRect(canv.width/2-80,canv.height/2-105,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2-50,160,30);
ctx.fillRect(canv.width/2-80,canv.height/2+5,160,30);

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Start Game",canv.width/2 - 40,canv.height/2 - 85);
ctx.fillText("Options",canv.width/2 - 30,canv.height/2 - 30);
ctx.fillText("Credits",canv.width/2 - 30,canv.height/2 + 25);

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

ctx.fillStyle="black";
ctx.font = "bold 15px Arial";
ctx.fillText("Main Menu",canv.width/2 - 40,canv.height/2 - 85);
ctx.fillText("Sound On/Off",canv.width/2 - 50,canv.height/2 - 30);


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

function gameover() {
xpoint = xsaved.slice(0, xsaved.length);
ypoint = ysaved.slice(0, xsaved.length);
oldx = [];
oldy = [];
clearInterval(interval);
document.removeEventListener("keydown",keyPush);

k = Math.floor(Math.random()*xpoint.length);
xstart = xpoint[k];
ystart = ypoint[k];
			oldx.push(xpoint[k]);
    		oldy.push(ypoint[k]);
			xpoint.splice(k,1);
    		ypoint.splice(k,1);

a = Math.floor(Math.random()*xpoint.length);

setTimeout(gamescreen, 3);     

}

function clicked(evt) {
//alert(getMousePos(canv, evt).x);
xpos = getMousePos(canv, evt).x;
ypos = getMousePos(canv, evt).y;
//alert(xpos + " " + ypos);

if (on == true) {
	if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {
        	setTimeout(startgame, 3);        
        }   
    	else if ((ypos > canv.height/2-50) && (ypos < canv.height/2-20)) {
        setTimeout(options, 3);
        }
    	else if ((ypos > canv.height/2+5) && (ypos < canv.height/2+35)) { 
        setTimeout(credits, 3);
        }
    
    }

}
else if (endgame == true) {
if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {

        	setTimeout(gameover, 3);        
        }   
}
}
else if (gameon == true) {
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
}
else if (opt == true) {
if ((xpos > canv.width/2-80) && (xpos < canv.width/2+80)) {
    	if ((ypos > canv.height/2-105) && (ypos < canv.height/2-75)) {
        	setTimeout(gamescreen, 3);        
        }   
    	else if ((ypos > canv.height/2-50) && (ypos < canv.height/2-20)) {
        setTimeout(volume, 3);
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

</script>
</body>
</html>
