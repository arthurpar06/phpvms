import{r as o}from"./rivets-ZtsXhcuL.js";import"./_commonjsHelpers-4gQjN7DL.js";o.formatters.prepend=function(t,r){return r+t};o.formatters.time_hm=function(t){const r=Math.floor(t/60),e=t%60;return`${r}h ${e}m`};o.formatters.gt=(t,r)=>t.length>r;o.formatters.lt=(t,r)=>t.length<r;o.formatters.eq=(t,r)=>t.length>r;o.formatters.fallback=(t,r)=>t||r;