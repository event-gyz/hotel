!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports):"function"==typeof define&&define.amd?define(["exports"],t):t(e.reduxLogger=e.reduxLogger||{})}(this,function(e){"use strict";function t(e,t){e.super_=t,e.prototype=Object.create(t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}})}function n(e,t){Object.defineProperty(this,"kind",{value:e,enumerable:!0}),t&&t.length&&Object.defineProperty(this,"path",{value:t,enumerable:!0})}function r(e,t,n){r.super_.call(this,"E",e),Object.defineProperty(this,"lhs",{value:t,enumerable:!0}),Object.defineProperty(this,"rhs",{value:n,enumerable:!0})}function o(e,t){o.super_.call(this,"N",e),Object.defineProperty(this,"rhs",{value:t,enumerable:!0})}function i(e,t){i.super_.call(this,"D",e),Object.defineProperty(this,"lhs",{value:t,enumerable:!0})}function a(e,t,n){a.super_.call(this,"A",e),Object.defineProperty(this,"index",{value:t,enumerable:!0}),Object.defineProperty(this,"item",{value:n,enumerable:!0})}function f(e,t,n){var r=e.slice((n||t)+1||e.length);return e.length=0>t?e.length+t:t,e.push.apply(e,r),e}function u(e){var t="undefined"==typeof e?"undefined":N(e);return"object"!==t?t:e===Math?"math":null===e?"null":Array.isArray(e)?"array":"[object Date]"===Object.prototype.toString.call(e)?"date":"function"==typeof e.toString&&/^\/.*\//.test(e.toString())?"regexp":"object"}function c(e,t,n,l,s,p,d){s=s||[],d=d||[];var h=s.slice(0);if("undefined"!=typeof p){if(l){if("function"==typeof l&&l(h,p))return;if("object"===("undefined"==typeof l?"undefined":N(l))){if(l.prefilter&&l.prefilter(h,p))return;if(l.normalize){var g=l.normalize(h,p,e,t);g&&(e=g[0],t=g[1])}}}h.push(p)}"regexp"===u(e)&&"regexp"===u(t)&&(e=e.toString(),t=t.toString());var y="undefined"==typeof e?"undefined":N(e),v="undefined"==typeof t?"undefined":N(t),b="undefined"!==y||d&&d[d.length-1].lhs&&d[d.length-1].lhs.hasOwnProperty(p),m="undefined"!==v||d&&d[d.length-1].rhs&&d[d.length-1].rhs.hasOwnProperty(p);if(!b&&m)n(new o(h,t));else if(!m&&b)n(new i(h,e));else if(u(e)!==u(t))n(new r(h,e,t));else if("date"===u(e)&&e-t!==0)n(new r(h,e,t));else if("object"===y&&null!==e&&null!==t)if(d.filter(function(t){return t.lhs===e}).length)e!==t&&n(new r(h,e,t));else{if(d.push({lhs:e,rhs:t}),Array.isArray(e)){var w;e.length;for(w=0;w<e.length;w++)w>=t.length?n(new a(h,w,new i(void 0,e[w]))):c(e[w],t[w],n,l,h,w,d);for(;w<t.length;)n(new a(h,w,new o(void 0,t[w++])))}else{var x=Object.keys(e),j=Object.keys(t);x.forEach(function(r,o){var i=j.indexOf(r);i>=0?(c(e[r],t[r],n,l,h,r,d),j=f(j,i)):c(e[r],void 0,n,l,h,r,d)}),j.forEach(function(e){c(void 0,t[e],n,l,h,e,d)})}d.length=d.length-1}else e!==t&&("number"===y&&isNaN(e)&&isNaN(t)||n(new r(h,e,t)))}function l(e,t,n,r){return r=r||[],c(e,t,function(e){e&&r.push(e)},n),r.length?r:void 0}function s(e,t,n){if(n.path&&n.path.length){var r,o=e[t],i=n.path.length-1;for(r=0;i>r;r++)o=o[n.path[r]];switch(n.kind){case"A":s(o[n.path[r]],n.index,n.item);break;case"D":delete o[n.path[r]];break;case"E":case"N":o[n.path[r]]=n.rhs}}else switch(n.kind){case"A":s(e[t],n.index,n.item);break;case"D":e=f(e,t);break;case"E":case"N":e[t]=n.rhs}return e}function p(e,t,n){if(e&&t&&n&&n.kind){for(var r=e,o=-1,i=n.path?n.path.length-1:0;++o<i;)"undefined"==typeof r[n.path[o]]&&(r[n.path[o]]="number"==typeof n.path[o]?[]:{}),r=r[n.path[o]];switch(n.kind){case"A":s(n.path?r[n.path[o]]:r,n.index,n.item);break;case"D":delete r[n.path[o]];break;case"E":case"N":r[n.path[o]]=n.rhs}}}function d(e,t,n){if(n.path&&n.path.length){var r,o=e[t],i=n.path.length-1;for(r=0;i>r;r++)o=o[n.path[r]];switch(n.kind){case"A":d(o[n.path[r]],n.index,n.item);break;case"D":o[n.path[r]]=n.lhs;break;case"E":o[n.path[r]]=n.lhs;break;case"N":delete o[n.path[r]]}}else switch(n.kind){case"A":d(e[t],n.index,n.item);break;case"D":e[t]=n.lhs;break;case"E":e[t]=n.lhs;break;case"N":e=f(e,t)}return e}function h(e,t,n){if(e&&t&&n&&n.kind){var r,o,i=e;for(o=n.path.length-1,r=0;o>r;r++)"undefined"==typeof i[n.path[r]]&&(i[n.path[r]]={}),i=i[n.path[r]];switch(n.kind){case"A":d(i[n.path[r]],n.index,n.item);break;case"D":i[n.path[r]]=n.lhs;break;case"E":i[n.path[r]]=n.lhs;break;case"N":delete i[n.path[r]]}}}function g(e,t,n){if(e&&t){var r=function(r){(!n||n(e,t,r))&&p(e,t,r)};c(e,t,r)}}function y(e){return"color: "+T[e].color+"; font-weight: bold"}function v(e){var t=e.kind,n=e.path,r=e.lhs,o=e.rhs,i=e.index,a=e.item;switch(t){case"E":return[n.join("."),r,"→",o];case"N":return[n.join("."),o];case"D":return[n.join(".")];case"A":return[n.join(".")+"["+i+"]",a];default:return[]}}function b(e,t,n,r){var o=l(e,t);try{r?n.groupCollapsed("diff"):n.group("diff")}catch(i){n.log("diff")}o?o.forEach(function(e){var t=e.kind,r=v(e);n.log.apply(n,["%c "+T[t].text,y(t)].concat(P(r)))}):n.log("—— no diff ——");try{n.groupEnd()}catch(i){n.log("—— diff end —— ")}}function m(e,t,n,r){switch("undefined"==typeof e?"undefined":N(e)){case"object":return"function"==typeof e[r]?e[r].apply(e,P(n)):e[r];case"function":return e(t);default:return e}}function w(e){var t=e.timestamp,n=e.duration;return function(e,r,o){var i=["action"];return i.push("%c"+String(e.type)),t&&i.push("%c@ "+r),n&&i.push("%c(in "+o.toFixed(2)+" ms)"),i.join(" ")}}function x(e,t){var n=t.logger,r=t.actionTransformer,o=t.titleFormatter,i=void 0===o?w(t):o,a=t.collapsed,f=t.colors,u=t.level,c=t.diff,l="undefined"==typeof t.titleFormatter;e.forEach(function(o,s){var p=o.started,d=o.startedTime,h=o.action,g=o.prevState,y=o.error,v=o.took,w=o.nextState,x=e[s+1];x&&(w=x.prevState,v=x.started-p);var j=r(h),k="function"==typeof a?a(function(){return w},h,o):a,S=D(d),E=f.title?"color: "+f.title(j)+";":"",A=["color: gray; font-weight: lighter;"];A.push(E),t.timestamp&&A.push("color: gray; font-weight: lighter;"),t.duration&&A.push("color: gray; font-weight: lighter;");var O=i(j,S,v);try{k?f.title&&l?n.groupCollapsed.apply(n,["%c "+O].concat(A)):n.groupCollapsed(O):f.title&&l?n.group.apply(n,["%c "+O].concat(A)):n.group(O)}catch(N){n.log(O)}var P=m(u,j,[g],"prevState"),C=m(u,j,[j],"action"),T=m(u,j,[y,g],"error"),F=m(u,j,[w],"nextState");if(P)if(f.prevState){var _="color: "+f.prevState(g)+"; font-weight: bold";n[P]("%c prev state",_,g)}else n[P]("prev state",g);if(C)if(f.action){var L="color: "+f.action(j)+"; font-weight: bold";n[C]("%c action    ",L,j)}else n[C]("action    ",j);if(y&&T)if(f.error){var M="color: "+f.error(y,g)+"; font-weight: bold;";n[T]("%c error     ",M,y)}else n[T]("error     ",y);if(F)if(f.nextState){var R="color: "+f.nextState(w)+"; font-weight: bold";n[F]("%c next state",R,w)}else n[F]("next state",w);n.withTrace&&(n.groupCollapsed("TRACE"),n.trace(),n.groupEnd()),c&&b(g,w,n,k);try{n.groupEnd()}catch(N){n.log("—— log end ——")}})}function j(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=Object.assign({},F,e),n=t.logger,r=t.stateTransformer,o=t.errorTransformer,i=t.predicate,a=t.logErrors,f=t.diffPredicate;if("undefined"==typeof n)return function(){return function(e){return function(t){return e(t)}}};if(e.getState&&e.dispatch)return function(){return function(e){return function(t){return e(t)}}};var u=[];return function(e){var n=e.getState;return function(e){return function(c){if("function"==typeof i&&!i(n,c))return e(c);var l={};u.push(l),l.started=O.now(),l.startedTime=new Date,l.prevState=r(n()),l.action=c;var s=void 0;if(a)try{s=e(c)}catch(p){l.error=o(p)}else s=e(c);l.took=O.now()-l.started,l.nextState=r(n());var d=t.diff&&"function"==typeof f?f(n,c):t.diff;if(x(u,Object.assign({},t,{diff:d})),u.length=0,l.error)throw l.error;return s}}}}var k,S,E=function(e,t){return new Array(t+1).join(e)},A=function(e,t){return E("0",t-e.toString().length)+e},D=function(e){return A(e.getHours(),2)+":"+A(e.getMinutes(),2)+":"+A(e.getSeconds(),2)+"."+A(e.getMilliseconds(),3)},O="undefined"!=typeof performance&&null!==performance&&"function"==typeof performance.now?performance:Date,N="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},P=function(e){if(Array.isArray(e)){for(var t=0,n=Array(e.length);t<e.length;t++)n[t]=e[t];return n}return Array.from(e)},C=[];k="object"===("undefined"==typeof global?"undefined":N(global))&&global?global:"undefined"!=typeof window?window:{},S=k.DeepDiff,S&&C.push(function(){"undefined"!=typeof S&&k.DeepDiff===l&&(k.DeepDiff=S,S=void 0)}),t(r,n),t(o,n),t(i,n),t(a,n),Object.defineProperties(l,{diff:{value:l,enumerable:!0},observableDiff:{value:c,enumerable:!0},applyDiff:{value:g,enumerable:!0},applyChange:{value:p,enumerable:!0},revertChange:{value:h,enumerable:!0},isConflict:{value:function(){return"undefined"!=typeof S},enumerable:!0},noConflict:{value:function(){return C&&(C.forEach(function(e){e()}),C=null),l},enumerable:!0}});var T={E:{color:"#2196F3",text:"CHANGED:"},N:{color:"#4CAF50",text:"ADDED:"},D:{color:"#F44336",text:"DELETED:"},A:{color:"#2196F3",text:"ARRAY:"}},F={level:"log",logger:console,logErrors:!0,collapsed:void 0,predicate:void 0,duration:!1,timestamp:!0,stateTransformer:function(e){return e},actionTransformer:function(e){return e},errorTransformer:function(e){return e},colors:{title:function(){return"inherit"},prevState:function(){return"#9E9E9E"},action:function(){return"#03A9F4"},nextState:function(){return"#4CAF50"},error:function(){return"#F20404"}},diff:!1,diffPredicate:void 0,transformer:void 0},_=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=e.dispatch,n=e.getState;return"function"==typeof t||"function"==typeof n?j()({dispatch:t,getState:n}):void 0};e.defaults=F,e.createLogger=j,e.logger=_,e["default"]=_,Object.defineProperty(e,"__esModule",{value:!0})});