import{c as L,g as $}from"./_commonjsHelpers-de833af9.js";var j={exports:{}},S={exports:{}},M;function I(){return M||(M=1,function(R){(function(){function h(p,f,m,w){return new k(p,f,m,w)}h.adapters={};function k(p,f,m,w){this.options=w||{},this.options.adapters=this.options.adapters||{},this.obj=p,this.keypath=f,this.callback=m,this.objectPath=[],this.update=this.update.bind(this),this.parse(),N(this.target=this.realize())&&this.set(!0,this.key,this.target,this.callback)}k.tokenize=function(p,f,m){var w=[],x={i:m,path:""},T,e;for(T=0;T<p.length;T++)e=p.charAt(T),~f.indexOf(e)?(w.push(x),x={i:e,path:""}):x.path+=e;return w.push(x),w},k.prototype.parse=function(){var p=this.interfaces(),f,m;p.length||F("Must define at least one adapter interface."),~p.indexOf(this.keypath[0])?(f=this.keypath[0],m=this.keypath.substr(1)):(typeof(f=this.options.root||h.root)>"u"&&F("Must define a default root adapter."),m=this.keypath),this.tokens=k.tokenize(m,p,f),this.key=this.tokens.pop()},k.prototype.realize=function(){var p=this.obj,f=!1,m;return this.tokens.forEach(function(w,x){N(p)?(typeof this.objectPath[x]<"u"?p!==(m=this.objectPath[x])&&(this.set(!1,w,m,this.update),this.set(!0,w,p,this.update),this.objectPath[x]=p):(this.set(!0,w,p,this.update),this.objectPath[x]=p),p=this.get(w,p)):(f===!1&&(f=x),(m=this.objectPath[x])&&this.set(!1,w,m,this.update))},this),f!==!1&&this.objectPath.splice(f),p},k.prototype.update=function(){var p,f;(p=this.realize())!==this.target&&(N(this.target)&&this.set(!1,this.key,this.target,this.callback),N(p)&&this.set(!0,this.key,p,this.callback),f=this.value(),this.target=p,(this.value()instanceof Function||this.value()!==f)&&this.callback())},k.prototype.value=function(){if(N(this.target))return this.get(this.key,this.target)},k.prototype.setValue=function(p){N(this.target)&&this.adapter(this.key).set(this.target,this.key.path,p)},k.prototype.get=function(p,f){return this.adapter(p).get(f,p.path)},k.prototype.set=function(p,f,m,w){var x=p?"observe":"unobserve";this.adapter(f)[x](m,f.path,w)},k.prototype.interfaces=function(){var p=Object.keys(this.options.adapters);return Object.keys(h.adapters).forEach(function(f){~p.indexOf(f)||p.push(f)}),p},k.prototype.adapter=function(p){return this.options.adapters[p.i]||h.adapters[p.i]},k.prototype.unobserve=function(){var p;this.tokens.forEach(function(f,m){(p=this.objectPath[m])&&this.set(!1,f,p,this.update)},this),N(this.target)&&this.set(!1,this.key,this.target,this.callback)};function N(p){return typeof p=="object"&&p!==null}function F(p){throw new Error("[sightglass] "+p)}R.exports?R.exports=h:this.sightglass=h}).call(L)}(S)),S.exports}j.exports;(function(R){(function(){var h,k,N,F,p,f=function(e,t){return function(){return e.apply(t,arguments)}},m=[].slice,w={}.hasOwnProperty,x=function(e,t){for(var i in t)w.call(t,i)&&(e[i]=t[i]);function n(){this.constructor=e}return n.prototype=t.prototype,e.prototype=new n,e.__super__=t.prototype,e},T=[].indexOf||function(e){for(var t=0,i=this.length;t<i;t++)if(t in this&&this[t]===e)return t;return-1};h={options:["prefix","templateDelimiters","rootInterface","preloadData","handler","executeFunctions"],extensions:["binders","formatters","components","adapters"],public:{binders:{},components:{},formatters:{},adapters:{},prefix:"rv",templateDelimiters:["{","}"],rootInterface:".",preloadData:!0,executeFunctions:!1,iterationAlias:function(e){return"%"+e+"%"},handler:function(e,t,i){return this.call(e,t,i.view.models)},configure:function(e){var t,i,n,r;e==null&&(e={});for(n in e)if(r=e[n],n==="binders"||n==="components"||n==="formatters"||n==="adapters")for(i in r)t=r[i],h[n][i]=t;else h.public[n]=r},bind:function(e,t,i){var n;return t==null&&(t={}),i==null&&(i={}),n=new h.View(e,t,i),n.bind(),n},init:function(e,t,i){var n,r,s;if(i==null&&(i={}),t==null&&(t=document.createElement("div")),e=h.public.components[e],r=e.template.call(this,t),r instanceof HTMLElement){for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(r)}else t.innerHTML=r;return n=e.initialize.call(this,t,i),s=new h.View(t,n),s.bind(),s}}},window.jQuery||window.$?(N=window.jQuery||window.$,p="on"in N.prototype?["on","off"]:["bind","unbind"],k=p[0],F=p[1],h.Util={bindEvent:function(e,t,i){return N(e)[k](t,i)},unbindEvent:function(e,t,i){return N(e)[F](t,i)},getInputValue:function(e){var t;return t=N(e),t.attr("type")==="checkbox"?t.is(":checked"):t.val()}}):h.Util={bindEvent:function(){return"addEventListener"in window?function(e,t,i){return e.addEventListener(t,i,!1)}:function(e,t,i){return e.attachEvent("on"+t,i)}}(),unbindEvent:function(){return"removeEventListener"in window?function(e,t,i){return e.removeEventListener(t,i,!1)}:function(e,t,i){return e.detachEvent("on"+t,i)}}(),getInputValue:function(e){var t,i,n,r;if(e.type==="checkbox")return e.checked;if(e.type==="select-multiple"){for(r=[],i=0,n=e.length;i<n;i++)t=e[i],t.selected&&r.push(t.value);return r}else return e.value}},h.TypeParser=function(){function e(){}return e.types={primitive:0,keypath:1},e.parse=function(t){return/^'.*'$|^".*"$/.test(t)?{type:this.types.primitive,value:t.slice(1,-1)}:t==="true"?{type:this.types.primitive,value:!0}:t==="false"?{type:this.types.primitive,value:!1}:t==="null"?{type:this.types.primitive,value:null}:t==="undefined"?{type:this.types.primitive,value:void 0}:t===""?{type:this.types.primitive,value:void 0}:isNaN(Number(t))===!1?{type:this.types.primitive,value:Number(t)}:{type:this.types.keypath,value:t}},e}(),h.TextTemplateParser=function(){function e(){}return e.types={text:0,binding:1},e.parse=function(t,i){var n,r,s,o,u,a,l;for(a=[],o=t.length,n=0,r=0;r<o;)if(n=t.indexOf(i[0],r),n<0){a.push({type:this.types.text,value:t.slice(r)});break}else{if(n>0&&r<n&&a.push({type:this.types.text,value:t.slice(r,n)}),r=n+i[0].length,n=t.indexOf(i[1],r),n<0){u=t.slice(r-i[1].length),s=a[a.length-1],(s!=null?s.type:void 0)===this.types.text?s.value+=u:a.push({type:this.types.text,value:u});break}l=t.slice(r,n).trim(),a.push({type:this.types.binding,value:l}),r=n+i[1].length}return a},e}(),h.View=function(){function e(t,i,n){var r,s,o,u,a,l,d,b,c,g,v,y,_;for(this.els=t,this.models=i,n==null&&(n={}),this.update=f(this.update,this),this.publish=f(this.publish,this),this.sync=f(this.sync,this),this.unbind=f(this.unbind,this),this.bind=f(this.bind,this),this.select=f(this.select,this),this.traverse=f(this.traverse,this),this.build=f(this.build,this),this.buildBinding=f(this.buildBinding,this),this.bindingRegExp=f(this.bindingRegExp,this),this.options=f(this.options,this),this.els.jquery||this.els instanceof Array||(this.els=[this.els]),c=h.extensions,a=0,d=c.length;a<d;a++){if(s=c[a],this[s]={},n[s]){g=n[s];for(r in g)o=g[r],this[s][r]=o}v=h.public[s];for(r in v)o=v[r],(u=this[s])[r]==null&&(u[r]=o)}for(y=h.options,l=0,b=y.length;l<b;l++)s=y[l],this[s]=(_=n[s])!=null?_:h.public[s];this.build()}return e.prototype.options=function(){var t,i,n,r,s;for(i={},s=h.extensions.concat(h.options),n=0,r=s.length;n<r;n++)t=s[n],i[t]=this[t];return i},e.prototype.bindingRegExp=function(){return new RegExp("^"+this.prefix+"-")},e.prototype.buildBinding=function(t,i,n,r){var s,o,u,a,l,d,b;return l={},b=function(){var c,g,v,y;for(v=r.match(/((?:'[^']*')*(?:(?:[^\|']*(?:'[^']*')+[^\|']*)+|[^\|]+))|^$/g),y=[],c=0,g=v.length;c<g;c++)d=v[c],y.push(d.trim());return y}(),s=function(){var c,g,v,y;for(v=b.shift().split("<"),y=[],c=0,g=v.length;c<g;c++)o=v[c],y.push(o.trim());return y}(),a=s.shift(),l.formatters=b,(u=s.shift())&&(l.dependencies=u.split(/\s+/)),this.bindings.push(new h[t](this,i,n,a,l))},e.prototype.build=function(){var t,i,n,r,s;for(this.bindings=[],i=function(o){return function(u){var a,l,d,b,c,g,v,y,_,E,O,V,P;if(u.nodeType===3){if(c=h.TextTemplateParser,(d=o.templateDelimiters)&&(y=c.parse(u.data,d)).length&&!(y.length===1&&y[0].type===c.types.text)){for(_=0,O=y.length;_<O;_++)v=y[_],g=document.createTextNode(v.value),u.parentNode.insertBefore(g,u),v.type===1&&o.buildBinding("TextBinding",g,null,v.value);u.parentNode.removeChild(u)}}else u.nodeType===1&&(a=o.traverse(u));if(!a)for(P=function(){var B,C,A,U;for(A=u.childNodes,U=[],B=0,C=A.length;B<C;B++)b=A[B],U.push(b);return U}(),E=0,V=P.length;E<V;E++)l=P[E],i(l)}}(this),s=this.els,n=0,r=s.length;n<r;n++)t=s[n],i(t);this.bindings.sort(function(o,u){var a,l;return(((a=u.binder)!=null?a.priority:void 0)||0)-(((l=o.binder)!=null?l.priority:void 0)||0)})},e.prototype.traverse=function(t){var i,n,r,s,o,u,a,l,d,b,c,g,v,y,_,E;for(s=this.bindingRegExp(),o=t.nodeName==="SCRIPT"||t.nodeName==="STYLE",y=t.attributes,b=0,g=y.length;b<g;b++)if(i=y[b],s.test(i.name)){if(l=i.name.replace(s,""),!(r=this.binders[l])){_=this.binders;for(u in _)d=_[u],u!=="*"&&u.indexOf("*")!==-1&&(a=new RegExp("^"+u.replace(/\*/g,".+")+"$"),a.test(l)&&(r=d))}r||(r=this.binders["*"]),r.block&&(o=!0,n=[i])}for(E=n||t.attributes,c=0,v=E.length;c<v;c++)i=E[c],s.test(i.name)&&(l=i.name.replace(s,""),this.buildBinding("Binding",t,l,i.value));return o||(l=t.nodeName.toLowerCase(),this.components[l]&&!t._bound&&(this.bindings.push(new h.ComponentBinding(this,t,l)),o=!0)),o},e.prototype.select=function(t){var i,n,r,s,o;for(s=this.bindings,o=[],n=0,r=s.length;n<r;n++)i=s[n],t(i)&&o.push(i);return o},e.prototype.bind=function(){var t,i,n,r;for(r=this.bindings,i=0,n=r.length;i<n;i++)t=r[i],t.bind()},e.prototype.unbind=function(){var t,i,n,r;for(r=this.bindings,i=0,n=r.length;i<n;i++)t=r[i],t.unbind()},e.prototype.sync=function(){var t,i,n,r;for(r=this.bindings,i=0,n=r.length;i<n;i++)t=r[i],typeof t.sync=="function"&&t.sync()},e.prototype.publish=function(){var t,i,n,r;for(r=this.select(function(s){var o;return(o=s.binder)!=null?o.publishes:void 0}),i=0,n=r.length;i<n;i++)t=r[i],t.publish()},e.prototype.update=function(t){var i,n,r,s,o,u;t==null&&(t={});for(n in t)r=t[n],this.models[n]=r;for(u=this.bindings,s=0,o=u.length;s<o;s++)i=u[s],typeof i.update=="function"&&i.update(t)},e}(),h.Binding=function(){function e(t,i,n,r,s){this.view=t,this.el=i,this.type=n,this.keypath=r,this.options=s??{},this.getValue=f(this.getValue,this),this.update=f(this.update,this),this.unbind=f(this.unbind,this),this.bind=f(this.bind,this),this.publish=f(this.publish,this),this.sync=f(this.sync,this),this.set=f(this.set,this),this.eventHandler=f(this.eventHandler,this),this.formattedValue=f(this.formattedValue,this),this.parseFormatterArguments=f(this.parseFormatterArguments,this),this.parseTarget=f(this.parseTarget,this),this.observe=f(this.observe,this),this.setBinder=f(this.setBinder,this),this.formatters=this.options.formatters||[],this.dependencies=[],this.formatterObservers={},this.model=void 0,this.setBinder()}return e.prototype.setBinder=function(){var t,i,n,r;if(!(this.binder=this.view.binders[this.type])){r=this.view.binders;for(t in r)n=r[t],t!=="*"&&t.indexOf("*")!==-1&&(i=new RegExp("^"+t.replace(/\*/g,".+")+"$"),i.test(this.type)&&(this.binder=n,this.args=new RegExp("^"+t.replace(/\*/g,"(.+)")+"$").exec(this.type),this.args.shift()))}if(this.binder||(this.binder=this.view.binders["*"]),this.binder instanceof Function)return this.binder={routine:this.binder}},e.prototype.observe=function(t,i,n){return h.sightglass(t,i,n,{root:this.view.rootInterface,adapters:this.view.adapters})},e.prototype.parseTarget=function(){var t;return t=h.TypeParser.parse(this.keypath),t.type===h.TypeParser.types.primitive?this.value=t.value:(this.observer=this.observe(this.view.models,this.keypath,this.sync),this.model=this.observer.target)},e.prototype.parseFormatterArguments=function(t,i){var n,r,s,o,u,a,l;for(t=function(){var d,b,c;for(c=[],d=0,b=t.length;d<b;d++)r=t[d],c.push(h.TypeParser.parse(r));return c}(),o=[],n=a=0,l=t.length;a<l;n=++a)r=t[n],o.push(r.type===h.TypeParser.types.primitive?r.value:((u=this.formatterObservers)[i]||(u[i]={}),(s=this.formatterObservers[i][n])||(s=this.observe(this.view.models,r.value,this.sync),this.formatterObservers[i][n]=s),s.value()));return o},e.prototype.formattedValue=function(t){var i,n,r,s,o,u,a,l,d;for(l=this.formatters,n=u=0,a=l.length;u<a;n=++u)r=l[n],i=r.match(/[^\s']+|'([^']|'[^\s])*'|"([^"]|"[^\s])*"/g),s=i.shift(),r=this.view.formatters[s],o=this.parseFormatterArguments(i,n),(r!=null?r.read:void 0)instanceof Function?t=(d=r.read).call.apply(d,[this.model,t].concat(m.call(o))):r instanceof Function&&(t=r.call.apply(r,[this.model,t].concat(m.call(o))));return t},e.prototype.eventHandler=function(t){var i,n;return n=(i=this).view.handler,function(r){return n.call(t,this,r,i)}},e.prototype.set=function(t){var i;return t=t instanceof Function&&!this.binder.function&&h.public.executeFunctions?this.formattedValue(t.call(this.model)):this.formattedValue(t),(i=this.binder.routine)!=null?i.call(this,this.el,t):void 0},e.prototype.sync=function(){var t,i;return this.set((function(){var n,r,s,o,u,a,l;if(this.observer){if(this.model!==this.observer.target){for(u=this.dependencies,n=0,s=u.length;n<s;n++)i=u[n],i.unobserve();if(this.dependencies=[],(this.model=this.observer.target)!=null&&((a=this.options.dependencies)!=null&&a.length))for(l=this.options.dependencies,r=0,o=l.length;r<o;r++)t=l[r],i=this.observe(this.model,t,this.sync),this.dependencies.push(i)}return this.observer.value()}else return this.value}).call(this))},e.prototype.publish=function(){var t,i,n,r,s,o,u,a,l,d,b,c,g;if(this.observer){for(a=this.getValue(this.el),o=this.formatters.length-1,b=this.formatters.slice(0).reverse(),n=l=0,d=b.length;l<d;n=++l)r=b[n],i=o-n,t=r.split(/\s+/),s=t.shift(),u=this.parseFormatterArguments(t,i),(c=this.view.formatters[s])!=null&&c.publish&&(a=(g=this.view.formatters[s]).publish.apply(g,[a].concat(m.call(u))));return this.observer.setValue(a)}},e.prototype.bind=function(){var t,i,n,r,s,o,u;if(this.parseTarget(),(s=this.binder.bind)!=null&&s.call(this,this.el),this.model!=null&&((o=this.options.dependencies)!=null&&o.length))for(u=this.options.dependencies,n=0,r=u.length;n<r;n++)t=u[n],i=this.observe(this.model,t,this.sync),this.dependencies.push(i);if(this.view.preloadData)return this.sync()},e.prototype.unbind=function(){var t,i,n,r,s,o,u,a,l,d;for((u=this.binder.unbind)!=null&&u.call(this,this.el),(a=this.observer)!=null&&a.unobserve(),l=this.dependencies,s=0,o=l.length;s<o;s++)r=l[s],r.unobserve();this.dependencies=[],d=this.formatterObservers;for(n in d){i=d[n];for(t in i)r=i[t],r.unobserve()}return this.formatterObservers={}},e.prototype.update=function(t){var i,n;return t==null&&(t={}),this.model=(i=this.observer)!=null?i.target:void 0,(n=this.binder.update)!=null?n.call(this,t):void 0},e.prototype.getValue=function(t){return this.binder&&this.binder.getValue!=null?this.binder.getValue.call(this,t):h.Util.getInputValue(t)},e}(),h.ComponentBinding=function(e){x(t,e);function t(i,n,r){var s,o,u,a,l,d,b,c;for(this.view=i,this.el=n,this.type=r,this.unbind=f(this.unbind,this),this.bind=f(this.bind,this),this.locals=f(this.locals,this),this.component=this.view.components[this.type],this.static={},this.observers={},this.upstreamObservers={},o=i.bindingRegExp(),b=this.el.attributes||[],l=0,d=b.length;l<d;l++)s=b[l],o.test(s.name)||(u=this.camelCase(s.name),a=h.TypeParser.parse(s.value),T.call((c=this.component.static)!=null?c:[],u)>=0?this.static[u]=s.value:a.type===h.TypeParser.types.primitive?this.static[u]=a.value:this.observers[u]=s.value)}return t.prototype.sync=function(){},t.prototype.update=function(){},t.prototype.publish=function(){},t.prototype.locals=function(){var i,n,r,s,o,u;r={},o=this.static;for(i in o)s=o[i],r[i]=s;u=this.observers;for(i in u)n=u[i],r[i]=n.value();return r},t.prototype.camelCase=function(i){return i.replace(/-([a-z])/g,function(n){return n[1].toUpperCase()})},t.prototype.bind=function(){var i,n,r,s,o,u,a,l,d,b,c,g,v,y,_,E,O,V,P,B;if(!this.bound){y=this.observers;for(n in y)r=y[n],this.observers[n]=this.observe(this.view.models,r,function(C){return function(A){return function(){return C.componentView.models[A]=C.observers[A].value()}}}(this).call(this,n));this.bound=!0}if(this.componentView!=null)this.componentView.bind();else{for(this.el.innerHTML=this.component.template.call(this),a=this.component.initialize.call(this,this.el,this.locals()),this.el._bound=!0,u={},_=h.extensions,b=0,g=_.length;b<g;b++){if(o=_[b],u[o]={},this.component[o]){E=this.component[o];for(i in E)l=E[i],u[o][i]=l}O=this.view[o];for(i in O)l=O[i],(d=u[o])[i]==null&&(d[i]=l)}for(V=h.options,c=0,v=V.length;c<v;c++)o=V[c],u[o]=(P=this.component[o])!=null?P:this.view[o];this.componentView=new h.View(Array.prototype.slice.call(this.el.childNodes),a,u),this.componentView.bind(),B=this.observers;for(n in B)s=B[n],this.upstreamObservers[n]=this.observe(this.componentView.models,n,function(C){return function(A,U){return function(){return U.setValue(C.componentView.models[A])}}}(this).call(this,n,s))}},t.prototype.unbind=function(){var i,n,r,s,o;r=this.upstreamObservers;for(i in r)n=r[i],n.unobserve();s=this.observers;for(i in s)n=s[i],n.unobserve();return(o=this.componentView)!=null?o.unbind.call(this):void 0},t}(h.Binding),h.TextBinding=function(e){x(t,e);function t(i,n,r,s,o){this.view=i,this.el=n,this.type=r,this.keypath=s,this.options=o??{},this.sync=f(this.sync,this),this.formatters=this.options.formatters||[],this.dependencies=[],this.formatterObservers={}}return t.prototype.binder={routine:function(i,n){return i.data=n??""}},t.prototype.sync=function(){return t.__super__.sync.apply(this,arguments)},t}(h.Binding),h.public.binders.text=function(e,t){return e.textContent!=null?e.textContent=t??"":e.innerText=t??""},h.public.binders.html=function(e,t){return e.innerHTML=t??""},h.public.binders.show=function(e,t){return e.style.display=t?"":"none"},h.public.binders.hide=function(e,t){return e.style.display=t?"none":""},h.public.binders.enabled=function(e,t){return e.disabled=!t},h.public.binders.disabled=function(e,t){return e.disabled=!!t},h.public.binders.checked={publishes:!0,priority:2e3,bind:function(e){return h.Util.bindEvent(e,"change",this.publish)},unbind:function(e){return h.Util.unbindEvent(e,"change",this.publish)},routine:function(e,t){var i;return e.type==="radio"?e.checked=((i=e.value)!=null?i.toString():void 0)===(t!=null?t.toString():void 0):e.checked=!!t}},h.public.binders.unchecked={publishes:!0,priority:2e3,bind:function(e){return h.Util.bindEvent(e,"change",this.publish)},unbind:function(e){return h.Util.unbindEvent(e,"change",this.publish)},routine:function(e,t){var i;return e.type==="radio"?e.checked=((i=e.value)!=null?i.toString():void 0)!==(t!=null?t.toString():void 0):e.checked=!t}},h.public.binders.value={publishes:!0,priority:3e3,bind:function(e){if(!(e.tagName==="INPUT"&&e.type==="radio"))return this.event=e.tagName==="SELECT"?"change":"input",h.Util.bindEvent(e,this.event,this.publish)},unbind:function(e){if(!(e.tagName==="INPUT"&&e.type==="radio"))return h.Util.unbindEvent(e,this.event,this.publish)},routine:function(e,t){var i,n,r,s,o,u,a;if(e.tagName==="INPUT"&&e.type==="radio")return e.setAttribute("value",t);if(window.jQuery!=null){if(e=N(e),(t!=null?t.toString():void 0)!==((s=e.val())!=null?s.toString():void 0))return e.val(t??"")}else if(e.type==="select-multiple"){if(t!=null){for(a=[],n=0,r=e.length;n<r;n++)i=e[n],a.push(i.selected=(o=i.value,T.call(t,o)>=0));return a}}else if((t!=null?t.toString():void 0)!==((u=e.value)!=null?u.toString():void 0))return e.value=t??""}},h.public.binders.if={block:!0,priority:4e3,bind:function(e){var t,i;if(this.marker==null)return t=[this.view.prefix,this.type].join("-").replace("--","-"),i=e.getAttribute(t),this.marker=document.createComment(" rivets: "+this.type+" "+i+" "),this.bound=!1,e.removeAttribute(t),e.parentNode.insertBefore(this.marker,e),e.parentNode.removeChild(e)},unbind:function(){if(this.nested)return this.nested.unbind(),this.bound=!1},routine:function(e,t){var i,n,r,s;if(!!t==!this.bound)if(t){r={},s=this.view.models;for(i in s)n=s[i],r[i]=n;return(this.nested||(this.nested=new h.View(e,r,this.view.options()))).bind(),this.marker.parentNode.insertBefore(e,this.marker.nextSibling),this.bound=!0}else return e.parentNode.removeChild(e),this.nested.unbind(),this.bound=!1},update:function(e){var t;return(t=this.nested)!=null?t.update(e):void 0}},h.public.binders.unless={block:!0,priority:4e3,bind:function(e){return h.public.binders.if.bind.call(this,e)},unbind:function(){return h.public.binders.if.unbind.call(this)},routine:function(e,t){return h.public.binders.if.routine.call(this,e,!t)},update:function(e){return h.public.binders.if.update.call(this,e)}},h.public.binders["on-*"]={function:!0,priority:1e3,unbind:function(e){if(this.handler)return h.Util.unbindEvent(e,this.args[0],this.handler)},routine:function(e,t){return this.handler&&h.Util.unbindEvent(e,this.args[0],this.handler),h.Util.bindEvent(e,this.args[0],this.handler=this.eventHandler(t))}},h.public.binders["each-*"]={block:!0,priority:4e3,bind:function(e){var t,i,n,r,s;if(this.marker==null)t=[this.view.prefix,this.type].join("-").replace("--","-"),this.marker=document.createComment(" rivets: "+this.type+" "),this.iterated=[],e.removeAttribute(t),e.parentNode.insertBefore(this.marker,e),e.parentNode.removeChild(e);else for(s=this.iterated,n=0,r=s.length;n<r;n++)i=s[n],i.bind()},unbind:function(e){var t,i,n,r;if(this.iterated!=null)for(r=this.iterated,i=0,n=r.length;i<n;i++)t=r[i],t.unbind()},routine:function(e,t){var i,n,r,s,o,u,a,l,d,b,c,g,v,y,_,E,O,V,P;if(u=this.args[0],t=t||[],this.iterated.length>t.length)for(O=Array(this.iterated.length-t.length),c=0,y=O.length;c<y;c++)O[c],b=this.iterated.pop(),b.unbind(),this.marker.parentNode.removeChild(b.els[0]);for(r=g=0,_=t.length;g<_;r=++g)if(o=t[r],n={index:r},n[h.public.iterationAlias(u)]=r,n[u]=o,this.iterated[r]==null){V=this.view.models;for(s in V)o=V[s],n[s]==null&&(n[s]=o);l=this.iterated.length?this.iterated[this.iterated.length-1].els[0]:this.marker,a=this.view.options(),a.preloadData=!0,d=e.cloneNode(!0),b=new h.View(d,n,a),b.bind(),this.iterated.push(b),this.marker.parentNode.insertBefore(d,l.nextSibling)}else this.iterated[r].models[u]!==o&&this.iterated[r].update(n);if(e.nodeName==="OPTION")for(P=this.view.bindings,v=0,E=P.length;v<E;v++)i=P[v],i.el===this.marker.parentNode&&i.type==="value"&&i.sync()},update:function(e){var t,i,n,r,s,o,u;t={};for(i in e)n=e[i],i!==this.args[0]&&(t[i]=n);for(u=this.iterated,s=0,o=u.length;s<o;s++)r=u[s],r.update(t)}},h.public.binders["class-*"]=function(e,t){var i;if(i=" "+e.className+" ",!t==(i.indexOf(" "+this.args[0]+" ")!==-1))return e.className=t?""+e.className+" "+this.args[0]:i.replace(" "+this.args[0]+" "," ").trim()},h.public.binders["*"]=function(e,t){return t!=null?e.setAttribute(this.type,t):e.removeAttribute(this.type)},h.public.formatters.call=function(){var e,t;return t=arguments[0],e=2<=arguments.length?m.call(arguments,1):[],t.call.apply(t,[this].concat(m.call(e)))},h.public.adapters["."]={id:"_rv",counter:0,weakmap:{},weakReference:function(e){var t,i,n;return e.hasOwnProperty(this.id)||(t=this.counter++,Object.defineProperty(e,this.id,{value:t})),(i=this.weakmap)[n=e[this.id]]||(i[n]={callbacks:{}})},cleanupWeakReference:function(e,t){if(!Object.keys(e.callbacks).length&&!(e.pointers&&Object.keys(e.pointers).length))return delete this.weakmap[t]},stubFunction:function(e,t){var i,n,r;return n=e[t],i=this.weakReference(e),r=this.weakmap,e[t]=function(){var s,o,u,a,l,d,b,c,g,v;a=n.apply(e,arguments),b=i.pointers;for(u in b)for(o=b[u],v=(c=(g=r[u])!=null?g.callbacks[o]:void 0)!=null?c:[],l=0,d=v.length;l<d;l++)s=v[l],s();return a}},observeMutations:function(e,t,i){var n,r,s,o,u,a;if(Array.isArray(e)){if(s=this.weakReference(e),s.pointers==null)for(s.pointers={},r=["push","pop","shift","unshift","sort","reverse","splice"],u=0,a=r.length;u<a;u++)n=r[u],this.stubFunction(e,n);if((o=s.pointers)[t]==null&&(o[t]=[]),T.call(s.pointers[t],i)<0)return s.pointers[t].push(i)}},unobserveMutations:function(e,t,i){var n,r,s;if(Array.isArray(e)&&e[this.id]!=null&&(r=this.weakmap[e[this.id]])&&(s=r.pointers[t]))return(n=s.indexOf(i))>=0&&s.splice(n,1),s.length||delete r.pointers[t],this.cleanupWeakReference(r,e[this.id])},observe:function(e,t,i){var n,r,s;return n=this.weakReference(e).callbacks,n[t]==null&&(n[t]=[],r=Object.getOwnPropertyDescriptor(e,t),r!=null&&r.get||r!=null&&r.set||(s=e[t],Object.defineProperty(e,t,{enumerable:!0,get:function(){return s},set:function(o){return function(u){var a,l,d,b,c;if(u!==s&&(o.unobserveMutations(s,e[o.id],t),s=u,l=o.weakmap[e[o.id]])){if(n=l.callbacks,n[t])for(c=n[t].slice(),d=0,b=c.length;d<b;d++)a=c[d],T.call(n[t],a)>=0&&a();return o.observeMutations(u,e[o.id],t)}}}(this)}))),T.call(n[t],i)<0&&n[t].push(i),this.observeMutations(e[t],e[this.id],t)},unobserve:function(e,t,i){var n,r,s;if((s=this.weakmap[e[this.id]])&&(n=s.callbacks[t]))return(r=n.indexOf(i))>=0&&(n.splice(r,1),n.length||(delete s.callbacks[t],this.unobserveMutations(e[t],e[this.id],t))),this.cleanupWeakReference(s,e[this.id])},get:function(e,t){return e[t]},set:function(e,t,i){return e[t]=i}},h.factory=function(e){return h.sightglass=e,h.public._=h,h.public},typeof(R!==null?R.exports:void 0)=="object"?R.exports=h.factory(I()):this.rivets=h.factory(sightglass)}).call(L)})(j);var D=j.exports;const H=$(D);export{H as r};
