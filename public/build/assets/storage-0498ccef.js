class n{constructor(t,a){this.name=t;const i=window.localStorage.getItem(this.name);i?(console.log("Found in storage: ",i),this.data=JSON.parse(i)):(console.log("Nothing found in storage, starting from default"),this.data=a)}save(){window.localStorage.setItem(this.name,JSON.stringify(this.data))}getList(t){return t in this.data?this.data[t]:[]}addToList(t,a){t in this.data||(this.data[t]=[]),this.data[t].indexOf(a)===-1&&this.data[t].push(a)}removeFromList(t,a){if(!(t in this.data))return;const i=this.data[t].indexOf(a);i!==-1&&this.data[t].splice(i,1)}}export{n as S};
