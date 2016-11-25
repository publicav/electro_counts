var TINY=TINY||{},T$=T$||function(b){return document.getElementById(b)},T$$$=T$$$||function(){return document.all?1:0};TINY.editor=function(){function b(p,c){this.n=p;window[p]=this;this.t=T$(c.id);this.obj=c;this.xhtml=c.xhtml;var a=document.createElement("div"),b=document.createElement("div"),h=document.createElement("div"),k=c.controls.length,n=0;this.i=document.createElement("iframe");this.i.width=c.width||"500";this.i.height=c.height||"250";this.ie=T$$$();h.className=c.rowclass||"tinyeditor-header";a.className=c.cssclass||"tinyeditor";a.style.width=this.i.width+"px";a.appendChild(h);for(n;n<k;n++){var e=c.controls[n];if("n"==e)h=document.createElement("div"),h.className=c.rowclass||"tinyeditor-header",a.appendChild(h);else if("|"==e){var d=document.createElement("div");d.className=c.dividerclass||"tinyeditor-divider";h.appendChild(d)}else if("font"==e){var e=document.createElement("select"),g=c.fonts||["Verdana","Arial","Georgia"],l=g.length,d=0;e.className="tinyeditor-font";e.onchange=new Function(this.n+'.ddaction(this, "fontname")');e.options[0]=new Option("Font","");for(d;d<l;d++){var m=g[d];e.options[d+1]=new Option(m,m)}h.appendChild(e)}else if("size"==e){e=document.createElement("select");l=c.sizes||[1,2,3,4,5,6,7];g=l.length;d=0;e.className="tinyeditor-size";e.onchange=new Function(this.n+'.ddaction(this, "fontsize")');for(d;d<g;d++)m=l[d],e.options[d]=new Option(m,m);h.appendChild(e)}else if("style"==e){e=document.createElement("select");l=c.styles||[["Style",""],["Paragraph","<p>"],["Header 1","<h1>"],["Header 2","<h2>"],["Header 3","<h3>"],["Header 4","<h4>"],["Header 5","<h5>"],["Header 6","<h6>"]];g=l.length;d=0;e.className="tinyeditor-style";e.onchange=new Function(this.n+'.ddaction(this, "formatblock")');for(d;d<g;d++)m=l[d],e.options[d]=new Option(m[0],m[1]);h.appendChild(e)}else f[e]&&(g=document.createElement("div"),d=f[e],m=d[2],l=d[0]*q,g.className=c.controlclass,g.unselectable="on",g.style.backgroundPosition="0px "+l+"px",g.title=d[1],d="a"==m?'.action("'+d[3]+'", 0, '+(d[4]||0)+")":'.insert("'+d[4]+'", "'+d[5]+'", "'+d[3]+'")',g.onmousedown=new Function(this.n+("print"==e?".print()":d)),g.onmouseover=new Function(this.n+".hover(this, "+l+", 1)"),g.onmouseout=new Function(this.n+".hover(this, "+l+", 0)"),h.appendChild(g),this.ie&&(g.unselectable="on"))}this.t.parentNode.insertBefore(a,this.t);this.t.style.width=this.i.width+"px";b.appendChild(this.t);b.appendChild(this.i);a.appendChild(b);this.t.style.display="none";c.footer&&(b=document.createElement("div"),b.className=c.footerclass||"tinyeditor-footer",c.toggle&&(h=c.toggle,k=document.createElement("div"),k.className=h.cssclass||"toggle",k.innerHTML=c.toggletext||"source",k.onclick=new Function(this.n+".toggle(0, this);return false"),b.appendChild(k)),c.resize&&(h=c.resize,k=document.createElement("div"),k.className=h.cssclass||"resize",k.onmousedown=new Function("event",this.n+".resize(event);return false"),k.onselectstart=function(){return!1},b.appendChild(k)),a.appendChild(b));this.e=this.i.contentWindow.document;this.e.open();a="<html><head>";b=c.bodyid?' id="'+c.bodyid+'"':"";c.cssfile&&(a+='<link rel="stylesheet" href="'+c.cssfile+'" />');c.css&&(a+='<style type="text/css">'+c.css+"</style>");a+="</head><body"+b+' contenteditable="true">'+(c.content||this.t.value);this.e.write(a+"</body></html>");this.e.close();this.e.designMode="On";this.d=1;if(this.xhtml)try{this.e.execCommand("styleWithCSS",0,0)}catch(r){try{this.e.execCommand("useCSS",0,1)}catch(s){}}}var f=[],q=-30;f.bold=[4,"Bold","a","bold"];f.italic=[5,"Italic","a","italic"];f.underline=[6,"Underline","a","underline"];f.strikethrough=[7,"Strikethrough","a","strikethrough"];f.subscript=[8,"Subscript","a","subscript"];f.superscript=[9,"Superscript","a","superscript"];f.orderedlist=[10,"Insert Ordered List","a","insertorderedlist"];f.unorderedlist=[11,"Insert Unordered List","a","insertunorderedlist"];f.outdent=[12,"Outdent","a","outdent"];f.indent=[13,"Indent","a","indent"];f.leftalign=[14,"Left Align","a","justifyleft"];f.centeralign=[15,"Center Align","a","justifycenter"];f.rightalign=[16,"Right Align","a","justifyright"];f.blockjustify=[17,"Block Justify","a","justifyfull"];f.undo=[18,"Undo","a","undo"];f.redo=[19,"Redo","a","redo"];f.image=[20,"Insert Image","i","insertimage","Enter Image URL:","http://"];f.hr=[21,"Insert Horizontal Rule","a","inserthorizontalrule"];f.link=[22,"Insert Hyperlink","i","createlink","Enter URL:","http://"];f.unlink=[23,"Remove Hyperlink","a","unlink"];f.unformat=[24,"Remove Formatting","a","removeformat"];f.print=[25,"Print","a","print"];b.prototype.print=function(){this.i.contentWindow.print()};b.prototype.hover=function(b,c,a){this.getSelection();b.style.backgroundPosition=(a?"34px ":"0px ")+c+"px"};b.prototype.getSelection=function(){this.ie&&this.e.getSelection&&(this.sel=this.e.getSelection(),this.sel.getRangeAt&&this.sel.rangeCount&&(this.range=this.sel.getRangeAt(0)))};b.prototype.restoreSelection=function(){this.range&&this.ie&&this.e.getSelection&&(this.sel=this.e.getSelection(),this.sel.removeAllRanges(),this.sel.addRange(this.range))};b.prototype.ddaction=function(b,c){this.action(c,b.options[b.selectedIndex].value)};b.prototype.action=function(b,c,a){a&&!this.ie?alert("Your browser does not support this function."):(this.restoreSelection(),this.e.execCommand(b,0,c||null))};b.prototype.insert=function(b,c,a){b=prompt(b,c);null!=b&&""!=b&&this.e.execCommand(a,0,b)};b.prototype.setfont=function(){this.restoreSelection();execCommand("formatblock",0,hType)};b.prototype.resize=function(b){this.mv&&this.freeze();this.i.bcs=TINY.cursor.top(b);this.mv=new Function("event",this.n+".move(event)");this.sr=new Function(this.n+".freeze()");this.ie?(document.attachEvent("onmousemove",this.mv),document.attachEvent("onmouseup",this.sr)):(document.addEventListener("mousemove",this.mv,1),document.addEventListener("mouseup",this.sr,1))};b.prototype.move=function(b){b=TINY.cursor.top(b);this.i.height=parseInt(this.i.height)+b-this.i.bcs;this.i.bcs=b};b.prototype.freeze=function(){this.ie?(document.detachEvent("onmousemove",this.mv),document.detachEvent("onmouseup",this.sr)):(document.removeEventListener("mousemove",this.mv,1),document.removeEventListener("mouseup",this.sr,1))};b.prototype.toggle=function(b,c){if(this.d)a=this.e.body.innerHTML,this.xhtml&&(a=a.replace(/<span class="apple-style-span">(.*)<\/span>/gi,"$1"),a=a.replace(/ class="apple-style-span"/gi,""),a=a.replace(/<span style="">/gi,""),a=a.replace(/<br>/gi,"<br />"),a=a.replace(/<br ?\/?>$/gi,""),a=a.replace(/^<br ?\/?>/gi,""),a=a.replace(/(<img [^>]+[^\/])>/gi,"$1 />"),a=a.replace(/<b\b[^>]*>(.*?)<\/b[^>]*>/gi,"<strong>$1</strong>"),a=a.replace(/<i\b[^>]*>(.*?)<\/i[^>]*>/gi,"<em>$1</em>"),a=a.replace(/<u\b[^>]*>(.*?)<\/u[^>]*>/gi,'<span style="text-decoration:underline">$1</span>'),a=a.replace(/<(b|strong|em|i|u) style="font-weight:normal;?">(.*)<\/(b|strong|em|i|u)>/gi,"$2"),a=a.replace(/<(b|strong|em|i|u) style="(.*)">(.*)<\/(b|strong|em|i|u)>/gi,'<span style="$2"><$4>$3</$4></span>'),a=a.replace(/<span style="font-weight:normal;?">(.*)<\/span>/gi,"$1"),a=a.replace(/<span style="font-weight:bold;?">(.*)<\/span>/gi,"<strong>$1</strong>"),a=a.replace(/<span style="font-style:italic;?">(.*)<\/span>/gi,"<em>$1</em>"),a=a.replace(/<span style="font-weight:bold;?">(.*)<\/span>|<b\b[^>]*>(.*?)<\/b[^>]*>/gi,"<strong>$1</strong>")),c&&(c.innerHTML=this.obj.toggletext||"wysiwyg"),this.t.value=a,b||(this.t.style.height=this.i.height+"px",this.i.style.display="none",this.t.style.display="block",this.d=0);else{var a=this.t.value;c&&(c.innerHTML=this.obj.toggletext||"source");this.xhtml&&!this.ie&&(a=a.replace(/<strong>(.*)<\/strong>/gi,'<span style="font-weight:bold;">$1</span>'),a=a.replace(/<em>(.*)<\/em>/gi,'<span style="font-weight:italic;">$1</span>'));this.e.body.innerHTML=a;this.t.style.display="none";this.i.style.display="block";this.d=1}};b.prototype.post=function(){this.d&&this.toggle(1)};b.prototype.val=function(b){if(b)this.e.body.innerHTML=b;else return this.e.body.innerHTML};return{edit:b}}();TINY.cursor=function(){return{top:function(b){return T$$$()?window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop:b.clientY+window.scrollY}}}();