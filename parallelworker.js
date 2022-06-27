//var workerdistance;


this.onmessage = function(e) {

var xsaved;
var ysaved;
var weights;
var num;
var bias;
var numpoints;
var startpoint;

xsaved = e.data.xsaved;
ysaved = e.data.ysaved;
weights = e.data.weights;
//num = e.data.count;
bias = e.data.bias;
startpoint = e.data.startpoint;
numhiddennodes = e.data.numhiddennodes;
//numpoints = e.data.count;
numpoints = xsaved.length;


//postMessage({id: e.data.id, workerdistance: weights[1]});
//workersetup();

worknumtest = 0;
startworkergame(worknumtest);

//    this.postMessage({id: e.data.id, sum: sum});


//workersetup();
//postMessage(xsaved[0]);

//workertested();

function workertested() {
//    getParameterByName(name, url);
    num = getParameterByName('arr').split(',');

//var num = location.href;
//nums = num.toString();
//nums = num.split(',');


postMessage(num[3]);
setTimeout("workertested()",500);
}



function getParameterByName(name, url) {
    if (!url) url = location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}



function workersetup() {
//postMessage({id: e.data.id, workerdistance: 2});
/*
xsaved = getParameterByName('xsaved').split(',');
ysaved = getParameterByName('ysaved').split(',');
weights = getParameterByName('weights').split(',');
bias = parseFloat(getParameterByName('bias'));
test = getParameterByName('test');

for (i = 0; i<weights.length; i++) {
weights[i] = parseFloat(weights[i]);
}

for (i = 0; i<xsaved.length; i++) {
xsaved[i] = parseFloat(xsaved[i]);
}

for (i = 0; i<ysaved.length; i++) {
ysaved[i] = parseFloat(ysaved[i]);
}
*/
numpoints = xsaved.length;
test = 'false';


if (test == 'yes') {
postMessage(Math.random());
//setTimeout("workersetup()",500);
close();

}
else {
worknumtest = 0;
//postMessage(xsaved[0]);
//postMessage(location.href);
//postMessage(bias);
startworkergame(worknumtest);

}

}



function startworkergame(worknumtest) {

//postMessage({id: e.data.id, workerdistance: 2});

workx = [];
worky = [];

//postMessage(worknumtest);

workxpoint = xsaved.slice(0, xsaved.length);
workypoint = ysaved.slice(0, ysaved.length);



if (startpoint === false) {
h = Math.floor(Math.random()*workxpoint.length);
}
else {
h = startpoint; 
}
//h = Math.floor(Math.random()*workxpoint.length);
workxstart = workxpoint[h];
workystart = workypoint[h];
			workx.push(workxpoint[h]);
    		worky.push(workypoint[h]);
			workxpoint.splice(h,1);
    		workypoint.splice(h,1);


	setTimeout(workergame(workxpoint, workypoint, workx, worky, worknumtest),1);


}



function workergame(workxpoint, workypoint, workx, worky, worknumtest) {
//postMessage({id: e.data.id, workerdistance: weights});

if (workxpoint.length == 0) {

workerdistance = workerdist(workx, worky).w;
workerdistance = workerdistance + Math.sqrt(((workx[workx.length - 1]-workx[0]) * (workx[workx.length - 1]-workx[0])) + ((worky[worky.length - 1]-worky[0]) * (worky[worky.length - 1]-worky[0])));

//totaltestdistance[worknumtest] = workerdistance;
//postMessage(workerdistance);
//postMessage({id: e.data.id, workerdistance: 12});
postMessage({id: e.data.id, workerdistance: workerdistance});
//setTimeout(workgameover(worknumtest), 3); 
close();

}
else {

workerlearn(workxpoint, workypoint, workx, worky, worknumtest);

}

}




function workerlearn(workxpoint, workypoint, workx, worky, worknumtest) {

distarray = [];
xdistarray = [];
ydistarray = [];
unorganizeddist = [];

sumdistance = 0.0;
xsumdist = 0.0;
ysumdist = 0.0;

xvector = 0.0;
yvector = 0.0;



for(var i=0;i<workxpoint.length;i++) {
distarray.push(Math.sqrt(((workxpoint[i]-workx[workx.length-1])*(workxpoint[i]-workx[workx.length-1]))+((workypoint[i]-worky[worky.length-1])*(workypoint[i]-worky[worky.length-1]))));
unorganizeddist.push(Math.sqrt(((workxpoint[i]-workx[workx.length-1])*(workxpoint[i]-workx[workx.length-1]))+((workypoint[i]-worky[worky.length-1])*(workypoint[i]-worky[worky.length-1]))));
xdistarray.push(workxpoint[i]-workx[workx.length-1]);
ydistarray.push(workypoint[i]-worky[worky.length-1]);
}

loop = 1;
while (loop === 1) {
loop = 0;
for(var i=1;i<workxpoint.length;i++) {
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
for(var i=1;i<workxpoint.length;i++) {
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
for(var i=1;i<workxpoint.length;i++) {
if (ydistarray[i-1] > ydistarray[i]) {
filler = ydistarray[i-1];
ydistarray[i-1] = ydistarray[i];
ydistarray[i] = filler;
loop = 1;
}
}
}

/*
h = Math.floor(workxpoint.length/2);
mediandist = distarray[h];
ymediandist = xdistarray[h];
xmediandist = ydistarray[h];

for(var i=0;i<workxpoint.length;i++) {
sumdistance = sumdistance + distarray[i];
xsumdist = xsumdist + xdistarray[i];
ysumdist = ysumdist + ydistarray[i];
}

avdistance = sumdistance/workxpoint.length;
xavdist = xsumdist/workxpoint.length;
yavdist = ysumdist/workxpoint.length;

//bias = (1*canv.width + canv.height)/(gs*1000);
//postMessage(typeof xsaved[0]);
//postMessage(worknumtest);
//postMessage(weights[15]);
//postMessage(workxpoint);


//alert(numtest);
xvector = workx[workx.length-1] + (bias)*(xavdist*weights[0] + xmediandist*weights[2] + avdistance*weights[4] + mediandist*weights[6] + (numpoints - workxpoint.length)*weights[8] + workxpoint.length*weights[10] + workx[workx.length-1]*weights[12]) + bias*weights[14];
yvector = worky[worky.length-1] + (bias)*(yavdist*weights[1] + ymediandist*weights[3] + avdistance*weights[5] + mediandist*weights[7] + (numpoints - workypoint.length)*weights[9] + workypoint.length*weights[11] + worky[worky.length-1]*weights[13]) + bias*weights[15];

//postMessage(bias);
*/

//"modified/normalized inputs" 
inputarray = [];
h = Math.floor(workxpoint.length/2);
inputarray[0] = distarray[h];
inputarray[1] = xdistarray[h];
inputarray[2] = ydistarray[h];

inputarray[3] = 0;
inputarray[4] = 0;
inputarray[5] = 0;
for(var i=0;i<workxpoint.length;i++) {
inputarray[3] = inputarray[3] + distarray[i];
inputarray[4] = inputarray[4] + xdistarray[i];
inputarray[5] = inputarray[5] + ydistarray[i];
}
inputarray[3] = inputarray[3]/workxpoint.length;
inputarray[4] = inputarray[4]/workxpoint.length;
inputarray[5] = inputarray[5]/workxpoint.length;

inputarray[6] = numpoints - workxpoint.length;
inputarray[7] = workxpoint.length;

inputarray[8] = workx[workx.length-1];  
inputarray[9] = worky[worky.length-1];  
inputarray[10] = 1; // bias 

modifier = calculateworkernetwork(inputarray);

//add hidden layer   
xvector = workx[workx.length-1] + bias * modifier.x; 
yvector = worky[worky.length-1] + bias * modifier.y; 



wevolve =  workvectorpoint(xvector, yvector, workxpoint, workypoint).w;



if (workxpoint.length !== 0) {

   			k = wevolve;

    		workx.push(workxpoint[k]);
    		worky.push(workypoint[k]);
			workxpoint.splice(k,1);
    		workypoint.splice(k,1);

 
}


setTimeout(workergame(workxpoint, workypoint, workx, worky, worknumtest),1);

}


function calculateworkernetwork(inputarray) {
//feed forward network 
hiddenarray = [];

k=0;
for(var h=0;h<numhiddennodes;h++) {
hiddenarray[h] = 0;
for(var i=0;i<inputarray.length;i++) {
hiddenarray[h] = hiddenarray[h] + weights[k] * inputarray[i];
k++;
}
}

xmod = 0; 
for(var h=0;h<numhiddennodes;h++) {
//xmod = xmod + hiddenarray[h] * weights[k]; //linear 
//xmod = xmod + Math.tanh(hiddenarray[h]) * weights[k]; //hyperbolic tangent 
xmod = xmod + 1/(1 + Math.exp(-hiddenarray[h])) * weights[k]; //sigmoid   
k++;
}

ymod = 0; 
for(var h=0;h<numhiddennodes;h++) {
//ymod = ymod + hiddenarray[h] * weights[k]; //linear  
//ymod = ymod + Math.tanh(hiddenarray[h]) * weights[k]; //hyperbolic tangent
ymod = ymod + 1/(1 + Math.exp(-hiddenarray[h])) * weights[k]; //sigmoid
k++;
}


return {
x: xmod,
y: ymod,
k: k
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



function workvectorpoint(xinput, yinput, workxpoint, workypoint) {
w = 0;
vectordist = [];

for(var i=0;i<workxpoint.length;i++) {
vectordist.push(Math.sqrt(((workxpoint[i]-xinput)*(workxpoint[i]-xinput))+((workypoint[i]-yinput)*(workypoint[i]-yinput))));
}

mindist = vectordist[0];

for(var i=1;i<workxpoint.length;i++) {
if (vectordist[i] < mindist) {
mindist = vectordist[i];
w = i;
}
}
//alert(w);
return {
x: workxpoint[w],
y: workypoint[w],
w: w
}

}


};

