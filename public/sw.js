if(!self.define){let e,s={};const n=(n,t)=>(n=new URL(n+".js",t).href,s[n]||new Promise((s=>{if("document"in self){const e=document.createElement("script");e.src=n,e.onload=s,document.head.appendChild(e)}else e=n,importScripts(n),s()})).then((()=>{let e=s[n];if(!e)throw new Error(`Module ${n} didn’t register its module`);return e})));self.define=(t,c)=>{const o=e||("document"in self?document.currentScript.src:"")||location.href;if(s[o])return;let i={};const l=e=>n(e,o),r={module:{uri:o},exports:i,require:l};s[o]=Promise.all(t.map((e=>r[e]||l(e)))).then((e=>(c(...e),i)))}}define(["./workbox-569eb35c"],(function(e){"use strict";self.skipWaiting(),e.clientsClaim(),e.registerRoute(/http:\/\/localhost/,new e.NetworkFirst({cacheName:"Laravel-local",plugins:[]}),"GET"),e.registerRoute(/\.(?:png|jpg|jpeg|svg|webp)$/,new e.CacheFirst({cacheName:"images",plugins:[]}),"GET"),e.registerRoute(/\.(?:js)$/,new e.CacheFirst({cacheName:"js",plugins:[]}),"GET"),e.registerRoute(/\.(?:css)$/,new e.CacheFirst({cacheName:"css",plugins:[]}),"GET")}));
