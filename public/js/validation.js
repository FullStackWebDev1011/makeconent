/* eslint-disable no-unused-vars */
window.toslug = function(text){
	return text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
}

window.alphaOnly = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[a-zA-Z ]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z ]/g, '') }, 25, 50)
}

window.fullNameKey = function (e) {
	if (/^(8|9)$/g.test(e.keyCode)) return true;
	if (/^[a-zA-Z ]$/g.test(e.key)) return;
	this.interval(() => { e.target.value = e.target.value.replace(/[^a-zA-Z ]/g, '') }, 25, 50)
}

window.alphaNumber = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[a-zA-Z0-9 ]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z0-9 ]/g, '') }, 25, 50)
}

window.websiteKey = function(e){
	if(/^(8)$/g.test(e.keyCode)) return true;
	// return /^[a-zA-Z0-9/:. ]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z0-9/:. ]/g, '') }, 25, 50)
}

window.numberKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[0-9]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^0-9]/g, '') }, 25, 50)
}

window.mobileKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[0-9+]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^0-9+]/g, '') }, 25, 50)
}

window.noKtmKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[0-9+/-]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z0-9./-]/g, '') }, 25, 50)
}

window.phoneKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[0-9]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^0-9]/g, '') }, 25, 50)
}

window.noNPWPKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[0-9./-]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^0-9./-]/g, '') }, 25, 50)
}

window.noSIUPKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[a-zA-Z0-9./-]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z0-9./-]/g, '') }, 25, 50)
}

window.noMenkumHamKey = function(e){
	if (/^(8)$/g.test(e.keyCode)) return true;
	// return /^[a-zA-Z0-9./-]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z0-9./-]/g, '') }, 25, 50)
}

window.emailKey = function(e){
	if(/^(8)$/g.test(e.keyCode)) return true;
	// return /^[a-zA-Z0-9@+._-]$/g.test(String.fromCharCode(e.which));
	this.interval(()=>{ e.target.value = e.target.value.replace(/[^a-zA-Z0-9@+._-]/g, '') }, 25, 50)
}

window.maxWord = function(e, limit){
	if(e.key===" "&&e.target.value.wordLength() == limit) return false
	if(e.key===" "&&e.key===e.target.value.substr(-1)) return false
	return true
}

function interval(callback, speed, timeout){
var time = 0;
var i = setInterval(()=>{
    time += speed;
    try{
    callback()
    }catch(e){
    // statement
    }
    if(time==timeout) clearInterval(i);
}, speed);
return new Promise((resolve)=>{ setTimeout(()=>{ resolve }, timeout) })
}