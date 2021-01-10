/*! jQuery v2.0.0 | (c) 2005, 2013 jQuery Foundation, Inc. | jquery.org/license
//@ sourceMappingURL=jquery.min.map
*/
! function (a, b) {
   "object" == typeof module && "object" == typeof module.exports ? module.exports = a.document ? b(a, !0) : function (a) {
      if (!a.document) throw new Error("jQuery requires a window with a document");
      return b(a)
   } : b(a)
}("undefined" != typeof window ? window : this, function (a, b) {
   var c = [],
      d = a.document,
      e = c.slice,
      f = c.concat,
      g = c.push,
      h = c.indexOf,
      i = {},
      j = i.toString,
      k = i.hasOwnProperty,
      l = {},
      m = "1.12.4",
      n = function (a, b) {
         return new n.fn.init(a, b)
      },
      o = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
      p = /^-ms-/,
      q = /-([\da-z])/gi,
      r = function (a, b) {
         return b.toUpperCase()
      };
   n.fn = n.prototype = {
      jquery: m,
      constructor: n,
      selector: "",
      length: 0,
      toArray: function () {
         return e.call(this)
      },
      get: function (a) {
         return null != a ? 0 > a ? this[a + this.length] : this[a] : e.call(this)
      },
      pushStack: function (a) {
         var b = n.merge(this.constructor(), a);
         return b.prevObject = this, b.context = this.context, b
      },
      each: function (a) {
         return n.each(this, a)
      },
      map: function (a) {
         return this.pushStack(n.map(this, function (b, c) {
            return a.call(b, c, b)
         }))
      },
      slice: function () {
         return this.pushStack(e.apply(this, arguments))
      },
      first: function () {
         return this.eq(0)
      },
      last: function () {
         return this.eq(-1)
      },
      eq: function (a) {
         var b = this.length,
            c = +a + (0 > a ? b : 0);
         return this.pushStack(c >= 0 && b > c ? [this[c]] : [])
      },
      end: function () {
         return this.prevObject || this.constructor()
      },
      push: g,
      sort: c.sort,
      splice: c.splice
   }, n.extend = n.fn.extend = function () {
      var a, b, c, d, e, f, g = arguments[0] || {},
         h = 1,
         i = arguments.length,
         j = !1;
      for ("boolean" == typeof g && (j = g, g = arguments[h] || {}, h++), "object" == typeof g || n.isFunction(g) || (g = {}), h === i && (g = this, h--); i > h; h++)
         if (null != (e = arguments[h]))
            for (d in e) a = g[d], c = e[d], g !== c && (j && c && (n.isPlainObject(c) || (b = n.isArray(c))) ? (b ? (b = !1, f = a && n.isArray(a) ? a : []) : f = a && n.isPlainObject(a) ? a : {}, g[d] = n.extend(j, f, c)) : void 0 !== c && (g[d] = c));
      return g
   }, n.extend({
      expando: "jQuery" + (m + Math.random()).replace(/\D/g, ""),
      isReady: !0,
      error: function (a) {
         throw new Error(a)
      },
      noop: function () {},
      isFunction: function (a) {
         return "function" === n.type(a)
      },
      isArray: Array.isArray || function (a) {
         return "array" === n.type(a)
      },
      isWindow: function (a) {
         return null != a && a == a.window
      },
      isNumeric: function (a) {
         var b = a && a.toString();
         return !n.isArray(a) && b - parseFloat(b) + 1 >= 0
      },
      isEmptyObject: function (a) {
         var b;
         for (b in a) return !1;
         return !0
      },
      isPlainObject: function (a) {
         var b;
         if (!a || "object" !== n.type(a) || a.nodeType || n.isWindow(a)) return !1;
         try {
            if (a.constructor && !k.call(a, "constructor") && !k.call(a.constructor.prototype, "isPrototypeOf")) return !1
         } catch (c) {
            return !1
         }
         if (!l.ownFirst)
            for (b in a) return k.call(a, b);
         for (b in a);
         return void 0 === b || k.call(a, b)
      },
      type: function (a) {
         return null == a ? a + "" : "object" == typeof a || "function" == typeof a ? i[j.call(a)] || "object" : typeof a
      },
      globalEval: function (b) {
         b && n.trim(b) && (a.execScript || function (b) {
            a.eval.call(a, b)
         })(b)
      },
      camelCase: function (a) {
         return a.replace(p, "ms-").replace(q, r)
      },
      nodeName: function (a, b) {
         return a.nodeName && a.nodeName.toLowerCase() === b.toLowerCase()
      },
      each: function (a, b) {
         var c, d = 0;
         if (s(a)) {
            for (c = a.length; c > d; d++)
               if (b.call(a[d], d, a[d]) === !1) break
         } else
            for (d in a)
               if (b.call(a[d], d, a[d]) === !1) break;
         return a
      },
      trim: function (a) {
         return null == a ? "" : (a + "").replace(o, "")
      },
      makeArray: function (a, b) {
         var c = b || [];
         return null != a && (s(Object(a)) ? n.merge(c, "string" == typeof a ? [a] : a) : g.call(c, a)), c
      },
      inArray: function (a, b, c) {
         var d;
         if (b) {
            if (h) return h.call(b, a, c);
            for (d = b.length, c = c ? 0 > c ? Math.max(0, d + c) : c : 0; d > c; c++)
               if (c in b && b[c] === a) return c
         }
         return -1
      },
      merge: function (a, b) {
         var c = +b.length,
            d = 0,
            e = a.length;
         while (c > d) a[e++] = b[d++];
         if (c !== c)
            while (void 0 !== b[d]) a[e++] = b[d++];
         return a.length = e, a
      },
      grep: function (a, b, c) {
         for (var d, e = [], f = 0, g = a.length, h = !c; g > f; f++) d = !b(a[f], f), d !== h && e.push(a[f]);
         return e
      },
      map: function (a, b, c) {
         var d, e, g = 0,
            h = [];
         if (s(a))
            for (d = a.length; d > g; g++) e = b(a[g], g, c), null != e && h.push(e);
         else
            for (g in a) e = b(a[g], g, c), null != e && h.push(e);
         return f.apply([], h)
      },
      guid: 1,
      proxy: function (a, b) {
         var c, d, f;
         return "string" == typeof b && (f = a[b], b = a, a = f), n.isFunction(a) ? (c = e.call(arguments, 2), d = function () {
            return a.apply(b || this, c.concat(e.call(arguments)))
         }, d.guid = a.guid = a.guid || n.guid++, d) : void 0
      },
      now: function () {
         return +new Date
      },
      support: l
   }), "function" == typeof Symbol && (n.fn[Symbol.iterator] = c[Symbol.iterator]), n.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (a, b) {
      i["[object " + b + "]"] = b.toLowerCase()
   });

   function s(a) {
      var b = !!a && "length" in a && a.length,
         c = n.type(a);
      return "function" === c || n.isWindow(a) ? !1 : "array" === c || 0 === b || "number" == typeof b && b > 0 && b - 1 in a
   }
   var t = function (a) {
      var b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u = "sizzle" + 1 * new Date,
         v = a.document,
         w = 0,
         x = 0,
         y = ga(),
         z = ga(),
         A = ga(),
         B = function (a, b) {
            return a === b && (l = !0), 0
         },
         C = 1 << 31,
         D = {}.hasOwnProperty,
         E = [],
         F = E.pop,
         G = E.push,
         H = E.push,
         I = E.slice,
         J = function (a, b) {
            for (var c = 0, d = a.length; d > c; c++)
               if (a[c] === b) return c;
            return -1
         },
         K = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
         L = "[\\x20\\t\\r\\n\\f]",
         M = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
         N = "\\[" + L + "*(" + M + ")(?:" + L + "*([*^$|!~]?=)" + L + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + M + "))|)" + L + "*\\]",
         O = ":(" + M + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + N + ")*)|.*)\\)|)",
         P = new RegExp(L + "+", "g"),
         Q = new RegExp("^" + L + "+|((?:^|[^\\\\])(?:\\\\.)*)" + L + "+$", "g"),
         R = new RegExp("^" + L + "*," + L + "*"),
         S = new RegExp("^" + L + "*([>+~]|" + L + ")" + L + "*"),
         T = new RegExp("=" + L + "*([^\\]'\"]*?)" + L + "*\\]", "g"),
         U = new RegExp(O),
         V = new RegExp("^" + M + "$"),
         W = {
            ID: new RegExp("^#(" + M + ")"),
            CLASS: new RegExp("^\\.(" + M + ")"),
            TAG: new RegExp("^(" + M + "|[*])"),
            ATTR: new RegExp("^" + N),
            PSEUDO: new RegExp("^" + O),
            CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + L + "*(even|odd|(([+-]|)(\\d*)n|)" + L + "*(?:([+-]|)" + L + "*(\\d+)|))" + L + "*\\)|)", "i"),
            bool: new RegExp("^(?:" + K + ")$", "i"),
            needsContext: new RegExp("^" + L + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + L + "*((?:-\\d)?\\d*)" + L + "*\\)|)(?=[^-]|$)", "i")
         },
         X = /^(?:input|select|textarea|button)$/i,
         Y = /^h\d$/i,
         Z = /^[^{]+\{\s*\[native \w/,
         $ = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
         _ = /[+~]/,
         aa = /'|\\/g,
         ba = new RegExp("\\\\([\\da-f]{1,6}" + L + "?|(" + L + ")|.)", "ig"),
         ca = function (a, b, c) {
            var d = "0x" + b - 65536;
            return d !== d || c ? b : 0 > d ? String.fromCharCode(d + 65536) : String.fromCharCode(d >> 10 | 55296, 1023 & d | 56320)
         },
         da = function () {
            m()
         };
      try {
         H.apply(E = I.call(v.childNodes), v.childNodes), E[v.childNodes.length].nodeType
      } catch (ea) {
         H = {
            apply: E.length ? function (a, b) {
               G.apply(a, I.call(b))
            } : function (a, b) {
               var c = a.length,
                  d = 0;
               while (a[c++] = b[d++]);
               a.length = c - 1
            }
         }
      }

      function fa(a, b, d, e) {
         var f, h, j, k, l, o, r, s, w = b && b.ownerDocument,
            x = b ? b.nodeType : 9;
         if (d = d || [], "string" != typeof a || !a || 1 !== x && 9 !== x && 11 !== x) return d;
         if (!e && ((b ? b.ownerDocument || b : v) !== n && m(b), b = b || n, p)) {
            if (11 !== x && (o = $.exec(a)))
               if (f = o[1]) {
                  if (9 === x) {
                     if (!(j = b.getElementById(f))) return d;
                     if (j.id === f) return d.push(j), d
                  } else if (w && (j = w.getElementById(f)) && t(b, j) && j.id === f) return d.push(j), d
               } else {
                  if (o[2]) return H.apply(d, b.getElementsByTagName(a)), d;
                  if ((f = o[3]) && c.getElementsByClassName && b.getElementsByClassName) return H.apply(d, b.getElementsByClassName(f)), d
               }
            if (c.qsa && !A[a + " "] && (!q || !q.test(a))) {
               if (1 !== x) w = b, s = a;
               else if ("object" !== b.nodeName.toLowerCase()) {
                  (k = b.getAttribute("id")) ? k = k.replace(aa, "\\$&"): b.setAttribute("id", k = u), r = g(a), h = r.length, l = V.test(k) ? "#" + k : "[id='" + k + "']";
                  while (h--) r[h] = l + " " + qa(r[h]);
                  s = r.join(","), w = _.test(a) && oa(b.parentNode) || b
               }
               if (s) try {
                  return H.apply(d, w.querySelectorAll(s)), d
               } catch (y) {} finally {
                  k === u && b.removeAttribute("id")
               }
            }
         }
         return i(a.replace(Q, "$1"), b, d, e)
      }

      function ga() {
         var a = [];

         function b(c, e) {
            return a.push(c + " ") > d.cacheLength && delete b[a.shift()], b[c + " "] = e
         }
         return b
      }

      function ha(a) {
         return a[u] = !0, a
      }

      function ia(a) {
         var b = n.createElement("div");
         try {
            return !!a(b)
         } catch (c) {
            return !1
         } finally {
            b.parentNode && b.parentNode.removeChild(b), b = null
         }
      }

      function ja(a, b) {
         var c = a.split("|"),
            e = c.length;
         while (e--) d.attrHandle[c[e]] = b
      }

      function ka(a, b) {
         var c = b && a,
            d = c && 1 === a.nodeType && 1 === b.nodeType && (~b.sourceIndex || C) - (~a.sourceIndex || C);
         if (d) return d;
         if (c)
            while (c = c.nextSibling)
               if (c === b) return -1;
         return a ? 1 : -1
      }

      function la(a) {
         return function (b) {
            var c = b.nodeName.toLowerCase();
            return "input" === c && b.type === a
         }
      }

      function ma(a) {
         return function (b) {
            var c = b.nodeName.toLowerCase();
            return ("input" === c || "button" === c) && b.type === a
         }
      }

      function na(a) {
         return ha(function (b) {
            return b = +b, ha(function (c, d) {
               var e, f = a([], c.length, b),
                  g = f.length;
               while (g--) c[e = f[g]] && (c[e] = !(d[e] = c[e]))
            })
         })
      }

      function oa(a) {
         return a && "undefined" != typeof a.getElementsByTagName && a
      }
      c = fa.support = {}, f = fa.isXML = function (a) {
         var b = a && (a.ownerDocument || a).documentElement;
         return b ? "HTML" !== b.nodeName : !1
      }, m = fa.setDocument = function (a) {
         var b, e, g = a ? a.ownerDocument || a : v;
         return g !== n && 9 === g.nodeType && g.documentElement ? (n = g, o = n.documentElement, p = !f(n), (e = n.defaultView) && e.top !== e && (e.addEventListener ? e.addEventListener("unload", da, !1) : e.attachEvent && e.attachEvent("onunload", da)), c.attributes = ia(function (a) {
            return a.className = "i", !a.getAttribute("className")
         }), c.getElementsByTagName = ia(function (a) {
            return a.appendChild(n.createComment("")), !a.getElementsByTagName("*").length
         }), c.getElementsByClassName = Z.test(n.getElementsByClassName), c.getById = ia(function (a) {
            return o.appendChild(a).id = u, !n.getElementsByName || !n.getElementsByName(u).length
         }), c.getById ? (d.find.ID = function (a, b) {
            if ("undefined" != typeof b.getElementById && p) {
               var c = b.getElementById(a);
               return c ? [c] : []
            }
         }, d.filter.ID = function (a) {
            var b = a.replace(ba, ca);
            return function (a) {
               return a.getAttribute("id") === b
            }
         }) : (delete d.find.ID, d.filter.ID = function (a) {
            var b = a.replace(ba, ca);
            return function (a) {
               var c = "undefined" != typeof a.getAttributeNode && a.getAttributeNode("id");
               return c && c.value === b
            }
         }), d.find.TAG = c.getElementsByTagName ? function (a, b) {
            return "undefined" != typeof b.getElementsByTagName ? b.getElementsByTagName(a) : c.qsa ? b.querySelectorAll(a) : void 0
         } : function (a, b) {
            var c, d = [],
               e = 0,
               f = b.getElementsByTagName(a);
            if ("*" === a) {
               while (c = f[e++]) 1 === c.nodeType && d.push(c);
               return d
            }
            return f
         }, d.find.CLASS = c.getElementsByClassName && function (a, b) {
            return "undefined" != typeof b.getElementsByClassName && p ? b.getElementsByClassName(a) : void 0
         }, r = [], q = [], (c.qsa = Z.test(n.querySelectorAll)) && (ia(function (a) {
            o.appendChild(a).innerHTML = "<a id='" + u + "'></a><select id='" + u + "-\r\\' msallowcapture=''><option selected=''></option></select>", a.querySelectorAll("[msallowcapture^='']").length && q.push("[*^$]=" + L + "*(?:''|\"\")"), a.querySelectorAll("[selected]").length || q.push("\\[" + L + "*(?:value|" + K + ")"), a.querySelectorAll("[id~=" + u + "-]").length || q.push("~="), a.querySelectorAll(":checked").length || q.push(":checked"), a.querySelectorAll("a#" + u + "+*").length || q.push(".#.+[+~]")
         }), ia(function (a) {
            var b = n.createElement("input");
            b.setAttribute("type", "hidden"), a.appendChild(b).setAttribute("name", "D"), a.querySelectorAll("[name=d]").length && q.push("name" + L + "*[*^$|!~]?="), a.querySelectorAll(":enabled").length || q.push(":enabled", ":disabled"), a.querySelectorAll("*,:x"), q.push(",.*:")
         })), (c.matchesSelector = Z.test(s = o.matches || o.webkitMatchesSelector || o.mozMatchesSelector || o.oMatchesSelector || o.msMatchesSelector)) && ia(function (a) {
            c.disconnectedMatch = s.call(a, "div"), s.call(a, "[s!='']:x"), r.push("!=", O)
         }), q = q.length && new RegExp(q.join("|")), r = r.length && new RegExp(r.join("|")), b = Z.test(o.compareDocumentPosition), t = b || Z.test(o.contains) ? function (a, b) {
            var c = 9 === a.nodeType ? a.documentElement : a,
               d = b && b.parentNode;
            return a === d || !(!d || 1 !== d.nodeType || !(c.contains ? c.contains(d) : a.compareDocumentPosition && 16 & a.compareDocumentPosition(d)))
         } : function (a, b) {
            if (b)
               while (b = b.parentNode)
                  if (b === a) return !0;
            return !1
         }, B = b ? function (a, b) {
            if (a === b) return l = !0, 0;
            var d = !a.compareDocumentPosition - !b.compareDocumentPosition;
            return d ? d : (d = (a.ownerDocument || a) === (b.ownerDocument || b) ? a.compareDocumentPosition(b) : 1, 1 & d || !c.sortDetached && b.compareDocumentPosition(a) === d ? a === n || a.ownerDocument === v && t(v, a) ? -1 : b === n || b.ownerDocument === v && t(v, b) ? 1 : k ? J(k, a) - J(k, b) : 0 : 4 & d ? -1 : 1)
         } : function (a, b) {
            if (a === b) return l = !0, 0;
            var c, d = 0,
               e = a.parentNode,
               f = b.parentNode,
               g = [a],
               h = [b];
            if (!e || !f) return a === n ? -1 : b === n ? 1 : e ? -1 : f ? 1 : k ? J(k, a) - J(k, b) : 0;
            if (e === f) return ka(a, b);
            c = a;
            while (c = c.parentNode) g.unshift(c);
            c = b;
            while (c = c.parentNode) h.unshift(c);
            while (g[d] === h[d]) d++;
            return d ? ka(g[d], h[d]) : g[d] === v ? -1 : h[d] === v ? 1 : 0
         }, n) : n
      }, fa.matches = function (a, b) {
         return fa(a, null, null, b)
      }, fa.matchesSelector = function (a, b) {
         if ((a.ownerDocument || a) !== n && m(a), b = b.replace(T, "='$1']"), c.matchesSelector && p && !A[b + " "] && (!r || !r.test(b)) && (!q || !q.test(b))) try {
            var d = s.call(a, b);
            if (d || c.disconnectedMatch || a.document && 11 !== a.document.nodeType) return d
         } catch (e) {}
         return fa(b, n, null, [a]).length > 0
      }, fa.contains = function (a, b) {
         return (a.ownerDocument || a) !== n && m(a), t(a, b)
      }, fa.attr = function (a, b) {
         (a.ownerDocument || a) !== n && m(a);
         var e = d.attrHandle[b.toLowerCase()],
            f = e && D.call(d.attrHandle, b.toLowerCase()) ? e(a, b, !p) : void 0;
         return void 0 !== f ? f : c.attributes || !p ? a.getAttribute(b) : (f = a.getAttributeNode(b)) && f.specified ? f.value : null
      }, fa.error = function (a) {
         throw new Error("Syntax error, unrecognized expression: " + a)
      }, fa.uniqueSort = function (a) {
         var b, d = [],
            e = 0,
            f = 0;
         if (l = !c.detectDuplicates, k = !c.sortStable && a.slice(0), a.sort(B), l) {
            while (b = a[f++]) b === a[f] && (e = d.push(f));
            while (e--) a.splice(d[e], 1)
         }
         return k = null, a
      }, e = fa.getText = function (a) {
         var b, c = "",
            d = 0,
            f = a.nodeType;
         if (f) {
            if (1 === f || 9 === f || 11 === f) {
               if ("string" == typeof a.textContent) return a.textContent;
               for (a = a.firstChild; a; a = a.nextSibling) c += e(a)
            } else if (3 === f || 4 === f) return a.nodeValue
         } else
            while (b = a[d++]) c += e(b);
         return c
      }, d = fa.selectors = {
         cacheLength: 50,
         createPseudo: ha,
         match: W,
         attrHandle: {},
         find: {},
         relative: {
            ">": {
               dir: "parentNode",
               first: !0
            },
            " ": {
               dir: "parentNode"
            },
            "+": {
               dir: "previousSibling",
               first: !0
            },
            "~": {
               dir: "previousSibling"
            }
         },
         preFilter: {
            ATTR: function (a) {
               return a[1] = a[1].replace(ba, ca), a[3] = (a[3] || a[4] || a[5] || "").replace(ba, ca), "~=" === a[2] && (a[3] = " " + a[3] + " "), a.slice(0, 4)
            },
            CHILD: function (a) {
               return a[1] = a[1].toLowerCase(), "nth" === a[1].slice(0, 3) ? (a[3] || fa.error(a[0]), a[4] = +(a[4] ? a[5] + (a[6] || 1) : 2 * ("even" === a[3] || "odd" === a[3])), a[5] = +(a[7] + a[8] || "odd" === a[3])) : a[3] && fa.error(a[0]), a
            },
            PSEUDO: function (a) {
               var b, c = !a[6] && a[2];
               return W.CHILD.test(a[0]) ? null : (a[3] ? a[2] = a[4] || a[5] || "" : c && U.test(c) && (b = g(c, !0)) && (b = c.indexOf(")", c.length - b) - c.length) && (a[0] = a[0].slice(0, b), a[2] = c.slice(0, b)), a.slice(0, 3))
            }
         },
         filter: {
            TAG: function (a) {
               var b = a.replace(ba, ca).toLowerCase();
               return "*" === a ? function () {
                  return !0
               } : function (a) {
                  return a.nodeName && a.nodeName.toLowerCase() === b
               }
            },
            CLASS: function (a) {
               var b = y[a + " "];
               return b || (b = new RegExp("(^|" + L + ")" + a + "(" + L + "|$)")) && y(a, function (a) {
                  return b.test("string" == typeof a.className && a.className || "undefined" != typeof a.getAttribute && a.getAttribute("class") || "")
               })
            },
            ATTR: function (a, b, c) {
               return function (d) {
                  var e = fa.attr(d, a);
                  return null == e ? "!=" === b : b ? (e += "", "=" === b ? e === c : "!=" === b ? e !== c : "^=" === b ? c && 0 === e.indexOf(c) : "*=" === b ? c && e.indexOf(c) > -1 : "$=" === b ? c && e.slice(-c.length) === c : "~=" === b ? (" " + e.replace(P, " ") + " ").indexOf(c) > -1 : "|=" === b ? e === c || e.slice(0, c.length + 1) === c + "-" : !1) : !0
               }
            },
            CHILD: function (a, b, c, d, e) {
               var f = "nth" !== a.slice(0, 3),
                  g = "last" !== a.slice(-4),
                  h = "of-type" === b;
               return 1 === d && 0 === e ? function (a) {
                  return !!a.parentNode
               } : function (b, c, i) {
                  var j, k, l, m, n, o, p = f !== g ? "nextSibling" : "previousSibling",
                     q = b.parentNode,
                     r = h && b.nodeName.toLowerCase(),
                     s = !i && !h,
                     t = !1;
                  if (q) {
                     if (f) {
                        while (p) {
                           m = b;
                           while (m = m[p])
                              if (h ? m.nodeName.toLowerCase() === r : 1 === m.nodeType) return !1;
                           o = p = "only" === a && !o && "nextSibling"
                        }
                        return !0
                     }
                     if (o = [g ? q.firstChild : q.lastChild], g && s) {
                        m = q, l = m[u] || (m[u] = {}), k = l[m.uniqueID] || (l[m.uniqueID] = {}), j = k[a] || [], n = j[0] === w && j[1], t = n && j[2], m = n && q.childNodes[n];
                        while (m = ++n && m && m[p] || (t = n = 0) || o.pop())
                           if (1 === m.nodeType && ++t && m === b) {
                              k[a] = [w, n, t];
                              break
                           }
                     } else if (s && (m = b, l = m[u] || (m[u] = {}), k = l[m.uniqueID] || (l[m.uniqueID] = {}), j = k[a] || [], n = j[0] === w && j[1], t = n), t === !1)
                        while (m = ++n && m && m[p] || (t = n = 0) || o.pop())
                           if ((h ? m.nodeName.toLowerCase() === r : 1 === m.nodeType) && ++t && (s && (l = m[u] || (m[u] = {}), k = l[m.uniqueID] || (l[m.uniqueID] = {}), k[a] = [w, t]), m === b)) break;
                     return t -= e, t === d || t % d === 0 && t / d >= 0
                  }
               }
            },
            PSEUDO: function (a, b) {
               var c, e = d.pseudos[a] || d.setFilters[a.toLowerCase()] || fa.error("unsupported pseudo: " + a);
               return e[u] ? e(b) : e.length > 1 ? (c = [a, a, "", b], d.setFilters.hasOwnProperty(a.toLowerCase()) ? ha(function (a, c) {
                  var d, f = e(a, b),
                     g = f.length;
                  while (g--) d = J(a, f[g]), a[d] = !(c[d] = f[g])
               }) : function (a) {
                  return e(a, 0, c)
               }) : e
            }
         },
         pseudos: {
            not: ha(function (a) {
               var b = [],
                  c = [],
                  d = h(a.replace(Q, "$1"));
               return d[u] ? ha(function (a, b, c, e) {
                  var f, g = d(a, null, e, []),
                     h = a.length;
                  while (h--)(f = g[h]) && (a[h] = !(b[h] = f))
               }) : function (a, e, f) {
                  return b[0] = a, d(b, null, f, c), b[0] = null, !c.pop()
               }
            }),
            has: ha(function (a) {
               return function (b) {
                  return fa(a, b).length > 0
               }
            }),
            contains: ha(function (a) {
               return a = a.replace(ba, ca),
                  function (b) {
                     return (b.textContent || b.innerText || e(b)).indexOf(a) > -1
                  }
            }),
            lang: ha(function (a) {
               return V.test(a || "") || fa.error("unsupported lang: " + a), a = a.replace(ba, ca).toLowerCase(),
                  function (b) {
                     var c;
                     do
                        if (c = p ? b.lang : b.getAttribute("xml:lang") || b.getAttribute("lang")) return c = c.toLowerCase(), c === a || 0 === c.indexOf(a + "-"); while ((b = b.parentNode) && 1 === b.nodeType);
                     return !1
                  }
            }),
            target: function (b) {
               var c = a.location && a.location.hash;
               return c && c.slice(1) === b.id
            },
            root: function (a) {
               return a === o
            },
            focus: function (a) {
               return a === n.activeElement && (!n.hasFocus || n.hasFocus()) && !!(a.type || a.href || ~a.tabIndex)
            },
            enabled: function (a) {
               return a.disabled === !1
            },
            disabled: function (a) {
               return a.disabled === !0
            },
            checked: function (a) {
               var b = a.nodeName.toLowerCase();
               return "input" === b && !!a.checked || "option" === b && !!a.selected
            },
            selected: function (a) {
               return a.parentNode && a.parentNode.selectedIndex, a.selected === !0
            },
            empty: function (a) {
               for (a = a.firstChild; a; a = a.nextSibling)
                  if (a.nodeType < 6) return !1;
               return !0
            },
            parent: function (a) {
               return !d.pseudos.empty(a)
            },
            header: function (a) {
               return Y.test(a.nodeName)
            },
            input: function (a) {
               return X.test(a.nodeName)
            },
            button: function (a) {
               var b = a.nodeName.toLowerCase();
               return "input" === b && "button" === a.type || "button" === b
            },
            text: function (a) {
               var b;
               return "input" === a.nodeName.toLowerCase() && "text" === a.type && (null == (b = a.getAttribute("type")) || "text" === b.toLowerCase())
            },
            first: na(function () {
               return [0]
            }),
            last: na(function (a, b) {
               return [b - 1]
            }),
            eq: na(function (a, b, c) {
               return [0 > c ? c + b : c]
            }),
            even: na(function (a, b) {
               for (var c = 0; b > c; c += 2) a.push(c);
               return a
            }),
            odd: na(function (a, b) {
               for (var c = 1; b > c; c += 2) a.push(c);
               return a
            }),
            lt: na(function (a, b, c) {
               for (var d = 0 > c ? c + b : c; --d >= 0;) a.push(d);
               return a
            }),
            gt: na(function (a, b, c) {
               for (var d = 0 > c ? c + b : c; ++d < b;) a.push(d);
               return a
            })
         }
      }, d.pseudos.nth = d.pseudos.eq;
      for (b in {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
         }) d.pseudos[b] = la(b);
      for (b in {
            submit: !0,
            reset: !0
         }) d.pseudos[b] = ma(b);

      function pa() {}
      pa.prototype = d.filters = d.pseudos, d.setFilters = new pa, g = fa.tokenize = function (a, b) {
         var c, e, f, g, h, i, j, k = z[a + " "];
         if (k) return b ? 0 : k.slice(0);
         h = a, i = [], j = d.preFilter;
         while (h) {
            c && !(e = R.exec(h)) || (e && (h = h.slice(e[0].length) || h), i.push(f = [])), c = !1, (e = S.exec(h)) && (c = e.shift(), f.push({
               value: c,
               type: e[0].replace(Q, " ")
            }), h = h.slice(c.length));
            for (g in d.filter) !(e = W[g].exec(h)) || j[g] && !(e = j[g](e)) || (c = e.shift(), f.push({
               value: c,
               type: g,
               matches: e
            }), h = h.slice(c.length));
            if (!c) break
         }
         return b ? h.length : h ? fa.error(a) : z(a, i).slice(0)
      };

      function qa(a) {
         for (var b = 0, c = a.length, d = ""; c > b; b++) d += a[b].value;
         return d
      }

      function ra(a, b, c) {
         var d = b.dir,
            e = c && "parentNode" === d,
            f = x++;
         return b.first ? function (b, c, f) {
            while (b = b[d])
               if (1 === b.nodeType || e) return a(b, c, f)
         } : function (b, c, g) {
            var h, i, j, k = [w, f];
            if (g) {
               while (b = b[d])
                  if ((1 === b.nodeType || e) && a(b, c, g)) return !0
            } else
               while (b = b[d])
                  if (1 === b.nodeType || e) {
                     if (j = b[u] || (b[u] = {}), i = j[b.uniqueID] || (j[b.uniqueID] = {}), (h = i[d]) && h[0] === w && h[1] === f) return k[2] = h[2];
                     if (i[d] = k, k[2] = a(b, c, g)) return !0
                  }
         }
      }

      function sa(a) {
         return a.length > 1 ? function (b, c, d) {
            var e = a.length;
            while (e--)
               if (!a[e](b, c, d)) return !1;
            return !0
         } : a[0]
      }

      function ta(a, b, c) {
         for (var d = 0, e = b.length; e > d; d++) fa(a, b[d], c);
         return c
      }

      function ua(a, b, c, d, e) {
         for (var f, g = [], h = 0, i = a.length, j = null != b; i > h; h++)(f = a[h]) && (c && !c(f, d, e) || (g.push(f), j && b.push(h)));
         return g
      }

      function va(a, b, c, d, e, f) {
         return d && !d[u] && (d = va(d)), e && !e[u] && (e = va(e, f)), ha(function (f, g, h, i) {
            var j, k, l, m = [],
               n = [],
               o = g.length,
               p = f || ta(b || "*", h.nodeType ? [h] : h, []),
               q = !a || !f && b ? p : ua(p, m, a, h, i),
               r = c ? e || (f ? a : o || d) ? [] : g : q;
            if (c && c(q, r, h, i), d) {
               j = ua(r, n), d(j, [], h, i), k = j.length;
               while (k--)(l = j[k]) && (r[n[k]] = !(q[n[k]] = l))
            }
            if (f) {
               if (e || a) {
                  if (e) {
                     j = [], k = r.length;
                     while (k--)(l = r[k]) && j.push(q[k] = l);
                     e(null, r = [], j, i)
                  }
                  k = r.length;
                  while (k--)(l = r[k]) && (j = e ? J(f, l) : m[k]) > -1 && (f[j] = !(g[j] = l))
               }
            } else r = ua(r === g ? r.splice(o, r.length) : r), e ? e(null, g, r, i) : H.apply(g, r)
         })
      }

      function wa(a) {
         for (var b, c, e, f = a.length, g = d.relative[a[0].type], h = g || d.relative[" "], i = g ? 1 : 0, k = ra(function (a) {
               return a === b
            }, h, !0), l = ra(function (a) {
               return J(b, a) > -1
            }, h, !0), m = [function (a, c, d) {
               var e = !g && (d || c !== j) || ((b = c).nodeType ? k(a, c, d) : l(a, c, d));
               return b = null, e
            }]; f > i; i++)
            if (c = d.relative[a[i].type]) m = [ra(sa(m), c)];
            else {
               if (c = d.filter[a[i].type].apply(null, a[i].matches), c[u]) {
                  for (e = ++i; f > e; e++)
                     if (d.relative[a[e].type]) break;
                  return va(i > 1 && sa(m), i > 1 && qa(a.slice(0, i - 1).concat({
                     value: " " === a[i - 2].type ? "*" : ""
                  })).replace(Q, "$1"), c, e > i && wa(a.slice(i, e)), f > e && wa(a = a.slice(e)), f > e && qa(a))
               }
               m.push(c)
            }
         return sa(m)
      }

      function xa(a, b) {
         var c = b.length > 0,
            e = a.length > 0,
            f = function (f, g, h, i, k) {
               var l, o, q, r = 0,
                  s = "0",
                  t = f && [],
                  u = [],
                  v = j,
                  x = f || e && d.find.TAG("*", k),
                  y = w += null == v ? 1 : Math.random() || .1,
                  z = x.length;
               for (k && (j = g === n || g || k); s !== z && null != (l = x[s]); s++) {
                  if (e && l) {
                     o = 0, g || l.ownerDocument === n || (m(l), h = !p);
                     while (q = a[o++])
                        if (q(l, g || n, h)) {
                           i.push(l);
                           break
                        }
                     k && (w = y)
                  }
                  c && ((l = !q && l) && r--, f && t.push(l))
               }
               if (r += s, c && s !== r) {
                  o = 0;
                  while (q = b[o++]) q(t, u, g, h);
                  if (f) {
                     if (r > 0)
                        while (s--) t[s] || u[s] || (u[s] = F.call(i));
                     u = ua(u)
                  }
                  H.apply(i, u), k && !f && u.length > 0 && r + b.length > 1 && fa.uniqueSort(i)
               }
               return k && (w = y, j = v), t
            };
         return c ? ha(f) : f
      }
      return h = fa.compile = function (a, b) {
         var c, d = [],
            e = [],
            f = A[a + " "];
         if (!f) {
            b || (b = g(a)), c = b.length;
            while (c--) f = wa(b[c]), f[u] ? d.push(f) : e.push(f);
            f = A(a, xa(e, d)), f.selector = a
         }
         return f
      }, i = fa.select = function (a, b, e, f) {
         var i, j, k, l, m, n = "function" == typeof a && a,
            o = !f && g(a = n.selector || a);
         if (e = e || [], 1 === o.length) {
            if (j = o[0] = o[0].slice(0), j.length > 2 && "ID" === (k = j[0]).type && c.getById && 9 === b.nodeType && p && d.relative[j[1].type]) {
               if (b = (d.find.ID(k.matches[0].replace(ba, ca), b) || [])[0], !b) return e;
               n && (b = b.parentNode), a = a.slice(j.shift().value.length)
            }
            i = W.needsContext.test(a) ? 0 : j.length;
            while (i--) {
               if (k = j[i], d.relative[l = k.type]) break;
               if ((m = d.find[l]) && (f = m(k.matches[0].replace(ba, ca), _.test(j[0].type) && oa(b.parentNode) || b))) {
                  if (j.splice(i, 1), a = f.length && qa(j), !a) return H.apply(e, f), e;
                  break
               }
            }
         }
         return (n || h(a, o))(f, b, !p, e, !b || _.test(a) && oa(b.parentNode) || b), e
      }, c.sortStable = u.split("").sort(B).join("") === u, c.detectDuplicates = !!l, m(), c.sortDetached = ia(function (a) {
         return 1 & a.compareDocumentPosition(n.createElement("div"))
      }), ia(function (a) {
         return a.innerHTML = "<a href='#'></a>", "#" === a.firstChild.getAttribute("href")
      }) || ja("type|href|height|width", function (a, b, c) {
         return c ? void 0 : a.getAttribute(b, "type" === b.toLowerCase() ? 1 : 2)
      }), c.attributes && ia(function (a) {
         return a.innerHTML = "<input/>", a.firstChild.setAttribute("value", ""), "" === a.firstChild.getAttribute("value")
      }) || ja("value", function (a, b, c) {
         return c || "input" !== a.nodeName.toLowerCase() ? void 0 : a.defaultValue
      }), ia(function (a) {
         return null == a.getAttribute("disabled")
      }) || ja(K, function (a, b, c) {
         var d;
         return c ? void 0 : a[b] === !0 ? b.toLowerCase() : (d = a.getAttributeNode(b)) && d.specified ? d.value : null
      }), fa
   }(a);
   n.find = t, n.expr = t.selectors, n.expr[":"] = n.expr.pseudos, n.uniqueSort = n.unique = t.uniqueSort, n.text = t.getText, n.isXMLDoc = t.isXML, n.contains = t.contains;
   var u = function (a, b, c) {
         var d = [],
            e = void 0 !== c;
         while ((a = a[b]) && 9 !== a.nodeType)
            if (1 === a.nodeType) {
               if (e && n(a).is(c)) break;
               d.push(a)
            }
         return d
      },
      v = function (a, b) {
         for (var c = []; a; a = a.nextSibling) 1 === a.nodeType && a !== b && c.push(a);
         return c
      },
      w = n.expr.match.needsContext,
      x = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/,
      y = /^.[^:#\[\.,]*$/;

   function z(a, b, c) {
      if (n.isFunction(b)) return n.grep(a, function (a, d) {
         return !!b.call(a, d, a) !== c
      });
      if (b.nodeType) return n.grep(a, function (a) {
         return a === b !== c
      });
      if ("string" == typeof b) {
         if (y.test(b)) return n.filter(b, a, c);
         b = n.filter(b, a)
      }
      return n.grep(a, function (a) {
         return n.inArray(a, b) > -1 !== c
      })
   }
   n.filter = function (a, b, c) {
      var d = b[0];
      return c && (a = ":not(" + a + ")"), 1 === b.length && 1 === d.nodeType ? n.find.matchesSelector(d, a) ? [d] : [] : n.find.matches(a, n.grep(b, function (a) {
         return 1 === a.nodeType
      }))
   }, n.fn.extend({
      find: function (a) {
         var b, c = [],
            d = this,
            e = d.length;
         if ("string" != typeof a) return this.pushStack(n(a).filter(function () {
            for (b = 0; e > b; b++)
               if (n.contains(d[b], this)) return !0
         }));
         for (b = 0; e > b; b++) n.find(a, d[b], c);
         return c = this.pushStack(e > 1 ? n.unique(c) : c), c.selector = this.selector ? this.selector + " " + a : a, c
      },
      filter: function (a) {
         return this.pushStack(z(this, a || [], !1))
      },
      not: function (a) {
         return this.pushStack(z(this, a || [], !0))
      },
      is: function (a) {
         return !!z(this, "string" == typeof a && w.test(a) ? n(a) : a || [], !1).length
      }
   });
   var A, B = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,
      C = n.fn.init = function (a, b, c) {
         var e, f;
         if (!a) return this;
         if (c = c || A, "string" == typeof a) {
            if (e = "<" === a.charAt(0) && ">" === a.charAt(a.length - 1) && a.length >= 3 ? [null, a, null] : B.exec(a), !e || !e[1] && b) return !b || b.jquery ? (b || c).find(a) : this.constructor(b).find(a);
            if (e[1]) {
               if (b = b instanceof n ? b[0] : b, n.merge(this, n.parseHTML(e[1], b && b.nodeType ? b.ownerDocument || b : d, !0)), x.test(e[1]) && n.isPlainObject(b))
                  for (e in b) n.isFunction(this[e]) ? this[e](b[e]) : this.attr(e, b[e]);
               return this
            }
            if (f = d.getElementById(e[2]), f && f.parentNode) {
               if (f.id !== e[2]) return A.find(a);
               this.length = 1, this[0] = f
            }
            return this.context = d, this.selector = a, this
         }
         return a.nodeType ? (this.context = this[0] = a, this.length = 1, this) : n.isFunction(a) ? "undefined" != typeof c.ready ? c.ready(a) : a(n) : (void 0 !== a.selector && (this.selector = a.selector, this.context = a.context), n.makeArray(a, this))
      };
   C.prototype = n.fn, A = n(d);
   var D = /^(?:parents|prev(?:Until|All))/,
      E = {
         children: !0,
         contents: !0,
         next: !0,
         prev: !0
      };
   n.fn.extend({
      has: function (a) {
         var b, c = n(a, this),
            d = c.length;
         return this.filter(function () {
            for (b = 0; d > b; b++)
               if (n.contains(this, c[b])) return !0
         })
      },
      closest: function (a, b) {
         for (var c, d = 0, e = this.length, f = [], g = w.test(a) || "string" != typeof a ? n(a, b || this.context) : 0; e > d; d++)
            for (c = this[d]; c && c !== b; c = c.parentNode)
               if (c.nodeType < 11 && (g ? g.index(c) > -1 : 1 === c.nodeType && n.find.matchesSelector(c, a))) {
                  f.push(c);
                  break
               }
         return this.pushStack(f.length > 1 ? n.uniqueSort(f) : f)
      },
      index: function (a) {
         return a ? "string" == typeof a ? n.inArray(this[0], n(a)) : n.inArray(a.jquery ? a[0] : a, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
      },
      add: function (a, b) {
         return this.pushStack(n.uniqueSort(n.merge(this.get(), n(a, b))))
      },
      addBack: function (a) {
         return this.add(null == a ? this.prevObject : this.prevObject.filter(a))
      }
   });

   function F(a, b) {
      do a = a[b]; while (a && 1 !== a.nodeType);
      return a
   }
   n.each({
      parent: function (a) {
         var b = a.parentNode;
         return b && 11 !== b.nodeType ? b : null
      },
      parents: function (a) {
         return u(a, "parentNode")
      },
      parentsUntil: function (a, b, c) {
         return u(a, "parentNode", c)
      },
      next: function (a) {
         return F(a, "nextSibling")
      },
      prev: function (a) {
         return F(a, "previousSibling")
      },
      nextAll: function (a) {
         return u(a, "nextSibling")
      },
      prevAll: function (a) {
         return u(a, "previousSibling")
      },
      nextUntil: function (a, b, c) {
         return u(a, "nextSibling", c)
      },
      prevUntil: function (a, b, c) {
         return u(a, "previousSibling", c)
      },
      siblings: function (a) {
         return v((a.parentNode || {}).firstChild, a)
      },
      children: function (a) {
         return v(a.firstChild)
      },
      contents: function (a) {
         return n.nodeName(a, "iframe") ? a.contentDocument || a.contentWindow.document : n.merge([], a.childNodes)
      }
   }, function (a, b) {
      n.fn[a] = function (c, d) {
         var e = n.map(this, b, c);
         return "Until" !== a.slice(-5) && (d = c), d && "string" == typeof d && (e = n.filter(d, e)), this.length > 1 && (E[a] || (e = n.uniqueSort(e)), D.test(a) && (e = e.reverse())), this.pushStack(e)
      }
   });
   var G = /\S+/g;

   function H(a) {
      var b = {};
      return n.each(a.match(G) || [], function (a, c) {
         b[c] = !0
      }), b
   }
   n.Callbacks = function (a) {
      a = "string" == typeof a ? H(a) : n.extend({}, a);
      var b, c, d, e, f = [],
         g = [],
         h = -1,
         i = function () {
            for (e = a.once, d = b = !0; g.length; h = -1) {
               c = g.shift();
               while (++h < f.length) f[h].apply(c[0], c[1]) === !1 && a.stopOnFalse && (h = f.length, c = !1)
            }
            a.memory || (c = !1), b = !1, e && (f = c ? [] : "")
         },
         j = {
            add: function () {
               return f && (c && !b && (h = f.length - 1, g.push(c)), function d(b) {
                  n.each(b, function (b, c) {
                     n.isFunction(c) ? a.unique && j.has(c) || f.push(c) : c && c.length && "string" !== n.type(c) && d(c)
                  })
               }(arguments), c && !b && i()), this
            },
            remove: function () {
               return n.each(arguments, function (a, b) {
                  var c;
                  while ((c = n.inArray(b, f, c)) > -1) f.splice(c, 1), h >= c && h--
               }), this
            },
            has: function (a) {
               return a ? n.inArray(a, f) > -1 : f.length > 0
            },
            empty: function () {
               return f && (f = []), this
            },
            disable: function () {
               return e = g = [], f = c = "", this
            },
            disabled: function () {
               return !f
            },
            lock: function () {
               return e = !0, c || j.disable(), this
            },
            locked: function () {
               return !!e
            },
            fireWith: function (a, c) {
               return e || (c = c || [], c = [a, c.slice ? c.slice() : c], g.push(c), b || i()), this
            },
            fire: function () {
               return j.fireWith(this, arguments), this
            },
            fired: function () {
               return !!d
            }
         };
      return j
   }, n.extend({
      Deferred: function (a) {
         var b = [
               ["resolve", "done", n.Callbacks("once memory"), "resolved"],
               ["reject", "fail", n.Callbacks("once memory"), "rejected"],
               ["notify", "progress", n.Callbacks("memory")]
            ],
            c = "pending",
            d = {
               state: function () {
                  return c
               },
               always: function () {
                  return e.done(arguments).fail(arguments), this
               },
               then: function () {
                  var a = arguments;
                  return n.Deferred(function (c) {
                     n.each(b, function (b, f) {
                        var g = n.isFunction(a[b]) && a[b];
                        e[f[1]](function () {
                           var a = g && g.apply(this, arguments);
                           a && n.isFunction(a.promise) ? a.promise().progress(c.notify).done(c.resolve).fail(c.reject) : c[f[0] + "With"](this === d ? c.promise() : this, g ? [a] : arguments)
                        })
                     }), a = null
                  }).promise()
               },
               promise: function (a) {
                  return null != a ? n.extend(a, d) : d
               }
            },
            e = {};
         return d.pipe = d.then, n.each(b, function (a, f) {
            var g = f[2],
               h = f[3];
            d[f[1]] = g.add, h && g.add(function () {
               c = h
            }, b[1 ^ a][2].disable, b[2][2].lock), e[f[0]] = function () {
               return e[f[0] + "With"](this === e ? d : this, arguments), this
            }, e[f[0] + "With"] = g.fireWith
         }), d.promise(e), a && a.call(e, e), e
      },
      when: function (a) {
         var b = 0,
            c = e.call(arguments),
            d = c.length,
            f = 1 !== d || a && n.isFunction(a.promise) ? d : 0,
            g = 1 === f ? a : n.Deferred(),
            h = function (a, b, c) {
               return function (d) {
                  b[a] = this, c[a] = arguments.length > 1 ? e.call(arguments) : d, c === i ? g.notifyWith(b, c) : --f || g.resolveWith(b, c)
               }
            },
            i, j, k;
         if (d > 1)
            for (i = new Array(d), j = new Array(d), k = new Array(d); d > b; b++) c[b] && n.isFunction(c[b].promise) ? c[b].promise().progress(h(b, j, i)).done(h(b, k, c)).fail(g.reject) : --f;
         return f || g.resolveWith(k, c), g.promise()
      }
   });
   var I;
   n.fn.ready = function (a) {
      return n.ready.promise().done(a), this
   }, n.extend({
      isReady: !1,
      readyWait: 1,
      holdReady: function (a) {
         a ? n.readyWait++ : n.ready(!0)
      },
      ready: function (a) {
         (a === !0 ? --n.readyWait : n.isReady) || (n.isReady = !0, a !== !0 && --n.readyWait > 0 || (I.resolveWith(d, [n]), n.fn.triggerHandler && (n(d).triggerHandler("ready"), n(d).off("ready"))))
      }
   });

   function J() {
      d.addEventListener ? (d.removeEventListener("DOMContentLoaded", K), a.removeEventListener("load", K)) : (d.detachEvent("onreadystatechange", K), a.detachEvent("onload", K))
   }

   function K() {
      (d.addEventListener || "load" === a.event.type || "complete" === d.readyState) && (J(), n.ready())
   }
   n.ready.promise = function (b) {
      if (!I)
         if (I = n.Deferred(), "complete" === d.readyState || "loading" !== d.readyState && !d.documentElement.doScroll) a.setTimeout(n.ready);
         else if (d.addEventListener) d.addEventListener("DOMContentLoaded", K), a.addEventListener("load", K);
      else {
         d.attachEvent("onreadystatechange", K), a.attachEvent("onload", K);
         var c = !1;
         try {
            c = null == a.frameElement && d.documentElement
         } catch (e) {}
         c && c.doScroll && ! function f() {
            if (!n.isReady) {
               try {
                  c.doScroll("left")
               } catch (b) {
                  return a.setTimeout(f, 50)
               }
               J(), n.ready()
            }
         }()
      }
      return I.promise(b)
   }, n.ready.promise();
   var L;
   for (L in n(l)) break;
   l.ownFirst = "0" === L, l.inlineBlockNeedsLayout = !1, n(function () {
         var a, b, c, e;
         c = d.getElementsByTagName("body")[0], c && c.style && (b = d.createElement("div"), e = d.createElement("div"), e.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", c.appendChild(e).appendChild(b), "undefined" != typeof b.style.zoom && (b.style.cssText = "display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1", l.inlineBlockNeedsLayout = a = 3 === b.offsetWidth, a && (c.style.zoom = 1)), c.removeChild(e))
      }),
      function () {
         var a = d.createElement("div");
         l.deleteExpando = !0;
         try {
            delete a.test
         } catch (b) {
            l.deleteExpando = !1
         }
         a = null
      }();
   var M = function (a) {
         var b = n.noData[(a.nodeName + " ").toLowerCase()],
            c = +a.nodeType || 1;
         return 1 !== c && 9 !== c ? !1 : !b || b !== !0 && a.getAttribute("classid") === b
      },
      N = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
      O = /([A-Z])/g;

   function P(a, b, c) {
      if (void 0 === c && 1 === a.nodeType) {
         var d = "data-" + b.replace(O, "-$1").toLowerCase();
         if (c = a.getAttribute(d), "string" == typeof c) {
            try {
               c = "true" === c ? !0 : "false" === c ? !1 : "null" === c ? null : +c + "" === c ? +c : N.test(c) ? n.parseJSON(c) : c
            } catch (e) {}
            n.data(a, b, c)
         } else c = void 0;
      }
      return c
   }

   function Q(a) {
      var b;
      for (b in a)
         if (("data" !== b || !n.isEmptyObject(a[b])) && "toJSON" !== b) return !1;
      return !0
   }

   function R(a, b, d, e) {
      if (M(a)) {
         var f, g, h = n.expando,
            i = a.nodeType,
            j = i ? n.cache : a,
            k = i ? a[h] : a[h] && h;
         if (k && j[k] && (e || j[k].data) || void 0 !== d || "string" != typeof b) return k || (k = i ? a[h] = c.pop() || n.guid++ : h), j[k] || (j[k] = i ? {} : {
            toJSON: n.noop
         }), "object" != typeof b && "function" != typeof b || (e ? j[k] = n.extend(j[k], b) : j[k].data = n.extend(j[k].data, b)), g = j[k], e || (g.data || (g.data = {}), g = g.data), void 0 !== d && (g[n.camelCase(b)] = d), "string" == typeof b ? (f = g[b], null == f && (f = g[n.camelCase(b)])) : f = g, f
      }
   }

   function S(a, b, c) {
      if (M(a)) {
         var d, e, f = a.nodeType,
            g = f ? n.cache : a,
            h = f ? a[n.expando] : n.expando;
         if (g[h]) {
            if (b && (d = c ? g[h] : g[h].data)) {
               n.isArray(b) ? b = b.concat(n.map(b, n.camelCase)) : b in d ? b = [b] : (b = n.camelCase(b), b = b in d ? [b] : b.split(" ")), e = b.length;
               while (e--) delete d[b[e]];
               if (c ? !Q(d) : !n.isEmptyObject(d)) return
            }(c || (delete g[h].data, Q(g[h]))) && (f ? n.cleanData([a], !0) : l.deleteExpando || g != g.window ? delete g[h] : g[h] = void 0)
         }
      }
   }
   n.extend({
         cache: {},
         noData: {
            "applet ": !0,
            "embed ": !0,
            "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
         },
         hasData: function (a) {
            return a = a.nodeType ? n.cache[a[n.expando]] : a[n.expando], !!a && !Q(a)
         },
         data: function (a, b, c) {
            return R(a, b, c)
         },
         removeData: function (a, b) {
            return S(a, b)
         },
         _data: function (a, b, c) {
            return R(a, b, c, !0)
         },
         _removeData: function (a, b) {
            return S(a, b, !0)
         }
      }), n.fn.extend({
         data: function (a, b) {
            var c, d, e, f = this[0],
               g = f && f.attributes;
            if (void 0 === a) {
               if (this.length && (e = n.data(f), 1 === f.nodeType && !n._data(f, "parsedAttrs"))) {
                  c = g.length;
                  while (c--) g[c] && (d = g[c].name, 0 === d.indexOf("data-") && (d = n.camelCase(d.slice(5)), P(f, d, e[d])));
                  n._data(f, "parsedAttrs", !0)
               }
               return e
            }
            return "object" == typeof a ? this.each(function () {
               n.data(this, a)
            }) : arguments.length > 1 ? this.each(function () {
               n.data(this, a, b)
            }) : f ? P(f, a, n.data(f, a)) : void 0
         },
         removeData: function (a) {
            return this.each(function () {
               n.removeData(this, a)
            })
         }
      }), n.extend({
         queue: function (a, b, c) {
            var d;
            return a ? (b = (b || "fx") + "queue", d = n._data(a, b), c && (!d || n.isArray(c) ? d = n._data(a, b, n.makeArray(c)) : d.push(c)), d || []) : void 0
         },
         dequeue: function (a, b) {
            b = b || "fx";
            var c = n.queue(a, b),
               d = c.length,
               e = c.shift(),
               f = n._queueHooks(a, b),
               g = function () {
                  n.dequeue(a, b)
               };
            "inprogress" === e && (e = c.shift(), d--), e && ("fx" === b && c.unshift("inprogress"), delete f.stop, e.call(a, g, f)), !d && f && f.empty.fire()
         },
         _queueHooks: function (a, b) {
            var c = b + "queueHooks";
            return n._data(a, c) || n._data(a, c, {
               empty: n.Callbacks("once memory").add(function () {
                  n._removeData(a, b + "queue"), n._removeData(a, c)
               })
            })
         }
      }), n.fn.extend({
         queue: function (a, b) {
            var c = 2;
            return "string" != typeof a && (b = a, a = "fx", c--), arguments.length < c ? n.queue(this[0], a) : void 0 === b ? this : this.each(function () {
               var c = n.queue(this, a, b);
               n._queueHooks(this, a), "fx" === a && "inprogress" !== c[0] && n.dequeue(this, a)
            })
         },
         dequeue: function (a) {
            return this.each(function () {
               n.dequeue(this, a)
            })
         },
         clearQueue: function (a) {
            return this.queue(a || "fx", [])
         },
         promise: function (a, b) {
            var c, d = 1,
               e = n.Deferred(),
               f = this,
               g = this.length,
               h = function () {
                  --d || e.resolveWith(f, [f])
               };
            "string" != typeof a && (b = a, a = void 0), a = a || "fx";
            while (g--) c = n._data(f[g], a + "queueHooks"), c && c.empty && (d++, c.empty.add(h));
            return h(), e.promise(b)
         }
      }),
      function () {
         var a;
         l.shrinkWrapBlocks = function () {
            if (null != a) return a;
            a = !1;
            var b, c, e;
            return c = d.getElementsByTagName("body")[0], c && c.style ? (b = d.createElement("div"), e = d.createElement("div"), e.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", c.appendChild(e).appendChild(b), "undefined" != typeof b.style.zoom && (b.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", b.appendChild(d.createElement("div")).style.width = "5px", a = 3 !== b.offsetWidth), c.removeChild(e), a) : void 0
         }
      }();
   var T = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
      U = new RegExp("^(?:([+-])=|)(" + T + ")([a-z%]*)$", "i"),
      V = ["Top", "Right", "Bottom", "Left"],
      W = function (a, b) {
         return a = b || a, "none" === n.css(a, "display") || !n.contains(a.ownerDocument, a)
      };

   function X(a, b, c, d) {
      var e, f = 1,
         g = 20,
         h = d ? function () {
            return d.cur()
         } : function () {
            return n.css(a, b, "")
         },
         i = h(),
         j = c && c[3] || (n.cssNumber[b] ? "" : "px"),
         k = (n.cssNumber[b] || "px" !== j && +i) && U.exec(n.css(a, b));
      if (k && k[3] !== j) {
         j = j || k[3], c = c || [], k = +i || 1;
         do f = f || ".5", k /= f, n.style(a, b, k + j); while (f !== (f = h() / i) && 1 !== f && --g)
      }
      return c && (k = +k || +i || 0, e = c[1] ? k + (c[1] + 1) * c[2] : +c[2], d && (d.unit = j, d.start = k, d.end = e)), e
   }
   var Y = function (a, b, c, d, e, f, g) {
         var h = 0,
            i = a.length,
            j = null == c;
         if ("object" === n.type(c)) {
            e = !0;
            for (h in c) Y(a, b, h, c[h], !0, f, g)
         } else if (void 0 !== d && (e = !0, n.isFunction(d) || (g = !0), j && (g ? (b.call(a, d), b = null) : (j = b, b = function (a, b, c) {
               return j.call(n(a), c)
            })), b))
            for (; i > h; h++) b(a[h], c, g ? d : d.call(a[h], h, b(a[h], c)));
         return e ? a : j ? b.call(a) : i ? b(a[0], c) : f
      },
      Z = /^(?:checkbox|radio)$/i,
      $ = /<([\w:-]+)/,
      _ = /^$|\/(?:java|ecma)script/i,
      aa = /^\s+/,
      ba = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|dialog|figcaption|figure|footer|header|hgroup|main|mark|meter|nav|output|picture|progress|section|summary|template|time|video";

   function ca(a) {
      var b = ba.split("|"),
         c = a.createDocumentFragment();
      if (c.createElement)
         while (b.length) c.createElement(b.pop());
      return c
   }! function () {
      var a = d.createElement("div"),
         b = d.createDocumentFragment(),
         c = d.createElement("input");
      a.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", l.leadingWhitespace = 3 === a.firstChild.nodeType, l.tbody = !a.getElementsByTagName("tbody").length, l.htmlSerialize = !!a.getElementsByTagName("link").length, l.html5Clone = "<:nav></:nav>" !== d.createElement("nav").cloneNode(!0).outerHTML, c.type = "checkbox", c.checked = !0, b.appendChild(c), l.appendChecked = c.checked, a.innerHTML = "<textarea>x</textarea>", l.noCloneChecked = !!a.cloneNode(!0).lastChild.defaultValue, b.appendChild(a), c = d.createElement("input"), c.setAttribute("type", "radio"), c.setAttribute("checked", "checked"), c.setAttribute("name", "t"), a.appendChild(c), l.checkClone = a.cloneNode(!0).cloneNode(!0).lastChild.checked, l.noCloneEvent = !!a.addEventListener, a[n.expando] = 1, l.attributes = !a.getAttribute(n.expando)
   }();
   var da = {
      option: [1, "<select multiple='multiple'>", "</select>"],
      legend: [1, "<fieldset>", "</fieldset>"],
      area: [1, "<map>", "</map>"],
      param: [1, "<object>", "</object>"],
      thead: [1, "<table>", "</table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      _default: l.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
   };
   da.optgroup = da.option, da.tbody = da.tfoot = da.colgroup = da.caption = da.thead, da.th = da.td;

   function ea(a, b) {
      var c, d, e = 0,
         f = "undefined" != typeof a.getElementsByTagName ? a.getElementsByTagName(b || "*") : "undefined" != typeof a.querySelectorAll ? a.querySelectorAll(b || "*") : void 0;
      if (!f)
         for (f = [], c = a.childNodes || a; null != (d = c[e]); e++) !b || n.nodeName(d, b) ? f.push(d) : n.merge(f, ea(d, b));
      return void 0 === b || b && n.nodeName(a, b) ? n.merge([a], f) : f
   }

   function fa(a, b) {
      for (var c, d = 0; null != (c = a[d]); d++) n._data(c, "globalEval", !b || n._data(b[d], "globalEval"))
   }
   var ga = /<|&#?\w+;/,
      ha = /<tbody/i;

   function ia(a) {
      Z.test(a.type) && (a.defaultChecked = a.checked)
   }

   function ja(a, b, c, d, e) {
      for (var f, g, h, i, j, k, m, o = a.length, p = ca(b), q = [], r = 0; o > r; r++)
         if (g = a[r], g || 0 === g)
            if ("object" === n.type(g)) n.merge(q, g.nodeType ? [g] : g);
            else if (ga.test(g)) {
         i = i || p.appendChild(b.createElement("div")), j = ($.exec(g) || ["", ""])[1].toLowerCase(), m = da[j] || da._default, i.innerHTML = m[1] + n.htmlPrefilter(g) + m[2], f = m[0];
         while (f--) i = i.lastChild;
         if (!l.leadingWhitespace && aa.test(g) && q.push(b.createTextNode(aa.exec(g)[0])), !l.tbody) {
            g = "table" !== j || ha.test(g) ? "<table>" !== m[1] || ha.test(g) ? 0 : i : i.firstChild, f = g && g.childNodes.length;
            while (f--) n.nodeName(k = g.childNodes[f], "tbody") && !k.childNodes.length && g.removeChild(k)
         }
         n.merge(q, i.childNodes), i.textContent = "";
         while (i.firstChild) i.removeChild(i.firstChild);
         i = p.lastChild
      } else q.push(b.createTextNode(g));
      i && p.removeChild(i), l.appendChecked || n.grep(ea(q, "input"), ia), r = 0;
      while (g = q[r++])
         if (d && n.inArray(g, d) > -1) e && e.push(g);
         else if (h = n.contains(g.ownerDocument, g), i = ea(p.appendChild(g), "script"), h && fa(i), c) {
         f = 0;
         while (g = i[f++]) _.test(g.type || "") && c.push(g)
      }
      return i = null, p
   }! function () {
      var b, c, e = d.createElement("div");
      for (b in {
            submit: !0,
            change: !0,
            focusin: !0
         }) c = "on" + b, (l[b] = c in a) || (e.setAttribute(c, "t"), l[b] = e.attributes[c].expando === !1);
      e = null
   }();
   var ka = /^(?:input|select|textarea)$/i,
      la = /^key/,
      ma = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
      na = /^(?:focusinfocus|focusoutblur)$/,
      oa = /^([^.]*)(?:\.(.+)|)/;

   function pa() {
      return !0
   }

   function qa() {
      return !1
   }

   function ra() {
      try {
         return d.activeElement
      } catch (a) {}
   }

   function sa(a, b, c, d, e, f) {
      var g, h;
      if ("object" == typeof b) {
         "string" != typeof c && (d = d || c, c = void 0);
         for (h in b) sa(a, h, c, d, b[h], f);
         return a
      }
      if (null == d && null == e ? (e = c, d = c = void 0) : null == e && ("string" == typeof c ? (e = d, d = void 0) : (e = d, d = c, c = void 0)), e === !1) e = qa;
      else if (!e) return a;
      return 1 === f && (g = e, e = function (a) {
         return n().off(a), g.apply(this, arguments)
      }, e.guid = g.guid || (g.guid = n.guid++)), a.each(function () {
         n.event.add(this, b, e, d, c)
      })
   }
   n.event = {
      global: {},
      add: function (a, b, c, d, e) {
         var f, g, h, i, j, k, l, m, o, p, q, r = n._data(a);
         if (r) {
            c.handler && (i = c, c = i.handler, e = i.selector), c.guid || (c.guid = n.guid++), (g = r.events) || (g = r.events = {}), (k = r.handle) || (k = r.handle = function (a) {
               return "undefined" == typeof n || a && n.event.triggered === a.type ? void 0 : n.event.dispatch.apply(k.elem, arguments)
            }, k.elem = a), b = (b || "").match(G) || [""], h = b.length;
            while (h--) f = oa.exec(b[h]) || [], o = q = f[1], p = (f[2] || "").split(".").sort(), o && (j = n.event.special[o] || {}, o = (e ? j.delegateType : j.bindType) || o, j = n.event.special[o] || {}, l = n.extend({
               type: o,
               origType: q,
               data: d,
               handler: c,
               guid: c.guid,
               selector: e,
               needsContext: e && n.expr.match.needsContext.test(e),
               namespace: p.join(".")
            }, i), (m = g[o]) || (m = g[o] = [], m.delegateCount = 0, j.setup && j.setup.call(a, d, p, k) !== !1 || (a.addEventListener ? a.addEventListener(o, k, !1) : a.attachEvent && a.attachEvent("on" + o, k))), j.add && (j.add.call(a, l), l.handler.guid || (l.handler.guid = c.guid)), e ? m.splice(m.delegateCount++, 0, l) : m.push(l), n.event.global[o] = !0);
            a = null
         }
      },
      remove: function (a, b, c, d, e) {
         var f, g, h, i, j, k, l, m, o, p, q, r = n.hasData(a) && n._data(a);
         if (r && (k = r.events)) {
            b = (b || "").match(G) || [""], j = b.length;
            while (j--)
               if (h = oa.exec(b[j]) || [], o = q = h[1], p = (h[2] || "").split(".").sort(), o) {
                  l = n.event.special[o] || {}, o = (d ? l.delegateType : l.bindType) || o, m = k[o] || [], h = h[2] && new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)"), i = f = m.length;
                  while (f--) g = m[f], !e && q !== g.origType || c && c.guid !== g.guid || h && !h.test(g.namespace) || d && d !== g.selector && ("**" !== d || !g.selector) || (m.splice(f, 1), g.selector && m.delegateCount--, l.remove && l.remove.call(a, g));
                  i && !m.length && (l.teardown && l.teardown.call(a, p, r.handle) !== !1 || n.removeEvent(a, o, r.handle), delete k[o])
               } else
                  for (o in k) n.event.remove(a, o + b[j], c, d, !0);
            n.isEmptyObject(k) && (delete r.handle, n._removeData(a, "events"))
         }
      },
      trigger: function (b, c, e, f) {
         var g, h, i, j, l, m, o, p = [e || d],
            q = k.call(b, "type") ? b.type : b,
            r = k.call(b, "namespace") ? b.namespace.split(".") : [];
         if (i = m = e = e || d, 3 !== e.nodeType && 8 !== e.nodeType && !na.test(q + n.event.triggered) && (q.indexOf(".") > -1 && (r = q.split("."), q = r.shift(), r.sort()), h = q.indexOf(":") < 0 && "on" + q, b = b[n.expando] ? b : new n.Event(q, "object" == typeof b && b), b.isTrigger = f ? 2 : 3, b.namespace = r.join("."), b.rnamespace = b.namespace ? new RegExp("(^|\\.)" + r.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, b.result = void 0, b.target || (b.target = e), c = null == c ? [b] : n.makeArray(c, [b]), l = n.event.special[q] || {}, f || !l.trigger || l.trigger.apply(e, c) !== !1)) {
            if (!f && !l.noBubble && !n.isWindow(e)) {
               for (j = l.delegateType || q, na.test(j + q) || (i = i.parentNode); i; i = i.parentNode) p.push(i), m = i;
               m === (e.ownerDocument || d) && p.push(m.defaultView || m.parentWindow || a)
            }
            o = 0;
            while ((i = p[o++]) && !b.isPropagationStopped()) b.type = o > 1 ? j : l.bindType || q, g = (n._data(i, "events") || {})[b.type] && n._data(i, "handle"), g && g.apply(i, c), g = h && i[h], g && g.apply && M(i) && (b.result = g.apply(i, c), b.result === !1 && b.preventDefault());
            if (b.type = q, !f && !b.isDefaultPrevented() && (!l._default || l._default.apply(p.pop(), c) === !1) && M(e) && h && e[q] && !n.isWindow(e)) {
               m = e[h], m && (e[h] = null), n.event.triggered = q;
               try {
                  e[q]()
               } catch (s) {}
               n.event.triggered = void 0, m && (e[h] = m)
            }
            return b.result
         }
      },
      dispatch: function (a) {
         a = n.event.fix(a);
         var b, c, d, f, g, h = [],
            i = e.call(arguments),
            j = (n._data(this, "events") || {})[a.type] || [],
            k = n.event.special[a.type] || {};
         if (i[0] = a, a.delegateTarget = this, !k.preDispatch || k.preDispatch.call(this, a) !== !1) {
            h = n.event.handlers.call(this, a, j), b = 0;
            while ((f = h[b++]) && !a.isPropagationStopped()) {
               a.currentTarget = f.elem, c = 0;
               while ((g = f.handlers[c++]) && !a.isImmediatePropagationStopped()) a.rnamespace && !a.rnamespace.test(g.namespace) || (a.handleObj = g, a.data = g.data, d = ((n.event.special[g.origType] || {}).handle || g.handler).apply(f.elem, i), void 0 !== d && (a.result = d) === !1 && (a.preventDefault(), a.stopPropagation()))
            }
            return k.postDispatch && k.postDispatch.call(this, a), a.result
         }
      },
      handlers: function (a, b) {
         var c, d, e, f, g = [],
            h = b.delegateCount,
            i = a.target;
         if (h && i.nodeType && ("click" !== a.type || isNaN(a.button) || a.button < 1))
            for (; i != this; i = i.parentNode || this)
               if (1 === i.nodeType && (i.disabled !== !0 || "click" !== a.type)) {
                  for (d = [], c = 0; h > c; c++) f = b[c], e = f.selector + " ", void 0 === d[e] && (d[e] = f.needsContext ? n(e, this).index(i) > -1 : n.find(e, this, null, [i]).length), d[e] && d.push(f);
                  d.length && g.push({
                     elem: i,
                     handlers: d
                  })
               }
         return h < b.length && g.push({
            elem: this,
            handlers: b.slice(h)
         }), g
      },
      fix: function (a) {
         if (a[n.expando]) return a;
         var b, c, e, f = a.type,
            g = a,
            h = this.fixHooks[f];
         h || (this.fixHooks[f] = h = ma.test(f) ? this.mouseHooks : la.test(f) ? this.keyHooks : {}), e = h.props ? this.props.concat(h.props) : this.props, a = new n.Event(g), b = e.length;
         while (b--) c = e[b], a[c] = g[c];
         return a.target || (a.target = g.srcElement || d), 3 === a.target.nodeType && (a.target = a.target.parentNode), a.metaKey = !!a.metaKey, h.filter ? h.filter(a, g) : a
      },
      props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
      fixHooks: {},
      keyHooks: {
         props: "char charCode key keyCode".split(" "),
         filter: function (a, b) {
            return null == a.which && (a.which = null != b.charCode ? b.charCode : b.keyCode), a
         }
      },
      mouseHooks: {
         props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
         filter: function (a, b) {
            var c, e, f, g = b.button,
               h = b.fromElement;
            return null == a.pageX && null != b.clientX && (e = a.target.ownerDocument || d, f = e.documentElement, c = e.body, a.pageX = b.clientX + (f && f.scrollLeft || c && c.scrollLeft || 0) - (f && f.clientLeft || c && c.clientLeft || 0), a.pageY = b.clientY + (f && f.scrollTop || c && c.scrollTop || 0) - (f && f.clientTop || c && c.clientTop || 0)), !a.relatedTarget && h && (a.relatedTarget = h === a.target ? b.toElement : h), a.which || void 0 === g || (a.which = 1 & g ? 1 : 2 & g ? 3 : 4 & g ? 2 : 0), a
         }
      },
      special: {
         load: {
            noBubble: !0
         },
         focus: {
            trigger: function () {
               if (this !== ra() && this.focus) try {
                  return this.focus(), !1
               } catch (a) {}
            },
            delegateType: "focusin"
         },
         blur: {
            trigger: function () {
               return this === ra() && this.blur ? (this.blur(), !1) : void 0
            },
            delegateType: "focusout"
         },
         click: {
            trigger: function () {
               return n.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : void 0
            },
            _default: function (a) {
               return n.nodeName(a.target, "a")
            }
         },
         beforeunload: {
            postDispatch: function (a) {
               void 0 !== a.result && a.originalEvent && (a.originalEvent.returnValue = a.result)
            }
         }
      },
      simulate: function (a, b, c) {
         var d = n.extend(new n.Event, c, {
            type: a,
            isSimulated: !0
         });
         n.event.trigger(d, null, b), d.isDefaultPrevented() && c.preventDefault()
      }
   }, n.removeEvent = d.removeEventListener ? function (a, b, c) {
      a.removeEventListener && a.removeEventListener(b, c)
   } : function (a, b, c) {
      var d = "on" + b;
      a.detachEvent && ("undefined" == typeof a[d] && (a[d] = null), a.detachEvent(d, c))
   }, n.Event = function (a, b) {
      return this instanceof n.Event ? (a && a.type ? (this.originalEvent = a, this.type = a.type, this.isDefaultPrevented = a.defaultPrevented || void 0 === a.defaultPrevented && a.returnValue === !1 ? pa : qa) : this.type = a, b && n.extend(this, b), this.timeStamp = a && a.timeStamp || n.now(), void(this[n.expando] = !0)) : new n.Event(a, b)
   }, n.Event.prototype = {
      constructor: n.Event,
      isDefaultPrevented: qa,
      isPropagationStopped: qa,
      isImmediatePropagationStopped: qa,
      preventDefault: function () {
         var a = this.originalEvent;
         this.isDefaultPrevented = pa, a && (a.preventDefault ? a.preventDefault() : a.returnValue = !1)
      },
      stopPropagation: function () {
         var a = this.originalEvent;
         this.isPropagationStopped = pa, a && !this.isSimulated && (a.stopPropagation && a.stopPropagation(), a.cancelBubble = !0)
      },
      stopImmediatePropagation: function () {
         var a = this.originalEvent;
         this.isImmediatePropagationStopped = pa, a && a.stopImmediatePropagation && a.stopImmediatePropagation(), this.stopPropagation()
      }
   }, n.each({
      mouseenter: "mouseover",
      mouseleave: "mouseout",
      pointerenter: "pointerover",
      pointerleave: "pointerout"
   }, function (a, b) {
      n.event.special[a] = {
         delegateType: b,
         bindType: b,
         handle: function (a) {
            var c, d = this,
               e = a.relatedTarget,
               f = a.handleObj;
            return e && (e === d || n.contains(d, e)) || (a.type = f.origType, c = f.handler.apply(this, arguments), a.type = b), c
         }
      }
   }), l.submit || (n.event.special.submit = {
      setup: function () {
         return n.nodeName(this, "form") ? !1 : void n.event.add(this, "click._submit keypress._submit", function (a) {
            var b = a.target,
               c = n.nodeName(b, "input") || n.nodeName(b, "button") ? n.prop(b, "form") : void 0;
            c && !n._data(c, "submit") && (n.event.add(c, "submit._submit", function (a) {
               a._submitBubble = !0
            }), n._data(c, "submit", !0))
         })
      },
      postDispatch: function (a) {
         a._submitBubble && (delete a._submitBubble, this.parentNode && !a.isTrigger && n.event.simulate("submit", this.parentNode, a))
      },
      teardown: function () {
         return n.nodeName(this, "form") ? !1 : void n.event.remove(this, "._submit")
      }
   }), l.change || (n.event.special.change = {
      setup: function () {
         return ka.test(this.nodeName) ? ("checkbox" !== this.type && "radio" !== this.type || (n.event.add(this, "propertychange._change", function (a) {
            "checked" === a.originalEvent.propertyName && (this._justChanged = !0)
         }), n.event.add(this, "click._change", function (a) {
            this._justChanged && !a.isTrigger && (this._justChanged = !1), n.event.simulate("change", this, a)
         })), !1) : void n.event.add(this, "beforeactivate._change", function (a) {
            var b = a.target;
            ka.test(b.nodeName) && !n._data(b, "change") && (n.event.add(b, "change._change", function (a) {
               !this.parentNode || a.isSimulated || a.isTrigger || n.event.simulate("change", this.parentNode, a)
            }), n._data(b, "change", !0))
         })
      },
      handle: function (a) {
         var b = a.target;
         return this !== b || a.isSimulated || a.isTrigger || "radio" !== b.type && "checkbox" !== b.type ? a.handleObj.handler.apply(this, arguments) : void 0
      },
      teardown: function () {
         return n.event.remove(this, "._change"), !ka.test(this.nodeName)
      }
   }), l.focusin || n.each({
      focus: "focusin",
      blur: "focusout"
   }, function (a, b) {
      var c = function (a) {
         n.event.simulate(b, a.target, n.event.fix(a))
      };
      n.event.special[b] = {
         setup: function () {
            var d = this.ownerDocument || this,
               e = n._data(d, b);
            e || d.addEventListener(a, c, !0), n._data(d, b, (e || 0) + 1)
         },
         teardown: function () {
            var d = this.ownerDocument || this,
               e = n._data(d, b) - 1;
            e ? n._data(d, b, e) : (d.removeEventListener(a, c, !0), n._removeData(d, b))
         }
      }
   }), n.fn.extend({
      on: function (a, b, c, d) {
         return sa(this, a, b, c, d)
      },
      one: function (a, b, c, d) {
         return sa(this, a, b, c, d, 1)
      },
      off: function (a, b, c) {
         var d, e;
         if (a && a.preventDefault && a.handleObj) return d = a.handleObj, n(a.delegateTarget).off(d.namespace ? d.origType + "." + d.namespace : d.origType, d.selector, d.handler), this;
         if ("object" == typeof a) {
            for (e in a) this.off(e, b, a[e]);
            return this
         }
         return b !== !1 && "function" != typeof b || (c = b, b = void 0), c === !1 && (c = qa), this.each(function () {
            n.event.remove(this, a, c, b)
         })
      },
      trigger: function (a, b) {
         return this.each(function () {
            n.event.trigger(a, b, this)
         })
      },
      triggerHandler: function (a, b) {
         var c = this[0];
         return c ? n.event.trigger(a, b, c, !0) : void 0
      }
   });
   var ta = / jQuery\d+="(?:null|\d+)"/g,
      ua = new RegExp("<(?:" + ba + ")[\\s/>]", "i"),
      va = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi,
      wa = /<script|<style|<link/i,
      xa = /checked\s*(?:[^=]|=\s*.checked.)/i,
      ya = /^true\/(.*)/,
      za = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
      Aa = ca(d),
      Ba = Aa.appendChild(d.createElement("div"));

   function Ca(a, b) {
      return n.nodeName(a, "table") && n.nodeName(11 !== b.nodeType ? b : b.firstChild, "tr") ? a.getElementsByTagName("tbody")[0] || a.appendChild(a.ownerDocument.createElement("tbody")) : a
   }

   function Da(a) {
      return a.type = (null !== n.find.attr(a, "type")) + "/" + a.type, a
   }

   function Ea(a) {
      var b = ya.exec(a.type);
      return b ? a.type = b[1] : a.removeAttribute("type"), a
   }

   function Fa(a, b) {
      if (1 === b.nodeType && n.hasData(a)) {
         var c, d, e, f = n._data(a),
            g = n._data(b, f),
            h = f.events;
         if (h) {
            delete g.handle, g.events = {};
            for (c in h)
               for (d = 0, e = h[c].length; e > d; d++) n.event.add(b, c, h[c][d])
         }
         g.data && (g.data = n.extend({}, g.data))
      }
   }

   function Ga(a, b) {
      var c, d, e;
      if (1 === b.nodeType) {
         if (c = b.nodeName.toLowerCase(), !l.noCloneEvent && b[n.expando]) {
            e = n._data(b);
            for (d in e.events) n.removeEvent(b, d, e.handle);
            b.removeAttribute(n.expando)
         }
         "script" === c && b.text !== a.text ? (Da(b).text = a.text, Ea(b)) : "object" === c ? (b.parentNode && (b.outerHTML = a.outerHTML), l.html5Clone && a.innerHTML && !n.trim(b.innerHTML) && (b.innerHTML = a.innerHTML)) : "input" === c && Z.test(a.type) ? (b.defaultChecked = b.checked = a.checked, b.value !== a.value && (b.value = a.value)) : "option" === c ? b.defaultSelected = b.selected = a.defaultSelected : "input" !== c && "textarea" !== c || (b.defaultValue = a.defaultValue)
      }
   }

   function Ha(a, b, c, d) {
      b = f.apply([], b);
      var e, g, h, i, j, k, m = 0,
         o = a.length,
         p = o - 1,
         q = b[0],
         r = n.isFunction(q);
      if (r || o > 1 && "string" == typeof q && !l.checkClone && xa.test(q)) return a.each(function (e) {
         var f = a.eq(e);
         r && (b[0] = q.call(this, e, f.html())), Ha(f, b, c, d)
      });
      if (o && (k = ja(b, a[0].ownerDocument, !1, a, d), e = k.firstChild, 1 === k.childNodes.length && (k = e), e || d)) {
         for (i = n.map(ea(k, "script"), Da), h = i.length; o > m; m++) g = k, m !== p && (g = n.clone(g, !0, !0), h && n.merge(i, ea(g, "script"))), c.call(a[m], g, m);
         if (h)
            for (j = i[i.length - 1].ownerDocument, n.map(i, Ea), m = 0; h > m; m++) g = i[m], _.test(g.type || "") && !n._data(g, "globalEval") && n.contains(j, g) && (g.src ? n._evalUrl && n._evalUrl(g.src) : n.globalEval((g.text || g.textContent || g.innerHTML || "").replace(za, "")));
         k = e = null
      }
      return a
   }

   function Ia(a, b, c) {
      for (var d, e = b ? n.filter(b, a) : a, f = 0; null != (d = e[f]); f++) c || 1 !== d.nodeType || n.cleanData(ea(d)), d.parentNode && (c && n.contains(d.ownerDocument, d) && fa(ea(d, "script")), d.parentNode.removeChild(d));
      return a
   }
   n.extend({
      htmlPrefilter: function (a) {
         return a.replace(va, "<$1></$2>")
      },
      clone: function (a, b, c) {
         var d, e, f, g, h, i = n.contains(a.ownerDocument, a);
         if (l.html5Clone || n.isXMLDoc(a) || !ua.test("<" + a.nodeName + ">") ? f = a.cloneNode(!0) : (Ba.innerHTML = a.outerHTML, Ba.removeChild(f = Ba.firstChild)), !(l.noCloneEvent && l.noCloneChecked || 1 !== a.nodeType && 11 !== a.nodeType || n.isXMLDoc(a)))
            for (d = ea(f), h = ea(a), g = 0; null != (e = h[g]); ++g) d[g] && Ga(e, d[g]);
         if (b)
            if (c)
               for (h = h || ea(a), d = d || ea(f), g = 0; null != (e = h[g]); g++) Fa(e, d[g]);
            else Fa(a, f);
         return d = ea(f, "script"), d.length > 0 && fa(d, !i && ea(a, "script")), d = h = e = null, f
      },
      cleanData: function (a, b) {
         for (var d, e, f, g, h = 0, i = n.expando, j = n.cache, k = l.attributes, m = n.event.special; null != (d = a[h]); h++)
            if ((b || M(d)) && (f = d[i], g = f && j[f])) {
               if (g.events)
                  for (e in g.events) m[e] ? n.event.remove(d, e) : n.removeEvent(d, e, g.handle);
               j[f] && (delete j[f], k || "undefined" == typeof d.removeAttribute ? d[i] = void 0 : d.removeAttribute(i), c.push(f))
            }
      }
   }), n.fn.extend({
      domManip: Ha,
      detach: function (a) {
         return Ia(this, a, !0)
      },
      remove: function (a) {
         return Ia(this, a)
      },
      text: function (a) {
         return Y(this, function (a) {
            return void 0 === a ? n.text(this) : this.empty().append((this[0] && this[0].ownerDocument || d).createTextNode(a))
         }, null, a, arguments.length)
      },
      append: function () {
         return Ha(this, arguments, function (a) {
            if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
               var b = Ca(this, a);
               b.appendChild(a)
            }
         })
      },
      prepend: function () {
         return Ha(this, arguments, function (a) {
            if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
               var b = Ca(this, a);
               b.insertBefore(a, b.firstChild)
            }
         })
      },
      before: function () {
         return Ha(this, arguments, function (a) {
            this.parentNode && this.parentNode.insertBefore(a, this)
         })
      },
      after: function () {
         return Ha(this, arguments, function (a) {
            this.parentNode && this.parentNode.insertBefore(a, this.nextSibling)
         })
      },
      empty: function () {
         for (var a, b = 0; null != (a = this[b]); b++) {
            1 === a.nodeType && n.cleanData(ea(a, !1));
            while (a.firstChild) a.removeChild(a.firstChild);
            a.options && n.nodeName(a, "select") && (a.options.length = 0)
         }
         return this
      },
      clone: function (a, b) {
         return a = null == a ? !1 : a, b = null == b ? a : b, this.map(function () {
            return n.clone(this, a, b)
         })
      },
      html: function (a) {
         return Y(this, function (a) {
            var b = this[0] || {},
               c = 0,
               d = this.length;
            if (void 0 === a) return 1 === b.nodeType ? b.innerHTML.replace(ta, "") : void 0;
            if ("string" == typeof a && !wa.test(a) && (l.htmlSerialize || !ua.test(a)) && (l.leadingWhitespace || !aa.test(a)) && !da[($.exec(a) || ["", ""])[1].toLowerCase()]) {
               a = n.htmlPrefilter(a);
               try {
                  for (; d > c; c++) b = this[c] || {}, 1 === b.nodeType && (n.cleanData(ea(b, !1)), b.innerHTML = a);
                  b = 0
               } catch (e) {}
            }
            b && this.empty().append(a)
         }, null, a, arguments.length)
      },
      replaceWith: function () {
         var a = [];
         return Ha(this, arguments, function (b) {
            var c = this.parentNode;
            n.inArray(this, a) < 0 && (n.cleanData(ea(this)), c && c.replaceChild(b, this))
         }, a)
      }
   }), n.each({
      appendTo: "append",
      prependTo: "prepend",
      insertBefore: "before",
      insertAfter: "after",
      replaceAll: "replaceWith"
   }, function (a, b) {
      n.fn[a] = function (a) {
         for (var c, d = 0, e = [], f = n(a), h = f.length - 1; h >= d; d++) c = d === h ? this : this.clone(!0), n(f[d])[b](c), g.apply(e, c.get());
         return this.pushStack(e)
      }
   });
   var Ja, Ka = {
      HTML: "block",
      BODY: "block"
   };

   function La(a, b) {
      var c = n(b.createElement(a)).appendTo(b.body),
         d = n.css(c[0], "display");
      return c.detach(), d
   }

   function Ma(a) {
      var b = d,
         c = Ka[a];
      return c || (c = La(a, b), "none" !== c && c || (Ja = (Ja || n("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement), b = (Ja[0].contentWindow || Ja[0].contentDocument).document, b.write(), b.close(), c = La(a, b), Ja.detach()), Ka[a] = c), c
   }
   var Na = /^margin/,
      Oa = new RegExp("^(" + T + ")(?!px)[a-z%]+$", "i"),
      Pa = function (a, b, c, d) {
         var e, f, g = {};
         for (f in b) g[f] = a.style[f], a.style[f] = b[f];
         e = c.apply(a, d || []);
         for (f in b) a.style[f] = g[f];
         return e
      },
      Qa = d.documentElement;
   ! function () {
      var b, c, e, f, g, h, i = d.createElement("div"),
         j = d.createElement("div");
      if (j.style) {
         j.style.cssText = "float:left;opacity:.5", l.opacity = "0.5" === j.style.opacity, l.cssFloat = !!j.style.cssFloat, j.style.backgroundClip = "content-box", j.cloneNode(!0).style.backgroundClip = "", l.clearCloneStyle = "content-box" === j.style.backgroundClip, i = d.createElement("div"), i.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", j.innerHTML = "", i.appendChild(j), l.boxSizing = "" === j.style.boxSizing || "" === j.style.MozBoxSizing || "" === j.style.WebkitBoxSizing, n.extend(l, {
            reliableHiddenOffsets: function () {
               return null == b && k(), f
            },
            boxSizingReliable: function () {
               return null == b && k(), e
            },
            pixelMarginRight: function () {
               return null == b && k(), c
            },
            pixelPosition: function () {
               return null == b && k(), b
            },
            reliableMarginRight: function () {
               return null == b && k(), g
            },
            reliableMarginLeft: function () {
               return null == b && k(), h
            }
         });

         function k() {
            var k, l, m = d.documentElement;
            m.appendChild(i), j.style.cssText = "-webkit-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", b = e = h = !1, c = g = !0, a.getComputedStyle && (l = a.getComputedStyle(j), b = "1%" !== (l || {}).top, h = "2px" === (l || {}).marginLeft, e = "4px" === (l || {
               width: "4px"
            }).width, j.style.marginRight = "50%", c = "4px" === (l || {
               marginRight: "4px"
            }).marginRight, k = j.appendChild(d.createElement("div")), k.style.cssText = j.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", k.style.marginRight = k.style.width = "0", j.style.width = "1px", g = !parseFloat((a.getComputedStyle(k) || {}).marginRight), j.removeChild(k)), j.style.display = "none", f = 0 === j.getClientRects().length, f && (j.style.display = "", j.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", j.childNodes[0].style.borderCollapse = "separate", k = j.getElementsByTagName("td"), k[0].style.cssText = "margin:0;border:0;padding:0;display:none", f = 0 === k[0].offsetHeight, f && (k[0].style.display = "", k[1].style.display = "none", f = 0 === k[0].offsetHeight)), m.removeChild(i)
         }
      }
   }();
   var Ra, Sa, Ta = /^(top|right|bottom|left)$/;
   a.getComputedStyle ? (Ra = function (b) {
      var c = b.ownerDocument.defaultView;
      return c && c.opener || (c = a), c.getComputedStyle(b)
   }, Sa = function (a, b, c) {
      var d, e, f, g, h = a.style;
      return c = c || Ra(a), g = c ? c.getPropertyValue(b) || c[b] : void 0, "" !== g && void 0 !== g || n.contains(a.ownerDocument, a) || (g = n.style(a, b)), c && !l.pixelMarginRight() && Oa.test(g) && Na.test(b) && (d = h.width, e = h.minWidth, f = h.maxWidth, h.minWidth = h.maxWidth = h.width = g, g = c.width, h.width = d, h.minWidth = e, h.maxWidth = f), void 0 === g ? g : g + ""
   }) : Qa.currentStyle && (Ra = function (a) {
      return a.currentStyle
   }, Sa = function (a, b, c) {
      var d, e, f, g, h = a.style;
      return c = c || Ra(a), g = c ? c[b] : void 0, null == g && h && h[b] && (g = h[b]), Oa.test(g) && !Ta.test(b) && (d = h.left, e = a.runtimeStyle, f = e && e.left, f && (e.left = a.currentStyle.left), h.left = "fontSize" === b ? "1em" : g, g = h.pixelLeft + "px", h.left = d, f && (e.left = f)), void 0 === g ? g : g + "" || "auto"
   });

   function Ua(a, b) {
      return {
         get: function () {
            return a() ? void delete this.get : (this.get = b).apply(this, arguments)
         }
      }
   }
   var Va = /alpha\([^)]*\)/i,
      Wa = /opacity\s*=\s*([^)]*)/i,
      Xa = /^(none|table(?!-c[ea]).+)/,
      Ya = new RegExp("^(" + T + ")(.*)$", "i"),
      Za = {
         position: "absolute",
         visibility: "hidden",
         display: "block"
      },
      $a = {
         letterSpacing: "0",
         fontWeight: "400"
      },
      _a = ["Webkit", "O", "Moz", "ms"],
      ab = d.createElement("div").style;

   function bb(a) {
      if (a in ab) return a;
      var b = a.charAt(0).toUpperCase() + a.slice(1),
         c = _a.length;
      while (c--)
         if (a = _a[c] + b, a in ab) return a
   }

   function cb(a, b) {
      for (var c, d, e, f = [], g = 0, h = a.length; h > g; g++) d = a[g], d.style && (f[g] = n._data(d, "olddisplay"), c = d.style.display, b ? (f[g] || "none" !== c || (d.style.display = ""), "" === d.style.display && W(d) && (f[g] = n._data(d, "olddisplay", Ma(d.nodeName)))) : (e = W(d), (c && "none" !== c || !e) && n._data(d, "olddisplay", e ? c : n.css(d, "display"))));
      for (g = 0; h > g; g++) d = a[g], d.style && (b && "none" !== d.style.display && "" !== d.style.display || (d.style.display = b ? f[g] || "" : "none"));
      return a
   }

   function db(a, b, c) {
      var d = Ya.exec(b);
      return d ? Math.max(0, d[1] - (c || 0)) + (d[2] || "px") : b
   }

   function eb(a, b, c, d, e) {
      for (var f = c === (d ? "border" : "content") ? 4 : "width" === b ? 1 : 0, g = 0; 4 > f; f += 2) "margin" === c && (g += n.css(a, c + V[f], !0, e)), d ? ("content" === c && (g -= n.css(a, "padding" + V[f], !0, e)), "margin" !== c && (g -= n.css(a, "border" + V[f] + "Width", !0, e))) : (g += n.css(a, "padding" + V[f], !0, e), "padding" !== c && (g += n.css(a, "border" + V[f] + "Width", !0, e)));
      return g
   }

   function fb(a, b, c) {
      var d = !0,
         e = "width" === b ? a.offsetWidth : a.offsetHeight,
         f = Ra(a),
         g = l.boxSizing && "border-box" === n.css(a, "boxSizing", !1, f);
      if (0 >= e || null == e) {
         if (e = Sa(a, b, f), (0 > e || null == e) && (e = a.style[b]), Oa.test(e)) return e;
         d = g && (l.boxSizingReliable() || e === a.style[b]), e = parseFloat(e) || 0
      }
      return e + eb(a, b, c || (g ? "border" : "content"), d, f) + "px"
   }
   n.extend({
      cssHooks: {
         opacity: {
            get: function (a, b) {
               if (b) {
                  var c = Sa(a, "opacity");
                  return "" === c ? "1" : c
               }
            }
         }
      },
      cssNumber: {
         animationIterationCount: !0,
         columnCount: !0,
         fillOpacity: !0,
         flexGrow: !0,
         flexShrink: !0,
         fontWeight: !0,
         lineHeight: !0,
         opacity: !0,
         order: !0,
         orphans: !0,
         widows: !0,
         zIndex: !0,
         zoom: !0
      },
      cssProps: {
         "float": l.cssFloat ? "cssFloat" : "styleFloat"
      },
      style: function (a, b, c, d) {
         if (a && 3 !== a.nodeType && 8 !== a.nodeType && a.style) {
            var e, f, g, h = n.camelCase(b),
               i = a.style;
            if (b = n.cssProps[h] || (n.cssProps[h] = bb(h) || h), g = n.cssHooks[b] || n.cssHooks[h], void 0 === c) return g && "get" in g && void 0 !== (e = g.get(a, !1, d)) ? e : i[b];
            if (f = typeof c, "string" === f && (e = U.exec(c)) && e[1] && (c = X(a, b, e), f = "number"), null != c && c === c && ("number" === f && (c += e && e[3] || (n.cssNumber[h] ? "" : "px")), l.clearCloneStyle || "" !== c || 0 !== b.indexOf("background") || (i[b] = "inherit"), !(g && "set" in g && void 0 === (c = g.set(a, c, d))))) try {
               i[b] = c
            } catch (j) {}
         }
      },
      css: function (a, b, c, d) {
         var e, f, g, h = n.camelCase(b);
         return b = n.cssProps[h] || (n.cssProps[h] = bb(h) || h), g = n.cssHooks[b] || n.cssHooks[h], g && "get" in g && (f = g.get(a, !0, c)), void 0 === f && (f = Sa(a, b, d)), "normal" === f && b in $a && (f = $a[b]), "" === c || c ? (e = parseFloat(f), c === !0 || isFinite(e) ? e || 0 : f) : f
      }
   }), n.each(["height", "width"], function (a, b) {
      n.cssHooks[b] = {
         get: function (a, c, d) {
            return c ? Xa.test(n.css(a, "display")) && 0 === a.offsetWidth ? Pa(a, Za, function () {
               return fb(a, b, d)
            }) : fb(a, b, d) : void 0
         },
         set: function (a, c, d) {
            var e = d && Ra(a);
            return db(a, c, d ? eb(a, b, d, l.boxSizing && "border-box" === n.css(a, "boxSizing", !1, e), e) : 0)
         }
      }
   }), l.opacity || (n.cssHooks.opacity = {
      get: function (a, b) {
         return Wa.test((b && a.currentStyle ? a.currentStyle.filter : a.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : b ? "1" : ""
      },
      set: function (a, b) {
         var c = a.style,
            d = a.currentStyle,
            e = n.isNumeric(b) ? "alpha(opacity=" + 100 * b + ")" : "",
            f = d && d.filter || c.filter || "";
         c.zoom = 1, (b >= 1 || "" === b) && "" === n.trim(f.replace(Va, "")) && c.removeAttribute && (c.removeAttribute("filter"), "" === b || d && !d.filter) || (c.filter = Va.test(f) ? f.replace(Va, e) : f + " " + e)
      }
   }), n.cssHooks.marginRight = Ua(l.reliableMarginRight, function (a, b) {
      return b ? Pa(a, {
         display: "inline-block"
      }, Sa, [a, "marginRight"]) : void 0
   }), n.cssHooks.marginLeft = Ua(l.reliableMarginLeft, function (a, b) {
      return b ? (parseFloat(Sa(a, "marginLeft")) || (n.contains(a.ownerDocument, a) ? a.getBoundingClientRect().left - Pa(a, {
         marginLeft: 0
      }, function () {
         return a.getBoundingClientRect().left
      }) : 0)) + "px" : void 0
   }), n.each({
      margin: "",
      padding: "",
      border: "Width"
   }, function (a, b) {
      n.cssHooks[a + b] = {
         expand: function (c) {
            for (var d = 0, e = {}, f = "string" == typeof c ? c.split(" ") : [c]; 4 > d; d++) e[a + V[d] + b] = f[d] || f[d - 2] || f[0];
            return e
         }
      }, Na.test(a) || (n.cssHooks[a + b].set = db)
   }), n.fn.extend({
      css: function (a, b) {
         return Y(this, function (a, b, c) {
            var d, e, f = {},
               g = 0;
            if (n.isArray(b)) {
               for (d = Ra(a), e = b.length; e > g; g++) f[b[g]] = n.css(a, b[g], !1, d);
               return f
            }
            return void 0 !== c ? n.style(a, b, c) : n.css(a, b)
         }, a, b, arguments.length > 1)
      },
      show: function () {
         return cb(this, !0)
      },
      hide: function () {
         return cb(this)
      },
      toggle: function (a) {
         return "boolean" == typeof a ? a ? this.show() : this.hide() : this.each(function () {
            W(this) ? n(this).show() : n(this).hide()
         })
      }
   });

   function gb(a, b, c, d, e) {
      return new gb.prototype.init(a, b, c, d, e)
   }
   n.Tween = gb, gb.prototype = {
      constructor: gb,
      init: function (a, b, c, d, e, f) {
         this.elem = a, this.prop = c, this.easing = e || n.easing._default, this.options = b, this.start = this.now = this.cur(), this.end = d, this.unit = f || (n.cssNumber[c] ? "" : "px")
      },
      cur: function () {
         var a = gb.propHooks[this.prop];
         return a && a.get ? a.get(this) : gb.propHooks._default.get(this)
      },
      run: function (a) {
         var b, c = gb.propHooks[this.prop];
         return this.options.duration ? this.pos = b = n.easing[this.easing](a, this.options.duration * a, 0, 1, this.options.duration) : this.pos = b = a, this.now = (this.end - this.start) * b + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), c && c.set ? c.set(this) : gb.propHooks._default.set(this), this
      }
   }, gb.prototype.init.prototype = gb.prototype, gb.propHooks = {
      _default: {
         get: function (a) {
            var b;
            return 1 !== a.elem.nodeType || null != a.elem[a.prop] && null == a.elem.style[a.prop] ? a.elem[a.prop] : (b = n.css(a.elem, a.prop, ""), b && "auto" !== b ? b : 0)
         },
         set: function (a) {
            n.fx.step[a.prop] ? n.fx.step[a.prop](a) : 1 !== a.elem.nodeType || null == a.elem.style[n.cssProps[a.prop]] && !n.cssHooks[a.prop] ? a.elem[a.prop] = a.now : n.style(a.elem, a.prop, a.now + a.unit)
         }
      }
   }, gb.propHooks.scrollTop = gb.propHooks.scrollLeft = {
      set: function (a) {
         a.elem.nodeType && a.elem.parentNode && (a.elem[a.prop] = a.now)
      }
   }, n.easing = {
      linear: function (a) {
         return a
      },
      swing: function (a) {
         return .5 - Math.cos(a * Math.PI) / 2
      },
      _default: "swing"
   }, n.fx = gb.prototype.init, n.fx.step = {};
   var hb, ib, jb = /^(?:toggle|show|hide)$/,
      kb = /queueHooks$/;

   function lb() {
      return a.setTimeout(function () {
         hb = void 0
      }), hb = n.now()
   }

   function mb(a, b) {
      var c, d = {
            height: a
         },
         e = 0;
      for (b = b ? 1 : 0; 4 > e; e += 2 - b) c = V[e], d["margin" + c] = d["padding" + c] = a;
      return b && (d.opacity = d.width = a), d
   }

   function nb(a, b, c) {
      for (var d, e = (qb.tweeners[b] || []).concat(qb.tweeners["*"]), f = 0, g = e.length; g > f; f++)
         if (d = e[f].call(c, b, a)) return d
   }

   function ob(a, b, c) {
      var d, e, f, g, h, i, j, k, m = this,
         o = {},
         p = a.style,
         q = a.nodeType && W(a),
         r = n._data(a, "fxshow");
      c.queue || (h = n._queueHooks(a, "fx"), null == h.unqueued && (h.unqueued = 0, i = h.empty.fire, h.empty.fire = function () {
         h.unqueued || i()
      }), h.unqueued++, m.always(function () {
         m.always(function () {
            h.unqueued--, n.queue(a, "fx").length || h.empty.fire()
         })
      })), 1 === a.nodeType && ("height" in b || "width" in b) && (c.overflow = [p.overflow, p.overflowX, p.overflowY], j = n.css(a, "display"), k = "none" === j ? n._data(a, "olddisplay") || Ma(a.nodeName) : j, "inline" === k && "none" === n.css(a, "float") && (l.inlineBlockNeedsLayout && "inline" !== Ma(a.nodeName) ? p.zoom = 1 : p.display = "inline-block")), c.overflow && (p.overflow = "hidden", l.shrinkWrapBlocks() || m.always(function () {
         p.overflow = c.overflow[0], p.overflowX = c.overflow[1], p.overflowY = c.overflow[2]
      }));
      for (d in b)
         if (e = b[d], jb.exec(e)) {
            if (delete b[d], f = f || "toggle" === e, e === (q ? "hide" : "show")) {
               if ("show" !== e || !r || void 0 === r[d]) continue;
               q = !0
            }
            o[d] = r && r[d] || n.style(a, d)
         } else j = void 0;
      if (n.isEmptyObject(o)) "inline" === ("none" === j ? Ma(a.nodeName) : j) && (p.display = j);
      else {
         r ? "hidden" in r && (q = r.hidden) : r = n._data(a, "fxshow", {}), f && (r.hidden = !q), q ? n(a).show() : m.done(function () {
            n(a).hide()
         }), m.done(function () {
            var b;
            n._removeData(a, "fxshow");
            for (b in o) n.style(a, b, o[b])
         });
         for (d in o) g = nb(q ? r[d] : 0, d, m), d in r || (r[d] = g.start, q && (g.end = g.start, g.start = "width" === d || "height" === d ? 1 : 0))
      }
   }

   function pb(a, b) {
      var c, d, e, f, g;
      for (c in a)
         if (d = n.camelCase(c), e = b[d], f = a[c], n.isArray(f) && (e = f[1], f = a[c] = f[0]), c !== d && (a[d] = f, delete a[c]), g = n.cssHooks[d], g && "expand" in g) {
            f = g.expand(f), delete a[d];
            for (c in f) c in a || (a[c] = f[c], b[c] = e)
         } else b[d] = e
   }

   function qb(a, b, c) {
      var d, e, f = 0,
         g = qb.prefilters.length,
         h = n.Deferred().always(function () {
            delete i.elem
         }),
         i = function () {
            if (e) return !1;
            for (var b = hb || lb(), c = Math.max(0, j.startTime + j.duration - b), d = c / j.duration || 0, f = 1 - d, g = 0, i = j.tweens.length; i > g; g++) j.tweens[g].run(f);
            return h.notifyWith(a, [j, f, c]), 1 > f && i ? c : (h.resolveWith(a, [j]), !1)
         },
         j = h.promise({
            elem: a,
            props: n.extend({}, b),
            opts: n.extend(!0, {
               specialEasing: {},
               easing: n.easing._default
            }, c),
            originalProperties: b,
            originalOptions: c,
            startTime: hb || lb(),
            duration: c.duration,
            tweens: [],
            createTween: function (b, c) {
               var d = n.Tween(a, j.opts, b, c, j.opts.specialEasing[b] || j.opts.easing);
               return j.tweens.push(d), d
            },
            stop: function (b) {
               var c = 0,
                  d = b ? j.tweens.length : 0;
               if (e) return this;
               for (e = !0; d > c; c++) j.tweens[c].run(1);
               return b ? (h.notifyWith(a, [j, 1, 0]), h.resolveWith(a, [j, b])) : h.rejectWith(a, [j, b]), this
            }
         }),
         k = j.props;
      for (pb(k, j.opts.specialEasing); g > f; f++)
         if (d = qb.prefilters[f].call(j, a, k, j.opts)) return n.isFunction(d.stop) && (n._queueHooks(j.elem, j.opts.queue).stop = n.proxy(d.stop, d)), d;
      return n.map(k, nb, j), n.isFunction(j.opts.start) && j.opts.start.call(a, j), n.fx.timer(n.extend(i, {
         elem: a,
         anim: j,
         queue: j.opts.queue
      })), j.progress(j.opts.progress).done(j.opts.done, j.opts.complete).fail(j.opts.fail).always(j.opts.always)
   }
   n.Animation = n.extend(qb, {
         tweeners: {
            "*": [function (a, b) {
               var c = this.createTween(a, b);
               return X(c.elem, a, U.exec(b), c), c
            }]
         },
         tweener: function (a, b) {
            n.isFunction(a) ? (b = a, a = ["*"]) : a = a.match(G);
            for (var c, d = 0, e = a.length; e > d; d++) c = a[d], qb.tweeners[c] = qb.tweeners[c] || [], qb.tweeners[c].unshift(b)
         },
         prefilters: [ob],
         prefilter: function (a, b) {
            b ? qb.prefilters.unshift(a) : qb.prefilters.push(a)
         }
      }), n.speed = function (a, b, c) {
         var d = a && "object" == typeof a ? n.extend({}, a) : {
            complete: c || !c && b || n.isFunction(a) && a,
            duration: a,
            easing: c && b || b && !n.isFunction(b) && b
         };
         return d.duration = n.fx.off ? 0 : "number" == typeof d.duration ? d.duration : d.duration in n.fx.speeds ? n.fx.speeds[d.duration] : n.fx.speeds._default, null != d.queue && d.queue !== !0 || (d.queue = "fx"), d.old = d.complete, d.complete = function () {
            n.isFunction(d.old) && d.old.call(this), d.queue && n.dequeue(this, d.queue)
         }, d
      }, n.fn.extend({
         fadeTo: function (a, b, c, d) {
            return this.filter(W).css("opacity", 0).show().end().animate({
               opacity: b
            }, a, c, d)
         },
         animate: function (a, b, c, d) {
            var e = n.isEmptyObject(a),
               f = n.speed(b, c, d),
               g = function () {
                  var b = qb(this, n.extend({}, a), f);
                  (e || n._data(this, "finish")) && b.stop(!0)
               };
            return g.finish = g, e || f.queue === !1 ? this.each(g) : this.queue(f.queue, g)
         },
         stop: function (a, b, c) {
            var d = function (a) {
               var b = a.stop;
               delete a.stop, b(c)
            };
            return "string" != typeof a && (c = b, b = a, a = void 0), b && a !== !1 && this.queue(a || "fx", []), this.each(function () {
               var b = !0,
                  e = null != a && a + "queueHooks",
                  f = n.timers,
                  g = n._data(this);
               if (e) g[e] && g[e].stop && d(g[e]);
               else
                  for (e in g) g[e] && g[e].stop && kb.test(e) && d(g[e]);
               for (e = f.length; e--;) f[e].elem !== this || null != a && f[e].queue !== a || (f[e].anim.stop(c), b = !1, f.splice(e, 1));
               !b && c || n.dequeue(this, a)
            })
         },
         finish: function (a) {
            return a !== !1 && (a = a || "fx"), this.each(function () {
               var b, c = n._data(this),
                  d = c[a + "queue"],
                  e = c[a + "queueHooks"],
                  f = n.timers,
                  g = d ? d.length : 0;
               for (c.finish = !0, n.queue(this, a, []), e && e.stop && e.stop.call(this, !0), b = f.length; b--;) f[b].elem === this && f[b].queue === a && (f[b].anim.stop(!0), f.splice(b, 1));
               for (b = 0; g > b; b++) d[b] && d[b].finish && d[b].finish.call(this);
               delete c.finish
            })
         }
      }), n.each(["toggle", "show", "hide"], function (a, b) {
         var c = n.fn[b];
         n.fn[b] = function (a, d, e) {
            return null == a || "boolean" == typeof a ? c.apply(this, arguments) : this.animate(mb(b, !0), a, d, e)
         }
      }), n.each({
         slideDown: mb("show"),
         slideUp: mb("hide"),
         slideToggle: mb("toggle"),
         fadeIn: {
            opacity: "show"
         },
         fadeOut: {
            opacity: "hide"
         },
         fadeToggle: {
            opacity: "toggle"
         }
      }, function (a, b) {
         n.fn[a] = function (a, c, d) {
            return this.animate(b, a, c, d)
         }
      }), n.timers = [], n.fx.tick = function () {
         var a, b = n.timers,
            c = 0;
         for (hb = n.now(); c < b.length; c++) a = b[c], a() || b[c] !== a || b.splice(c--, 1);
         b.length || n.fx.stop(), hb = void 0
      }, n.fx.timer = function (a) {
         n.timers.push(a), a() ? n.fx.start() : n.timers.pop()
      }, n.fx.interval = 13, n.fx.start = function () {
         ib || (ib = a.setInterval(n.fx.tick, n.fx.interval))
      }, n.fx.stop = function () {
         a.clearInterval(ib), ib = null
      }, n.fx.speeds = {
         slow: 600,
         fast: 200,
         _default: 400
      }, n.fn.delay = function (b, c) {
         return b = n.fx ? n.fx.speeds[b] || b : b, c = c || "fx", this.queue(c, function (c, d) {
            var e = a.setTimeout(c, b);
            d.stop = function () {
               a.clearTimeout(e)
            }
         })
      },
      function () {
         var a, b = d.createElement("input"),
            c = d.createElement("div"),
            e = d.createElement("select"),
            f = e.appendChild(d.createElement("option"));
         c = d.createElement("div"), c.setAttribute("className", "t"), c.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", a = c.getElementsByTagName("a")[0], b.setAttribute("type", "checkbox"), c.appendChild(b), a = c.getElementsByTagName("a")[0], a.style.cssText = "top:1px", l.getSetAttribute = "t" !== c.className, l.style = /top/.test(a.getAttribute("style")), l.hrefNormalized = "/a" === a.getAttribute("href"), l.checkOn = !!b.value, l.optSelected = f.selected, l.enctype = !!d.createElement("form").enctype, e.disabled = !0, l.optDisabled = !f.disabled, b = d.createElement("input"), b.setAttribute("value", ""), l.input = "" === b.getAttribute("value"), b.value = "t", b.setAttribute("type", "radio"), l.radioValue = "t" === b.value
      }();
   var rb = /\r/g,
      sb = /[\x20\t\r\n\f]+/g;
   n.fn.extend({
      val: function (a) {
         var b, c, d, e = this[0]; {
            if (arguments.length) return d = n.isFunction(a), this.each(function (c) {
               var e;
               1 === this.nodeType && (e = d ? a.call(this, c, n(this).val()) : a, null == e ? e = "" : "number" == typeof e ? e += "" : n.isArray(e) && (e = n.map(e, function (a) {
                  return null == a ? "" : a + ""
               })), b = n.valHooks[this.type] || n.valHooks[this.nodeName.toLowerCase()], b && "set" in b && void 0 !== b.set(this, e, "value") || (this.value = e))
            });
            if (e) return b = n.valHooks[e.type] || n.valHooks[e.nodeName.toLowerCase()], b && "get" in b && void 0 !== (c = b.get(e, "value")) ? c : (c = e.value, "string" == typeof c ? c.replace(rb, "") : null == c ? "" : c)
         }
      }
   }), n.extend({
      valHooks: {
         option: {
            get: function (a) {
               var b = n.find.attr(a, "value");
               return null != b ? b : n.trim(n.text(a)).replace(sb, " ")
            }
         },
         select: {
            get: function (a) {
               for (var b, c, d = a.options, e = a.selectedIndex, f = "select-one" === a.type || 0 > e, g = f ? null : [], h = f ? e + 1 : d.length, i = 0 > e ? h : f ? e : 0; h > i; i++)
                  if (c = d[i], (c.selected || i === e) && (l.optDisabled ? !c.disabled : null === c.getAttribute("disabled")) && (!c.parentNode.disabled || !n.nodeName(c.parentNode, "optgroup"))) {
                     if (b = n(c).val(), f) return b;
                     g.push(b)
                  }
               return g
            },
            set: function (a, b) {
               var c, d, e = a.options,
                  f = n.makeArray(b),
                  g = e.length;
               while (g--)
                  if (d = e[g], n.inArray(n.valHooks.option.get(d), f) > -1) try {
                     d.selected = c = !0
                  } catch (h) {
                     d.scrollHeight
                  } else d.selected = !1;
               return c || (a.selectedIndex = -1), e
            }
         }
      }
   }), n.each(["radio", "checkbox"], function () {
      n.valHooks[this] = {
         set: function (a, b) {
            return n.isArray(b) ? a.checked = n.inArray(n(a).val(), b) > -1 : void 0
         }
      }, l.checkOn || (n.valHooks[this].get = function (a) {
         return null === a.getAttribute("value") ? "on" : a.value
      })
   });
   var tb, ub, vb = n.expr.attrHandle,
      wb = /^(?:checked|selected)$/i,
      xb = l.getSetAttribute,
      yb = l.input;
   n.fn.extend({
      attr: function (a, b) {
         return Y(this, n.attr, a, b, arguments.length > 1)
      },
      removeAttr: function (a) {
         return this.each(function () {
            n.removeAttr(this, a)
         })
      }
   }), n.extend({
      attr: function (a, b, c) {
         var d, e, f = a.nodeType;
         if (3 !== f && 8 !== f && 2 !== f) return "undefined" == typeof a.getAttribute ? n.prop(a, b, c) : (1 === f && n.isXMLDoc(a) || (b = b.toLowerCase(), e = n.attrHooks[b] || (n.expr.match.bool.test(b) ? ub : tb)), void 0 !== c ? null === c ? void n.removeAttr(a, b) : e && "set" in e && void 0 !== (d = e.set(a, c, b)) ? d : (a.setAttribute(b, c + ""), c) : e && "get" in e && null !== (d = e.get(a, b)) ? d : (d = n.find.attr(a, b), null == d ? void 0 : d))
      },
      attrHooks: {
         type: {
            set: function (a, b) {
               if (!l.radioValue && "radio" === b && n.nodeName(a, "input")) {
                  var c = a.value;
                  return a.setAttribute("type", b), c && (a.value = c), b
               }
            }
         }
      },
      removeAttr: function (a, b) {
         var c, d, e = 0,
            f = b && b.match(G);
         if (f && 1 === a.nodeType)
            while (c = f[e++]) d = n.propFix[c] || c, n.expr.match.bool.test(c) ? yb && xb || !wb.test(c) ? a[d] = !1 : a[n.camelCase("default-" + c)] = a[d] = !1 : n.attr(a, c, ""), a.removeAttribute(xb ? c : d)
      }
   }), ub = {
      set: function (a, b, c) {
         return b === !1 ? n.removeAttr(a, c) : yb && xb || !wb.test(c) ? a.setAttribute(!xb && n.propFix[c] || c, c) : a[n.camelCase("default-" + c)] = a[c] = !0, c
      }
   }, n.each(n.expr.match.bool.source.match(/\w+/g), function (a, b) {
      var c = vb[b] || n.find.attr;
      yb && xb || !wb.test(b) ? vb[b] = function (a, b, d) {
         var e, f;
         return d || (f = vb[b], vb[b] = e, e = null != c(a, b, d) ? b.toLowerCase() : null, vb[b] = f), e
      } : vb[b] = function (a, b, c) {
         return c ? void 0 : a[n.camelCase("default-" + b)] ? b.toLowerCase() : null
      }
   }), yb && xb || (n.attrHooks.value = {
      set: function (a, b, c) {
         return n.nodeName(a, "input") ? void(a.defaultValue = b) : tb && tb.set(a, b, c)
      }
   }), xb || (tb = {
      set: function (a, b, c) {
         var d = a.getAttributeNode(c);
         return d || a.setAttributeNode(d = a.ownerDocument.createAttribute(c)), d.value = b += "", "value" === c || b === a.getAttribute(c) ? b : void 0
      }
   }, vb.id = vb.name = vb.coords = function (a, b, c) {
      var d;
      return c ? void 0 : (d = a.getAttributeNode(b)) && "" !== d.value ? d.value : null
   }, n.valHooks.button = {
      get: function (a, b) {
         var c = a.getAttributeNode(b);
         return c && c.specified ? c.value : void 0
      },
      set: tb.set
   }, n.attrHooks.contenteditable = {
      set: function (a, b, c) {
         tb.set(a, "" === b ? !1 : b, c)
      }
   }, n.each(["width", "height"], function (a, b) {
      n.attrHooks[b] = {
         set: function (a, c) {
            return "" === c ? (a.setAttribute(b, "auto"), c) : void 0
         }
      }
   })), l.style || (n.attrHooks.style = {
      get: function (a) {
         return a.style.cssText || void 0
      },
      set: function (a, b) {
         return a.style.cssText = b + ""
      }
   });
   var zb = /^(?:input|select|textarea|button|object)$/i,
      Ab = /^(?:a|area)$/i;
   n.fn.extend({
      prop: function (a, b) {
         return Y(this, n.prop, a, b, arguments.length > 1)
      },
      removeProp: function (a) {
         return a = n.propFix[a] || a, this.each(function () {
            try {
               this[a] = void 0, delete this[a]
            } catch (b) {}
         })
      }
   }), n.extend({
      prop: function (a, b, c) {
         var d, e, f = a.nodeType;
         if (3 !== f && 8 !== f && 2 !== f) return 1 === f && n.isXMLDoc(a) || (b = n.propFix[b] || b, e = n.propHooks[b]), void 0 !== c ? e && "set" in e && void 0 !== (d = e.set(a, c, b)) ? d : a[b] = c : e && "get" in e && null !== (d = e.get(a, b)) ? d : a[b]
      },
      propHooks: {
         tabIndex: {
            get: function (a) {
               var b = n.find.attr(a, "tabindex");
               return b ? parseInt(b, 10) : zb.test(a.nodeName) || Ab.test(a.nodeName) && a.href ? 0 : -1
            }
         }
      },
      propFix: {
         "for": "htmlFor",
         "class": "className"
      }
   }), l.hrefNormalized || n.each(["href", "src"], function (a, b) {
      n.propHooks[b] = {
         get: function (a) {
            return a.getAttribute(b, 4)
         }
      }
   }), l.optSelected || (n.propHooks.selected = {
      get: function (a) {
         var b = a.parentNode;
         return b && (b.selectedIndex, b.parentNode && b.parentNode.selectedIndex), null
      },
      set: function (a) {
         var b = a.parentNode;
         b && (b.selectedIndex, b.parentNode && b.parentNode.selectedIndex)
      }
   }), n.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
      n.propFix[this.toLowerCase()] = this
   }), l.enctype || (n.propFix.enctype = "encoding");
   var Bb = /[\t\r\n\f]/g;

   function Cb(a) {
      return n.attr(a, "class") || ""
   }
   n.fn.extend({
      addClass: function (a) {
         var b, c, d, e, f, g, h, i = 0;
         if (n.isFunction(a)) return this.each(function (b) {
            n(this).addClass(a.call(this, b, Cb(this)))
         });
         if ("string" == typeof a && a) {
            b = a.match(G) || [];
            while (c = this[i++])
               if (e = Cb(c), d = 1 === c.nodeType && (" " + e + " ").replace(Bb, " ")) {
                  g = 0;
                  while (f = b[g++]) d.indexOf(" " + f + " ") < 0 && (d += f + " ");
                  h = n.trim(d), e !== h && n.attr(c, "class", h)
               }
         }
         return this
      },
      removeClass: function (a) {
         var b, c, d, e, f, g, h, i = 0;
         if (n.isFunction(a)) return this.each(function (b) {
            n(this).removeClass(a.call(this, b, Cb(this)))
         });
         if (!arguments.length) return this.attr("class", "");
         if ("string" == typeof a && a) {
            b = a.match(G) || [];
            while (c = this[i++])
               if (e = Cb(c), d = 1 === c.nodeType && (" " + e + " ").replace(Bb, " ")) {
                  g = 0;
                  while (f = b[g++])
                     while (d.indexOf(" " + f + " ") > -1) d = d.replace(" " + f + " ", " ");
                  h = n.trim(d), e !== h && n.attr(c, "class", h)
               }
         }
         return this
      },
      toggleClass: function (a, b) {
         var c = typeof a;
         return "boolean" == typeof b && "string" === c ? b ? this.addClass(a) : this.removeClass(a) : n.isFunction(a) ? this.each(function (c) {
            n(this).toggleClass(a.call(this, c, Cb(this), b), b)
         }) : this.each(function () {
            var b, d, e, f;
            if ("string" === c) {
               d = 0, e = n(this), f = a.match(G) || [];
               while (b = f[d++]) e.hasClass(b) ? e.removeClass(b) : e.addClass(b)
            } else void 0 !== a && "boolean" !== c || (b = Cb(this), b && n._data(this, "__className__", b), n.attr(this, "class", b || a === !1 ? "" : n._data(this, "__className__") || ""))
         })
      },
      hasClass: function (a) {
         var b, c, d = 0;
         b = " " + a + " ";
         while (c = this[d++])
            if (1 === c.nodeType && (" " + Cb(c) + " ").replace(Bb, " ").indexOf(b) > -1) return !0;
         return !1
      }
   }), n.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (a, b) {
      n.fn[b] = function (a, c) {
         return arguments.length > 0 ? this.on(b, null, a, c) : this.trigger(b)
      }
   }), n.fn.extend({
      hover: function (a, b) {
         return this.mouseenter(a).mouseleave(b || a)
      }
   });
   var Db = a.location,
      Eb = n.now(),
      Fb = /\?/,
      Gb = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
   n.parseJSON = function (b) {
      if (a.JSON && a.JSON.parse) return a.JSON.parse(b + "");
      var c, d = null,
         e = n.trim(b + "");
      return e && !n.trim(e.replace(Gb, function (a, b, e, f) {
         return c && b && (d = 0), 0 === d ? a : (c = e || b, d += !f - !e, "")
      })) ? Function("return " + e)() : n.error("Invalid JSON: " + b)
   }, n.parseXML = function (b) {
      var c, d;
      if (!b || "string" != typeof b) return null;
      try {
         a.DOMParser ? (d = new a.DOMParser, c = d.parseFromString(b, "text/xml")) : (c = new a.ActiveXObject("Microsoft.XMLDOM"), c.async = "false", c.loadXML(b))
      } catch (e) {
         c = void 0
      }
      return c && c.documentElement && !c.getElementsByTagName("parsererror").length || n.error("Invalid XML: " + b), c
   };
   var Hb = /#.*$/,
      Ib = /([?&])_=[^&]*/,
      Jb = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm,
      Kb = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
      Lb = /^(?:GET|HEAD)$/,
      Mb = /^\/\//,
      Nb = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,
      Ob = {},
      Pb = {},
      Qb = "*/".concat("*"),
      Rb = Db.href,
      Sb = Nb.exec(Rb.toLowerCase()) || [];

   function Tb(a) {
      return function (b, c) {
         "string" != typeof b && (c = b, b = "*");
         var d, e = 0,
            f = b.toLowerCase().match(G) || [];
         if (n.isFunction(c))
            while (d = f[e++]) "+" === d.charAt(0) ? (d = d.slice(1) || "*", (a[d] = a[d] || []).unshift(c)) : (a[d] = a[d] || []).push(c)
      }
   }

   function Ub(a, b, c, d) {
      var e = {},
         f = a === Pb;

      function g(h) {
         var i;
         return e[h] = !0, n.each(a[h] || [], function (a, h) {
            var j = h(b, c, d);
            return "string" != typeof j || f || e[j] ? f ? !(i = j) : void 0 : (b.dataTypes.unshift(j), g(j), !1)
         }), i
      }
      return g(b.dataTypes[0]) || !e["*"] && g("*")
   }

   function Vb(a, b) {
      var c, d, e = n.ajaxSettings.flatOptions || {};
      for (d in b) void 0 !== b[d] && ((e[d] ? a : c || (c = {}))[d] = b[d]);
      return c && n.extend(!0, a, c), a
   }

   function Wb(a, b, c) {
      var d, e, f, g, h = a.contents,
         i = a.dataTypes;
      while ("*" === i[0]) i.shift(), void 0 === e && (e = a.mimeType || b.getResponseHeader("Content-Type"));
      if (e)
         for (g in h)
            if (h[g] && h[g].test(e)) {
               i.unshift(g);
               break
            }
      if (i[0] in c) f = i[0];
      else {
         for (g in c) {
            if (!i[0] || a.converters[g + " " + i[0]]) {
               f = g;
               break
            }
            d || (d = g)
         }
         f = f || d
      }
      return f ? (f !== i[0] && i.unshift(f), c[f]) : void 0
   }

   function Xb(a, b, c, d) {
      var e, f, g, h, i, j = {},
         k = a.dataTypes.slice();
      if (k[1])
         for (g in a.converters) j[g.toLowerCase()] = a.converters[g];
      f = k.shift();
      while (f)
         if (a.responseFields[f] && (c[a.responseFields[f]] = b), !i && d && a.dataFilter && (b = a.dataFilter(b, a.dataType)), i = f, f = k.shift())
            if ("*" === f) f = i;
            else if ("*" !== i && i !== f) {
         if (g = j[i + " " + f] || j["* " + f], !g)
            for (e in j)
               if (h = e.split(" "), h[1] === f && (g = j[i + " " + h[0]] || j["* " + h[0]])) {
                  g === !0 ? g = j[e] : j[e] !== !0 && (f = h[0], k.unshift(h[1]));
                  break
               }
         if (g !== !0)
            if (g && a["throws"]) b = g(b);
            else try {
               b = g(b)
            } catch (l) {
               return {
                  state: "parsererror",
                  error: g ? l : "No conversion from " + i + " to " + f
               }
            }
      }
      return {
         state: "success",
         data: b
      }
   }
   n.extend({
      active: 0,
      lastModified: {},
      etag: {},
      ajaxSettings: {
         url: Rb,
         type: "GET",
         isLocal: Kb.test(Sb[1]),
         global: !0,
         processData: !0,
         async: !0,
         contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         accepts: {
            "*": Qb,
            text: "text/plain",
            html: "text/html",
            xml: "application/xml, text/xml",
            json: "application/json, text/javascript"
         },
         contents: {
            xml: /\bxml\b/,
            html: /\bhtml/,
            json: /\bjson\b/
         },
         responseFields: {
            xml: "responseXML",
            text: "responseText",
            json: "responseJSON"
         },
         converters: {
            "* text": String,
            "text html": !0,
            "text json": n.parseJSON,
            "text xml": n.parseXML
         },
         flatOptions: {
            url: !0,
            context: !0
         }
      },
      ajaxSetup: function (a, b) {
         return b ? Vb(Vb(a, n.ajaxSettings), b) : Vb(n.ajaxSettings, a)
      },
      ajaxPrefilter: Tb(Ob),
      ajaxTransport: Tb(Pb),
      ajax: function (b, c) {
         "object" == typeof b && (c = b, b = void 0), c = c || {};
         var d, e, f, g, h, i, j, k, l = n.ajaxSetup({}, c),
            m = l.context || l,
            o = l.context && (m.nodeType || m.jquery) ? n(m) : n.event,
            p = n.Deferred(),
            q = n.Callbacks("once memory"),
            r = l.statusCode || {},
            s = {},
            t = {},
            u = 0,
            v = "canceled",
            w = {
               readyState: 0,
               getResponseHeader: function (a) {
                  var b;
                  if (2 === u) {
                     if (!k) {
                        k = {};
                        while (b = Jb.exec(g)) k[b[1].toLowerCase()] = b[2]
                     }
                     b = k[a.toLowerCase()]
                  }
                  return null == b ? null : b
               },
               getAllResponseHeaders: function () {
                  return 2 === u ? g : null
               },
               setRequestHeader: function (a, b) {
                  var c = a.toLowerCase();
                  return u || (a = t[c] = t[c] || a, s[a] = b), this
               },
               overrideMimeType: function (a) {
                  return u || (l.mimeType = a), this
               },
               statusCode: function (a) {
                  var b;
                  if (a)
                     if (2 > u)
                        for (b in a) r[b] = [r[b], a[b]];
                     else w.always(a[w.status]);
                  return this
               },
               abort: function (a) {
                  var b = a || v;
                  return j && j.abort(b), y(0, b), this
               }
            };
         if (p.promise(w).complete = q.add, w.success = w.done, w.error = w.fail, l.url = ((b || l.url || Rb) + "").replace(Hb, "").replace(Mb, Sb[1] + "//"), l.type = c.method || c.type || l.method || l.type, l.dataTypes = n.trim(l.dataType || "*").toLowerCase().match(G) || [""], null == l.crossDomain && (d = Nb.exec(l.url.toLowerCase()), l.crossDomain = !(!d || d[1] === Sb[1] && d[2] === Sb[2] && (d[3] || ("http:" === d[1] ? "80" : "443")) === (Sb[3] || ("http:" === Sb[1] ? "80" : "443")))), l.data && l.processData && "string" != typeof l.data && (l.data = n.param(l.data, l.traditional)), Ub(Ob, l, c, w), 2 === u) return w;
         i = n.event && l.global, i && 0 === n.active++ && n.event.trigger("ajaxStart"), l.type = l.type.toUpperCase(), l.hasContent = !Lb.test(l.type), f = l.url, l.hasContent || (l.data && (f = l.url += (Fb.test(f) ? "&" : "?") + l.data, delete l.data), l.cache === !1 && (l.url = Ib.test(f) ? f.replace(Ib, "$1_=" + Eb++) : f + (Fb.test(f) ? "&" : "?") + "_=" + Eb++)), l.ifModified && (n.lastModified[f] && w.setRequestHeader("If-Modified-Since", n.lastModified[f]), n.etag[f] && w.setRequestHeader("If-None-Match", n.etag[f])), (l.data && l.hasContent && l.contentType !== !1 || c.contentType) && w.setRequestHeader("Content-Type", l.contentType), w.setRequestHeader("Accept", l.dataTypes[0] && l.accepts[l.dataTypes[0]] ? l.accepts[l.dataTypes[0]] + ("*" !== l.dataTypes[0] ? ", " + Qb + "; q=0.01" : "") : l.accepts["*"]);
         for (e in l.headers) w.setRequestHeader(e, l.headers[e]);
         if (l.beforeSend && (l.beforeSend.call(m, w, l) === !1 || 2 === u)) return w.abort();
         v = "abort";
         for (e in {
               success: 1,
               error: 1,
               complete: 1
            }) w[e](l[e]);
         if (j = Ub(Pb, l, c, w)) {
            if (w.readyState = 1, i && o.trigger("ajaxSend", [w, l]), 2 === u) return w;
            l.async && l.timeout > 0 && (h = a.setTimeout(function () {
               w.abort("timeout")
            }, l.timeout));
            try {
               u = 1, j.send(s, y)
            } catch (x) {
               if (!(2 > u)) throw x;
               y(-1, x)
            }
         } else y(-1, "No Transport");

         function y(b, c, d, e) {
            var k, s, t, v, x, y = c;
            2 !== u && (u = 2, h && a.clearTimeout(h), j = void 0, g = e || "", w.readyState = b > 0 ? 4 : 0, k = b >= 200 && 300 > b || 304 === b, d && (v = Wb(l, w, d)), v = Xb(l, v, w, k), k ? (l.ifModified && (x = w.getResponseHeader("Last-Modified"), x && (n.lastModified[f] = x), x = w.getResponseHeader("etag"), x && (n.etag[f] = x)), 204 === b || "HEAD" === l.type ? y = "nocontent" : 304 === b ? y = "notmodified" : (y = v.state, s = v.data, t = v.error, k = !t)) : (t = y, !b && y || (y = "error", 0 > b && (b = 0))), w.status = b, w.statusText = (c || y) + "", k ? p.resolveWith(m, [s, y, w]) : p.rejectWith(m, [w, y, t]), w.statusCode(r), r = void 0, i && o.trigger(k ? "ajaxSuccess" : "ajaxError", [w, l, k ? s : t]), q.fireWith(m, [w, y]), i && (o.trigger("ajaxComplete", [w, l]), --n.active || n.event.trigger("ajaxStop")))
         }
         return w
      },
      getJSON: function (a, b, c) {
         return n.get(a, b, c, "json")
      },
      getScript: function (a, b) {
         return n.get(a, void 0, b, "script")
      }
   }), n.each(["get", "post"], function (a, b) {
      n[b] = function (a, c, d, e) {
         return n.isFunction(c) && (e = e || d, d = c, c = void 0), n.ajax(n.extend({
            url: a,
            type: b,
            dataType: e,
            data: c,
            success: d
         }, n.isPlainObject(a) && a))
      }
   }), n._evalUrl = function (a) {
      return n.ajax({
         url: a,
         type: "GET",
         dataType: "script",
         cache: !0,
         async: !1,
         global: !1,
         "throws": !0
      })
   }, n.fn.extend({
      wrapAll: function (a) {
         if (n.isFunction(a)) return this.each(function (b) {
            n(this).wrapAll(a.call(this, b))
         });
         if (this[0]) {
            var b = n(a, this[0].ownerDocument).eq(0).clone(!0);
            this[0].parentNode && b.insertBefore(this[0]), b.map(function () {
               var a = this;
               while (a.firstChild && 1 === a.firstChild.nodeType) a = a.firstChild;
               return a
            }).append(this)
         }
         return this
      },
      wrapInner: function (a) {
         return n.isFunction(a) ? this.each(function (b) {
            n(this).wrapInner(a.call(this, b))
         }) : this.each(function () {
            var b = n(this),
               c = b.contents();
            c.length ? c.wrapAll(a) : b.append(a)
         })
      },
      wrap: function (a) {
         var b = n.isFunction(a);
         return this.each(function (c) {
            n(this).wrapAll(b ? a.call(this, c) : a)
         })
      },
      unwrap: function () {
         return this.parent().each(function () {
            n.nodeName(this, "body") || n(this).replaceWith(this.childNodes)
         }).end()
      }
   });

   function Yb(a) {
      return a.style && a.style.display || n.css(a, "display")
   }

   function Zb(a) {
      if (!n.contains(a.ownerDocument || d, a)) return !0;
      while (a && 1 === a.nodeType) {
         if ("none" === Yb(a) || "hidden" === a.type) return !0;
         a = a.parentNode
      }
      return !1
   }
   n.expr.filters.hidden = function (a) {
      return l.reliableHiddenOffsets() ? a.offsetWidth <= 0 && a.offsetHeight <= 0 && !a.getClientRects().length : Zb(a)
   }, n.expr.filters.visible = function (a) {
      return !n.expr.filters.hidden(a)
   };
   var $b = /%20/g,
      _b = /\[\]$/,
      ac = /\r?\n/g,
      bc = /^(?:submit|button|image|reset|file)$/i,
      cc = /^(?:input|select|textarea|keygen)/i;

   function dc(a, b, c, d) {
      var e;
      if (n.isArray(b)) n.each(b, function (b, e) {
         c || _b.test(a) ? d(a, e) : dc(a + "[" + ("object" == typeof e && null != e ? b : "") + "]", e, c, d)
      });
      else if (c || "object" !== n.type(b)) d(a, b);
      else
         for (e in b) dc(a + "[" + e + "]", b[e], c, d)
   }
   n.param = function (a, b) {
      var c, d = [],
         e = function (a, b) {
            b = n.isFunction(b) ? b() : null == b ? "" : b, d[d.length] = encodeURIComponent(a) + "=" + encodeURIComponent(b)
         };
      if (void 0 === b && (b = n.ajaxSettings && n.ajaxSettings.traditional), n.isArray(a) || a.jquery && !n.isPlainObject(a)) n.each(a, function () {
         e(this.name, this.value)
      });
      else
         for (c in a) dc(c, a[c], b, e);
      return d.join("&").replace($b, "+")
   }, n.fn.extend({
      serialize: function () {
         return n.param(this.serializeArray())
      },
      serializeArray: function () {
         return this.map(function () {
            var a = n.prop(this, "elements");
            return a ? n.makeArray(a) : this
         }).filter(function () {
            var a = this.type;
            return this.name && !n(this).is(":disabled") && cc.test(this.nodeName) && !bc.test(a) && (this.checked || !Z.test(a))
         }).map(function (a, b) {
            var c = n(this).val();
            return null == c ? null : n.isArray(c) ? n.map(c, function (a) {
               return {
                  name: b.name,
                  value: a.replace(ac, "\r\n")
               }
            }) : {
               name: b.name,
               value: c.replace(ac, "\r\n")
            }
         }).get()
      }
   }), n.ajaxSettings.xhr = void 0 !== a.ActiveXObject ? function () {
      return this.isLocal ? ic() : d.documentMode > 8 ? hc() : /^(get|post|head|put|delete|options)$/i.test(this.type) && hc() || ic()
   } : hc;
   var ec = 0,
      fc = {},
      gc = n.ajaxSettings.xhr();
   a.attachEvent && a.attachEvent("onunload", function () {
      for (var a in fc) fc[a](void 0, !0)
   }), l.cors = !!gc && "withCredentials" in gc, gc = l.ajax = !!gc, gc && n.ajaxTransport(function (b) {
      if (!b.crossDomain || l.cors) {
         var c;
         return {
            send: function (d, e) {
               var f, g = b.xhr(),
                  h = ++ec;
               if (g.open(b.type, b.url, b.async, b.username, b.password), b.xhrFields)
                  for (f in b.xhrFields) g[f] = b.xhrFields[f];
               b.mimeType && g.overrideMimeType && g.overrideMimeType(b.mimeType), b.crossDomain || d["X-Requested-With"] || (d["X-Requested-With"] = "XMLHttpRequest");
               for (f in d) void 0 !== d[f] && g.setRequestHeader(f, d[f] + "");
               g.send(b.hasContent && b.data || null), c = function (a, d) {
                  var f, i, j;
                  if (c && (d || 4 === g.readyState))
                     if (delete fc[h], c = void 0, g.onreadystatechange = n.noop, d) 4 !== g.readyState && g.abort();
                     else {
                        j = {}, f = g.status, "string" == typeof g.responseText && (j.text = g.responseText);
                        try {
                           i = g.statusText
                        } catch (k) {
                           i = ""
                        }
                        f || !b.isLocal || b.crossDomain ? 1223 === f && (f = 204) : f = j.text ? 200 : 404
                     }
                  j && e(f, i, j, g.getAllResponseHeaders())
               }, b.async ? 4 === g.readyState ? a.setTimeout(c) : g.onreadystatechange = fc[h] = c : c()
            },
            abort: function () {
               c && c(void 0, !0)
            }
         }
      }
   });

   function hc() {
      try {
         return new a.XMLHttpRequest
      } catch (b) {}
   }

   function ic() {
      try {
         return new a.ActiveXObject("Microsoft.XMLHTTP")
      } catch (b) {}
   }
   n.ajaxSetup({
      accepts: {
         script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
      },
      contents: {
         script: /\b(?:java|ecma)script\b/
      },
      converters: {
         "text script": function (a) {
            return n.globalEval(a), a
         }
      }
   }), n.ajaxPrefilter("script", function (a) {
      void 0 === a.cache && (a.cache = !1), a.crossDomain && (a.type = "GET", a.global = !1)
   }), n.ajaxTransport("script", function (a) {
      if (a.crossDomain) {
         var b, c = d.head || n("head")[0] || d.documentElement;
         return {
            send: function (e, f) {
               b = d.createElement("script"), b.async = !0, a.scriptCharset && (b.charset = a.scriptCharset), b.src = a.url, b.onload = b.onreadystatechange = function (a, c) {
                  (c || !b.readyState || /loaded|complete/.test(b.readyState)) && (b.onload = b.onreadystatechange = null, b.parentNode && b.parentNode.removeChild(b), b = null, c || f(200, "success"))
               }, c.insertBefore(b, c.firstChild)
            },
            abort: function () {
               b && b.onload(void 0, !0)
            }
         }
      }
   });
   var jc = [],
      kc = /(=)\?(?=&|$)|\?\?/;
   n.ajaxSetup({
      jsonp: "callback",
      jsonpCallback: function () {
         var a = jc.pop() || n.expando + "_" + Eb++;
         return this[a] = !0, a
      }
   }), n.ajaxPrefilter("json jsonp", function (b, c, d) {
      var e, f, g, h = b.jsonp !== !1 && (kc.test(b.url) ? "url" : "string" == typeof b.data && 0 === (b.contentType || "").indexOf("application/x-www-form-urlencoded") && kc.test(b.data) && "data");
      return h || "jsonp" === b.dataTypes[0] ? (e = b.jsonpCallback = n.isFunction(b.jsonpCallback) ? b.jsonpCallback() : b.jsonpCallback, h ? b[h] = b[h].replace(kc, "$1" + e) : b.jsonp !== !1 && (b.url += (Fb.test(b.url) ? "&" : "?") + b.jsonp + "=" + e), b.converters["script json"] = function () {
         return g || n.error(e + " was not called"), g[0]
      }, b.dataTypes[0] = "json", f = a[e], a[e] = function () {
         g = arguments
      }, d.always(function () {
         void 0 === f ? n(a).removeProp(e) : a[e] = f, b[e] && (b.jsonpCallback = c.jsonpCallback, jc.push(e)), g && n.isFunction(f) && f(g[0]), g = f = void 0
      }), "script") : void 0
   }), n.parseHTML = function (a, b, c) {
      if (!a || "string" != typeof a) return null;
      "boolean" == typeof b && (c = b, b = !1), b = b || d;
      var e = x.exec(a),
         f = !c && [];
      return e ? [b.createElement(e[1])] : (e = ja([a], b, f), f && f.length && n(f).remove(), n.merge([], e.childNodes))
   };
   var lc = n.fn.load;
   n.fn.load = function (a, b, c) {
      if ("string" != typeof a && lc) return lc.apply(this, arguments);
      var d, e, f, g = this,
         h = a.indexOf(" ");
      return h > -1 && (d = n.trim(a.slice(h, a.length)), a = a.slice(0, h)), n.isFunction(b) ? (c = b, b = void 0) : b && "object" == typeof b && (e = "POST"), g.length > 0 && n.ajax({
         url: a,
         type: e || "GET",
         dataType: "html",
         data: b
      }).done(function (a) {
         f = arguments, g.html(d ? n("<div>").append(n.parseHTML(a)).find(d) : a)
      }).always(c && function (a, b) {
         g.each(function () {
            c.apply(this, f || [a.responseText, b, a])
         })
      }), this
   }, n.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (a, b) {
      n.fn[b] = function (a) {
         return this.on(b, a)
      }
   }), n.expr.filters.animated = function (a) {
      return n.grep(n.timers, function (b) {
         return a === b.elem
      }).length
   };

   function mc(a) {
      return n.isWindow(a) ? a : 9 === a.nodeType ? a.defaultView || a.parentWindow : !1
   }
   n.offset = {
      setOffset: function (a, b, c) {
         var d, e, f, g, h, i, j, k = n.css(a, "position"),
            l = n(a),
            m = {};
         "static" === k && (a.style.position = "relative"), h = l.offset(), f = n.css(a, "top"), i = n.css(a, "left"), j = ("absolute" === k || "fixed" === k) && n.inArray("auto", [f, i]) > -1, j ? (d = l.position(), g = d.top, e = d.left) : (g = parseFloat(f) || 0, e = parseFloat(i) || 0), n.isFunction(b) && (b = b.call(a, c, n.extend({}, h))), null != b.top && (m.top = b.top - h.top + g), null != b.left && (m.left = b.left - h.left + e), "using" in b ? b.using.call(a, m) : l.css(m)
      }
   }, n.fn.extend({
      offset: function (a) {
         if (arguments.length) return void 0 === a ? this : this.each(function (b) {
            n.offset.setOffset(this, a, b)
         });
         var b, c, d = {
               top: 0,
               left: 0
            },
            e = this[0],
            f = e && e.ownerDocument;
         if (f) return b = f.documentElement, n.contains(b, e) ? ("undefined" != typeof e.getBoundingClientRect && (d = e.getBoundingClientRect()), c = mc(f), {
            top: d.top + (c.pageYOffset || b.scrollTop) - (b.clientTop || 0),
            left: d.left + (c.pageXOffset || b.scrollLeft) - (b.clientLeft || 0)
         }) : d
      },
      position: function () {
         if (this[0]) {
            var a, b, c = {
                  top: 0,
                  left: 0
               },
               d = this[0];
            return "fixed" === n.css(d, "position") ? b = d.getBoundingClientRect() : (a = this.offsetParent(), b = this.offset(), n.nodeName(a[0], "html") || (c = a.offset()), c.top += n.css(a[0], "borderTopWidth", !0), c.left += n.css(a[0], "borderLeftWidth", !0)), {
               top: b.top - c.top - n.css(d, "marginTop", !0),
               left: b.left - c.left - n.css(d, "marginLeft", !0)
            }
         }
      },
      offsetParent: function () {
         return this.map(function () {
            var a = this.offsetParent;
            while (a && !n.nodeName(a, "html") && "static" === n.css(a, "position")) a = a.offsetParent;
            return a || Qa
         })
      }
   }), n.each({
      scrollLeft: "pageXOffset",
      scrollTop: "pageYOffset"
   }, function (a, b) {
      var c = /Y/.test(b);
      n.fn[a] = function (d) {
         return Y(this, function (a, d, e) {
            var f = mc(a);
            return void 0 === e ? f ? b in f ? f[b] : f.document.documentElement[d] : a[d] : void(f ? f.scrollTo(c ? n(f).scrollLeft() : e, c ? e : n(f).scrollTop()) : a[d] = e)
         }, a, d, arguments.length, null)
      }
   }), n.each(["top", "left"], function (a, b) {
      n.cssHooks[b] = Ua(l.pixelPosition, function (a, c) {
         return c ? (c = Sa(a, b), Oa.test(c) ? n(a).position()[b] + "px" : c) : void 0
      })
   }), n.each({
      Height: "height",
      Width: "width"
   }, function (a, b) {
      n.each({
         padding: "inner" + a,
         content: b,
         "": "outer" + a
      }, function (c, d) {
         n.fn[d] = function (d, e) {
            var f = arguments.length && (c || "boolean" != typeof d),
               g = c || (d === !0 || e === !0 ? "margin" : "border");
            return Y(this, function (b, c, d) {
               var e;
               return n.isWindow(b) ? b.document.documentElement["client" + a] : 9 === b.nodeType ? (e = b.documentElement, Math.max(b.body["scroll" + a], e["scroll" + a], b.body["offset" + a], e["offset" + a], e["client" + a])) : void 0 === d ? n.css(b, c, g) : n.style(b, c, d, g)
            }, b, f ? d : void 0, f, null)
         }
      })
   }), n.fn.extend({
      bind: function (a, b, c) {
         return this.on(a, null, b, c)
      },
      unbind: function (a, b) {
         return this.off(a, null, b)
      },
      delegate: function (a, b, c, d) {
         return this.on(b, a, c, d)
      },
      undelegate: function (a, b, c) {
         return 1 === arguments.length ? this.off(a, "**") : this.off(b, a || "**", c)
      }
   }), n.fn.size = function () {
      return this.length
   }, n.fn.andSelf = n.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
      return n
   });
   var nc = a.jQuery,
      oc = a.$;
   return n.noConflict = function (b) {
      return a.$ === n && (a.$ = oc), b && a.jQuery === n && (a.jQuery = nc), n
   }, b || (a.jQuery = a.$ = n), n
});
/*
 Copyright (C) Federico Zivolo 2017
 Distributed under the MIT License (license terms are at http://opensource.org/licenses/MIT).
 */(function(e,t){'object'==typeof exports&&'undefined'!=typeof module?module.exports=t():'function'==typeof define&&define.amd?define(t):e.Popper=t()})(this,function(){'use strict';function e(e){return e&&'[object Function]'==={}.toString.call(e)}function t(e,t){if(1!==e.nodeType)return[];var o=window.getComputedStyle(e,null);return t?o[t]:o}function o(e){return'HTML'===e.nodeName?e:e.parentNode||e.host}function n(e){if(!e||-1!==['HTML','BODY','#document'].indexOf(e.nodeName))return window.document.body;var i=t(e),r=i.overflow,p=i.overflowX,s=i.overflowY;return /(auto|scroll)/.test(r+s+p)?e:n(o(e))}function r(e){var o=e&&e.offsetParent,i=o&&o.nodeName;return i&&'BODY'!==i&&'HTML'!==i?-1!==['TD','TABLE'].indexOf(o.nodeName)&&'static'===t(o,'position')?r(o):o:window.document.documentElement}function p(e){var t=e.nodeName;return'BODY'!==t&&('HTML'===t||r(e.firstElementChild)===e)}function s(e){return null===e.parentNode?e:s(e.parentNode)}function d(e,t){if(!e||!e.nodeType||!t||!t.nodeType)return window.document.documentElement;var o=e.compareDocumentPosition(t)&Node.DOCUMENT_POSITION_FOLLOWING,i=o?e:t,n=o?t:e,a=document.createRange();a.setStart(i,0),a.setEnd(n,0);var l=a.commonAncestorContainer;if(e!==l&&t!==l||i.contains(n))return p(l)?l:r(l);var f=s(e);return f.host?d(f.host,t):d(e,s(t).host)}function a(e){var t=1<arguments.length&&void 0!==arguments[1]?arguments[1]:'top',o='top'===t?'scrollTop':'scrollLeft',i=e.nodeName;if('BODY'===i||'HTML'===i){var n=window.document.documentElement,r=window.document.scrollingElement||n;return r[o]}return e[o]}function l(e,t){var o=2<arguments.length&&void 0!==arguments[2]&&arguments[2],i=a(t,'top'),n=a(t,'left'),r=o?-1:1;return e.top+=i*r,e.bottom+=i*r,e.left+=n*r,e.right+=n*r,e}function f(e,t){var o='x'===t?'Left':'Top',i='Left'==o?'Right':'Bottom';return+e['border'+o+'Width'].split('px')[0]+ +e['border'+i+'Width'].split('px')[0]}function m(e,t,o,i){return X(t['offset'+e],t['scroll'+e],o['client'+e],o['offset'+e],o['scroll'+e],ne()?o['offset'+e]+i['margin'+('Height'===e?'Top':'Left')]+i['margin'+('Height'===e?'Bottom':'Right')]:0)}function c(){var e=window.document.body,t=window.document.documentElement,o=ne()&&window.getComputedStyle(t);return{height:m('Height',e,t,o),width:m('Width',e,t,o)}}function h(e){return de({},e,{right:e.left+e.width,bottom:e.top+e.height})}function g(e){var o={};if(ne())try{o=e.getBoundingClientRect();var i=a(e,'top'),n=a(e,'left');o.top+=i,o.left+=n,o.bottom+=i,o.right+=n}catch(e){}else o=e.getBoundingClientRect();var r={left:o.left,top:o.top,width:o.right-o.left,height:o.bottom-o.top},p='HTML'===e.nodeName?c():{},s=p.width||e.clientWidth||r.right-r.left,d=p.height||e.clientHeight||r.bottom-r.top,l=e.offsetWidth-s,m=e.offsetHeight-d;if(l||m){var g=t(e);l-=f(g,'x'),m-=f(g,'y'),r.width-=l,r.height-=m}return h(r)}function u(e,o){var i=ne(),r='HTML'===o.nodeName,p=g(e),s=g(o),d=n(e),a=t(o),f=+a.borderTopWidth.split('px')[0],m=+a.borderLeftWidth.split('px')[0],c=h({top:p.top-s.top-f,left:p.left-s.left-m,width:p.width,height:p.height});if(c.marginTop=0,c.marginLeft=0,!i&&r){var u=+a.marginTop.split('px')[0],b=+a.marginLeft.split('px')[0];c.top-=f-u,c.bottom-=f-u,c.left-=m-b,c.right-=m-b,c.marginTop=u,c.marginLeft=b}return(i?o.contains(d):o===d&&'BODY'!==d.nodeName)&&(c=l(c,o)),c}function b(e){var t=window.document.documentElement,o=u(e,t),i=X(t.clientWidth,window.innerWidth||0),n=X(t.clientHeight,window.innerHeight||0),r=a(t),p=a(t,'left'),s={top:r-o.top+o.marginTop,left:p-o.left+o.marginLeft,width:i,height:n};return h(s)}function y(e){var i=e.nodeName;return'BODY'===i||'HTML'===i?!1:'fixed'===t(e,'position')||y(o(e))}function w(e,t,i,r){var p={top:0,left:0},s=d(e,t);if('viewport'===r)p=b(s);else{var a;'scrollParent'===r?(a=n(o(e)),'BODY'===a.nodeName&&(a=window.document.documentElement)):'window'===r?a=window.document.documentElement:a=r;var l=u(a,s);if('HTML'===a.nodeName&&!y(s)){var f=c(),m=f.height,h=f.width;p.top+=l.top-l.marginTop,p.bottom=m+l.top,p.left+=l.left-l.marginLeft,p.right=h+l.left}else p=l}return p.left+=i,p.top+=i,p.right-=i,p.bottom-=i,p}function E(e){var t=e.width,o=e.height;return t*o}function v(e,t,o,i,n){var r=5<arguments.length&&void 0!==arguments[5]?arguments[5]:0;if(-1===e.indexOf('auto'))return e;var p=w(o,i,r,n),s={top:{width:p.width,height:t.top-p.top},right:{width:p.right-t.right,height:p.height},bottom:{width:p.width,height:p.bottom-t.bottom},left:{width:t.left-p.left,height:p.height}},d=Object.keys(s).map(function(e){return de({key:e},s[e],{area:E(s[e])})}).sort(function(e,t){return t.area-e.area}),a=d.filter(function(e){var t=e.width,i=e.height;return t>=o.clientWidth&&i>=o.clientHeight}),l=0<a.length?a[0].key:d[0].key,f=e.split('-')[1];return l+(f?'-'+f:'')}function x(e,t,o){var i=d(t,o);return u(o,i)}function O(e){var t=window.getComputedStyle(e),o=parseFloat(t.marginTop)+parseFloat(t.marginBottom),i=parseFloat(t.marginLeft)+parseFloat(t.marginRight),n={width:e.offsetWidth+i,height:e.offsetHeight+o};return n}function L(e){var t={left:'right',right:'left',bottom:'top',top:'bottom'};return e.replace(/left|right|bottom|top/g,function(e){return t[e]})}function S(e,t,o){o=o.split('-')[0];var i=O(e),n={width:i.width,height:i.height},r=-1!==['right','left'].indexOf(o),p=r?'top':'left',s=r?'left':'top',d=r?'height':'width',a=r?'width':'height';return n[p]=t[p]+t[d]/2-i[d]/2,n[s]=o===s?t[s]-i[a]:t[L(s)],n}function T(e,t){return Array.prototype.find?e.find(t):e.filter(t)[0]}function C(e,t,o){if(Array.prototype.findIndex)return e.findIndex(function(e){return e[t]===o});var i=T(e,function(e){return e[t]===o});return e.indexOf(i)}function N(t,o,i){var n=void 0===i?t:t.slice(0,C(t,'name',i));return n.forEach(function(t){t.function&&console.warn('`modifier.function` is deprecated, use `modifier.fn`!');var i=t.function||t.fn;t.enabled&&e(i)&&(o.offsets.popper=h(o.offsets.popper),o.offsets.reference=h(o.offsets.reference),o=i(o,t))}),o}function k(){if(!this.state.isDestroyed){var e={instance:this,styles:{},arrowStyles:{},attributes:{},flipped:!1,offsets:{}};e.offsets.reference=x(this.state,this.popper,this.reference),e.placement=v(this.options.placement,e.offsets.reference,this.popper,this.reference,this.options.modifiers.flip.boundariesElement,this.options.modifiers.flip.padding),e.originalPlacement=e.placement,e.offsets.popper=S(this.popper,e.offsets.reference,e.placement),e.offsets.popper.position='absolute',e=N(this.modifiers,e),this.state.isCreated?this.options.onUpdate(e):(this.state.isCreated=!0,this.options.onCreate(e))}}function W(e,t){return e.some(function(e){var o=e.name,i=e.enabled;return i&&o===t})}function B(e){for(var t=[!1,'ms','Webkit','Moz','O'],o=e.charAt(0).toUpperCase()+e.slice(1),n=0;n<t.length-1;n++){var i=t[n],r=i?''+i+o:e;if('undefined'!=typeof window.document.body.style[r])return r}return null}function P(){return this.state.isDestroyed=!0,W(this.modifiers,'applyStyle')&&(this.popper.removeAttribute('x-placement'),this.popper.style.left='',this.popper.style.position='',this.popper.style.top='',this.popper.style[B('transform')]=''),this.disableEventListeners(),this.options.removeOnDestroy&&this.popper.parentNode.removeChild(this.popper),this}function D(e,t,o,i){var r='BODY'===e.nodeName,p=r?window:e;p.addEventListener(t,o,{passive:!0}),r||D(n(p.parentNode),t,o,i),i.push(p)}function H(e,t,o,i){o.updateBound=i,window.addEventListener('resize',o.updateBound,{passive:!0});var r=n(e);return D(r,'scroll',o.updateBound,o.scrollParents),o.scrollElement=r,o.eventsEnabled=!0,o}function A(){this.state.eventsEnabled||(this.state=H(this.reference,this.options,this.state,this.scheduleUpdate))}function M(e,t){return window.removeEventListener('resize',t.updateBound),t.scrollParents.forEach(function(e){e.removeEventListener('scroll',t.updateBound)}),t.updateBound=null,t.scrollParents=[],t.scrollElement=null,t.eventsEnabled=!1,t}function I(){this.state.eventsEnabled&&(window.cancelAnimationFrame(this.scheduleUpdate),this.state=M(this.reference,this.state))}function R(e){return''!==e&&!isNaN(parseFloat(e))&&isFinite(e)}function U(e,t){Object.keys(t).forEach(function(o){var i='';-1!==['width','height','top','right','bottom','left'].indexOf(o)&&R(t[o])&&(i='px'),e.style[o]=t[o]+i})}function Y(e,t){Object.keys(t).forEach(function(o){var i=t[o];!1===i?e.removeAttribute(o):e.setAttribute(o,t[o])})}function F(e,t,o){var i=T(e,function(e){var o=e.name;return o===t}),n=!!i&&e.some(function(e){return e.name===o&&e.enabled&&e.order<i.order});if(!n){var r='`'+t+'`';console.warn('`'+o+'`'+' modifier is required by '+r+' modifier in order to work, be sure to include it before '+r+'!')}return n}function j(e){return'end'===e?'start':'start'===e?'end':e}function K(e){var t=1<arguments.length&&void 0!==arguments[1]&&arguments[1],o=le.indexOf(e),i=le.slice(o+1).concat(le.slice(0,o));return t?i.reverse():i}function q(e,t,o,i){var n=e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),r=+n[1],p=n[2];if(!r)return e;if(0===p.indexOf('%')){var s;switch(p){case'%p':s=o;break;case'%':case'%r':default:s=i;}var d=h(s);return d[t]/100*r}if('vh'===p||'vw'===p){var a;return a='vh'===p?X(document.documentElement.clientHeight,window.innerHeight||0):X(document.documentElement.clientWidth,window.innerWidth||0),a/100*r}return r}function G(e,t,o,i){var n=[0,0],r=-1!==['right','left'].indexOf(i),p=e.split(/(\+|\-)/).map(function(e){return e.trim()}),s=p.indexOf(T(p,function(e){return-1!==e.search(/,|\s/)}));p[s]&&-1===p[s].indexOf(',')&&console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.');var d=/\s*,\s*|\s+/,a=-1===s?[p]:[p.slice(0,s).concat([p[s].split(d)[0]]),[p[s].split(d)[1]].concat(p.slice(s+1))];return a=a.map(function(e,i){var n=(1===i?!r:r)?'height':'width',p=!1;return e.reduce(function(e,t){return''===e[e.length-1]&&-1!==['+','-'].indexOf(t)?(e[e.length-1]=t,p=!0,e):p?(e[e.length-1]+=t,p=!1,e):e.concat(t)},[]).map(function(e){return q(e,n,t,o)})}),a.forEach(function(e,t){e.forEach(function(o,i){R(o)&&(n[t]+=o*('-'===e[i-1]?-1:1))})}),n}function z(e,t){var o,i=t.offset,n=e.placement,r=e.offsets,p=r.popper,s=r.reference,d=n.split('-')[0];return o=R(+i)?[+i,0]:G(i,p,s,d),'left'===d?(p.top+=o[0],p.left-=o[1]):'right'===d?(p.top+=o[0],p.left+=o[1]):'top'===d?(p.left+=o[0],p.top-=o[1]):'bottom'===d&&(p.left+=o[0],p.top+=o[1]),e.popper=p,e}for(var V=Math.min,_=Math.floor,X=Math.max,Q=['native code','[object MutationObserverConstructor]'],J=function(e){return Q.some(function(t){return-1<(e||'').toString().indexOf(t)})},Z='undefined'!=typeof window,$=['Edge','Trident','Firefox'],ee=0,te=0;te<$.length;te+=1)if(Z&&0<=navigator.userAgent.indexOf($[te])){ee=1;break}var i,oe=Z&&J(window.MutationObserver),ie=oe?function(e){var t=!1,o=0,i=document.createElement('span'),n=new MutationObserver(function(){e(),t=!1});return n.observe(i,{attributes:!0}),function(){t||(t=!0,i.setAttribute('x-index',o),++o)}}:function(e){var t=!1;return function(){t||(t=!0,setTimeout(function(){t=!1,e()},ee))}},ne=function(){return void 0==i&&(i=-1!==navigator.appVersion.indexOf('MSIE 10')),i},re=function(e,t){if(!(e instanceof t))throw new TypeError('Cannot call a class as a function')},pe=function(){function e(e,t){for(var o,n=0;n<t.length;n++)o=t[n],o.enumerable=o.enumerable||!1,o.configurable=!0,'value'in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}return function(t,o,i){return o&&e(t.prototype,o),i&&e(t,i),t}}(),se=function(e,t,o){return t in e?Object.defineProperty(e,t,{value:o,enumerable:!0,configurable:!0,writable:!0}):e[t]=o,e},de=Object.assign||function(e){for(var t,o=1;o<arguments.length;o++)for(var i in t=arguments[o],t)Object.prototype.hasOwnProperty.call(t,i)&&(e[i]=t[i]);return e},ae=['auto-start','auto','auto-end','top-start','top','top-end','right-start','right','right-end','bottom-end','bottom','bottom-start','left-end','left','left-start'],le=ae.slice(3),fe={FLIP:'flip',CLOCKWISE:'clockwise',COUNTERCLOCKWISE:'counterclockwise'},me=function(){function t(o,i){var n=this,r=2<arguments.length&&void 0!==arguments[2]?arguments[2]:{};re(this,t),this.scheduleUpdate=function(){return requestAnimationFrame(n.update)},this.update=ie(this.update.bind(this)),this.options=de({},t.Defaults,r),this.state={isDestroyed:!1,isCreated:!1,scrollParents:[]},this.reference=o.jquery?o[0]:o,this.popper=i.jquery?i[0]:i,this.options.modifiers={},Object.keys(de({},t.Defaults.modifiers,r.modifiers)).forEach(function(e){n.options.modifiers[e]=de({},t.Defaults.modifiers[e]||{},r.modifiers?r.modifiers[e]:{})}),this.modifiers=Object.keys(this.options.modifiers).map(function(e){return de({name:e},n.options.modifiers[e])}).sort(function(e,t){return e.order-t.order}),this.modifiers.forEach(function(t){t.enabled&&e(t.onLoad)&&t.onLoad(n.reference,n.popper,n.options,t,n.state)}),this.update();var p=this.options.eventsEnabled;p&&this.enableEventListeners(),this.state.eventsEnabled=p}return pe(t,[{key:'update',value:function(){return k.call(this)}},{key:'destroy',value:function(){return P.call(this)}},{key:'enableEventListeners',value:function(){return A.call(this)}},{key:'disableEventListeners',value:function(){return I.call(this)}}]),t}();return me.Utils=('undefined'==typeof window?global:window).PopperUtils,me.placements=ae,me.Defaults={placement:'bottom',eventsEnabled:!0,removeOnDestroy:!1,onCreate:function(){},onUpdate:function(){},modifiers:{shift:{order:100,enabled:!0,fn:function(e){var t=e.placement,o=t.split('-')[0],i=t.split('-')[1];if(i){var n=e.offsets,r=n.reference,p=n.popper,s=-1!==['bottom','top'].indexOf(o),d=s?'left':'top',a=s?'width':'height',l={start:se({},d,r[d]),end:se({},d,r[d]+r[a]-p[a])};e.offsets.popper=de({},p,l[i])}return e}},offset:{order:200,enabled:!0,fn:z,offset:0},preventOverflow:{order:300,enabled:!0,fn:function(e,t){var o=t.boundariesElement||r(e.instance.popper);e.instance.reference===o&&(o=r(o));var i=w(e.instance.popper,e.instance.reference,t.padding,o);t.boundaries=i;var n=t.priority,p=e.offsets.popper,s={primary:function(e){var o=p[e];return p[e]<i[e]&&!t.escapeWithReference&&(o=X(p[e],i[e])),se({},e,o)},secondary:function(e){var o='right'===e?'left':'top',n=p[o];return p[e]>i[e]&&!t.escapeWithReference&&(n=V(p[o],i[e]-('right'===e?p.width:p.height))),se({},o,n)}};return n.forEach(function(e){var t=-1===['left','top'].indexOf(e)?'secondary':'primary';p=de({},p,s[t](e))}),e.offsets.popper=p,e},priority:['left','right','top','bottom'],padding:5,boundariesElement:'scrollParent'},keepTogether:{order:400,enabled:!0,fn:function(e){var t=e.offsets,o=t.popper,i=t.reference,n=e.placement.split('-')[0],r=_,p=-1!==['top','bottom'].indexOf(n),s=p?'right':'bottom',d=p?'left':'top',a=p?'width':'height';return o[s]<r(i[d])&&(e.offsets.popper[d]=r(i[d])-o[a]),o[d]>r(i[s])&&(e.offsets.popper[d]=r(i[s])),e}},arrow:{order:500,enabled:!0,fn:function(e,o){if(!F(e.instance.modifiers,'arrow','keepTogether'))return e;var i=o.element;if('string'==typeof i){if(i=e.instance.popper.querySelector(i),!i)return e;}else if(!e.instance.popper.contains(i))return console.warn('WARNING: `arrow.element` must be child of its popper element!'),e;var n=e.placement.split('-')[0],r=e.offsets,p=r.popper,s=r.reference,d=-1!==['left','right'].indexOf(n),a=d?'height':'width',l=d?'Top':'Left',f=l.toLowerCase(),m=d?'left':'top',c=d?'bottom':'right',g=O(i)[a];s[c]-g<p[f]&&(e.offsets.popper[f]-=p[f]-(s[c]-g)),s[f]+g>p[c]&&(e.offsets.popper[f]+=s[f]+g-p[c]);var u=s[f]+s[a]/2-g/2,b=t(e.instance.popper,'margin'+l).replace('px',''),y=u-h(e.offsets.popper)[f]-b;return y=X(V(p[a]-g,y),0),e.arrowElement=i,e.offsets.arrow={},e.offsets.arrow[f]=Math.round(y),e.offsets.arrow[m]='',e},element:'[x-arrow]'},flip:{order:600,enabled:!0,fn:function(e,t){if(W(e.instance.modifiers,'inner'))return e;if(e.flipped&&e.placement===e.originalPlacement)return e;var o=w(e.instance.popper,e.instance.reference,t.padding,t.boundariesElement),i=e.placement.split('-')[0],n=L(i),r=e.placement.split('-')[1]||'',p=[];switch(t.behavior){case fe.FLIP:p=[i,n];break;case fe.CLOCKWISE:p=K(i);break;case fe.COUNTERCLOCKWISE:p=K(i,!0);break;default:p=t.behavior;}return p.forEach(function(s,d){if(i!==s||p.length===d+1)return e;i=e.placement.split('-')[0],n=L(i);var a=e.offsets.popper,l=e.offsets.reference,f=_,m='left'===i&&f(a.right)>f(l.left)||'right'===i&&f(a.left)<f(l.right)||'top'===i&&f(a.bottom)>f(l.top)||'bottom'===i&&f(a.top)<f(l.bottom),c=f(a.left)<f(o.left),h=f(a.right)>f(o.right),g=f(a.top)<f(o.top),u=f(a.bottom)>f(o.bottom),b='left'===i&&c||'right'===i&&h||'top'===i&&g||'bottom'===i&&u,y=-1!==['top','bottom'].indexOf(i),w=!!t.flipVariations&&(y&&'start'===r&&c||y&&'end'===r&&h||!y&&'start'===r&&g||!y&&'end'===r&&u);(m||b||w)&&(e.flipped=!0,(m||b)&&(i=p[d+1]),w&&(r=j(r)),e.placement=i+(r?'-'+r:''),e.offsets.popper=de({},e.offsets.popper,S(e.instance.popper,e.offsets.reference,e.placement)),e=N(e.instance.modifiers,e,'flip'))}),e},behavior:'flip',padding:5,boundariesElement:'viewport'},inner:{order:700,enabled:!1,fn:function(e){var t=e.placement,o=t.split('-')[0],i=e.offsets,n=i.popper,r=i.reference,p=-1!==['left','right'].indexOf(o),s=-1===['top','left'].indexOf(o);return n[p?'left':'top']=r[o]-(s?n[p?'width':'height']:0),e.placement=L(t),e.offsets.popper=h(n),e}},hide:{order:800,enabled:!0,fn:function(e){if(!F(e.instance.modifiers,'hide','preventOverflow'))return e;var t=e.offsets.reference,o=T(e.instance.modifiers,function(e){return'preventOverflow'===e.name}).boundaries;if(t.bottom<o.top||t.left>o.right||t.top>o.bottom||t.right<o.left){if(!0===e.hide)return e;e.hide=!0,e.attributes['x-out-of-boundaries']=''}else{if(!1===e.hide)return e;e.hide=!1,e.attributes['x-out-of-boundaries']=!1}return e}},computeStyle:{order:850,enabled:!0,fn:function(e,t){var o=t.x,i=t.y,n=e.offsets.popper,p=T(e.instance.modifiers,function(e){return'applyStyle'===e.name}).gpuAcceleration;void 0!==p&&console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!');var s,d,a=void 0===p?t.gpuAcceleration:p,l=r(e.instance.popper),f=g(l),m={position:n.position},c={left:_(n.left),top:_(n.top),bottom:_(n.bottom),right:_(n.right)},h='bottom'===o?'top':'bottom',u='right'===i?'left':'right',b=B('transform');if(d='bottom'==h?-f.height+c.bottom:c.top,s='right'==u?-f.width+c.right:c.left,a&&b)m[b]='translate3d('+s+'px, '+d+'px, 0)',m[h]=0,m[u]=0,m.willChange='transform';else{var y='bottom'==h?-1:1,w='right'==u?-1:1;m[h]=d*y,m[u]=s*w,m.willChange=h+', '+u}var E={"x-placement":e.placement};return e.attributes=de({},E,e.attributes),e.styles=de({},m,e.styles),e.arrowStyles=de({},e.offsets.arrow,e.arrowStyles),e},gpuAcceleration:!0,x:'bottom',y:'right'},applyStyle:{order:900,enabled:!0,fn:function(e){return U(e.instance.popper,e.styles),Y(e.instance.popper,e.attributes),e.arrowElement&&Object.keys(e.arrowStyles).length&&U(e.arrowElement,e.arrowStyles),e},onLoad:function(e,t,o,i,n){var r=x(n,t,e),p=v(o.placement,r,t,e,o.modifiers.flip.boundariesElement,o.modifiers.flip.padding);return t.setAttribute('x-placement',p),U(t,{position:'absolute'}),o},gpuAcceleration:void 0}}},me});
//# sourceMappingURL=popper.min.js.map

/*!
  * Bootstrap v4.0.0-beta.2 (https://getbootstrap.com)
  * Copyright 2011-2017 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
  */
var bootstrap=function(t,e,n){"use strict";function i(t,e){for(var n=0;n<e.length;n++){var i=e[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,i.key,i)}}e=e&&e.hasOwnProperty("default")?e.default:e,n=n&&n.hasOwnProperty("default")?n.default:n;var s=function(){function t(t){return{}.toString.call(t).match(/\s([a-zA-Z]+)/)[1].toLowerCase()}function n(){return{bindType:r.end,delegateType:r.end,handle:function(t){if(e(t.target).is(this))return t.handleObj.handler.apply(this,arguments)}}}function i(){if(window.QUnit)return!1;var t=document.createElement("bootstrap");for(var e in o)if("undefined"!=typeof t.style[e])return{end:o[e]};return!1}function s(t){var n=this,i=!1;return e(this).one(a.TRANSITION_END,function(){i=!0}),setTimeout(function(){i||a.triggerTransitionEnd(n)},t),this}var r=!1,o={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"},a={TRANSITION_END:"bsTransitionEnd",getUID:function(t){do{t+=~~(1e6*Math.random())}while(document.getElementById(t));return t},getSelectorFromElement:function(t){var n=t.getAttribute("data-target");n&&"#"!==n||(n=t.getAttribute("href")||"");try{return e(document).find(n).length>0?n:null}catch(t){return null}},reflow:function(t){return t.offsetHeight},triggerTransitionEnd:function(t){e(t).trigger(r.end)},supportsTransitionEnd:function(){return Boolean(r)},isElement:function(t){return(t[0]||t).nodeType},typeCheckConfig:function(e,n,i){for(var s in i)if(Object.prototype.hasOwnProperty.call(i,s)){var r=i[s],o=n[s],l=o&&a.isElement(o)?"element":t(o);if(!new RegExp(r).test(l))throw new Error(e.toUpperCase()+': Option "'+s+'" provided type "'+l+'" but expected type "'+r+'".')}}};return r=i(),e.fn.emulateTransitionEnd=s,a.supportsTransitionEnd()&&(e.event.special[a.TRANSITION_END]=n()),a}(),r=function(t,e,n){return e&&i(t.prototype,e),n&&i(t,n),t},o=function(t,e){t.prototype=Object.create(e.prototype),t.prototype.constructor=t,t.__proto__=e},a=function(){var t="alert",n=e.fn[t],i={CLOSE:"close.bs.alert",CLOSED:"closed.bs.alert",CLICK_DATA_API:"click.bs.alert.data-api"},o={ALERT:"alert",FADE:"fade",SHOW:"show"},a=function(){function t(t){this._element=t}var n=t.prototype;return n.close=function(t){t=t||this._element;var e=this._getRootElement(t);this._triggerCloseEvent(e).isDefaultPrevented()||this._removeElement(e)},n.dispose=function(){e.removeData(this._element,"bs.alert"),this._element=null},n._getRootElement=function(t){var n=s.getSelectorFromElement(t),i=!1;return n&&(i=e(n)[0]),i||(i=e(t).closest("."+o.ALERT)[0]),i},n._triggerCloseEvent=function(t){var n=e.Event(i.CLOSE);return e(t).trigger(n),n},n._removeElement=function(t){var n=this;e(t).removeClass(o.SHOW),s.supportsTransitionEnd()&&e(t).hasClass(o.FADE)?e(t).one(s.TRANSITION_END,function(e){return n._destroyElement(t,e)}).emulateTransitionEnd(150):this._destroyElement(t)},n._destroyElement=function(t){e(t).detach().trigger(i.CLOSED).remove()},t._jQueryInterface=function(n){return this.each(function(){var i=e(this),s=i.data("bs.alert");s||(s=new t(this),i.data("bs.alert",s)),"close"===n&&s[n](this)})},t._handleDismiss=function(t){return function(e){e&&e.preventDefault(),t.close(this)}},r(t,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}}]),t}();return e(document).on(i.CLICK_DATA_API,{DISMISS:'[data-dismiss="alert"]'}.DISMISS,a._handleDismiss(new a)),e.fn[t]=a._jQueryInterface,e.fn[t].Constructor=a,e.fn[t].noConflict=function(){return e.fn[t]=n,a._jQueryInterface},a}(),l=function(){var t="button",n=e.fn[t],i={ACTIVE:"active",BUTTON:"btn",FOCUS:"focus"},s={DATA_TOGGLE_CARROT:'[data-toggle^="button"]',DATA_TOGGLE:'[data-toggle="buttons"]',INPUT:"input",ACTIVE:".active",BUTTON:".btn"},o={CLICK_DATA_API:"click.bs.button.data-api",FOCUS_BLUR_DATA_API:"focus.bs.button.data-api blur.bs.button.data-api"},a=function(){function t(t){this._element=t}var n=t.prototype;return n.toggle=function(){var t=!0,n=!0,r=e(this._element).closest(s.DATA_TOGGLE)[0];if(r){var o=e(this._element).find(s.INPUT)[0];if(o){if("radio"===o.type)if(o.checked&&e(this._element).hasClass(i.ACTIVE))t=!1;else{var a=e(r).find(s.ACTIVE)[0];a&&e(a).removeClass(i.ACTIVE)}if(t){if(o.hasAttribute("disabled")||r.hasAttribute("disabled")||o.classList.contains("disabled")||r.classList.contains("disabled"))return;o.checked=!e(this._element).hasClass(i.ACTIVE),e(o).trigger("change")}o.focus(),n=!1}}n&&this._element.setAttribute("aria-pressed",!e(this._element).hasClass(i.ACTIVE)),t&&e(this._element).toggleClass(i.ACTIVE)},n.dispose=function(){e.removeData(this._element,"bs.button"),this._element=null},t._jQueryInterface=function(n){return this.each(function(){var i=e(this).data("bs.button");i||(i=new t(this),e(this).data("bs.button",i)),"toggle"===n&&i[n]()})},r(t,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}}]),t}();return e(document).on(o.CLICK_DATA_API,s.DATA_TOGGLE_CARROT,function(t){t.preventDefault();var n=t.target;e(n).hasClass(i.BUTTON)||(n=e(n).closest(s.BUTTON)),a._jQueryInterface.call(e(n),"toggle")}).on(o.FOCUS_BLUR_DATA_API,s.DATA_TOGGLE_CARROT,function(t){var n=e(t.target).closest(s.BUTTON)[0];e(n).toggleClass(i.FOCUS,/^focus(in)?$/.test(t.type))}),e.fn[t]=a._jQueryInterface,e.fn[t].Constructor=a,e.fn[t].noConflict=function(){return e.fn[t]=n,a._jQueryInterface},a}(),h=function(){var t="carousel",n="bs.carousel",i="."+n,o=e.fn[t],a={interval:5e3,keyboard:!0,slide:!1,pause:"hover",wrap:!0},l={interval:"(number|boolean)",keyboard:"boolean",slide:"(boolean|string)",pause:"(string|boolean)",wrap:"boolean"},h={NEXT:"next",PREV:"prev",LEFT:"left",RIGHT:"right"},c={SLIDE:"slide"+i,SLID:"slid"+i,KEYDOWN:"keydown"+i,MOUSEENTER:"mouseenter"+i,MOUSELEAVE:"mouseleave"+i,TOUCHEND:"touchend"+i,LOAD_DATA_API:"load.bs.carousel.data-api",CLICK_DATA_API:"click.bs.carousel.data-api"},u={CAROUSEL:"carousel",ACTIVE:"active",SLIDE:"slide",RIGHT:"carousel-item-right",LEFT:"carousel-item-left",NEXT:"carousel-item-next",PREV:"carousel-item-prev",ITEM:"carousel-item"},d={ACTIVE:".active",ACTIVE_ITEM:".active.carousel-item",ITEM:".carousel-item",NEXT_PREV:".carousel-item-next, .carousel-item-prev",INDICATORS:".carousel-indicators",DATA_SLIDE:"[data-slide], [data-slide-to]",DATA_RIDE:'[data-ride="carousel"]'},f=function(){function o(t,n){this._items=null,this._interval=null,this._activeElement=null,this._isPaused=!1,this._isSliding=!1,this.touchTimeout=null,this._config=this._getConfig(n),this._element=e(t)[0],this._indicatorsElement=e(this._element).find(d.INDICATORS)[0],this._addEventListeners()}var f=o.prototype;return f.next=function(){this._isSliding||this._slide(h.NEXT)},f.nextWhenVisible=function(){!document.hidden&&e(this._element).is(":visible")&&"hidden"!==e(this._element).css("visibility")&&this.next()},f.prev=function(){this._isSliding||this._slide(h.PREV)},f.pause=function(t){t||(this._isPaused=!0),e(this._element).find(d.NEXT_PREV)[0]&&s.supportsTransitionEnd()&&(s.triggerTransitionEnd(this._element),this.cycle(!0)),clearInterval(this._interval),this._interval=null},f.cycle=function(t){t||(this._isPaused=!1),this._interval&&(clearInterval(this._interval),this._interval=null),this._config.interval&&!this._isPaused&&(this._interval=setInterval((document.visibilityState?this.nextWhenVisible:this.next).bind(this),this._config.interval))},f.to=function(t){var n=this;this._activeElement=e(this._element).find(d.ACTIVE_ITEM)[0];var i=this._getItemIndex(this._activeElement);if(!(t>this._items.length-1||t<0))if(this._isSliding)e(this._element).one(c.SLID,function(){return n.to(t)});else{if(i===t)return this.pause(),void this.cycle();var s=t>i?h.NEXT:h.PREV;this._slide(s,this._items[t])}},f.dispose=function(){e(this._element).off(i),e.removeData(this._element,n),this._items=null,this._config=null,this._element=null,this._interval=null,this._isPaused=null,this._isSliding=null,this._activeElement=null,this._indicatorsElement=null},f._getConfig=function(n){return n=e.extend({},a,n),s.typeCheckConfig(t,n,l),n},f._addEventListeners=function(){var t=this;this._config.keyboard&&e(this._element).on(c.KEYDOWN,function(e){return t._keydown(e)}),"hover"===this._config.pause&&(e(this._element).on(c.MOUSEENTER,function(e){return t.pause(e)}).on(c.MOUSELEAVE,function(e){return t.cycle(e)}),"ontouchstart"in document.documentElement&&e(this._element).on(c.TOUCHEND,function(){t.pause(),t.touchTimeout&&clearTimeout(t.touchTimeout),t.touchTimeout=setTimeout(function(e){return t.cycle(e)},500+t._config.interval)}))},f._keydown=function(t){if(!/input|textarea/i.test(t.target.tagName))switch(t.which){case 37:t.preventDefault(),this.prev();break;case 39:t.preventDefault(),this.next();break;default:return}},f._getItemIndex=function(t){return this._items=e.makeArray(e(t).parent().find(d.ITEM)),this._items.indexOf(t)},f._getItemByDirection=function(t,e){var n=t===h.NEXT,i=t===h.PREV,s=this._getItemIndex(e),r=this._items.length-1;if((i&&0===s||n&&s===r)&&!this._config.wrap)return e;var o=(s+(t===h.PREV?-1:1))%this._items.length;return-1===o?this._items[this._items.length-1]:this._items[o]},f._triggerSlideEvent=function(t,n){var i=this._getItemIndex(t),s=this._getItemIndex(e(this._element).find(d.ACTIVE_ITEM)[0]),r=e.Event(c.SLIDE,{relatedTarget:t,direction:n,from:s,to:i});return e(this._element).trigger(r),r},f._setActiveIndicatorElement=function(t){if(this._indicatorsElement){e(this._indicatorsElement).find(d.ACTIVE).removeClass(u.ACTIVE);var n=this._indicatorsElement.children[this._getItemIndex(t)];n&&e(n).addClass(u.ACTIVE)}},f._slide=function(t,n){var i,r,o,a=this,l=e(this._element).find(d.ACTIVE_ITEM)[0],f=this._getItemIndex(l),_=n||l&&this._getItemByDirection(t,l),g=this._getItemIndex(_),m=Boolean(this._interval);if(t===h.NEXT?(i=u.LEFT,r=u.NEXT,o=h.LEFT):(i=u.RIGHT,r=u.PREV,o=h.RIGHT),_&&e(_).hasClass(u.ACTIVE))this._isSliding=!1;else if(!this._triggerSlideEvent(_,o).isDefaultPrevented()&&l&&_){this._isSliding=!0,m&&this.pause(),this._setActiveIndicatorElement(_);var p=e.Event(c.SLID,{relatedTarget:_,direction:o,from:f,to:g});s.supportsTransitionEnd()&&e(this._element).hasClass(u.SLIDE)?(e(_).addClass(r),s.reflow(_),e(l).addClass(i),e(_).addClass(i),e(l).one(s.TRANSITION_END,function(){e(_).removeClass(i+" "+r).addClass(u.ACTIVE),e(l).removeClass(u.ACTIVE+" "+r+" "+i),a._isSliding=!1,setTimeout(function(){return e(a._element).trigger(p)},0)}).emulateTransitionEnd(600)):(e(l).removeClass(u.ACTIVE),e(_).addClass(u.ACTIVE),this._isSliding=!1,e(this._element).trigger(p)),m&&this.cycle()}},o._jQueryInterface=function(t){return this.each(function(){var i=e(this).data(n),s=e.extend({},a,e(this).data());"object"==typeof t&&e.extend(s,t);var r="string"==typeof t?t:s.slide;if(i||(i=new o(this,s),e(this).data(n,i)),"number"==typeof t)i.to(t);else if("string"==typeof r){if("undefined"==typeof i[r])throw new Error('No method named "'+r+'"');i[r]()}else s.interval&&(i.pause(),i.cycle())})},o._dataApiClickHandler=function(t){var i=s.getSelectorFromElement(this);if(i){var r=e(i)[0];if(r&&e(r).hasClass(u.CAROUSEL)){var a=e.extend({},e(r).data(),e(this).data()),l=this.getAttribute("data-slide-to");l&&(a.interval=!1),o._jQueryInterface.call(e(r),a),l&&e(r).data(n).to(l),t.preventDefault()}}},r(o,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return a}}]),o}();return e(document).on(c.CLICK_DATA_API,d.DATA_SLIDE,f._dataApiClickHandler),e(window).on(c.LOAD_DATA_API,function(){e(d.DATA_RIDE).each(function(){var t=e(this);f._jQueryInterface.call(t,t.data())})}),e.fn[t]=f._jQueryInterface,e.fn[t].Constructor=f,e.fn[t].noConflict=function(){return e.fn[t]=o,f._jQueryInterface},f}(),c=function(){var t="collapse",n="bs.collapse",i=e.fn[t],o={toggle:!0,parent:""},a={toggle:"boolean",parent:"(string|element)"},l={SHOW:"show.bs.collapse",SHOWN:"shown.bs.collapse",HIDE:"hide.bs.collapse",HIDDEN:"hidden.bs.collapse",CLICK_DATA_API:"click.bs.collapse.data-api"},h={SHOW:"show",COLLAPSE:"collapse",COLLAPSING:"collapsing",COLLAPSED:"collapsed"},c={WIDTH:"width",HEIGHT:"height"},u={ACTIVES:".show, .collapsing",DATA_TOGGLE:'[data-toggle="collapse"]'},d=function(){function i(t,n){this._isTransitioning=!1,this._element=t,this._config=this._getConfig(n),this._triggerArray=e.makeArray(e('[data-toggle="collapse"][href="#'+t.id+'"],[data-toggle="collapse"][data-target="#'+t.id+'"]'));for(var i=e(u.DATA_TOGGLE),r=0;r<i.length;r++){var o=i[r],a=s.getSelectorFromElement(o);null!==a&&e(a).filter(t).length>0&&this._triggerArray.push(o)}this._parent=this._config.parent?this._getParent():null,this._config.parent||this._addAriaAndCollapsedClass(this._element,this._triggerArray),this._config.toggle&&this.toggle()}var d=i.prototype;return d.toggle=function(){e(this._element).hasClass(h.SHOW)?this.hide():this.show()},d.show=function(){var t=this;if(!this._isTransitioning&&!e(this._element).hasClass(h.SHOW)){var r,o;if(this._parent&&((r=e.makeArray(e(this._parent).children().children(u.ACTIVES))).length||(r=null)),!(r&&(o=e(r).data(n))&&o._isTransitioning)){var a=e.Event(l.SHOW);if(e(this._element).trigger(a),!a.isDefaultPrevented()){r&&(i._jQueryInterface.call(e(r),"hide"),o||e(r).data(n,null));var c=this._getDimension();e(this._element).removeClass(h.COLLAPSE).addClass(h.COLLAPSING),this._element.style[c]=0,this._triggerArray.length&&e(this._triggerArray).removeClass(h.COLLAPSED).attr("aria-expanded",!0),this.setTransitioning(!0);var d=function(){e(t._element).removeClass(h.COLLAPSING).addClass(h.COLLAPSE).addClass(h.SHOW),t._element.style[c]="",t.setTransitioning(!1),e(t._element).trigger(l.SHOWN)};if(s.supportsTransitionEnd()){var f="scroll"+(c[0].toUpperCase()+c.slice(1));e(this._element).one(s.TRANSITION_END,d).emulateTransitionEnd(600),this._element.style[c]=this._element[f]+"px"}else d()}}}},d.hide=function(){var t=this;if(!this._isTransitioning&&e(this._element).hasClass(h.SHOW)){var n=e.Event(l.HIDE);if(e(this._element).trigger(n),!n.isDefaultPrevented()){var i=this._getDimension();if(this._element.style[i]=this._element.getBoundingClientRect()[i]+"px",s.reflow(this._element),e(this._element).addClass(h.COLLAPSING).removeClass(h.COLLAPSE).removeClass(h.SHOW),this._triggerArray.length)for(var r=0;r<this._triggerArray.length;r++){var o=this._triggerArray[r],a=s.getSelectorFromElement(o);null!==a&&(e(a).hasClass(h.SHOW)||e(o).addClass(h.COLLAPSED).attr("aria-expanded",!1))}this.setTransitioning(!0);var c=function(){t.setTransitioning(!1),e(t._element).removeClass(h.COLLAPSING).addClass(h.COLLAPSE).trigger(l.HIDDEN)};this._element.style[i]="",s.supportsTransitionEnd()?e(this._element).one(s.TRANSITION_END,c).emulateTransitionEnd(600):c()}}},d.setTransitioning=function(t){this._isTransitioning=t},d.dispose=function(){e.removeData(this._element,n),this._config=null,this._parent=null,this._element=null,this._triggerArray=null,this._isTransitioning=null},d._getConfig=function(n){return n=e.extend({},o,n),n.toggle=Boolean(n.toggle),s.typeCheckConfig(t,n,a),n},d._getDimension=function(){return e(this._element).hasClass(c.WIDTH)?c.WIDTH:c.HEIGHT},d._getParent=function(){var t=this,n=null;s.isElement(this._config.parent)?(n=this._config.parent,"undefined"!=typeof this._config.parent.jquery&&(n=this._config.parent[0])):n=e(this._config.parent)[0];var r='[data-toggle="collapse"][data-parent="'+this._config.parent+'"]';return e(n).find(r).each(function(e,n){t._addAriaAndCollapsedClass(i._getTargetFromElement(n),[n])}),n},d._addAriaAndCollapsedClass=function(t,n){if(t){var i=e(t).hasClass(h.SHOW);n.length&&e(n).toggleClass(h.COLLAPSED,!i).attr("aria-expanded",i)}},i._getTargetFromElement=function(t){var n=s.getSelectorFromElement(t);return n?e(n)[0]:null},i._jQueryInterface=function(t){return this.each(function(){var s=e(this),r=s.data(n),a=e.extend({},o,s.data(),"object"==typeof t&&t);if(!r&&a.toggle&&/show|hide/.test(t)&&(a.toggle=!1),r||(r=new i(this,a),s.data(n,r)),"string"==typeof t){if("undefined"==typeof r[t])throw new Error('No method named "'+t+'"');r[t]()}})},r(i,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return o}}]),i}();return e(document).on(l.CLICK_DATA_API,u.DATA_TOGGLE,function(t){"A"===t.currentTarget.tagName&&t.preventDefault();var i=e(this),r=s.getSelectorFromElement(this);e(r).each(function(){var t=e(this),s=t.data(n)?"toggle":i.data();d._jQueryInterface.call(t,s)})}),e.fn[t]=d._jQueryInterface,e.fn[t].Constructor=d,e.fn[t].noConflict=function(){return e.fn[t]=i,d._jQueryInterface},d}(),u=function(){if("undefined"==typeof n)throw new Error("Bootstrap dropdown require Popper.js (https://popper.js.org)");var t="dropdown",i="bs.dropdown",o="."+i,a=e.fn[t],l=new RegExp("38|40|27"),h={HIDE:"hide"+o,HIDDEN:"hidden"+o,SHOW:"show"+o,SHOWN:"shown"+o,CLICK:"click"+o,CLICK_DATA_API:"click.bs.dropdown.data-api",KEYDOWN_DATA_API:"keydown.bs.dropdown.data-api",KEYUP_DATA_API:"keyup.bs.dropdown.data-api"},c={DISABLED:"disabled",SHOW:"show",DROPUP:"dropup",MENURIGHT:"dropdown-menu-right",MENULEFT:"dropdown-menu-left"},u={DATA_TOGGLE:'[data-toggle="dropdown"]',FORM_CHILD:".dropdown form",MENU:".dropdown-menu",NAVBAR_NAV:".navbar-nav",VISIBLE_ITEMS:".dropdown-menu .dropdown-item:not(.disabled)"},d={TOP:"top-start",TOPEND:"top-end",BOTTOM:"bottom-start",BOTTOMEND:"bottom-end"},f={offset:0,flip:!0},_={offset:"(number|string|function)",flip:"boolean"},g=function(){function a(t,e){this._element=t,this._popper=null,this._config=this._getConfig(e),this._menu=this._getMenuElement(),this._inNavbar=this._detectNavbar(),this._addEventListeners()}var g=a.prototype;return g.toggle=function(){if(!this._element.disabled&&!e(this._element).hasClass(c.DISABLED)){var t=a._getParentFromElement(this._element),i=e(this._menu).hasClass(c.SHOW);if(a._clearMenus(),!i){var s={relatedTarget:this._element},r=e.Event(h.SHOW,s);if(e(t).trigger(r),!r.isDefaultPrevented()){var o=this._element;e(t).hasClass(c.DROPUP)&&(e(this._menu).hasClass(c.MENULEFT)||e(this._menu).hasClass(c.MENURIGHT))&&(o=t),this._popper=new n(o,this._menu,this._getPopperConfig()),"ontouchstart"in document.documentElement&&!e(t).closest(u.NAVBAR_NAV).length&&e("body").children().on("mouseover",null,e.noop),this._element.focus(),this._element.setAttribute("aria-expanded",!0),e(this._menu).toggleClass(c.SHOW),e(t).toggleClass(c.SHOW).trigger(e.Event(h.SHOWN,s))}}}},g.dispose=function(){e.removeData(this._element,i),e(this._element).off(o),this._element=null,this._menu=null,null!==this._popper&&this._popper.destroy(),this._popper=null},g.update=function(){this._inNavbar=this._detectNavbar(),null!==this._popper&&this._popper.scheduleUpdate()},g._addEventListeners=function(){var t=this;e(this._element).on(h.CLICK,function(e){e.preventDefault(),e.stopPropagation(),t.toggle()})},g._getConfig=function(n){return n=e.extend({},this.constructor.Default,e(this._element).data(),n),s.typeCheckConfig(t,n,this.constructor.DefaultType),n},g._getMenuElement=function(){if(!this._menu){var t=a._getParentFromElement(this._element);this._menu=e(t).find(u.MENU)[0]}return this._menu},g._getPlacement=function(){var t=e(this._element).parent(),n=d.BOTTOM;return t.hasClass(c.DROPUP)?(n=d.TOP,e(this._menu).hasClass(c.MENURIGHT)&&(n=d.TOPEND)):e(this._menu).hasClass(c.MENURIGHT)&&(n=d.BOTTOMEND),n},g._detectNavbar=function(){return e(this._element).closest(".navbar").length>0},g._getPopperConfig=function(){var t=this,n={};"function"==typeof this._config.offset?n.fn=function(n){return n.offsets=e.extend({},n.offsets,t._config.offset(n.offsets)||{}),n}:n.offset=this._config.offset;var i={placement:this._getPlacement(),modifiers:{offset:n,flip:{enabled:this._config.flip}}};return this._inNavbar&&(i.modifiers.applyStyle={enabled:!this._inNavbar}),i},a._jQueryInterface=function(t){return this.each(function(){var n=e(this).data(i),s="object"==typeof t?t:null;if(n||(n=new a(this,s),e(this).data(i,n)),"string"==typeof t){if("undefined"==typeof n[t])throw new Error('No method named "'+t+'"');n[t]()}})},a._clearMenus=function(t){if(!t||3!==t.which&&("keyup"!==t.type||9===t.which))for(var n=e.makeArray(e(u.DATA_TOGGLE)),s=0;s<n.length;s++){var r=a._getParentFromElement(n[s]),o=e(n[s]).data(i),l={relatedTarget:n[s]};if(o){var d=o._menu;if(e(r).hasClass(c.SHOW)&&!(t&&("click"===t.type&&/input|textarea/i.test(t.target.tagName)||"keyup"===t.type&&9===t.which)&&e.contains(r,t.target))){var f=e.Event(h.HIDE,l);e(r).trigger(f),f.isDefaultPrevented()||("ontouchstart"in document.documentElement&&e("body").children().off("mouseover",null,e.noop),n[s].setAttribute("aria-expanded","false"),e(d).removeClass(c.SHOW),e(r).removeClass(c.SHOW).trigger(e.Event(h.HIDDEN,l)))}}}},a._getParentFromElement=function(t){var n,i=s.getSelectorFromElement(t);return i&&(n=e(i)[0]),n||t.parentNode},a._dataApiKeydownHandler=function(t){if(!(!l.test(t.which)||/button/i.test(t.target.tagName)&&32===t.which||/input|textarea/i.test(t.target.tagName)||(t.preventDefault(),t.stopPropagation(),this.disabled||e(this).hasClass(c.DISABLED)))){var n=a._getParentFromElement(this),i=e(n).hasClass(c.SHOW);if((i||27===t.which&&32===t.which)&&(!i||27!==t.which&&32!==t.which)){var s=e(n).find(u.VISIBLE_ITEMS).get();if(s.length){var r=s.indexOf(t.target);38===t.which&&r>0&&r--,40===t.which&&r<s.length-1&&r++,r<0&&(r=0),s[r].focus()}}else{if(27===t.which){var o=e(n).find(u.DATA_TOGGLE)[0];e(o).trigger("focus")}e(this).trigger("click")}}},r(a,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return f}},{key:"DefaultType",get:function(){return _}}]),a}();return e(document).on(h.KEYDOWN_DATA_API,u.DATA_TOGGLE,g._dataApiKeydownHandler).on(h.KEYDOWN_DATA_API,u.MENU,g._dataApiKeydownHandler).on(h.CLICK_DATA_API+" "+h.KEYUP_DATA_API,g._clearMenus).on(h.CLICK_DATA_API,u.DATA_TOGGLE,function(t){t.preventDefault(),t.stopPropagation(),g._jQueryInterface.call(e(this),"toggle")}).on(h.CLICK_DATA_API,u.FORM_CHILD,function(t){t.stopPropagation()}),e.fn[t]=g._jQueryInterface,e.fn[t].Constructor=g,e.fn[t].noConflict=function(){return e.fn[t]=a,g._jQueryInterface},g}(),d=function(){var t="modal",n=".bs.modal",i=e.fn[t],o={backdrop:!0,keyboard:!0,focus:!0,show:!0},a={backdrop:"(boolean|string)",keyboard:"boolean",focus:"boolean",show:"boolean"},l={HIDE:"hide.bs.modal",HIDDEN:"hidden.bs.modal",SHOW:"show.bs.modal",SHOWN:"shown.bs.modal",FOCUSIN:"focusin.bs.modal",RESIZE:"resize.bs.modal",CLICK_DISMISS:"click.dismiss.bs.modal",KEYDOWN_DISMISS:"keydown.dismiss.bs.modal",MOUSEUP_DISMISS:"mouseup.dismiss.bs.modal",MOUSEDOWN_DISMISS:"mousedown.dismiss.bs.modal",CLICK_DATA_API:"click.bs.modal.data-api"},h={SCROLLBAR_MEASURER:"modal-scrollbar-measure",BACKDROP:"modal-backdrop",OPEN:"modal-open",FADE:"fade",SHOW:"show"},c={DIALOG:".modal-dialog",DATA_TOGGLE:'[data-toggle="modal"]',DATA_DISMISS:'[data-dismiss="modal"]',FIXED_CONTENT:".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",STICKY_CONTENT:".sticky-top",NAVBAR_TOGGLER:".navbar-toggler"},u=function(){function i(t,n){this._config=this._getConfig(n),this._element=t,this._dialog=e(t).find(c.DIALOG)[0],this._backdrop=null,this._isShown=!1,this._isBodyOverflowing=!1,this._ignoreBackdropClick=!1,this._originalBodyPadding=0,this._scrollbarWidth=0}var u=i.prototype;return u.toggle=function(t){return this._isShown?this.hide():this.show(t)},u.show=function(t){var n=this;if(!this._isTransitioning&&!this._isShown){s.supportsTransitionEnd()&&e(this._element).hasClass(h.FADE)&&(this._isTransitioning=!0);var i=e.Event(l.SHOW,{relatedTarget:t});e(this._element).trigger(i),this._isShown||i.isDefaultPrevented()||(this._isShown=!0,this._checkScrollbar(),this._setScrollbar(),this._adjustDialog(),e(document.body).addClass(h.OPEN),this._setEscapeEvent(),this._setResizeEvent(),e(this._element).on(l.CLICK_DISMISS,c.DATA_DISMISS,function(t){return n.hide(t)}),e(this._dialog).on(l.MOUSEDOWN_DISMISS,function(){e(n._element).one(l.MOUSEUP_DISMISS,function(t){e(t.target).is(n._element)&&(n._ignoreBackdropClick=!0)})}),this._showBackdrop(function(){return n._showElement(t)}))}},u.hide=function(t){var n=this;if(t&&t.preventDefault(),!this._isTransitioning&&this._isShown){var i=e.Event(l.HIDE);if(e(this._element).trigger(i),this._isShown&&!i.isDefaultPrevented()){this._isShown=!1;var r=s.supportsTransitionEnd()&&e(this._element).hasClass(h.FADE);r&&(this._isTransitioning=!0),this._setEscapeEvent(),this._setResizeEvent(),e(document).off(l.FOCUSIN),e(this._element).removeClass(h.SHOW),e(this._element).off(l.CLICK_DISMISS),e(this._dialog).off(l.MOUSEDOWN_DISMISS),r?e(this._element).one(s.TRANSITION_END,function(t){return n._hideModal(t)}).emulateTransitionEnd(300):this._hideModal()}}},u.dispose=function(){e.removeData(this._element,"bs.modal"),e(window,document,this._element,this._backdrop).off(n),this._config=null,this._element=null,this._dialog=null,this._backdrop=null,this._isShown=null,this._isBodyOverflowing=null,this._ignoreBackdropClick=null,this._scrollbarWidth=null},u.handleUpdate=function(){this._adjustDialog()},u._getConfig=function(n){return n=e.extend({},o,n),s.typeCheckConfig(t,n,a),n},u._showElement=function(t){var n=this,i=s.supportsTransitionEnd()&&e(this._element).hasClass(h.FADE);this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE||document.body.appendChild(this._element),this._element.style.display="block",this._element.removeAttribute("aria-hidden"),this._element.scrollTop=0,i&&s.reflow(this._element),e(this._element).addClass(h.SHOW),this._config.focus&&this._enforceFocus();var r=e.Event(l.SHOWN,{relatedTarget:t}),o=function(){n._config.focus&&n._element.focus(),n._isTransitioning=!1,e(n._element).trigger(r)};i?e(this._dialog).one(s.TRANSITION_END,o).emulateTransitionEnd(300):o()},u._enforceFocus=function(){var t=this;e(document).off(l.FOCUSIN).on(l.FOCUSIN,function(n){document===n.target||t._element===n.target||e(t._element).has(n.target).length||t._element.focus()})},u._setEscapeEvent=function(){var t=this;this._isShown&&this._config.keyboard?e(this._element).on(l.KEYDOWN_DISMISS,function(e){27===e.which&&(e.preventDefault(),t.hide())}):this._isShown||e(this._element).off(l.KEYDOWN_DISMISS)},u._setResizeEvent=function(){var t=this;this._isShown?e(window).on(l.RESIZE,function(e){return t.handleUpdate(e)}):e(window).off(l.RESIZE)},u._hideModal=function(){var t=this;this._element.style.display="none",this._element.setAttribute("aria-hidden",!0),this._isTransitioning=!1,this._showBackdrop(function(){e(document.body).removeClass(h.OPEN),t._resetAdjustments(),t._resetScrollbar(),e(t._element).trigger(l.HIDDEN)})},u._removeBackdrop=function(){this._backdrop&&(e(this._backdrop).remove(),this._backdrop=null)},u._showBackdrop=function(t){var n=this,i=e(this._element).hasClass(h.FADE)?h.FADE:"";if(this._isShown&&this._config.backdrop){var r=s.supportsTransitionEnd()&&i;if(this._backdrop=document.createElement("div"),this._backdrop.className=h.BACKDROP,i&&e(this._backdrop).addClass(i),e(this._backdrop).appendTo(document.body),e(this._element).on(l.CLICK_DISMISS,function(t){n._ignoreBackdropClick?n._ignoreBackdropClick=!1:t.target===t.currentTarget&&("static"===n._config.backdrop?n._element.focus():n.hide())}),r&&s.reflow(this._backdrop),e(this._backdrop).addClass(h.SHOW),!t)return;if(!r)return void t();e(this._backdrop).one(s.TRANSITION_END,t).emulateTransitionEnd(150)}else if(!this._isShown&&this._backdrop){e(this._backdrop).removeClass(h.SHOW);var o=function(){n._removeBackdrop(),t&&t()};s.supportsTransitionEnd()&&e(this._element).hasClass(h.FADE)?e(this._backdrop).one(s.TRANSITION_END,o).emulateTransitionEnd(150):o()}else t&&t()},u._adjustDialog=function(){var t=this._element.scrollHeight>document.documentElement.clientHeight;!this._isBodyOverflowing&&t&&(this._element.style.paddingLeft=this._scrollbarWidth+"px"),this._isBodyOverflowing&&!t&&(this._element.style.paddingRight=this._scrollbarWidth+"px")},u._resetAdjustments=function(){this._element.style.paddingLeft="",this._element.style.paddingRight=""},u._checkScrollbar=function(){var t=document.body.getBoundingClientRect();this._isBodyOverflowing=t.left+t.right<window.innerWidth,this._scrollbarWidth=this._getScrollbarWidth()},u._setScrollbar=function(){var t=this;if(this._isBodyOverflowing){e(c.FIXED_CONTENT).each(function(n,i){var s=e(i)[0].style.paddingRight,r=e(i).css("padding-right");e(i).data("padding-right",s).css("padding-right",parseFloat(r)+t._scrollbarWidth+"px")}),e(c.STICKY_CONTENT).each(function(n,i){var s=e(i)[0].style.marginRight,r=e(i).css("margin-right");e(i).data("margin-right",s).css("margin-right",parseFloat(r)-t._scrollbarWidth+"px")}),e(c.NAVBAR_TOGGLER).each(function(n,i){var s=e(i)[0].style.marginRight,r=e(i).css("margin-right");e(i).data("margin-right",s).css("margin-right",parseFloat(r)+t._scrollbarWidth+"px")});var n=document.body.style.paddingRight,i=e("body").css("padding-right");e("body").data("padding-right",n).css("padding-right",parseFloat(i)+this._scrollbarWidth+"px")}},u._resetScrollbar=function(){e(c.FIXED_CONTENT).each(function(t,n){var i=e(n).data("padding-right");"undefined"!=typeof i&&e(n).css("padding-right",i).removeData("padding-right")}),e(c.STICKY_CONTENT+", "+c.NAVBAR_TOGGLER).each(function(t,n){var i=e(n).data("margin-right");"undefined"!=typeof i&&e(n).css("margin-right",i).removeData("margin-right")});var t=e("body").data("padding-right");"undefined"!=typeof t&&e("body").css("padding-right",t).removeData("padding-right")},u._getScrollbarWidth=function(){var t=document.createElement("div");t.className=h.SCROLLBAR_MEASURER,document.body.appendChild(t);var e=t.getBoundingClientRect().width-t.clientWidth;return document.body.removeChild(t),e},i._jQueryInterface=function(t,n){return this.each(function(){var s=e(this).data("bs.modal"),r=e.extend({},i.Default,e(this).data(),"object"==typeof t&&t);if(s||(s=new i(this,r),e(this).data("bs.modal",s)),"string"==typeof t){if("undefined"==typeof s[t])throw new Error('No method named "'+t+'"');s[t](n)}else r.show&&s.show(n)})},r(i,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return o}}]),i}();return e(document).on(l.CLICK_DATA_API,c.DATA_TOGGLE,function(t){var n,i=this,r=s.getSelectorFromElement(this);r&&(n=e(r)[0]);var o=e(n).data("bs.modal")?"toggle":e.extend({},e(n).data(),e(this).data());"A"!==this.tagName&&"AREA"!==this.tagName||t.preventDefault();var a=e(n).one(l.SHOW,function(t){t.isDefaultPrevented()||a.one(l.HIDDEN,function(){e(i).is(":visible")&&i.focus()})});u._jQueryInterface.call(e(n),o,this)}),e.fn[t]=u._jQueryInterface,e.fn[t].Constructor=u,e.fn[t].noConflict=function(){return e.fn[t]=i,u._jQueryInterface},u}(),f=function(){if("undefined"==typeof n)throw new Error("Bootstrap tooltips require Popper.js (https://popper.js.org)");var t="tooltip",i=".bs.tooltip",o=e.fn[t],a=new RegExp("(^|\\s)bs-tooltip\\S+","g"),l={animation:"boolean",template:"string",title:"(string|element|function)",trigger:"string",delay:"(number|object)",html:"boolean",selector:"(string|boolean)",placement:"(string|function)",offset:"(number|string)",container:"(string|element|boolean)",fallbackPlacement:"(string|array)"},h={AUTO:"auto",TOP:"top",RIGHT:"right",BOTTOM:"bottom",LEFT:"left"},c={animation:!0,template:'<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,selector:!1,placement:"top",offset:0,container:!1,fallbackPlacement:"flip"},u={SHOW:"show",OUT:"out"},d={HIDE:"hide"+i,HIDDEN:"hidden"+i,SHOW:"show"+i,SHOWN:"shown"+i,INSERTED:"inserted"+i,CLICK:"click"+i,FOCUSIN:"focusin"+i,FOCUSOUT:"focusout"+i,MOUSEENTER:"mouseenter"+i,MOUSELEAVE:"mouseleave"+i},f={FADE:"fade",SHOW:"show"},_={TOOLTIP:".tooltip",TOOLTIP_INNER:".tooltip-inner",ARROW:".arrow"},g={HOVER:"hover",FOCUS:"focus",CLICK:"click",MANUAL:"manual"},m=function(){function o(t,e){this._isEnabled=!0,this._timeout=0,this._hoverState="",this._activeTrigger={},this._popper=null,this.element=t,this.config=this._getConfig(e),this.tip=null,this._setListeners()}var m=o.prototype;return m.enable=function(){this._isEnabled=!0},m.disable=function(){this._isEnabled=!1},m.toggleEnabled=function(){this._isEnabled=!this._isEnabled},m.toggle=function(t){if(this._isEnabled)if(t){var n=this.constructor.DATA_KEY,i=e(t.currentTarget).data(n);i||(i=new this.constructor(t.currentTarget,this._getDelegateConfig()),e(t.currentTarget).data(n,i)),i._activeTrigger.click=!i._activeTrigger.click,i._isWithActiveTrigger()?i._enter(null,i):i._leave(null,i)}else{if(e(this.getTipElement()).hasClass(f.SHOW))return void this._leave(null,this);this._enter(null,this)}},m.dispose=function(){clearTimeout(this._timeout),e.removeData(this.element,this.constructor.DATA_KEY),e(this.element).off(this.constructor.EVENT_KEY),e(this.element).closest(".modal").off("hide.bs.modal"),this.tip&&e(this.tip).remove(),this._isEnabled=null,this._timeout=null,this._hoverState=null,this._activeTrigger=null,null!==this._popper&&this._popper.destroy(),this._popper=null,this.element=null,this.config=null,this.tip=null},m.show=function(){var t=this;if("none"===e(this.element).css("display"))throw new Error("Please use show on visible elements");var i=e.Event(this.constructor.Event.SHOW);if(this.isWithContent()&&this._isEnabled){e(this.element).trigger(i);var r=e.contains(this.element.ownerDocument.documentElement,this.element);if(i.isDefaultPrevented()||!r)return;var a=this.getTipElement(),l=s.getUID(this.constructor.NAME);a.setAttribute("id",l),this.element.setAttribute("aria-describedby",l),this.setContent(),this.config.animation&&e(a).addClass(f.FADE);var h="function"==typeof this.config.placement?this.config.placement.call(this,a,this.element):this.config.placement,c=this._getAttachment(h);this.addAttachmentClass(c);var d=!1===this.config.container?document.body:e(this.config.container);e(a).data(this.constructor.DATA_KEY,this),e.contains(this.element.ownerDocument.documentElement,this.tip)||e(a).appendTo(d),e(this.element).trigger(this.constructor.Event.INSERTED),this._popper=new n(this.element,a,{placement:c,modifiers:{offset:{offset:this.config.offset},flip:{behavior:this.config.fallbackPlacement},arrow:{element:_.ARROW}},onCreate:function(e){e.originalPlacement!==e.placement&&t._handlePopperPlacementChange(e)},onUpdate:function(e){t._handlePopperPlacementChange(e)}}),e(a).addClass(f.SHOW),"ontouchstart"in document.documentElement&&e("body").children().on("mouseover",null,e.noop);var g=function(){t.config.animation&&t._fixTransition();var n=t._hoverState;t._hoverState=null,e(t.element).trigger(t.constructor.Event.SHOWN),n===u.OUT&&t._leave(null,t)};s.supportsTransitionEnd()&&e(this.tip).hasClass(f.FADE)?e(this.tip).one(s.TRANSITION_END,g).emulateTransitionEnd(o._TRANSITION_DURATION):g()}},m.hide=function(t){var n=this,i=this.getTipElement(),r=e.Event(this.constructor.Event.HIDE),o=function(){n._hoverState!==u.SHOW&&i.parentNode&&i.parentNode.removeChild(i),n._cleanTipClass(),n.element.removeAttribute("aria-describedby"),e(n.element).trigger(n.constructor.Event.HIDDEN),null!==n._popper&&n._popper.destroy(),t&&t()};e(this.element).trigger(r),r.isDefaultPrevented()||(e(i).removeClass(f.SHOW),"ontouchstart"in document.documentElement&&e("body").children().off("mouseover",null,e.noop),this._activeTrigger[g.CLICK]=!1,this._activeTrigger[g.FOCUS]=!1,this._activeTrigger[g.HOVER]=!1,s.supportsTransitionEnd()&&e(this.tip).hasClass(f.FADE)?e(i).one(s.TRANSITION_END,o).emulateTransitionEnd(150):o(),this._hoverState="")},m.update=function(){null!==this._popper&&this._popper.scheduleUpdate()},m.isWithContent=function(){return Boolean(this.getTitle())},m.addAttachmentClass=function(t){e(this.getTipElement()).addClass("bs-tooltip-"+t)},m.getTipElement=function(){return this.tip=this.tip||e(this.config.template)[0],this.tip},m.setContent=function(){var t=e(this.getTipElement());this.setElementContent(t.find(_.TOOLTIP_INNER),this.getTitle()),t.removeClass(f.FADE+" "+f.SHOW)},m.setElementContent=function(t,n){var i=this.config.html;"object"==typeof n&&(n.nodeType||n.jquery)?i?e(n).parent().is(t)||t.empty().append(n):t.text(e(n).text()):t[i?"html":"text"](n)},m.getTitle=function(){var t=this.element.getAttribute("data-original-title");return t||(t="function"==typeof this.config.title?this.config.title.call(this.element):this.config.title),t},m._getAttachment=function(t){return h[t.toUpperCase()]},m._setListeners=function(){var t=this;this.config.trigger.split(" ").forEach(function(n){if("click"===n)e(t.element).on(t.constructor.Event.CLICK,t.config.selector,function(e){return t.toggle(e)});else if(n!==g.MANUAL){var i=n===g.HOVER?t.constructor.Event.MOUSEENTER:t.constructor.Event.FOCUSIN,s=n===g.HOVER?t.constructor.Event.MOUSELEAVE:t.constructor.Event.FOCUSOUT;e(t.element).on(i,t.config.selector,function(e){return t._enter(e)}).on(s,t.config.selector,function(e){return t._leave(e)})}e(t.element).closest(".modal").on("hide.bs.modal",function(){return t.hide()})}),this.config.selector?this.config=e.extend({},this.config,{trigger:"manual",selector:""}):this._fixTitle()},m._fixTitle=function(){var t=typeof this.element.getAttribute("data-original-title");(this.element.getAttribute("title")||"string"!==t)&&(this.element.setAttribute("data-original-title",this.element.getAttribute("title")||""),this.element.setAttribute("title",""))},m._enter=function(t,n){var i=this.constructor.DATA_KEY;(n=n||e(t.currentTarget).data(i))||(n=new this.constructor(t.currentTarget,this._getDelegateConfig()),e(t.currentTarget).data(i,n)),t&&(n._activeTrigger["focusin"===t.type?g.FOCUS:g.HOVER]=!0),e(n.getTipElement()).hasClass(f.SHOW)||n._hoverState===u.SHOW?n._hoverState=u.SHOW:(clearTimeout(n._timeout),n._hoverState=u.SHOW,n.config.delay&&n.config.delay.show?n._timeout=setTimeout(function(){n._hoverState===u.SHOW&&n.show()},n.config.delay.show):n.show())},m._leave=function(t,n){var i=this.constructor.DATA_KEY;(n=n||e(t.currentTarget).data(i))||(n=new this.constructor(t.currentTarget,this._getDelegateConfig()),e(t.currentTarget).data(i,n)),t&&(n._activeTrigger["focusout"===t.type?g.FOCUS:g.HOVER]=!1),n._isWithActiveTrigger()||(clearTimeout(n._timeout),n._hoverState=u.OUT,n.config.delay&&n.config.delay.hide?n._timeout=setTimeout(function(){n._hoverState===u.OUT&&n.hide()},n.config.delay.hide):n.hide())},m._isWithActiveTrigger=function(){for(var t in this._activeTrigger)if(this._activeTrigger[t])return!0;return!1},m._getConfig=function(n){return"number"==typeof(n=e.extend({},this.constructor.Default,e(this.element).data(),n)).delay&&(n.delay={show:n.delay,hide:n.delay}),"number"==typeof n.title&&(n.title=n.title.toString()),"number"==typeof n.content&&(n.content=n.content.toString()),s.typeCheckConfig(t,n,this.constructor.DefaultType),n},m._getDelegateConfig=function(){var t={};if(this.config)for(var e in this.config)this.constructor.Default[e]!==this.config[e]&&(t[e]=this.config[e]);return t},m._cleanTipClass=function(){var t=e(this.getTipElement()),n=t.attr("class").match(a);null!==n&&n.length>0&&t.removeClass(n.join(""))},m._handlePopperPlacementChange=function(t){this._cleanTipClass(),this.addAttachmentClass(this._getAttachment(t.placement))},m._fixTransition=function(){var t=this.getTipElement(),n=this.config.animation;null===t.getAttribute("x-placement")&&(e(t).removeClass(f.FADE),this.config.animation=!1,this.hide(),this.show(),this.config.animation=n)},o._jQueryInterface=function(t){return this.each(function(){var n=e(this).data("bs.tooltip"),i="object"==typeof t&&t;if((n||!/dispose|hide/.test(t))&&(n||(n=new o(this,i),e(this).data("bs.tooltip",n)),"string"==typeof t)){if("undefined"==typeof n[t])throw new Error('No method named "'+t+'"');n[t]()}})},r(o,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return c}},{key:"NAME",get:function(){return t}},{key:"DATA_KEY",get:function(){return"bs.tooltip"}},{key:"Event",get:function(){return d}},{key:"EVENT_KEY",get:function(){return i}},{key:"DefaultType",get:function(){return l}}]),o}();return e.fn[t]=m._jQueryInterface,e.fn[t].Constructor=m,e.fn[t].noConflict=function(){return e.fn[t]=o,m._jQueryInterface},m}(),_=function(){var t="popover",n=".bs.popover",i=e.fn[t],s=new RegExp("(^|\\s)bs-popover\\S+","g"),a=e.extend({},f.Default,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'}),l=e.extend({},f.DefaultType,{content:"(string|element|function)"}),h={FADE:"fade",SHOW:"show"},c={TITLE:".popover-header",CONTENT:".popover-body"},u={HIDE:"hide"+n,HIDDEN:"hidden"+n,SHOW:"show"+n,SHOWN:"shown"+n,INSERTED:"inserted"+n,CLICK:"click"+n,FOCUSIN:"focusin"+n,FOCUSOUT:"focusout"+n,MOUSEENTER:"mouseenter"+n,MOUSELEAVE:"mouseleave"+n},d=function(i){function d(){return i.apply(this,arguments)||this}o(d,i);var f=d.prototype;return f.isWithContent=function(){return this.getTitle()||this._getContent()},f.addAttachmentClass=function(t){e(this.getTipElement()).addClass("bs-popover-"+t)},f.getTipElement=function(){return this.tip=this.tip||e(this.config.template)[0],this.tip},f.setContent=function(){var t=e(this.getTipElement());this.setElementContent(t.find(c.TITLE),this.getTitle()),this.setElementContent(t.find(c.CONTENT),this._getContent()),t.removeClass(h.FADE+" "+h.SHOW)},f._getContent=function(){return this.element.getAttribute("data-content")||("function"==typeof this.config.content?this.config.content.call(this.element):this.config.content)},f._cleanTipClass=function(){var t=e(this.getTipElement()),n=t.attr("class").match(s);null!==n&&n.length>0&&t.removeClass(n.join(""))},d._jQueryInterface=function(t){return this.each(function(){var n=e(this).data("bs.popover"),i="object"==typeof t?t:null;if((n||!/destroy|hide/.test(t))&&(n||(n=new d(this,i),e(this).data("bs.popover",n)),"string"==typeof t)){if("undefined"==typeof n[t])throw new Error('No method named "'+t+'"');n[t]()}})},r(d,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return a}},{key:"NAME",get:function(){return t}},{key:"DATA_KEY",get:function(){return"bs.popover"}},{key:"Event",get:function(){return u}},{key:"EVENT_KEY",get:function(){return n}},{key:"DefaultType",get:function(){return l}}]),d}(f);return e.fn[t]=d._jQueryInterface,e.fn[t].Constructor=d,e.fn[t].noConflict=function(){return e.fn[t]=i,d._jQueryInterface},d}(),g=function(){var t="scrollspy",n=e.fn[t],i={offset:10,method:"auto",target:""},o={offset:"number",method:"string",target:"(string|element)"},a={ACTIVATE:"activate.bs.scrollspy",SCROLL:"scroll.bs.scrollspy",LOAD_DATA_API:"load.bs.scrollspy.data-api"},l={DROPDOWN_ITEM:"dropdown-item",DROPDOWN_MENU:"dropdown-menu",ACTIVE:"active"},h={DATA_SPY:'[data-spy="scroll"]',ACTIVE:".active",NAV_LIST_GROUP:".nav, .list-group",NAV_LINKS:".nav-link",NAV_ITEMS:".nav-item",LIST_ITEMS:".list-group-item",DROPDOWN:".dropdown",DROPDOWN_ITEMS:".dropdown-item",DROPDOWN_TOGGLE:".dropdown-toggle"},c={OFFSET:"offset",POSITION:"position"},u=function(){function n(t,n){var i=this;this._element=t,this._scrollElement="BODY"===t.tagName?window:t,this._config=this._getConfig(n),this._selector=this._config.target+" "+h.NAV_LINKS+","+this._config.target+" "+h.LIST_ITEMS+","+this._config.target+" "+h.DROPDOWN_ITEMS,this._offsets=[],this._targets=[],this._activeTarget=null,this._scrollHeight=0,e(this._scrollElement).on(a.SCROLL,function(t){return i._process(t)}),this.refresh(),this._process()}var u=n.prototype;return u.refresh=function(){var t=this,n=this._scrollElement!==this._scrollElement.window?c.POSITION:c.OFFSET,i="auto"===this._config.method?n:this._config.method,r=i===c.POSITION?this._getScrollTop():0;this._offsets=[],this._targets=[],this._scrollHeight=this._getScrollHeight(),e.makeArray(e(this._selector)).map(function(t){var n,o=s.getSelectorFromElement(t);if(o&&(n=e(o)[0]),n){var a=n.getBoundingClientRect();if(a.width||a.height)return[e(n)[i]().top+r,o]}return null}).filter(function(t){return t}).sort(function(t,e){return t[0]-e[0]}).forEach(function(e){t._offsets.push(e[0]),t._targets.push(e[1])})},u.dispose=function(){e.removeData(this._element,"bs.scrollspy"),e(this._scrollElement).off(".bs.scrollspy"),this._element=null,this._scrollElement=null,this._config=null,this._selector=null,this._offsets=null,this._targets=null,this._activeTarget=null,this._scrollHeight=null},u._getConfig=function(n){if("string"!=typeof(n=e.extend({},i,n)).target){var r=e(n.target).attr("id");r||(r=s.getUID(t),e(n.target).attr("id",r)),n.target="#"+r}return s.typeCheckConfig(t,n,o),n},u._getScrollTop=function(){return this._scrollElement===window?this._scrollElement.pageYOffset:this._scrollElement.scrollTop},u._getScrollHeight=function(){return this._scrollElement.scrollHeight||Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)},u._getOffsetHeight=function(){return this._scrollElement===window?window.innerHeight:this._scrollElement.getBoundingClientRect().height},u._process=function(){var t=this._getScrollTop()+this._config.offset,e=this._getScrollHeight(),n=this._config.offset+e-this._getOffsetHeight();if(this._scrollHeight!==e&&this.refresh(),t>=n){var i=this._targets[this._targets.length-1];this._activeTarget!==i&&this._activate(i)}else{if(this._activeTarget&&t<this._offsets[0]&&this._offsets[0]>0)return this._activeTarget=null,void this._clear();for(var s=this._offsets.length;s--;)this._activeTarget!==this._targets[s]&&t>=this._offsets[s]&&("undefined"==typeof this._offsets[s+1]||t<this._offsets[s+1])&&this._activate(this._targets[s])}},u._activate=function(t){this._activeTarget=t,this._clear();var n=this._selector.split(",");n=n.map(function(e){return e+'[data-target="'+t+'"],'+e+'[href="'+t+'"]'});var i=e(n.join(","));i.hasClass(l.DROPDOWN_ITEM)?(i.closest(h.DROPDOWN).find(h.DROPDOWN_TOGGLE).addClass(l.ACTIVE),i.addClass(l.ACTIVE)):(i.addClass(l.ACTIVE),i.parents(h.NAV_LIST_GROUP).prev(h.NAV_LINKS+", "+h.LIST_ITEMS).addClass(l.ACTIVE),i.parents(h.NAV_LIST_GROUP).prev(h.NAV_ITEMS).children(h.NAV_LINKS).addClass(l.ACTIVE)),e(this._scrollElement).trigger(a.ACTIVATE,{relatedTarget:t})},u._clear=function(){e(this._selector).filter(h.ACTIVE).removeClass(l.ACTIVE)},n._jQueryInterface=function(t){return this.each(function(){var i=e(this).data("bs.scrollspy"),s="object"==typeof t&&t;if(i||(i=new n(this,s),e(this).data("bs.scrollspy",i)),"string"==typeof t){if("undefined"==typeof i[t])throw new Error('No method named "'+t+'"');i[t]()}})},r(n,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}},{key:"Default",get:function(){return i}}]),n}();return e(window).on(a.LOAD_DATA_API,function(){for(var t=e.makeArray(e(h.DATA_SPY)),n=t.length;n--;){var i=e(t[n]);u._jQueryInterface.call(i,i.data())}}),e.fn[t]=u._jQueryInterface,e.fn[t].Constructor=u,e.fn[t].noConflict=function(){return e.fn[t]=n,u._jQueryInterface},u}(),m=function(){var t=e.fn.tab,n={HIDE:"hide.bs.tab",HIDDEN:"hidden.bs.tab",SHOW:"show.bs.tab",SHOWN:"shown.bs.tab",CLICK_DATA_API:"click.bs.tab.data-api"},i={DROPDOWN_MENU:"dropdown-menu",ACTIVE:"active",DISABLED:"disabled",FADE:"fade",SHOW:"show"},o={DROPDOWN:".dropdown",NAV_LIST_GROUP:".nav, .list-group",ACTIVE:".active",ACTIVE_UL:"> li > .active",DATA_TOGGLE:'[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',DROPDOWN_TOGGLE:".dropdown-toggle",DROPDOWN_ACTIVE_CHILD:"> .dropdown-menu .active"},a=function(){function t(t){this._element=t}var a=t.prototype;return a.show=function(){var t=this;if(!(this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE&&e(this._element).hasClass(i.ACTIVE)||e(this._element).hasClass(i.DISABLED))){var r,a,l=e(this._element).closest(o.NAV_LIST_GROUP)[0],h=s.getSelectorFromElement(this._element);if(l){var c="UL"===l.nodeName?o.ACTIVE_UL:o.ACTIVE;a=e.makeArray(e(l).find(c)),a=a[a.length-1]}var u=e.Event(n.HIDE,{relatedTarget:this._element}),d=e.Event(n.SHOW,{relatedTarget:a});if(a&&e(a).trigger(u),e(this._element).trigger(d),!d.isDefaultPrevented()&&!u.isDefaultPrevented()){h&&(r=e(h)[0]),this._activate(this._element,l);var f=function(){var i=e.Event(n.HIDDEN,{relatedTarget:t._element}),s=e.Event(n.SHOWN,{relatedTarget:a});e(a).trigger(i),e(t._element).trigger(s)};r?this._activate(r,r.parentNode,f):f()}}},a.dispose=function(){e.removeData(this._element,"bs.tab"),this._element=null},a._activate=function(t,n,r){var a,l=this,h=(a="UL"===n.nodeName?e(n).find(o.ACTIVE_UL):e(n).children(o.ACTIVE))[0],c=r&&s.supportsTransitionEnd()&&h&&e(h).hasClass(i.FADE),u=function(){return l._transitionComplete(t,h,c,r)};h&&c?e(h).one(s.TRANSITION_END,u).emulateTransitionEnd(150):u(),h&&e(h).removeClass(i.SHOW)},a._transitionComplete=function(t,n,r,a){if(n){e(n).removeClass(i.ACTIVE);var l=e(n.parentNode).find(o.DROPDOWN_ACTIVE_CHILD)[0];l&&e(l).removeClass(i.ACTIVE),"tab"===n.getAttribute("role")&&n.setAttribute("aria-selected",!1)}if(e(t).addClass(i.ACTIVE),"tab"===t.getAttribute("role")&&t.setAttribute("aria-selected",!0),r?(s.reflow(t),e(t).addClass(i.SHOW)):e(t).removeClass(i.FADE),t.parentNode&&e(t.parentNode).hasClass(i.DROPDOWN_MENU)){var h=e(t).closest(o.DROPDOWN)[0];h&&e(h).find(o.DROPDOWN_TOGGLE).addClass(i.ACTIVE),t.setAttribute("aria-expanded",!0)}a&&a()},t._jQueryInterface=function(n){return this.each(function(){var i=e(this),s=i.data("bs.tab");if(s||(s=new t(this),i.data("bs.tab",s)),"string"==typeof n){if("undefined"==typeof s[n])throw new Error('No method named "'+n+'"');s[n]()}})},r(t,null,[{key:"VERSION",get:function(){return"4.0.0-beta.2"}}]),t}();return e(document).on(n.CLICK_DATA_API,o.DATA_TOGGLE,function(t){t.preventDefault(),a._jQueryInterface.call(e(this),"show")}),e.fn.tab=a._jQueryInterface,e.fn.tab.Constructor=a,e.fn.tab.noConflict=function(){return e.fn.tab=t,a._jQueryInterface},a}();return function(){if("undefined"==typeof e)throw new Error("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var t=e.fn.jquery.split(" ")[0].split(".");if(t[0]<2&&t[1]<9||1===t[0]&&9===t[1]&&t[2]<1||t[0]>=4)throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")}(),t.Util=s,t.Alert=a,t.Button=l,t.Carousel=h,t.Collapse=c,t.Dropdown=u,t.Modal=d,t.Popover=_,t.Scrollspy=g,t.Tab=m,t.Tooltip=f,t}({},$,Popper);
//# sourceMappingURL=bootstrap.min.js.map
/**
 * Owl Carousel v2.3.0
 * Copyright 2013-2017 David Deutsch
 * Licensed under  ()
 */
! function(a, b, c, d) {
    function e(b, c) { this.settings = null, this.options = a.extend({}, e.Defaults, c), this.$element = a(b), this._handlers = {}, this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._widths = [], this._invalidated = {}, this._pipe = [], this._drag = { time: null, target: null, pointer: null, stage: { start: null, current: null }, direction: null }, this._states = { current: {}, tags: { initializing: ["busy"], animating: ["busy"], dragging: ["interacting"] } }, a.each(["onResize", "onThrottledResize"], a.proxy(function(b, c) { this._handlers[c] = a.proxy(this[c], this) }, this)), a.each(e.Plugins, a.proxy(function(a, b) { this._plugins[a.charAt(0).toLowerCase() + a.slice(1)] = new b(this) }, this)), a.each(e.Workers, a.proxy(function(b, c) { this._pipe.push({ filter: c.filter, run: a.proxy(c.run, this) }) }, this)), this.setup(), this.initialize() } e.Defaults = { items: 3, loop: !1, center: !1, rewind: !1, mouseDrag: !0, touchDrag: !0, pullDrag: !0, freeDrag: !1, margin: 0, stagePadding: 0, merge: !1, mergeFit: !0, autoWidth: !1, startPosition: 0, rtl: !1, smartSpeed: 250, fluidSpeed: !1, dragEndSpeed: !1, responsive: {}, responsiveRefreshRate: 200, responsiveBaseElement: b, fallbackEasing: "swing", info: !1, nestedItemSelector: !1, itemElement: "div", stageElement: "div", refreshClass: "owl-refresh", loadedClass: "owl-loaded", loadingClass: "owl-loading", rtlClass: "owl-rtl", responsiveClass: "owl-responsive", dragClass: "owl-drag", itemClass: "owl-item", stageClass: "owl-stage", stageOuterClass: "owl-stage-outer", grabClass: "owl-grab" }, e.Width = { Default: "default", Inner: "inner", Outer: "outer" }, e.Type = { Event: "event", State: "state" }, e.Plugins = {}, e.Workers = [{ filter: ["width", "settings"], run: function() { this._width = this.$element.width() } }, { filter: ["width", "items", "settings"], run: function(a) { a.current = this._items && this._items[this.relative(this._current)] } }, { filter: ["items", "settings"], run: function() { this.$stage.children(".cloned").remove() } }, { filter: ["width", "items", "settings"], run: function(a) { var b = this.settings.margin || "",
                c = !this.settings.autoWidth,
                d = this.settings.rtl,
                e = { width: "auto", "margin-left": d ? b : "", "margin-right": d ? "" : b };!c && this.$stage.children().css(e), a.css = e } }, { filter: ["width", "items", "settings"], run: function(a) { var b = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                c = null,
                d = this._items.length,
                e = !this.settings.autoWidth,
                f = []; for (a.items = { merge: !1, width: b }; d--;) c = this._mergers[d], c = this.settings.mergeFit && Math.min(c, this.settings.items) || c, a.items.merge = c > 1 || a.items.merge, f[d] = e ? b * c : this._items[d].width();
            this._widths = f } }, { filter: ["items", "settings"], run: function() { var b = [],
                c = this._items,
                d = this.settings,
                e = Math.max(2 * d.items, 4),
                f = 2 * Math.ceil(c.length / 2),
                g = d.loop && c.length ? d.rewind ? e : Math.max(e, f) : 0,
                h = "",
                i = ""; for (g /= 2; g > 0;) b.push(this.normalize(b.length / 2, !0)), h += c[b[b.length - 1]][0].outerHTML, b.push(this.normalize(c.length - 1 - (b.length - 1) / 2, !0)), i = c[b[b.length - 1]][0].outerHTML + i, g -= 1;
            this._clones = b, a(h).addClass("cloned").appendTo(this.$stage), a(i).addClass("cloned").prependTo(this.$stage) } }, { filter: ["width", "items", "settings"], run: function() { for (var a = this.settings.rtl ? 1 : -1, b = this._clones.length + this._items.length, c = -1, d = 0, e = 0, f = []; ++c < b;) d = f[c - 1] || 0, e = this._widths[this.relative(c)] + this.settings.margin, f.push(d + e * a);
            this._coordinates = f } }, { filter: ["width", "items", "settings"], run: function() { var a = this.settings.stagePadding,
                b = this._coordinates,
                c = { width: Math.ceil(Math.abs(b[b.length - 1])) + 2 * a, "padding-left": a || "", "padding-right": a || "" };
            this.$stage.css(c) } }, { filter: ["width", "items", "settings"], run: function(a) { var b = this._coordinates.length,
                c = !this.settings.autoWidth,
                d = this.$stage.children(); if (c && a.items.merge)
                for (; b--;) a.css.width = this._widths[this.relative(b)], d.eq(b).css(a.css);
            else c && (a.css.width = a.items.width, d.css(a.css)) } }, { filter: ["items"], run: function() { this._coordinates.length < 1 && this.$stage.removeAttr("style") } }, { filter: ["width", "items", "settings"], run: function(a) { a.current = a.current ? this.$stage.children().index(a.current) : 0, a.current = Math.max(this.minimum(), Math.min(this.maximum(), a.current)), this.reset(a.current) } }, { filter: ["position"], run: function() { this.animate(this.coordinates(this._current)) } }, { filter: ["width", "position", "items", "settings"], run: function() { var a, b, c, d, e = this.settings.rtl ? 1 : -1,
                f = 2 * this.settings.stagePadding,
                g = this.coordinates(this.current()) + f,
                h = g + this.width() * e,
                i = []; for (c = 0, d = this._coordinates.length; d > c; c++) a = this._coordinates[c - 1] || 0, b = Math.abs(this._coordinates[c]) + f * e, (this.op(a, "<=", g) && this.op(a, ">", h) || this.op(b, "<", g) && this.op(b, ">", h)) && i.push(c);
            this.$stage.children(".active").removeClass("active"), this.$stage.children(":eq(" + i.join("), :eq(") + ")").addClass("active"), this.$stage.children(".center").removeClass("center"), this.settings.center && this.$stage.children().eq(this.current()).addClass("center") } }], e.prototype.initialize = function() { if (this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading")) { var b, c, e;
            b = this.$element.find("img"), c = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : d, e = this.$element.children(c).width(), b.length && 0 >= e && this.preloadAutoWidthImages(b) } this.$element.addClass(this.options.loadingClass), this.$stage = a("<" + this.settings.stageElement + ' class="' + this.settings.stageClass + '"/>').wrap('<div class="' + this.settings.stageOuterClass + '"/>'), this.$element.append(this.$stage.parent()), this.replace(this.$element.children().not(this.$stage.parent())), this.$element.is(":visible") ? this.refresh() : this.invalidate("width"), this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass), this.registerEventHandlers(), this.leave("initializing"), this.trigger("initialized") }, e.prototype.setup = function() { var b = this.viewport(),
            c = this.options.responsive,
            d = -1,
            e = null;
        c ? (a.each(c, function(a) { b >= a && a > d && (d = Number(a)) }), e = a.extend({}, this.options, c[d]), "function" == typeof e.stagePadding && (e.stagePadding = e.stagePadding()), delete e.responsive, e.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + d))) : e = a.extend({}, this.options), this.trigger("change", { property: { name: "settings", value: e } }), this._breakpoint = d, this.settings = e, this.invalidate("settings"), this.trigger("changed", { property: { name: "settings", value: this.settings } }) }, e.prototype.optionsLogic = function() { this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1) }, e.prototype.prepare = function(b) { var c = this.trigger("prepare", { content: b }); return c.data || (c.data = a("<" + this.settings.itemElement + "/>").addClass(this.options.itemClass).append(b)), this.trigger("prepared", { content: c.data }), c.data }, e.prototype.update = function() { for (var b = 0, c = this._pipe.length, d = a.proxy(function(a) { return this[a] }, this._invalidated), e = {}; c > b;)(this._invalidated.all || a.grep(this._pipe[b].filter, d).length > 0) && this._pipe[b].run(e), b++;
        this._invalidated = {}, !this.is("valid") && this.enter("valid") }, e.prototype.width = function(a) { switch (a = a || e.Width.Default) {
            case e.Width.Inner:
            case e.Width.Outer:
                return this._width;
            default:
                return this._width - 2 * this.settings.stagePadding + this.settings.margin } }, e.prototype.refresh = function() { this.enter("refreshing"), this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$element.addClass(this.options.refreshClass), this.update(), this.$element.removeClass(this.options.refreshClass), this.leave("refreshing"), this.trigger("refreshed") }, e.prototype.onThrottledResize = function() { b.clearTimeout(this.resizeTimer), this.resizeTimer = b.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate) }, e.prototype.onResize = function() { return this._items.length ? this._width === this.$element.width() ? !1 : this.$element.is(":visible") ? (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized"))) : !1 : !1 }, e.prototype.registerEventHandlers = function() { a.support.transition && this.$stage.on(a.support.transition.end + ".owl.core", a.proxy(this.onTransitionEnd, this)), this.settings.responsive !== !1 && this.on(b, "resize", this._handlers.onThrottledResize), this.settings.mouseDrag && (this.$element.addClass(this.options.dragClass), this.$stage.on("mousedown.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("dragstart.owl.core selectstart.owl.core", function() { return !1 })), this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", a.proxy(this.onDragEnd, this))) }, e.prototype.onDragStart = function(b) { var d = null;
        3 !== b.which && (a.support.transform ? (d = this.$stage.css("transform").replace(/.*\(|\)| /g, "").split(","), d = { x: d[16 === d.length ? 12 : 4], y: d[16 === d.length ? 13 : 5] }) : (d = this.$stage.position(), d = { x: this.settings.rtl ? d.left + this.$stage.width() - this.width() + this.settings.margin : d.left, y: d.top }), this.is("animating") && (a.support.transform ? this.animate(d.x) : this.$stage.stop(), this.invalidate("position")), this.$element.toggleClass(this.options.grabClass, "mousedown" === b.type), this.speed(0), this._drag.time = (new Date).getTime(), this._drag.target = a(b.target), this._drag.stage.start = d, this._drag.stage.current = d, this._drag.pointer = this.pointer(b), a(c).on("mouseup.owl.core touchend.owl.core", a.proxy(this.onDragEnd, this)), a(c).one("mousemove.owl.core touchmove.owl.core", a.proxy(function(b) { var d = this.difference(this._drag.pointer, this.pointer(b));
            a(c).on("mousemove.owl.core touchmove.owl.core", a.proxy(this.onDragMove, this)), Math.abs(d.x) < Math.abs(d.y) && this.is("valid") || (b.preventDefault(), this.enter("dragging"), this.trigger("drag")) }, this))) }, e.prototype.onDragMove = function(a) { var b = null,
            c = null,
            d = null,
            e = this.difference(this._drag.pointer, this.pointer(a)),
            f = this.difference(this._drag.stage.start, e);
        this.is("dragging") && (a.preventDefault(), this.settings.loop ? (b = this.coordinates(this.minimum()), c = this.coordinates(this.maximum() + 1) - b, f.x = ((f.x - b) % c + c) % c + b) : (b = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), c = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), d = this.settings.pullDrag ? -1 * e.x / 5 : 0, f.x = Math.max(Math.min(f.x, b + d), c + d)), this._drag.stage.current = f, this.animate(f.x)) }, e.prototype.onDragEnd = function(b) { var d = this.difference(this._drag.pointer, this.pointer(b)),
            e = this._drag.stage.current,
            f = d.x > 0 ^ this.settings.rtl ? "left" : "right";
        a(c).off(".owl.core"), this.$element.removeClass(this.options.grabClass), (0 !== d.x && this.is("dragging") || !this.is("valid")) && (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(this.closest(e.x, 0 !== d.x ? f : this._drag.direction)), this.invalidate("position"), this.update(), this._drag.direction = f, (Math.abs(d.x) > 3 || (new Date).getTime() - this._drag.time > 300) && this._drag.target.one("click.owl.core", function() { return !1 })), this.is("dragging") && (this.leave("dragging"), this.trigger("dragged")) }, e.prototype.closest = function(b, c) { var d = -1,
            e = 30,
            f = this.width(),
            g = this.coordinates(); return this.settings.freeDrag || a.each(g, a.proxy(function(a, h) { return "left" === c && b > h - e && h + e > b ? d = a : "right" === c && b > h - f - e && h - f + e > b ? d = a + 1 : this.op(b, "<", h) && this.op(b, ">", g[a + 1] || h - f) && (d = "left" === c ? a + 1 : a), -1 === d }, this)), this.settings.loop || (this.op(b, ">", g[this.minimum()]) ? d = b = this.minimum() : this.op(b, "<", g[this.maximum()]) && (d = b = this.maximum())), d }, e.prototype.animate = function(b) { var c = this.speed() > 0;
        this.is("animating") && this.onTransitionEnd(), c && (this.enter("animating"), this.trigger("translate")), a.support.transform3d && a.support.transition ? this.$stage.css({ transform: "translate3d(" + b + "px,0px,0px)", transition: this.speed() / 1e3 + "s" }) : c ? this.$stage.animate({ left: b + "px" }, this.speed(), this.settings.fallbackEasing, a.proxy(this.onTransitionEnd, this)) : this.$stage.css({ left: b + "px" }) }, e.prototype.is = function(a) { return this._states.current[a] && this._states.current[a] > 0 }, e.prototype.current = function(a) { if (a === d) return this._current; if (0 === this._items.length) return d; if (a = this.normalize(a), this._current !== a) { var b = this.trigger("change", { property: { name: "position", value: a } });
            b.data !== d && (a = this.normalize(b.data)), this._current = a, this.invalidate("position"), this.trigger("changed", { property: { name: "position", value: this._current } }) } return this._current }, e.prototype.invalidate = function(b) { return "string" === a.type(b) && (this._invalidated[b] = !0, this.is("valid") && this.leave("valid")), a.map(this._invalidated, function(a, b) { return b }) }, e.prototype.reset = function(a) { a = this.normalize(a), a !== d && (this._speed = 0, this._current = a, this.suppress(["translate", "translated"]), this.animate(this.coordinates(a)), this.release(["translate", "translated"])) }, e.prototype.normalize = function(a, b) { var c = this._items.length,
            e = b ? 0 : this._clones.length; return !this.isNumeric(a) || 1 > c ? a = d : (0 > a || a >= c + e) && (a = ((a - e / 2) % c + c) % c + e / 2), a }, e.prototype.relative = function(a) { return a -= this._clones.length / 2, this.normalize(a, !0) }, e.prototype.maximum = function(a) { var b, c, d, e = this.settings,
            f = this._coordinates.length; if (e.loop) f = this._clones.length / 2 + this._items.length - 1;
        else if (e.autoWidth || e.merge) { if (b = this._items.length)
                for (c = this._items[--b].width(), d = this.$element.width(); b-- && (c += this._items[b].width() + this.settings.margin, !(c > d)););
            f = b + 1 } else f = e.center ? this._items.length - 1 : this._items.length - e.items; return a && (f -= this._clones.length / 2), Math.max(f, 0) }, e.prototype.minimum = function(a) { return a ? 0 : this._clones.length / 2 }, e.prototype.items = function(a) { return a === d ? this._items.slice() : (a = this.normalize(a, !0), this._items[a]) }, e.prototype.mergers = function(a) { return a === d ? this._mergers.slice() : (a = this.normalize(a, !0), this._mergers[a]) }, e.prototype.clones = function(b) { var c = this._clones.length / 2,
            e = c + this._items.length,
            f = function(a) { return a % 2 === 0 ? e + a / 2 : c - (a + 1) / 2 }; return b === d ? a.map(this._clones, function(a, b) { return f(b) }) : a.map(this._clones, function(a, c) { return a === b ? f(c) : null }) }, e.prototype.speed = function(a) { return a !== d && (this._speed = a), this._speed }, e.prototype.coordinates = function(b) { var c, e = 1,
            f = b - 1; return b === d ? a.map(this._coordinates, a.proxy(function(a, b) { return this.coordinates(b) }, this)) : (this.settings.center ? (this.settings.rtl && (e = -1, f = b + 1), c = this._coordinates[b], c += (this.width() - c + (this._coordinates[f] || 0)) / 2 * e) : c = this._coordinates[f] || 0, c = Math.ceil(c)) }, e.prototype.duration = function(a, b, c) { return 0 === c ? 0 : Math.min(Math.max(Math.abs(b - a), 1), 6) * Math.abs(c || this.settings.smartSpeed) }, e.prototype.to = function(a, b) { var c = this.current(),
            d = null,
            e = a - this.relative(c),
            f = (e > 0) - (0 > e),
            g = this._items.length,
            h = this.minimum(),
            i = this.maximum();
        this.settings.loop ? (!this.settings.rewind && Math.abs(e) > g / 2 && (e += -1 * f * g), a = c + e, d = ((a - h) % g + g) % g + h, d !== a && i >= d - e && d - e > 0 && (c = d - e, a = d, this.reset(c))) : this.settings.rewind ? (i += 1, a = (a % i + i) % i) : a = Math.max(h, Math.min(i, a)), this.speed(this.duration(c, a, b)), this.current(a), this.$element.is(":visible") && this.update() }, e.prototype.next = function(a) { a = a || !1, this.to(this.relative(this.current()) + 1, a) }, e.prototype.prev = function(a) { a = a || !1, this.to(this.relative(this.current()) - 1, a) }, e.prototype.onTransitionEnd = function(a) { return a !== d && (a.stopPropagation(), (a.target || a.srcElement || a.originalTarget) !== this.$stage.get(0)) ? !1 : (this.leave("animating"), void this.trigger("translated")) }, e.prototype.viewport = function() { var d; return this.options.responsiveBaseElement !== b ? d = a(this.options.responsiveBaseElement).width() : b.innerWidth ? d = b.innerWidth : c.documentElement && c.documentElement.clientWidth ? d = c.documentElement.clientWidth : console.warn("Can not detect viewport width."), d }, e.prototype.replace = function(b) { this.$stage.empty(), this._items = [], b && (b = b instanceof jQuery ? b : a(b)), this.settings.nestedItemSelector && (b = b.find("." + this.settings.nestedItemSelector)), b.filter(function() { return 1 === this.nodeType }).each(a.proxy(function(a, b) { b = this.prepare(b), this.$stage.append(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1) }, this)), this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items") }, e.prototype.add = function(b, c) { var e = this.relative(this._current);
        c = c === d ? this._items.length : this.normalize(c, !0), b = b instanceof jQuery ? b : a(b), this.trigger("add", { content: b, position: c }), b = this.prepare(b), 0 === this._items.length || c === this._items.length ? (0 === this._items.length && this.$stage.append(b), 0 !== this._items.length && this._items[c - 1].after(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)) : (this._items[c].before(b), this._items.splice(c, 0, b), this._mergers.splice(c, 0, 1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)), this._items[e] && this.reset(this._items[e].index()), this.invalidate("items"), this.trigger("added", { content: b, position: c }) }, e.prototype.remove = function(a) { a = this.normalize(a, !0), a !== d && (this.trigger("remove", { content: this._items[a], position: a }), this._items[a].remove(), this._items.splice(a, 1), this._mergers.splice(a, 1), this.invalidate("items"), this.trigger("removed", { content: null, position: a })) }, e.prototype.preloadAutoWidthImages = function(b) { b.each(a.proxy(function(b, c) { this.enter("pre-loading"), c = a(c), a(new Image).one("load", a.proxy(function(a) { c.attr("src", a.target.src), c.css("opacity", 1), this.leave("pre-loading"), !this.is("pre-loading") && !this.is("initializing") && this.refresh() }, this)).attr("src", c.attr("src") || c.attr("data-src") || c.attr("data-src-retina")) }, this)) }, e.prototype.destroy = function() { this.$element.off(".owl.core"), this.$stage.off(".owl.core"), a(c).off(".owl.core"), this.settings.responsive !== !1 && (b.clearTimeout(this.resizeTimer), this.off(b, "resize", this._handlers.onThrottledResize)); for (var d in this._plugins) this._plugins[d].destroy();
        this.$stage.children(".cloned").remove(), this.$stage.unwrap(), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$stage.remove(), this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), "")).removeData("owl.carousel") }, e.prototype.op = function(a, b, c) { var d = this.settings.rtl; switch (b) {
            case "<":
                return d ? a > c : c > a;
            case ">":
                return d ? c > a : a > c;
            case ">=":
                return d ? c >= a : a >= c;
            case "<=":
                return d ? a >= c : c >= a } }, e.prototype.on = function(a, b, c, d) { a.addEventListener ? a.addEventListener(b, c, d) : a.attachEvent && a.attachEvent("on" + b, c) }, e.prototype.off = function(a, b, c, d) { a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent && a.detachEvent("on" + b, c) }, e.prototype.trigger = function(b, c, d, f, g) { var h = { item: { count: this._items.length, index: this.current() } },
            i = a.camelCase(a.grep(["on", b, d], function(a) { return a }).join("-").toLowerCase()),
            j = a.Event([b, "owl", d || "carousel"].join(".").toLowerCase(), a.extend({ relatedTarget: this }, h, c)); return this._supress[b] || (a.each(this._plugins, function(a, b) { b.onTrigger && b.onTrigger(j) }), this.register({ type: e.Type.Event, name: b }), this.$element.trigger(j), this.settings && "function" == typeof this.settings[i] && this.settings[i].call(this, j)), j }, e.prototype.enter = function(b) { a.each([b].concat(this._states.tags[b] || []), a.proxy(function(a, b) { this._states.current[b] === d && (this._states.current[b] = 0), this._states.current[b]++ }, this)) }, e.prototype.leave = function(b) { a.each([b].concat(this._states.tags[b] || []), a.proxy(function(a, b) { this._states.current[b]-- }, this)) }, e.prototype.register = function(b) { if (b.type === e.Type.Event) { if (a.event.special[b.name] || (a.event.special[b.name] = {}), !a.event.special[b.name].owl) { var c = a.event.special[b.name]._default;
                a.event.special[b.name]._default = function(a) { return !c || !c.apply || a.namespace && -1 !== a.namespace.indexOf("owl") ? a.namespace && a.namespace.indexOf("owl") > -1 : c.apply(this, arguments) }, a.event.special[b.name].owl = !0 } } else b.type === e.Type.State && (this._states.tags[b.name] ? this._states.tags[b.name] = this._states.tags[b.name].concat(b.tags) : this._states.tags[b.name] = b.tags, this._states.tags[b.name] = a.grep(this._states.tags[b.name], a.proxy(function(c, d) { return a.inArray(c, this._states.tags[b.name]) === d }, this))) }, e.prototype.suppress = function(b) { a.each(b, a.proxy(function(a, b) { this._supress[b] = !0 }, this)) }, e.prototype.release = function(b) { a.each(b, a.proxy(function(a, b) { delete this._supress[b] }, this)) }, e.prototype.pointer = function(a) { var c = { x: null, y: null }; return a = a.originalEvent || a || b.event, a = a.touches && a.touches.length ? a.touches[0] : a.changedTouches && a.changedTouches.length ? a.changedTouches[0] : a, a.pageX ? (c.x = a.pageX, c.y = a.pageY) : (c.x = a.clientX, c.y = a.clientY), c }, e.prototype.isNumeric = function(a) { return !isNaN(parseFloat(a)) }, e.prototype.difference = function(a, b) { return { x: a.x - b.x, y: a.y - b.y } }, a.fn.owlCarousel = function(b) { var c = Array.prototype.slice.call(arguments, 1); return this.each(function() { var d = a(this),
                f = d.data("owl.carousel");
            f || (f = new e(this, "object" == typeof b && b), d.data("owl.carousel", f), a.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function(b, c) { f.register({ type: e.Type.Event, name: c }), f.$element.on(c + ".owl.carousel.core", a.proxy(function(a) { a.namespace && a.relatedTarget !== this && (this.suppress([c]), f[c].apply(this, [].slice.call(arguments, 1)), this.release([c])) }, f)) })), "string" == typeof b && "_" !== b.charAt(0) && f[b].apply(f, c) }) }, a.fn.owlCarousel.Constructor = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { var e = function(b) { this._core = b, this._interval = null, this._visible = null, this._handlers = { "initialized.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.autoRefresh && this.watch() }, this) }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers) };
    e.Defaults = { autoRefresh: !0, autoRefreshInterval: 500 }, e.prototype.watch = function() { this._interval || (this._visible = this._core.$element.is(":visible"), this._interval = b.setInterval(a.proxy(this.refresh, this), this._core.settings.autoRefreshInterval)) }, e.prototype.refresh = function() { this._core.$element.is(":visible") !== this._visible && (this._visible = !this._visible, this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh()) }, e.prototype.destroy = function() { var a, c;
        b.clearInterval(this._interval); for (a in this._handlers) this._core.$element.off(a, this._handlers[a]); for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null) }, a.fn.owlCarousel.Constructor.Plugins.AutoRefresh = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { var e = function(b) { this._core = b, this._loaded = [], this._handlers = { "initialized.owl.carousel change.owl.carousel resized.owl.carousel": a.proxy(function(b) { if (b.namespace && this._core.settings && this._core.settings.lazyLoad && (b.property && "position" == b.property.name || "initialized" == b.type))
                    for (var c = this._core.settings, e = c.center && Math.ceil(c.items / 2) || c.items, f = c.center && -1 * e || 0, g = (b.property && b.property.value !== d ? b.property.value : this._core.current()) + f, h = this._core.clones().length, i = a.proxy(function(a, b) { this.load(b) }, this); f++ < e;) this.load(h / 2 + this._core.relative(g)), h && a.each(this._core.clones(this._core.relative(g)), i), g++ }, this) }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers) };
    e.Defaults = { lazyLoad: !1 }, e.prototype.load = function(c) { var d = this._core.$stage.children().eq(c),
            e = d && d.find(".owl-lazy");!e || a.inArray(d.get(0), this._loaded) > -1 || (e.each(a.proxy(function(c, d) { var e, f = a(d),
                g = b.devicePixelRatio > 1 && f.attr("data-src-retina") || f.attr("data-src");
            this._core.trigger("load", { element: f, url: g }, "lazy"), f.is("img") ? f.one("load.owl.lazy", a.proxy(function() { f.css("opacity", 1), this._core.trigger("loaded", { element: f, url: g }, "lazy") }, this)).attr("src", g) : (e = new Image, e.onload = a.proxy(function() { f.css({ "background-image": 'url("' + g + '")', opacity: "1" }), this._core.trigger("loaded", { element: f, url: g }, "lazy") }, this), e.src = g) }, this)), this._loaded.push(d.get(0))) }, e.prototype.destroy = function() { var a, b; for (a in this.handlers) this._core.$element.off(a, this.handlers[a]); for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null) }, a.fn.owlCarousel.Constructor.Plugins.Lazy = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { var e = function(b) { this._core = b, this._handlers = { "initialized.owl.carousel refreshed.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.autoHeight && this.update() }, this), "changed.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.autoHeight && "position" == a.property.name && this.update() }, this), "loaded.owl.lazy": a.proxy(function(a) { a.namespace && this._core.settings.autoHeight && a.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update() }, this) }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers) };
    e.Defaults = { autoHeight: !1, autoHeightClass: "owl-height" }, e.prototype.update = function() { var b = this._core._current,
            c = b + this._core.settings.items,
            d = this._core.$stage.children().toArray().slice(b, c),
            e = [],
            f = 0;
        a.each(d, function(b, c) { e.push(a(c).height()) }), f = Math.max.apply(null, e), this._core.$stage.parent().height(f).addClass(this._core.settings.autoHeightClass) }, e.prototype.destroy = function() { var a, b; for (a in this._handlers) this._core.$element.off(a, this._handlers[a]); for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null) }, a.fn.owlCarousel.Constructor.Plugins.AutoHeight = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { var e = function(b) { this._core = b, this._videos = {}, this._playing = null, this._handlers = { "initialized.owl.carousel": a.proxy(function(a) { a.namespace && this._core.register({ type: "state", name: "playing", tags: ["interacting"] }) }, this), "resize.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.video && this.isInFullScreen() && a.preventDefault() }, this), "refreshed.owl.carousel": a.proxy(function(a) { a.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove() }, this), "changed.owl.carousel": a.proxy(function(a) { a.namespace && "position" === a.property.name && this._playing && this.stop() }, this), "prepared.owl.carousel": a.proxy(function(b) { if (b.namespace) { var c = a(b.content).find(".owl-video");
                    c.length && (c.css("display", "none"), this.fetch(c, a(b.content))) } }, this) }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", a.proxy(function(a) { this.play(a) }, this)) };
    e.Defaults = { video: !1, videoHeight: !1, videoWidth: !1 }, e.prototype.fetch = function(a, b) { var c = function() { return a.attr("data-vimeo-id") ? "vimeo" : a.attr("data-vzaar-id") ? "vzaar" : "youtube" }(),
            d = a.attr("data-vimeo-id") || a.attr("data-youtube-id") || a.attr("data-vzaar-id"),
            e = a.attr("data-width") || this._core.settings.videoWidth,
            f = a.attr("data-height") || this._core.settings.videoHeight,
            g = a.attr("href"); if (!g) throw new Error("Missing video URL."); if (d = g.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), d[3].indexOf("youtu") > -1) c = "youtube";
        else if (d[3].indexOf("vimeo") > -1) c = "vimeo";
        else { if (!(d[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
            c = "vzaar" } d = d[6], this._videos[g] = { type: c, id: d, width: e, height: f }, b.attr("data-video", g), this.thumbnail(a, this._videos[g]) }, e.prototype.thumbnail = function(b, c) { var d, e, f, g = c.width && c.height ? 'style="width:' + c.width + "px;height:" + c.height + 'px;"' : "",
            h = b.find("img"),
            i = "src",
            j = "",
            k = this._core.settings,
            l = function(a) { e = '<div class="owl-video-play-icon"></div>', d = k.lazyLoad ? '<div class="owl-video-tn ' + j + '" ' + i + '="' + a + '"></div>' : '<div class="owl-video-tn" style="opacity:1;background-image:url(' + a + ')"></div>', b.after(d), b.after(e) }; return b.wrap('<div class="owl-video-wrapper"' + g + "></div>"), this._core.settings.lazyLoad && (i = "data-src", j = "owl-lazy"), h.length ? (l(h.attr(i)), h.remove(), !1) : void("youtube" === c.type ? (f = "//img.youtube.com/vi/" + c.id + "/hqdefault.jpg", l(f)) : "vimeo" === c.type ? a.ajax({ type: "GET", url: "//vimeo.com/api/v2/video/" + c.id + ".json", jsonp: "callback", dataType: "jsonp", success: function(a) { f = a[0].thumbnail_large, l(f) } }) : "vzaar" === c.type && a.ajax({ type: "GET", url: "//vzaar.com/api/videos/" + c.id + ".json", jsonp: "callback", dataType: "jsonp", success: function(a) { f = a.framegrab_url, l(f) } })) }, e.prototype.stop = function() { this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null, this._core.leave("playing"), this._core.trigger("stopped", null, "video") }, e.prototype.play = function(b) { var c, d = a(b.target),
            e = d.closest("." + this._core.settings.itemClass),
            f = this._videos[e.attr("data-video")],
            g = f.width || "100%",
            h = f.height || this._core.$stage.height();
        this._playing || (this._core.enter("playing"), this._core.trigger("play", null, "video"), e = this._core.items(this._core.relative(e.index())), this._core.reset(e.index()), "youtube" === f.type ? c = '<iframe width="' + g + '" height="' + h + '" src="//www.youtube.com/embed/' + f.id + "?autoplay=1&rel=0&v=" + f.id + '" frameborder="0" allowfullscreen></iframe>' : "vimeo" === f.type ? c = '<iframe src="//player.vimeo.com/video/' + f.id + '?autoplay=1" width="' + g + '" height="' + h + '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' : "vzaar" === f.type && (c = '<iframe frameborder="0"height="' + h + '"width="' + g + '" allowfullscreen mozallowfullscreen webkitAllowFullScreen src="//view.vzaar.com/' + f.id + '/player?autoplay=true"></iframe>'), a('<div class="owl-video-frame">' + c + "</div>").insertAfter(e.find(".owl-video")), this._playing = e.addClass("owl-video-playing")) }, e.prototype.isInFullScreen = function() { var b = c.fullscreenElement || c.mozFullScreenElement || c.webkitFullscreenElement; return b && a(b).parent().hasClass("owl-video-frame") }, e.prototype.destroy = function() { var a, b;
        this._core.$element.off("click.owl.video"); for (a in this._handlers) this._core.$element.off(a, this._handlers[a]); for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null) }, a.fn.owlCarousel.Constructor.Plugins.Video = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(b) { this.core = b, this.core.options = a.extend({}, e.Defaults, this.core.options), this.swapping = !0, this.previous = d, this.next = d, this.handlers = { "change.owl.carousel": a.proxy(function(a) { a.namespace && "position" == a.property.name && (this.previous = this.core.current(), this.next = a.property.value) }, this), "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": a.proxy(function(a) { a.namespace && (this.swapping = "translated" == a.type) }, this), "translate.owl.carousel": a.proxy(function(a) { a.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap() }, this) }, this.core.$element.on(this.handlers) };
    e.Defaults = { animateOut: !1, animateIn: !1 }, e.prototype.swap = function() { if (1 === this.core.settings.items && a.support.animation && a.support.transition) { this.core.speed(0); var b, c = a.proxy(this.clear, this),
                d = this.core.$stage.children().eq(this.previous),
                e = this.core.$stage.children().eq(this.next),
                f = this.core.settings.animateIn,
                g = this.core.settings.animateOut;
            this.core.current() !== this.previous && (g && (b = this.core.coordinates(this.previous) - this.core.coordinates(this.next), d.one(a.support.animation.end, c).css({ left: b + "px" }).addClass("animated owl-animated-out").addClass(g)), f && e.one(a.support.animation.end, c).addClass("animated owl-animated-in").addClass(f)) } }, e.prototype.clear = function(b) { a(b.target).css({ left: "" }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd() }, e.prototype.destroy = function() {
        var a, b;
        for (a in this.handlers) this.core.$element.off(a, this.handlers[a]);
        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null);
    }, a.fn.owlCarousel.Constructor.Plugins.Animate = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { var e = function(b) { this._core = b, this._call = null, this._time = 0, this._timeout = 0, this._paused = !0, this._handlers = { "changed.owl.carousel": a.proxy(function(a) { a.namespace && "settings" === a.property.name ? this._core.settings.autoplay ? this.play() : this.stop() : a.namespace && "position" === a.property.name && this._paused && (this._time = 0) }, this), "initialized.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.autoplay && this.play() }, this), "play.owl.autoplay": a.proxy(function(a, b, c) { a.namespace && this.play(b, c) }, this), "stop.owl.autoplay": a.proxy(function(a) { a.namespace && this.stop() }, this), "mouseover.owl.autoplay": a.proxy(function() { this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause() }, this), "mouseleave.owl.autoplay": a.proxy(function() { this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play() }, this), "touchstart.owl.core": a.proxy(function() { this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause() }, this), "touchend.owl.core": a.proxy(function() { this._core.settings.autoplayHoverPause && this.play() }, this) }, this._core.$element.on(this._handlers), this._core.options = a.extend({}, e.Defaults, this._core.options) };
    e.Defaults = { autoplay: !1, autoplayTimeout: 5e3, autoplayHoverPause: !1, autoplaySpeed: !1 }, e.prototype._next = function(d) { this._call = b.setTimeout(a.proxy(this._next, this, d), this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()), this._core.is("busy") || this._core.is("interacting") || c.hidden || this._core.next(d || this._core.settings.autoplaySpeed) }, e.prototype.read = function() { return (new Date).getTime() - this._time }, e.prototype.play = function(c, d) { var e;
        this._core.is("rotating") || this._core.enter("rotating"), c = c || this._core.settings.autoplayTimeout, e = Math.min(this._time % (this._timeout || c), c), this._paused ? (this._time = this.read(), this._paused = !1) : b.clearTimeout(this._call), this._time += this.read() % c - e, this._timeout = c, this._call = b.setTimeout(a.proxy(this._next, this, d), c - e) }, e.prototype.stop = function() { this._core.is("rotating") && (this._time = 0, this._paused = !0, b.clearTimeout(this._call), this._core.leave("rotating")) }, e.prototype.pause = function() { this._core.is("rotating") && !this._paused && (this._time = this.read(), this._paused = !0, b.clearTimeout(this._call)) }, e.prototype.destroy = function() { var a, b;
        this.stop(); for (a in this._handlers) this._core.$element.off(a, this._handlers[a]); for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null) }, a.fn.owlCarousel.Constructor.Plugins.autoplay = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { "use strict"; var e = function(b) { this._core = b, this._initialized = !1, this._pages = [], this._controls = {}, this._templates = [], this.$element = this._core.$element, this._overrides = { next: this._core.next, prev: this._core.prev, to: this._core.to }, this._handlers = { "prepared.owl.carousel": a.proxy(function(b) { b.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + a(b.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "</div>") }, this), "added.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 0, this._templates.pop()) }, this), "remove.owl.carousel": a.proxy(function(a) { a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 1) }, this), "changed.owl.carousel": a.proxy(function(a) { a.namespace && "position" == a.property.name && this.draw() }, this), "initialized.owl.carousel": a.proxy(function(a) { a.namespace && !this._initialized && (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), this._initialized = !0, this._core.trigger("initialized", null, "navigation")) }, this), "refreshed.owl.carousel": a.proxy(function(a) { a.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation")) }, this) }, this._core.options = a.extend({}, e.Defaults, this._core.options), this.$element.on(this._handlers) };
    e.Defaults = { nav: !1, navText: ['<span aria-label="prev">&#x2039;</span>', '<span aria-label="next">&#x203a;</span>'], navSpeed: !1, navElement: 'button role="presentation"', navContainer: !1, navContainerClass: "owl-nav", navClass: ["owl-prev", "owl-next"], slideBy: 1, dotClass: "owl-dot", dotsClass: "owl-dots", dots: !0, dotsEach: !1, dotsData: !1, dotsSpeed: !1, dotsContainer: !1 }, e.prototype.initialize = function() { var b, c = this._core.settings;
        this._controls.$relative = (c.navContainer ? a(c.navContainer) : a("<div>").addClass(c.navContainerClass).appendTo(this.$element)).addClass("disabled"), this._controls.$previous = a("<" + c.navElement + ">").addClass(c.navClass[0]).html(c.navText[0]).prependTo(this._controls.$relative).on("click", a.proxy(function(a) { this.prev(c.navSpeed) }, this)), this._controls.$next = a("<" + c.navElement + ">").addClass(c.navClass[1]).html(c.navText[1]).appendTo(this._controls.$relative).on("click", a.proxy(function(a) { this.next(c.navSpeed) }, this)), c.dotsData || (this._templates = [a("<button>").addClass(c.dotClass).append(a("<span>")).prop("outerHTML")]), this._controls.$absolute = (c.dotsContainer ? a(c.dotsContainer) : a("<div>").addClass(c.dotsClass).appendTo(this.$element)).addClass("disabled"), this._controls.$absolute.on("click", "button", a.proxy(function(b) { var d = a(b.target).parent().is(this._controls.$absolute) ? a(b.target).index() : a(b.target).parent().index();
            b.preventDefault(), this.to(d, c.dotsSpeed) }, this)); for (b in this._overrides) this._core[b] = a.proxy(this[b], this) }, e.prototype.destroy = function() { var a, b, c, d; for (a in this._handlers) this.$element.off(a, this._handlers[a]); for (b in this._controls) "$relative" === b && settings.navContainer ? this._controls[b].html("") : this._controls[b].remove(); for (d in this.overides) this._core[d] = this._overrides[d]; for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null) }, e.prototype.update = function() { var a, b, c, d = this._core.clones().length / 2,
            e = d + this._core.items().length,
            f = this._core.maximum(!0),
            g = this._core.settings,
            h = g.center || g.autoWidth || g.dotsData ? 1 : g.dotsEach || g.items; if ("page" !== g.slideBy && (g.slideBy = Math.min(g.slideBy, g.items)), g.dots || "page" == g.slideBy)
            for (this._pages = [], a = d, b = 0, c = 0; e > a; a++) { if (b >= h || 0 === b) { if (this._pages.push({ start: Math.min(f, a - d), end: a - d + h - 1 }), Math.min(f, a - d) === f) break;
                    b = 0, ++c } b += this._core.mergers(this._core.relative(a)) } }, e.prototype.draw = function() { var b, c = this._core.settings,
            d = this._core.items().length <= c.items,
            e = this._core.relative(this._core.current()),
            f = c.loop || c.rewind;
        this._controls.$relative.toggleClass("disabled", !c.nav || d), c.nav && (this._controls.$previous.toggleClass("disabled", !f && e <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !f && e >= this._core.maximum(!0))), this._controls.$absolute.toggleClass("disabled", !c.dots || d), c.dots && (b = this._pages.length - this._controls.$absolute.children().length, c.dotsData && 0 !== b ? this._controls.$absolute.html(this._templates.join("")) : b > 0 ? this._controls.$absolute.append(new Array(b + 1).join(this._templates[0])) : 0 > b && this._controls.$absolute.children().slice(b).remove(), this._controls.$absolute.find(".active").removeClass("active"), this._controls.$absolute.children().eq(a.inArray(this.current(), this._pages)).addClass("active")) }, e.prototype.onTrigger = function(b) { var c = this._core.settings;
        b.page = { index: a.inArray(this.current(), this._pages), count: this._pages.length, size: c && (c.center || c.autoWidth || c.dotsData ? 1 : c.dotsEach || c.items) } }, e.prototype.current = function() { var b = this._core.relative(this._core.current()); return a.grep(this._pages, a.proxy(function(a, c) { return a.start <= b && a.end >= b }, this)).pop() }, e.prototype.getPosition = function(b) { var c, d, e = this._core.settings; return "page" == e.slideBy ? (c = a.inArray(this.current(), this._pages), d = this._pages.length, b ? ++c : --c, c = this._pages[(c % d + d) % d].start) : (c = this._core.relative(this._core.current()), d = this._core.items().length, b ? c += e.slideBy : c -= e.slideBy), c }, e.prototype.next = function(b) { a.proxy(this._overrides.to, this._core)(this.getPosition(!0), b) }, e.prototype.prev = function(b) { a.proxy(this._overrides.to, this._core)(this.getPosition(!1), b) }, e.prototype.to = function(b, c, d) { var e;!d && this._pages.length ? (e = this._pages.length, a.proxy(this._overrides.to, this._core)(this._pages[(b % e + e) % e].start, c)) : a.proxy(this._overrides.to, this._core)(b, c) }, a.fn.owlCarousel.Constructor.Plugins.Navigation = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) { "use strict"; var e = function(c) { this._core = c, this._hashes = {}, this.$element = this._core.$element, this._handlers = { "initialized.owl.carousel": a.proxy(function(c) { c.namespace && "URLHash" === this._core.settings.startPosition && a(b).trigger("hashchange.owl.navigation") }, this), "prepared.owl.carousel": a.proxy(function(b) { if (b.namespace) { var c = a(b.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash"); if (!c) return;
                    this._hashes[c] = b.content } }, this), "changed.owl.carousel": a.proxy(function(c) { if (c.namespace && "position" === c.property.name) { var d = this._core.items(this._core.relative(this._core.current())),
                        e = a.map(this._hashes, function(a, b) { return a === d ? b : null }).join(); if (!e || b.location.hash.slice(1) === e) return;
                    b.location.hash = e } }, this) }, this._core.options = a.extend({}, e.Defaults, this._core.options), this.$element.on(this._handlers), a(b).on("hashchange.owl.navigation", a.proxy(function(a) { var c = b.location.hash.substring(1),
                e = this._core.$stage.children(),
                f = this._hashes[c] && e.index(this._hashes[c]);
            f !== d && f !== this._core.current() && this._core.to(this._core.relative(f), !1, !0) }, this)) };
    e.Defaults = { URLhashListener: !1 }, e.prototype.destroy = function() { var c, d;
        a(b).off("hashchange.owl.navigation"); for (c in this._handlers) this._core.$element.off(c, this._handlers[c]); for (d in Object.getOwnPropertyNames(this)) "function" != typeof this[d] && (this[d] = null) }, a.fn.owlCarousel.Constructor.Plugins.Hash = e }(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    function e(b, c) { var e = !1,
            f = b.charAt(0).toUpperCase() + b.slice(1); return a.each((b + " " + h.join(f + " ") + f).split(" "), function(a, b) { return g[b] !== d ? (e = c ? b : !0, !1) : void 0 }), e }

    function f(a) { return e(a, !0) } var g = a("<support>").get(0).style,
        h = "Webkit Moz O ms".split(" "),
        i = { transition: { end: { WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", OTransition: "oTransitionEnd", transition: "transitionend" } }, animation: { end: { WebkitAnimation: "webkitAnimationEnd", MozAnimation: "animationend", OAnimation: "oAnimationEnd", animation: "animationend" } } },
        j = { csstransforms: function() { return !!e("transform") }, csstransforms3d: function() { return !!e("perspective") }, csstransitions: function() { return !!e("transition") }, cssanimations: function() { return !!e("animation") } };
    j.csstransitions() && (a.support.transition = new String(f("transition")), a.support.transition.end = i.transition.end[a.support.transition]), j.cssanimations() && (a.support.animation = new String(f("animation")), a.support.animation.end = i.animation.end[a.support.animation]), j.csstransforms() && (a.support.transform = new String(f("transform")), a.support.transform3d = j.csstransforms3d()) }(window.Zepto || window.jQuery, window, document);
// Generated by CoffeeScript 1.6.2
/*
jQuery Waypoints - v2.0.3
Copyright (c) 2011-2013 Caleb Troughton
Dual licensed under the MIT license and GPL license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(this,function(n,r){var i,o,l,s,f,u,a,c,h,d,p,y,v,w,g,m;i=n(r);c=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;a={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};t.data(u,this.id);a[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||c)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(c&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete a[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;r=n.extend({},n.fn[g].defaults,r);if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=t.data(w))!=null?o:[];i.push(this.id);t.data(w,i)}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=n(t).data(w);if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;if(e==null){e={}}if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=a[i.data(u)];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke(this,"disable")},enable:function(){return d._invoke(this,"enable")},destroy:function(){return d._invoke(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t,e){t.each(function(){var t;t=l.getWaypointsByElement(this);return n.each(t,function(t,n){n[e]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(a,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=a[n(t).data(u)])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=a[n(t).data(u)];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.load(function(){return n[m]("refresh")})})}).call(this);
/*!
* jquery.counterup.js 1.0
*
* Copyright 2013, Benjamin Intal http://gambit.ph @bfintal
* Released under the GPL v2 License
*
* Date: Nov 26, 2013
*/(function(e){"use strict";e.fn.counterUp=function(t){var n=e.extend({time:400,delay:10},t);return this.each(function(){var t=e(this),r=n,i=function(){var e=[],n=r.time/r.delay,i=t.text(),s=/[0-9]+,[0-9]+/.test(i);i=i.replace(/,/g,"");var o=/^[0-9]+$/.test(i),u=/^[0-9]+\.[0-9]+$/.test(i),a=u?(i.split(".")[1]||[]).length:0;for(var f=n;f>=1;f--){var l=parseInt(i/n*f);u&&(l=parseFloat(i/n*f).toFixed(a));if(s)while(/(\d+)(\d{3})/.test(l.toString()))l=l.toString().replace(/(\d+)(\d{3})/,"$1,$2");e.unshift(l)}t.data("counterup-nums",e);t.text("0");var c=function(){t.text(t.data("counterup-nums").shift());if(t.data("counterup-nums").length)setTimeout(t.data("counterup-func"),r.delay);else{delete t.data("counterup-nums");t.data("counterup-nums",null);t.data("counterup-func",null)}};t.data("counterup-func",c);setTimeout(t.data("counterup-func"),r.delay)};t.waypoint(i,{offset:"100%",triggerOnce:!0})})}})(jQuery);
/*! Magnific Popup - v1.1.0 - 2016-02-20
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2016 Dmitry Semenov; */
;(function (factory) { 
if (typeof define === 'function' && define.amd) { 
 // AMD. Register as an anonymous module. 
 define(['jquery'], factory); 
 } else if (typeof exports === 'object') { 
 // Node/CommonJS 
 factory(require('jquery')); 
 } else { 
 // Browser globals 
 factory(window.jQuery || window.Zepto); 
 } 
 }(function($) { 

/*>>core*/
/**
 * 
 * Magnific Popup Core JS file
 * 
 */


/**
 * Private static constants
 */
var CLOSE_EVENT = 'Close',
	BEFORE_CLOSE_EVENT = 'BeforeClose',
	AFTER_CLOSE_EVENT = 'AfterClose',
	BEFORE_APPEND_EVENT = 'BeforeAppend',
	MARKUP_PARSE_EVENT = 'MarkupParse',
	OPEN_EVENT = 'Open',
	CHANGE_EVENT = 'Change',
	NS = 'mfp',
	EVENT_NS = '.' + NS,
	READY_CLASS = 'mfp-ready',
	REMOVING_CLASS = 'mfp-removing',
	PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


/**
 * Private vars 
 */
/*jshint -W079 */
var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
	MagnificPopup = function(){},
	_isJQ = !!(window.jQuery),
	_prevStatus,
	_window = $(window),
	_document,
	_prevContentType,
	_wrapClasses,
	_currPopupType;


/**
 * Private functions
 */
var _mfpOn = function(name, f) {
		mfp.ev.on(NS + name + EVENT_NS, f);
	},
	_getEl = function(className, appendTo, html, raw) {
		var el = document.createElement('div');
		el.className = 'mfp-'+className;
		if(html) {
			el.innerHTML = html;
		}
		if(!raw) {
			el = $(el);
			if(appendTo) {
				el.appendTo(appendTo);
			}
		} else if(appendTo) {
			appendTo.appendChild(el);
		}
		return el;
	},
	_mfpTrigger = function(e, data) {
		mfp.ev.triggerHandler(NS + e, data);

		if(mfp.st.callbacks) {
			// converts "mfpEventName" to "eventName" callback and triggers it if it's present
			e = e.charAt(0).toLowerCase() + e.slice(1);
			if(mfp.st.callbacks[e]) {
				mfp.st.callbacks[e].apply(mfp, $.isArray(data) ? data : [data]);
			}
		}
	},
	_getCloseBtn = function(type) {
		if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
			mfp.currTemplate.closeBtn = $( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
			_currPopupType = type;
		}
		return mfp.currTemplate.closeBtn;
	},
	// Initialize Magnific Popup only when called at least once
	_checkInstance = function() {
		if(!$.magnificPopup.instance) {
			/*jshint -W020 */
			mfp = new MagnificPopup();
			mfp.init();
			$.magnificPopup.instance = mfp;
		}
	},
	// CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
	supportsTransitions = function() {
		var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
			v = ['ms','O','Moz','Webkit']; // 'v' for vendor

		if( s['transition'] !== undefined ) {
			return true; 
		}
			
		while( v.length ) {
			if( v.pop() + 'Transition' in s ) {
				return true;
			}
		}
				
		return false;
	};



/**
 * Public functions
 */
MagnificPopup.prototype = {

	constructor: MagnificPopup,

	/**
	 * Initializes Magnific Popup plugin. 
	 * This function is triggered only once when $.fn.magnificPopup or $.magnificPopup is executed
	 */
	init: function() {
		var appVersion = navigator.appVersion;
		mfp.isLowIE = mfp.isIE8 = document.all && !document.addEventListener;
		mfp.isAndroid = (/android/gi).test(appVersion);
		mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
		mfp.supportsTransition = supportsTransitions();

		// We disable fixed positioned lightbox on devices that don't handle it nicely.
		// If you know a better way of detecting this - let me know.
		mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
		_document = $(document);

		mfp.popupsCache = {};
	},

	/**
	 * Opens popup
	 * @param  data [description]
	 */
	open: function(data) {

		var i;

		if(data.isObj === false) { 
			// convert jQuery collection to array to avoid conflicts later
			mfp.items = data.items.toArray();

			mfp.index = 0;
			var items = data.items,
				item;
			for(i = 0; i < items.length; i++) {
				item = items[i];
				if(item.parsed) {
					item = item.el[0];
				}
				if(item === data.el[0]) {
					mfp.index = i;
					break;
				}
			}
		} else {
			mfp.items = $.isArray(data.items) ? data.items : [data.items];
			mfp.index = data.index || 0;
		}

		// if popup is already opened - we just update the content
		if(mfp.isOpen) {
			mfp.updateItemHTML();
			return;
		}
		
		mfp.types = []; 
		_wrapClasses = '';
		if(data.mainEl && data.mainEl.length) {
			mfp.ev = data.mainEl.eq(0);
		} else {
			mfp.ev = _document;
		}

		if(data.key) {
			if(!mfp.popupsCache[data.key]) {
				mfp.popupsCache[data.key] = {};
			}
			mfp.currTemplate = mfp.popupsCache[data.key];
		} else {
			mfp.currTemplate = {};
		}



		mfp.st = $.extend(true, {}, $.magnificPopup.defaults, data ); 
		mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

		if(mfp.st.modal) {
			mfp.st.closeOnContentClick = false;
			mfp.st.closeOnBgClick = false;
			mfp.st.showCloseBtn = false;
			mfp.st.enableEscapeKey = false;
		}
		

		// Building markup
		// main containers are created only once
		if(!mfp.bgOverlay) {

			// Dark overlay
			mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
				mfp.close();
			});

			mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
				if(mfp._checkIfClose(e.target)) {
					mfp.close();
				}
			});

			mfp.container = _getEl('container', mfp.wrap);
		}

		mfp.contentContainer = _getEl('content');
		if(mfp.st.preloader) {
			mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
		}


		// Initializing modules
		var modules = $.magnificPopup.modules;
		for(i = 0; i < modules.length; i++) {
			var n = modules[i];
			n = n.charAt(0).toUpperCase() + n.slice(1);
			mfp['init'+n].call(mfp);
		}
		_mfpTrigger('BeforeOpen');


		if(mfp.st.showCloseBtn) {
			// Close button
			if(!mfp.st.closeBtnInside) {
				mfp.wrap.append( _getCloseBtn() );
			} else {
				_mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
					values.close_replaceWith = _getCloseBtn(item.type);
				});
				_wrapClasses += ' mfp-close-btn-in';
			}
		}

		if(mfp.st.alignTop) {
			_wrapClasses += ' mfp-align-top';
		}

	

		if(mfp.fixedContentPos) {
			mfp.wrap.css({
				overflow: mfp.st.overflowY,
				overflowX: 'hidden',
				overflowY: mfp.st.overflowY
			});
		} else {
			mfp.wrap.css({ 
				top: _window.scrollTop(),
				position: 'absolute'
			});
		}
		if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
			mfp.bgOverlay.css({
				height: _document.height(),
				position: 'absolute'
			});
		}

		

		if(mfp.st.enableEscapeKey) {
			// Close on ESC key
			_document.on('keyup' + EVENT_NS, function(e) {
				if(e.keyCode === 27) {
					mfp.close();
				}
			});
		}

		_window.on('resize' + EVENT_NS, function() {
			mfp.updateSize();
		});


		if(!mfp.st.closeOnContentClick) {
			_wrapClasses += ' mfp-auto-cursor';
		}
		
		if(_wrapClasses)
			mfp.wrap.addClass(_wrapClasses);


		// this triggers recalculation of layout, so we get it once to not to trigger twice
		var windowHeight = mfp.wH = _window.height();

		
		var windowStyles = {};

		if( mfp.fixedContentPos ) {
            if(mfp._hasScrollBar(windowHeight)){
                var s = mfp._getScrollbarSize();
                if(s) {
                    windowStyles.marginRight = s;
                }
            }
        }

		if(mfp.fixedContentPos) {
			if(!mfp.isIE7) {
				windowStyles.overflow = 'hidden';
			} else {
				// ie7 double-scroll bug
				$('body, html').css('overflow', 'hidden');
			}
		}

		
		
		var classesToadd = mfp.st.mainClass;
		if(mfp.isIE7) {
			classesToadd += ' mfp-ie7';
		}
		if(classesToadd) {
			mfp._addClassToMFP( classesToadd );
		}

		// add content
		mfp.updateItemHTML();

		_mfpTrigger('BuildControls');

		// remove scrollbar, add margin e.t.c
		$('html').css(windowStyles);
		
		// add everything to DOM
		mfp.bgOverlay.add(mfp.wrap).prependTo( mfp.st.prependTo || $(document.body) );

		// Save last focused element
		mfp._lastFocusedEl = document.activeElement;
		
		// Wait for next cycle to allow CSS transition
		setTimeout(function() {
			
			if(mfp.content) {
				mfp._addClassToMFP(READY_CLASS);
				mfp._setFocus();
			} else {
				// if content is not defined (not loaded e.t.c) we add class only for BG
				mfp.bgOverlay.addClass(READY_CLASS);
			}
			
			// Trap the focus in popup
			_document.on('focusin' + EVENT_NS, mfp._onFocusIn);

		}, 16);

		mfp.isOpen = true;
		mfp.updateSize(windowHeight);
		_mfpTrigger(OPEN_EVENT);

		return data;
	},

	/**
	 * Closes the popup
	 */
	close: function() {
		if(!mfp.isOpen) return;
		_mfpTrigger(BEFORE_CLOSE_EVENT);

		mfp.isOpen = false;
		// for CSS3 animation
		if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
			mfp._addClassToMFP(REMOVING_CLASS);
			setTimeout(function() {
				mfp._close();
			}, mfp.st.removalDelay);
		} else {
			mfp._close();
		}
	},

	/**
	 * Helper for close() function
	 */
	_close: function() {
		_mfpTrigger(CLOSE_EVENT);

		var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

		mfp.bgOverlay.detach();
		mfp.wrap.detach();
		mfp.container.empty();

		if(mfp.st.mainClass) {
			classesToRemove += mfp.st.mainClass + ' ';
		}

		mfp._removeClassFromMFP(classesToRemove);

		if(mfp.fixedContentPos) {
			var windowStyles = {marginRight: ''};
			if(mfp.isIE7) {
				$('body, html').css('overflow', '');
			} else {
				windowStyles.overflow = '';
			}
			$('html').css(windowStyles);
		}
		
		_document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
		mfp.ev.off(EVENT_NS);

		// clean up DOM elements that aren't removed
		mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
		mfp.bgOverlay.attr('class', 'mfp-bg');
		mfp.container.attr('class', 'mfp-container');

		// remove close button from target element
		if(mfp.st.showCloseBtn &&
		(!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
			if(mfp.currTemplate.closeBtn)
				mfp.currTemplate.closeBtn.detach();
		}


		if(mfp.st.autoFocusLast && mfp._lastFocusedEl) {
			$(mfp._lastFocusedEl).focus(); // put tab focus back
		}
		mfp.currItem = null;	
		mfp.content = null;
		mfp.currTemplate = null;
		mfp.prevHeight = 0;

		_mfpTrigger(AFTER_CLOSE_EVENT);
	},
	
	updateSize: function(winHeight) {

		if(mfp.isIOS) {
			// fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
			var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
			var height = window.innerHeight * zoomLevel;
			mfp.wrap.css('height', height);
			mfp.wH = height;
		} else {
			mfp.wH = winHeight || _window.height();
		}
		// Fixes #84: popup incorrectly positioned with position:relative on body
		if(!mfp.fixedContentPos) {
			mfp.wrap.css('height', mfp.wH);
		}

		_mfpTrigger('Resize');

	},

	/**
	 * Set content of popup based on current index
	 */
	updateItemHTML: function() {
		var item = mfp.items[mfp.index];

		// Detach and perform modifications
		mfp.contentContainer.detach();

		if(mfp.content)
			mfp.content.detach();

		if(!item.parsed) {
			item = mfp.parseEl( mfp.index );
		}

		var type = item.type;

		_mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
		// BeforeChange event works like so:
		// _mfpOn('BeforeChange', function(e, prevType, newType) { });

		mfp.currItem = item;

		if(!mfp.currTemplate[type]) {
			var markup = mfp.st[type] ? mfp.st[type].markup : false;

			// allows to modify markup
			_mfpTrigger('FirstMarkupParse', markup);

			if(markup) {
				mfp.currTemplate[type] = $(markup);
			} else {
				// if there is no markup found we just define that template is parsed
				mfp.currTemplate[type] = true;
			}
		}

		if(_prevContentType && _prevContentType !== item.type) {
			mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
		}

		var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
		mfp.appendContent(newContent, type);

		item.preloaded = true;

		_mfpTrigger(CHANGE_EVENT, item);
		_prevContentType = item.type;

		// Append container back after its content changed
		mfp.container.prepend(mfp.contentContainer);

		_mfpTrigger('AfterChange');
	},


	/**
	 * Set HTML content of popup
	 */
	appendContent: function(newContent, type) {
		mfp.content = newContent;

		if(newContent) {
			if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
				mfp.currTemplate[type] === true) {
				// if there is no markup, we just append close button element inside
				if(!mfp.content.find('.mfp-close').length) {
					mfp.content.append(_getCloseBtn());
				}
			} else {
				mfp.content = newContent;
			}
		} else {
			mfp.content = '';
		}

		_mfpTrigger(BEFORE_APPEND_EVENT);
		mfp.container.addClass('mfp-'+type+'-holder');

		mfp.contentContainer.append(mfp.content);
	},


	/**
	 * Creates Magnific Popup data object based on given data
	 * @param  {int} index Index of item to parse
	 */
	parseEl: function(index) {
		var item = mfp.items[index],
			type;

		if(item.tagName) {
			item = { el: $(item) };
		} else {
			type = item.type;
			item = { data: item, src: item.src };
		}

		if(item.el) {
			var types = mfp.types;

			// check for 'mfp-TYPE' class
			for(var i = 0; i < types.length; i++) {
				if( item.el.hasClass('mfp-'+types[i]) ) {
					type = types[i];
					break;
				}
			}

			item.src = item.el.attr('data-mfp-src');
			if(!item.src) {
				item.src = item.el.attr('href');
			}
		}

		item.type = type || mfp.st.type || 'inline';
		item.index = index;
		item.parsed = true;
		mfp.items[index] = item;
		_mfpTrigger('ElementParse', item);

		return mfp.items[index];
	},


	/**
	 * Initializes single popup or a group of popups
	 */
	addGroup: function(el, options) {
		var eHandler = function(e) {
			e.mfpEl = this;
			mfp._openClick(e, el, options);
		};

		if(!options) {
			options = {};
		}

		var eName = 'click.magnificPopup';
		options.mainEl = el;

		if(options.items) {
			options.isObj = true;
			el.off(eName).on(eName, eHandler);
		} else {
			options.isObj = false;
			if(options.delegate) {
				el.off(eName).on(eName, options.delegate , eHandler);
			} else {
				options.items = el;
				el.off(eName).on(eName, eHandler);
			}
		}
	},
	_openClick: function(e, el, options) {
		var midClick = options.midClick !== undefined ? options.midClick : $.magnificPopup.defaults.midClick;


		if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey || e.altKey || e.shiftKey ) ) {
			return;
		}

		var disableOn = options.disableOn !== undefined ? options.disableOn : $.magnificPopup.defaults.disableOn;

		if(disableOn) {
			if($.isFunction(disableOn)) {
				if( !disableOn.call(mfp) ) {
					return true;
				}
			} else { // else it's number
				if( _window.width() < disableOn ) {
					return true;
				}
			}
		}

		if(e.type) {
			e.preventDefault();

			// This will prevent popup from closing if element is inside and popup is already opened
			if(mfp.isOpen) {
				e.stopPropagation();
			}
		}

		options.el = $(e.mfpEl);
		if(options.delegate) {
			options.items = el.find(options.delegate);
		}
		mfp.open(options);
	},


	/**
	 * Updates text on preloader
	 */
	updateStatus: function(status, text) {

		if(mfp.preloader) {
			if(_prevStatus !== status) {
				mfp.container.removeClass('mfp-s-'+_prevStatus);
			}

			if(!text && status === 'loading') {
				text = mfp.st.tLoading;
			}

			var data = {
				status: status,
				text: text
			};
			// allows to modify status
			_mfpTrigger('UpdateStatus', data);

			status = data.status;
			text = data.text;

			mfp.preloader.html(text);

			mfp.preloader.find('a').on('click', function(e) {
				e.stopImmediatePropagation();
			});

			mfp.container.addClass('mfp-s-'+status);
			_prevStatus = status;
		}
	},


	/*
		"Private" helpers that aren't private at all
	 */
	// Check to close popup or not
	// "target" is an element that was clicked
	_checkIfClose: function(target) {

		if($(target).hasClass(PREVENT_CLOSE_CLASS)) {
			return;
		}

		var closeOnContent = mfp.st.closeOnContentClick;
		var closeOnBg = mfp.st.closeOnBgClick;

		if(closeOnContent && closeOnBg) {
			return true;
		} else {

			// We close the popup if click is on close button or on preloader. Or if there is no content.
			if(!mfp.content || $(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
				return true;
			}

			// if click is outside the content
			if(  (target !== mfp.content[0] && !$.contains(mfp.content[0], target))  ) {
				if(closeOnBg) {
					// last check, if the clicked element is in DOM, (in case it's removed onclick)
					if( $.contains(document, target) ) {
						return true;
					}
				}
			} else if(closeOnContent) {
				return true;
			}

		}
		return false;
	},
	_addClassToMFP: function(cName) {
		mfp.bgOverlay.addClass(cName);
		mfp.wrap.addClass(cName);
	},
	_removeClassFromMFP: function(cName) {
		this.bgOverlay.removeClass(cName);
		mfp.wrap.removeClass(cName);
	},
	_hasScrollBar: function(winHeight) {
		return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
	},
	_setFocus: function() {
		(mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).focus();
	},
	_onFocusIn: function(e) {
		if( e.target !== mfp.wrap[0] && !$.contains(mfp.wrap[0], e.target) ) {
			mfp._setFocus();
			return false;
		}
	},
	_parseMarkup: function(template, values, item) {
		var arr;
		if(item.data) {
			values = $.extend(item.data, values);
		}
		_mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

		$.each(values, function(key, value) {
			if(value === undefined || value === false) {
				return true;
			}
			arr = key.split('_');
			if(arr.length > 1) {
				var el = template.find(EVENT_NS + '-'+arr[0]);

				if(el.length > 0) {
					var attr = arr[1];
					if(attr === 'replaceWith') {
						if(el[0] !== value[0]) {
							el.replaceWith(value);
						}
					} else if(attr === 'img') {
						if(el.is('img')) {
							el.attr('src', value);
						} else {
							el.replaceWith( $('<img>').attr('src', value).attr('class', el.attr('class')) );
						}
					} else {
						el.attr(arr[1], value);
					}
				}

			} else {
				template.find(EVENT_NS + '-'+key).html(value);
			}
		});
	},

	_getScrollbarSize: function() {
		// thx David
		if(mfp.scrollbarSize === undefined) {
			var scrollDiv = document.createElement("div");
			scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
			document.body.appendChild(scrollDiv);
			mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
			document.body.removeChild(scrollDiv);
		}
		return mfp.scrollbarSize;
	}

}; /* MagnificPopup core prototype end */




/**
 * Public static functions
 */
$.magnificPopup = {
	instance: null,
	proto: MagnificPopup.prototype,
	modules: [],

	open: function(options, index) {
		_checkInstance();

		if(!options) {
			options = {};
		} else {
			options = $.extend(true, {}, options);
		}

		options.isObj = true;
		options.index = index || 0;
		return this.instance.open(options);
	},

	close: function() {
		return $.magnificPopup.instance && $.magnificPopup.instance.close();
	},

	registerModule: function(name, module) {
		if(module.options) {
			$.magnificPopup.defaults[name] = module.options;
		}
		$.extend(this.proto, module.proto);
		this.modules.push(name);
	},

	defaults: {

		// Info about options is in docs:
		// http://dimsemenov.com/plugins/magnific-popup/documentation.html#options

		disableOn: 0,

		key: null,

		midClick: false,

		mainClass: '',

		preloader: true,

		focus: '', // CSS selector of input to focus after popup is opened

		closeOnContentClick: false,

		closeOnBgClick: true,

		closeBtnInside: true,

		showCloseBtn: true,

		enableEscapeKey: true,

		modal: false,

		alignTop: false,

		removalDelay: 0,

		prependTo: null,

		fixedContentPos: 'auto',

		fixedBgPos: 'auto',

		overflowY: 'auto',

		closeMarkup: '<button title="%title%" type="button" class="mfp-close">&#215;</button>',

		tClose: 'Close (Esc)',

		tLoading: 'Loading...',

		autoFocusLast: true

	}
};



$.fn.magnificPopup = function(options) {
	_checkInstance();

	var jqEl = $(this);

	// We call some API method of first param is a string
	if (typeof options === "string" ) {

		if(options === 'open') {
			var items,
				itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
				index = parseInt(arguments[1], 10) || 0;

			if(itemOpts.items) {
				items = itemOpts.items[index];
			} else {
				items = jqEl;
				if(itemOpts.delegate) {
					items = items.find(itemOpts.delegate);
				}
				items = items.eq( index );
			}
			mfp._openClick({mfpEl:items}, jqEl, itemOpts);
		} else {
			if(mfp.isOpen)
				mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
		}

	} else {
		// clone options obj
		options = $.extend(true, {}, options);

		/*
		 * As Zepto doesn't support .data() method for objects
		 * and it works only in normal browsers
		 * we assign "options" object directly to the DOM element. FTW!
		 */
		if(_isJQ) {
			jqEl.data('magnificPopup', options);
		} else {
			jqEl[0].magnificPopup = options;
		}

		mfp.addGroup(jqEl, options);

	}
	return jqEl;
};

/*>>core*/

/*>>inline*/

var INLINE_NS = 'inline',
	_hiddenClass,
	_inlinePlaceholder,
	_lastInlineElement,
	_putInlineElementsBack = function() {
		if(_lastInlineElement) {
			_inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
			_lastInlineElement = null;
		}
	};

$.magnificPopup.registerModule(INLINE_NS, {
	options: {
		hiddenClass: 'hide', // will be appended with `mfp-` prefix
		markup: '',
		tNotFound: 'Content not found'
	},
	proto: {

		initInline: function() {
			mfp.types.push(INLINE_NS);

			_mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
				_putInlineElementsBack();
			});
		},

		getInline: function(item, template) {

			_putInlineElementsBack();

			if(item.src) {
				var inlineSt = mfp.st.inline,
					el = $(item.src);

				if(el.length) {

					// If target element has parent - we replace it with placeholder and put it back after popup is closed
					var parent = el[0].parentNode;
					if(parent && parent.tagName) {
						if(!_inlinePlaceholder) {
							_hiddenClass = inlineSt.hiddenClass;
							_inlinePlaceholder = _getEl(_hiddenClass);
							_hiddenClass = 'mfp-'+_hiddenClass;
						}
						// replace target inline element with placeholder
						_lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
					}

					mfp.updateStatus('ready');
				} else {
					mfp.updateStatus('error', inlineSt.tNotFound);
					el = $('<div>');
				}

				item.inlineElement = el;
				return el;
			}

			mfp.updateStatus('ready');
			mfp._parseMarkup(template, {}, item);
			return template;
		}
	}
});

/*>>inline*/

/*>>ajax*/
var AJAX_NS = 'ajax',
	_ajaxCur,
	_removeAjaxCursor = function() {
		if(_ajaxCur) {
			$(document.body).removeClass(_ajaxCur);
		}
	},
	_destroyAjaxRequest = function() {
		_removeAjaxCursor();
		if(mfp.req) {
			mfp.req.abort();
		}
	};

$.magnificPopup.registerModule(AJAX_NS, {

	options: {
		settings: null,
		cursor: 'mfp-ajax-cur',
		tError: '<a href="%url%">The content</a> could not be loaded.'
	},

	proto: {
		initAjax: function() {
			mfp.types.push(AJAX_NS);
			_ajaxCur = mfp.st.ajax.cursor;

			_mfpOn(CLOSE_EVENT+'.'+AJAX_NS, _destroyAjaxRequest);
			_mfpOn('BeforeChange.' + AJAX_NS, _destroyAjaxRequest);
		},
		getAjax: function(item) {

			if(_ajaxCur) {
				$(document.body).addClass(_ajaxCur);
			}

			mfp.updateStatus('loading');

			var opts = $.extend({
				url: item.src,
				success: function(data, textStatus, jqXHR) {
					var temp = {
						data:data,
						xhr:jqXHR
					};

					_mfpTrigger('ParseAjax', temp);

					mfp.appendContent( $(temp.data), AJAX_NS );

					item.finished = true;

					_removeAjaxCursor();

					mfp._setFocus();

					setTimeout(function() {
						mfp.wrap.addClass(READY_CLASS);
					}, 16);

					mfp.updateStatus('ready');

					_mfpTrigger('AjaxContentAdded');
				},
				error: function() {
					_removeAjaxCursor();
					item.finished = item.loadError = true;
					mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
				}
			}, mfp.st.ajax.settings);

			mfp.req = $.ajax(opts);

			return '';
		}
	}
});

/*>>ajax*/

/*>>image*/
var _imgInterval,
	_getTitle = function(item) {
		if(item.data && item.data.title !== undefined)
			return item.data.title;

		var src = mfp.st.image.titleSrc;

		if(src) {
			if($.isFunction(src)) {
				return src.call(mfp, item);
			} else if(item.el) {
				return item.el.attr(src) || '';
			}
		}
		return '';
	};

$.magnificPopup.registerModule('image', {

	options: {
		markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<figure>'+
						'<div class="mfp-img"></div>'+
						'<figcaption>'+
							'<div class="mfp-bottom-bar">'+
								'<div class="mfp-title"></div>'+
								'<div class="mfp-counter"></div>'+
							'</div>'+
						'</figcaption>'+
					'</figure>'+
				'</div>',
		cursor: 'mfp-zoom-out-cur',
		titleSrc: 'title',
		verticalFit: true,
		tError: '<a href="%url%">The image</a> could not be loaded.'
	},

	proto: {
		initImage: function() {
			var imgSt = mfp.st.image,
				ns = '.image';

			mfp.types.push('image');

			_mfpOn(OPEN_EVENT+ns, function() {
				if(mfp.currItem.type === 'image' && imgSt.cursor) {
					$(document.body).addClass(imgSt.cursor);
				}
			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(imgSt.cursor) {
					$(document.body).removeClass(imgSt.cursor);
				}
				_window.off('resize' + EVENT_NS);
			});

			_mfpOn('Resize'+ns, mfp.resizeImage);
			if(mfp.isLowIE) {
				_mfpOn('AfterChange', mfp.resizeImage);
			}
		},
		resizeImage: function() {
			var item = mfp.currItem;
			if(!item || !item.img) return;

			if(mfp.st.image.verticalFit) {
				var decr = 0;
				// fix box-sizing in ie7/8
				if(mfp.isLowIE) {
					decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
				}
				item.img.css('max-height', mfp.wH-decr);
			}
		},
		_onImageHasSize: function(item) {
			if(item.img) {

				item.hasSize = true;

				if(_imgInterval) {
					clearInterval(_imgInterval);
				}

				item.isCheckingImgSize = false;

				_mfpTrigger('ImageHasSize', item);

				if(item.imgHidden) {
					if(mfp.content)
						mfp.content.removeClass('mfp-loading');

					item.imgHidden = false;
				}

			}
		},

		/**
		 * Function that loops until the image has size to display elements that rely on it asap
		 */
		findImageSize: function(item) {

			var counter = 0,
				img = item.img[0],
				mfpSetInterval = function(delay) {

					if(_imgInterval) {
						clearInterval(_imgInterval);
					}
					// decelerating interval that checks for size of an image
					_imgInterval = setInterval(function() {
						if(img.naturalWidth > 0) {
							mfp._onImageHasSize(item);
							return;
						}

						if(counter > 200) {
							clearInterval(_imgInterval);
						}

						counter++;
						if(counter === 3) {
							mfpSetInterval(10);
						} else if(counter === 40) {
							mfpSetInterval(50);
						} else if(counter === 100) {
							mfpSetInterval(500);
						}
					}, delay);
				};

			mfpSetInterval(1);
		},

		getImage: function(item, template) {

			var guard = 0,

				// image load complete handler
				onLoadComplete = function() {
					if(item) {
						if (item.img[0].complete) {
							item.img.off('.mfploader');

							if(item === mfp.currItem){
								mfp._onImageHasSize(item);

								mfp.updateStatus('ready');
							}

							item.hasSize = true;
							item.loaded = true;

							_mfpTrigger('ImageLoadComplete');

						}
						else {
							// if image complete check fails 200 times (20 sec), we assume that there was an error.
							guard++;
							if(guard < 200) {
								setTimeout(onLoadComplete,100);
							} else {
								onLoadError();
							}
						}
					}
				},

				// image error handler
				onLoadError = function() {
					if(item) {
						item.img.off('.mfploader');
						if(item === mfp.currItem){
							mfp._onImageHasSize(item);
							mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
						}

						item.hasSize = true;
						item.loaded = true;
						item.loadError = true;
					}
				},
				imgSt = mfp.st.image;


			var el = template.find('.mfp-img');
			if(el.length) {
				var img = document.createElement('img');
				img.className = 'mfp-img';
				if(item.el && item.el.find('img').length) {
					img.alt = item.el.find('img').attr('alt');
				}
				item.img = $(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
				img.src = item.src;

				// without clone() "error" event is not firing when IMG is replaced by new IMG
				// TODO: find a way to avoid such cloning
				if(el.is('img')) {
					item.img = item.img.clone();
				}

				img = item.img[0];
				if(img.naturalWidth > 0) {
					item.hasSize = true;
				} else if(!img.width) {
					item.hasSize = false;
				}
			}

			mfp._parseMarkup(template, {
				title: _getTitle(item),
				img_replaceWith: item.img
			}, item);

			mfp.resizeImage();

			if(item.hasSize) {
				if(_imgInterval) clearInterval(_imgInterval);

				if(item.loadError) {
					template.addClass('mfp-loading');
					mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
				} else {
					template.removeClass('mfp-loading');
					mfp.updateStatus('ready');
				}
				return template;
			}

			mfp.updateStatus('loading');
			item.loading = true;

			if(!item.hasSize) {
				item.imgHidden = true;
				template.addClass('mfp-loading');
				mfp.findImageSize(item);
			}

			return template;
		}
	}
});

/*>>image*/

/*>>zoom*/
var hasMozTransform,
	getHasMozTransform = function() {
		if(hasMozTransform === undefined) {
			hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
		}
		return hasMozTransform;
	};

$.magnificPopup.registerModule('zoom', {

	options: {
		enabled: false,
		easing: 'ease-in-out',
		duration: 300,
		opener: function(element) {
			return element.is('img') ? element : element.find('img');
		}
	},

	proto: {

		initZoom: function() {
			var zoomSt = mfp.st.zoom,
				ns = '.zoom',
				image;

			if(!zoomSt.enabled || !mfp.supportsTransition) {
				return;
			}

			var duration = zoomSt.duration,
				getElToAnimate = function(image) {
					var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
						transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
						cssObj = {
							position: 'fixed',
							zIndex: 9999,
							left: 0,
							top: 0,
							'-webkit-backface-visibility': 'hidden'
						},
						t = 'transition';

					cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

					newImg.css(cssObj);
					return newImg;
				},
				showMainContent = function() {
					mfp.content.css('visibility', 'visible');
				},
				openTimeout,
				animatedImg;

			_mfpOn('BuildControls'+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);
					mfp.content.css('visibility', 'hidden');

					// Basically, all code below does is clones existing image, puts in on top of the current one and animated it

					image = mfp._getItemToZoom();

					if(!image) {
						showMainContent();
						return;
					}

					animatedImg = getElToAnimate(image);

					animatedImg.css( mfp._getOffset() );

					mfp.wrap.append(animatedImg);

					openTimeout = setTimeout(function() {
						animatedImg.css( mfp._getOffset( true ) );
						openTimeout = setTimeout(function() {

							showMainContent();

							setTimeout(function() {
								animatedImg.remove();
								image = animatedImg = null;
								_mfpTrigger('ZoomAnimationEnded');
							}, 16); // avoid blink when switching images

						}, duration); // this timeout equals animation duration

					}, 16); // by adding this timeout we avoid short glitch at the beginning of animation


					// Lots of timeouts...
				}
			});
			_mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {

					clearTimeout(openTimeout);

					mfp.st.removalDelay = duration;

					if(!image) {
						image = mfp._getItemToZoom();
						if(!image) {
							return;
						}
						animatedImg = getElToAnimate(image);
					}

					animatedImg.css( mfp._getOffset(true) );
					mfp.wrap.append(animatedImg);
					mfp.content.css('visibility', 'hidden');

					setTimeout(function() {
						animatedImg.css( mfp._getOffset() );
					}, 16);
				}

			});

			_mfpOn(CLOSE_EVENT+ns, function() {
				if(mfp._allowZoom()) {
					showMainContent();
					if(animatedImg) {
						animatedImg.remove();
					}
					image = null;
				}
			});
		},

		_allowZoom: function() {
			return mfp.currItem.type === 'image';
		},

		_getItemToZoom: function() {
			if(mfp.currItem.hasSize) {
				return mfp.currItem.img;
			} else {
				return false;
			}
		},

		// Get element postion relative to viewport
		_getOffset: function(isLarge) {
			var el;
			if(isLarge) {
				el = mfp.currItem.img;
			} else {
				el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
			}

			var offset = el.offset();
			var paddingTop = parseInt(el.css('padding-top'),10);
			var paddingBottom = parseInt(el.css('padding-bottom'),10);
			offset.top -= ( $(window).scrollTop() - paddingTop );


			/*

			Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

			 */
			var obj = {
				width: el.width(),
				// fix Zepto height+padding issue
				height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
			};

			// I hate to do this, but there is no another option
			if( getHasMozTransform() ) {
				obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
			} else {
				obj.left = offset.left;
				obj.top = offset.top;
			}
			return obj;
		}

	}
});



/*>>zoom*/

/*>>iframe*/

var IFRAME_NS = 'iframe',
	_emptyPage = '//about:blank',

	_fixIframeBugs = function(isShowing) {
		if(mfp.currTemplate[IFRAME_NS]) {
			var el = mfp.currTemplate[IFRAME_NS].find('iframe');
			if(el.length) {
				// reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
				if(!isShowing) {
					el[0].src = _emptyPage;
				}

				// IE8 black screen bug fix
				if(mfp.isIE8) {
					el.css('display', isShowing ? 'block' : 'none');
				}
			}
		}
	};

$.magnificPopup.registerModule(IFRAME_NS, {

	options: {
		markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
				'</div>',

		srcAction: 'iframe_src',

		// we don't care and support only one default type of URL by default
		patterns: {
			youtube: {
				index: 'youtube.com',
				id: 'v=',
				src: '//www.youtube.com/embed/%id%?autoplay=1'
			},
			vimeo: {
				index: 'vimeo.com/',
				id: '/',
				src: '//player.vimeo.com/video/%id%?autoplay=1'
			},
			gmaps: {
				index: '//maps.google.',
				src: '%id%&output=embed'
			}
		}
	},

	proto: {
		initIframe: function() {
			mfp.types.push(IFRAME_NS);

			_mfpOn('BeforeChange', function(e, prevType, newType) {
				if(prevType !== newType) {
					if(prevType === IFRAME_NS) {
						_fixIframeBugs(); // iframe if removed
					} else if(newType === IFRAME_NS) {
						_fixIframeBugs(true); // iframe is showing
					}
				}// else {
					// iframe source is switched, don't do anything
				//}
			});

			_mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
				_fixIframeBugs();
			});
		},

		getIframe: function(item, template) {
			var embedSrc = item.src;
			var iframeSt = mfp.st.iframe;

			$.each(iframeSt.patterns, function() {
				if(embedSrc.indexOf( this.index ) > -1) {
					if(this.id) {
						if(typeof this.id === 'string') {
							embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
						} else {
							embedSrc = this.id.call( this, embedSrc );
						}
					}
					embedSrc = this.src.replace('%id%', embedSrc );
					return false; // break;
				}
			});

			var dataObj = {};
			if(iframeSt.srcAction) {
				dataObj[iframeSt.srcAction] = embedSrc;
			}
			mfp._parseMarkup(template, dataObj, item);

			mfp.updateStatus('ready');

			return template;
		}
	}
});



/*>>iframe*/

/*>>gallery*/
/**
 * Get looped index depending on number of slides
 */
var _getLoopedId = function(index) {
		var numSlides = mfp.items.length;
		if(index > numSlides - 1) {
			return index - numSlides;
		} else  if(index < 0) {
			return numSlides + index;
		}
		return index;
	},
	_replaceCurrTotal = function(text, curr, total) {
		return text.replace(/%curr%/gi, curr + 1).replace(/%total%/gi, total);
	};

$.magnificPopup.registerModule('gallery', {

	options: {
		enabled: false,
		arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
		preload: [0,2],
		navigateByImgClick: true,
		arrows: true,

		tPrev: 'Previous (Left arrow key)',
		tNext: 'Next (Right arrow key)',
		tCounter: '%curr% of %total%'
	},

	proto: {
		initGallery: function() {

			var gSt = mfp.st.gallery,
				ns = '.mfp-gallery';

			mfp.direction = true; // true - next, false - prev

			if(!gSt || !gSt.enabled ) return false;

			_wrapClasses += ' mfp-gallery';

			_mfpOn(OPEN_EVENT+ns, function() {

				if(gSt.navigateByImgClick) {
					mfp.wrap.on('click'+ns, '.mfp-img', function() {
						if(mfp.items.length > 1) {
							mfp.next();
							return false;
						}
					});
				}

				_document.on('keydown'+ns, function(e) {
					if (e.keyCode === 37) {
						mfp.prev();
					} else if (e.keyCode === 39) {
						mfp.next();
					}
				});
			});

			_mfpOn('UpdateStatus'+ns, function(e, data) {
				if(data.text) {
					data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
				}
			});

			_mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
				var l = mfp.items.length;
				values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
			});

			_mfpOn('BuildControls' + ns, function() {
				if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
					var markup = gSt.arrowMarkup,
						arrowLeft = mfp.arrowLeft = $( markup.replace(/%title%/gi, gSt.tPrev).replace(/%dir%/gi, 'left') ).addClass(PREVENT_CLOSE_CLASS),
						arrowRight = mfp.arrowRight = $( markup.replace(/%title%/gi, gSt.tNext).replace(/%dir%/gi, 'right') ).addClass(PREVENT_CLOSE_CLASS);

					arrowLeft.click(function() {
						mfp.prev();
					});
					arrowRight.click(function() {
						mfp.next();
					});

					mfp.container.append(arrowLeft.add(arrowRight));
				}
			});

			_mfpOn(CHANGE_EVENT+ns, function() {
				if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

				mfp._preloadTimeout = setTimeout(function() {
					mfp.preloadNearbyImages();
					mfp._preloadTimeout = null;
				}, 16);
			});


			_mfpOn(CLOSE_EVENT+ns, function() {
				_document.off(ns);
				mfp.wrap.off('click'+ns);
				mfp.arrowRight = mfp.arrowLeft = null;
			});

		},
		next: function() {
			mfp.direction = true;
			mfp.index = _getLoopedId(mfp.index + 1);
			mfp.updateItemHTML();
		},
		prev: function() {
			mfp.direction = false;
			mfp.index = _getLoopedId(mfp.index - 1);
			mfp.updateItemHTML();
		},
		goTo: function(newIndex) {
			mfp.direction = (newIndex >= mfp.index);
			mfp.index = newIndex;
			mfp.updateItemHTML();
		},
		preloadNearbyImages: function() {
			var p = mfp.st.gallery.preload,
				preloadBefore = Math.min(p[0], mfp.items.length),
				preloadAfter = Math.min(p[1], mfp.items.length),
				i;

			for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
				mfp._preloadItem(mfp.index+i);
			}
			for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
				mfp._preloadItem(mfp.index-i);
			}
		},
		_preloadItem: function(index) {
			index = _getLoopedId(index);

			if(mfp.items[index].preloaded) {
				return;
			}

			var item = mfp.items[index];
			if(!item.parsed) {
				item = mfp.parseEl( index );
			}

			_mfpTrigger('LazyLoad', item);

			if(item.type === 'image') {
				item.img = $('<img class="mfp-img" />').on('load.mfploader', function() {
					item.hasSize = true;
				}).on('error.mfploader', function() {
					item.hasSize = true;
					item.loadError = true;
					_mfpTrigger('LazyLoadError', item);
				}).attr('src', item.src);
			}


			item.preloaded = true;
		}
	}
});

/*>>gallery*/

/*>>retina*/

var RETINA_NS = 'retina';

$.magnificPopup.registerModule(RETINA_NS, {
	options: {
		replaceSrc: function(item) {
			return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
		},
		ratio: 1 // Function or number.  Set to 1 to disable.
	},
	proto: {
		initRetina: function() {
			if(window.devicePixelRatio > 1) {

				var st = mfp.st.retina,
					ratio = st.ratio;

				ratio = !isNaN(ratio) ? ratio : ratio();

				if(ratio > 1) {
					_mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
						item.img.css({
							'max-width': item.img[0].naturalWidth / ratio,
							'width': '100%'
						});
					});
					_mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
						item.src = st.replaceSrc(item, ratio);
					});
				}
			}

		}
	}
});

/*>>retina*/
 _checkInstance(); }));
//Smmoth Scroll
! function () {
   function e() {
      z.keyboardSupport && m("keydown", a)
   }

   function t() {
      if (!A && document.body) {
         A = !0;
         var t = document.body,
            o = document.documentElement,
            n = window.innerHeight,
            r = t.scrollHeight;
         if (B = document.compatMode.indexOf("CSS") >= 0 ? o : t, D = t, e(), top != self) X = !0;
         else if (r > n && (t.offsetHeight <= n || o.offsetHeight <= n)) {
            var a = document.createElement("div");
            a.style.cssText = "position:absolute; z-index:-10000; top:0; left:0; right:0; height:" + B.scrollHeight + "px", document.body.appendChild(a);
            var i;
            T = function () {
               i || (i = setTimeout(function () {
                  L || (a.style.height = "0", a.style.height = B.scrollHeight + "px", i = null)
               }, 500))
            }, setTimeout(T, 10), m("resize", T);
            var l = {
               attributes: !0,
               childList: !0,
               characterData: !1
            };
            if (M = new W(T), M.observe(t, l), B.offsetHeight <= n) {
               var c = document.createElement("div");
               c.style.clear = "both", t.appendChild(c)
            }
         }
         z.fixedBackground || L || (t.style.backgroundAttachment = "scroll", o.style.backgroundAttachment = "scroll")
      }
   }

   function o() {
      M && M.disconnect(), w(_, r), w("mousedown", i), w("keydown", a), w("resize", T), w("load", t)
   }

   function n(e, t, o) {
      if (p(t, o), 1 != z.accelerationMax) {
         var n = Date.now(),
            r = n - j;
         if (r < z.accelerationDelta) {
            var a = (1 + 50 / r) / 2;
            a > 1 && (a = Math.min(a, z.accelerationMax), t *= a, o *= a)
         }
         j = Date.now()
      }
      if (q.push({
            x: t,
            y: o,
            lastX: 0 > t ? .99 : -.99,
            lastY: 0 > o ? .99 : -.99,
            start: Date.now()
         }), !P) {
         var i = e === document.body,
            l = function (n) {
               for (var r = Date.now(), a = 0, c = 0, u = 0; u < q.length; u++) {
                  var d = q[u],
                     s = r - d.start,
                     f = s >= z.animationTime,
                     m = f ? 1 : s / z.animationTime;
                  z.pulseAlgorithm && (m = x(m));
                  var w = d.x * m - d.lastX >> 0,
                     h = d.y * m - d.lastY >> 0;
                  a += w, c += h, d.lastX += w, d.lastY += h, f && (q.splice(u, 1), u--)
               }
               i ? window.scrollBy(a, c) : (a && (e.scrollLeft += a), c && (e.scrollTop += c)), t || o || (q = []), q.length ? V(l, e, 1e3 / z.frameRate + 1) : P = !1
            };
         V(l, e, 0), P = !0
      }
   }

   function r(e) {
      A || t();
      var o = e.target,
         r = u(o);
      if (!r || e.defaultPrevented || e.ctrlKey) return !0;
      if (h(D, "embed") || h(o, "embed") && /\.pdf/i.test(o.src) || h(D, "object") || o.shadowRoot) return !0;
      var a = -e.wheelDeltaX || e.deltaX || 0,
         i = -e.wheelDeltaY || e.deltaY || 0;
      return O && (e.wheelDeltaX && b(e.wheelDeltaX, 120) && (a = -120 * (e.wheelDeltaX / Math.abs(e.wheelDeltaX))), e.wheelDeltaY && b(e.wheelDeltaY, 120) && (i = -120 * (e.wheelDeltaY / Math.abs(e.wheelDeltaY)))), a || i || (i = -e.wheelDelta || 0), 1 === e.deltaMode && (a *= 40, i *= 40), !z.touchpadSupport && v(i) ? !0 : (Math.abs(a) > 1.2 && (a *= z.stepSize / 120), Math.abs(i) > 1.2 && (i *= z.stepSize / 120), n(r, a, i), e.preventDefault(), void l())
   }

   function a(e) {
      var t = e.target,
         o = e.ctrlKey || e.altKey || e.metaKey || e.shiftKey && e.keyCode !== K.spacebar;
      document.body.contains(D) || (D = document.activeElement);
      var r = /^(textarea|select|embed|object)$/i,
         a = /^(button|submit|radio|checkbox|file|color|image)$/i;
      if (e.defaultPrevented || r.test(t.nodeName) || h(t, "input") && !a.test(t.type) || h(D, "video") || g(e) || t.isContentEditable || o) return !0;
      if ((h(t, "button") || h(t, "input") && a.test(t.type)) && e.keyCode === K.spacebar) return !0;
      if (h(t, "input") && "radio" == t.type && R[e.keyCode]) return !0;
      var i, c = 0,
         d = 0,
         s = u(D),
         f = s.clientHeight;
      switch (s == document.body && (f = window.innerHeight), e.keyCode) {
         case K.up:
            d = -z.arrowScroll;
            break;
         case K.down:
            d = z.arrowScroll;
            break;
         case K.spacebar:
            i = e.shiftKey ? 1 : -1, d = -i * f * .9;
            break;
         case K.pageup:
            d = .9 * -f;
            break;
         case K.pagedown:
            d = .9 * f;
            break;
         case K.home:
            d = -s.scrollTop;
            break;
         case K.end:
            var m = s.scrollHeight - s.scrollTop - f;
            d = m > 0 ? m + 10 : 0;
            break;
         case K.left:
            c = -z.arrowScroll;
            break;
         case K.right:
            c = z.arrowScroll;
            break;
         default:
            return !0
      }
      n(s, c, d), e.preventDefault(), l()
   }

   function i(e) {
      D = e.target
   }

   function l() {
      clearTimeout(E), E = setInterval(function () {
         I = {}
      }, 1e3)
   }

   function c(e, t) {
      for (var o = e.length; o--;) I[F(e[o])] = t;
      return t
   }

   function u(e) {
      var t = [],
         o = document.body,
         n = B.scrollHeight;
      do {
         var r = I[F(e)];
         if (r) return c(t, r);
         if (t.push(e), n === e.scrollHeight) {
            var a = s(B) && s(o),
               i = a || f(B);
            if (X && d(B) || !X && i) return c(t, $())
         } else if (d(e) && f(e)) return c(t, e)
      } while (e = e.parentElement)
   }

   function d(e) {
      return e.clientHeight + 10 < e.scrollHeight
   }

   function s(e) {
      var t = getComputedStyle(e, "").getPropertyValue("overflow-y");
      return "hidden" !== t
   }

   function f(e) {
      var t = getComputedStyle(e, "").getPropertyValue("overflow-y");
      return "scroll" === t || "auto" === t
   }

   function m(e, t) {
      window.addEventListener(e, t, !1)
   }

   function w(e, t) {
      window.removeEventListener(e, t, !1)
   }

   function h(e, t) {
      return (e.nodeName || "").toLowerCase() === t.toLowerCase()
   }

   function p(e, t) {
      e = e > 0 ? 1 : -1, t = t > 0 ? 1 : -1, (Y.x !== e || Y.y !== t) && (Y.x = e, Y.y = t, q = [], j = 0)
   }

   function v(e) {
      return e ? (N.length || (N = [e, e, e]), e = Math.abs(e), N.push(e), N.shift(), clearTimeout(C), C = setTimeout(function () {
         window.localStorage && (localStorage.SS_deltaBuffer = N.join(","))
      }, 1e3), !y(120) && !y(100)) : void 0
   }

   function b(e, t) {
      return Math.floor(e / t) == e / t
   }

   function y(e) {
      return b(N[0], e) && b(N[1], e) && b(N[2], e)
   }

   function g(e) {
      var t = e.target,
         o = !1;
      if (-1 != document.URL.indexOf("www.youtube.com/watch"))
         do
            if (o = t.classList && t.classList.contains("html5-video-controls")) break; while (t = t.parentNode);
      return o
   }

   function S(e) {
      var t, o, n;
      return e *= z.pulseScale, 1 > e ? t = e - (1 - Math.exp(-e)) : (o = Math.exp(-1), e -= 1, n = 1 - Math.exp(-e), t = o + n * (1 - o)), t * z.pulseNormalize
   }

   function x(e) {
      return e >= 1 ? 1 : 0 >= e ? 0 : (1 == z.pulseNormalize && (z.pulseNormalize /= S(1)), S(e))
   }

   function k(e) {
      for (var t in e) H.hasOwnProperty(t) && (z[t] = e[t])
   }
   var D, M, T, E, C, H = {
         frameRate: 150,
         animationTime: 400,
         stepSize: 100,
         pulseAlgorithm: !0,
         pulseScale: 4,
         pulseNormalize: 1,
         accelerationDelta: 50,
         accelerationMax: 3,
         keyboardSupport: !0,
         arrowScroll: 50,
         touchpadSupport: !1,
         fixedBackground: !0,
         excluded: ""
      },
      z = H,
      L = !1,
      X = !1,
      Y = {
         x: 0,
         y: 0
      },
      A = !1,
      B = document.documentElement,
      N = [],
      O = /^Mac/.test(navigator.platform),
      K = {
         left: 37,
         up: 38,
         right: 39,
         down: 40,
         spacebar: 32,
         pageup: 33,
         pagedown: 34,
         end: 35,
         home: 36
      },
      R = {
         37: 1,
         38: 1,
         39: 1,
         40: 1
      },
      q = [],
      P = !1,
      j = Date.now(),
      F = function () {
         var e = 0;
         return function (t) {
            return t.uniqueID || (t.uniqueID = e++)
         }
      }(),
      I = {};
   window.localStorage && localStorage.SS_deltaBuffer && (N = localStorage.SS_deltaBuffer.split(","));
   var _, V = function () {
         return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (e, t, o) {
            window.setTimeout(e, o || 1e3 / 60)
         }
      }(),
      W = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver,
      $ = function () {
         var e;
         return function () {
            if (!e) {
               var t = document.createElement("div");
               t.style.cssText = "height:10000px;width:1px;", document.body.appendChild(t);
               var o = document.body.scrollTop;
               document.documentElement.scrollTop;
               window.scrollBy(0, 3), e = document.body.scrollTop != o ? document.body : document.documentElement, window.scrollBy(0, -3), document.body.removeChild(t)
            }
            return e
         }
      }(),
      U = window.navigator.userAgent,
      G = /Edge/.test(U),
      J = /chrome/i.test(U) && !G,
      Q = /safari/i.test(U) && !G,
      Z = /mobile/i.test(U),
      ee = /Windows NT 6.1/i.test(U) && /rv:11/i.test(U),
      te = (J || Q || ee) && !Z;
   "onwheel" in document.createElement("div") ? _ = "wheel" : "onmousewheel" in document.createElement("div") && (_ = "mousewheel"), _ && te && (m(_, r), m("mousedown", i), m("load", t)), k.destroy = o, window.SmoothScrollOptions && k(window.SmoothScrollOptions), "function" == typeof define && define.amd ? define(function () {
      return k
   }) : "object" == typeof exports ? module.exports = k : window.SmoothScroll = k
}();
/*! WOW - v1.0.3 - 2015-01-14
 * Copyright (c) 2015 Matthieu Aussaguel; Licensed MIT */
(function () {
   var a, b, c, d, e, f = function (a, b) {
         return function () {
            return a.apply(b, arguments)
         }
      },
      g = [].indexOf || function (a) {
         for (var b = 0, c = this.length; c > b; b++)
            if (b in this && this[b] === a) return b;
         return -1
      };
   b = function () {
      function a() {}
      return a.prototype.extend = function (a, b) {
         var c, d;
         for (c in b) d = b[c], null == a[c] && (a[c] = d);
         return a
      }, a.prototype.isMobile = function (a) {
         return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(a)
      }, a.prototype.createEvent = function (a, b, c, d) {
         var e;
         return null == b && (b = !1), null == c && (c = !1), null == d && (d = null), null != document.createEvent ? (e = document.createEvent("CustomEvent"), e.initCustomEvent(a, b, c, d)) : null != document.createEventObject ? (e = document.createEventObject(), e.eventType = a) : e.eventName = a, e
      }, a.prototype.emitEvent = function (a, b) {
         return null != a.dispatchEvent ? a.dispatchEvent(b) : b in (null != a) ? a[b]() : "on" + b in (null != a) ? a["on" + b]() : void 0
      }, a.prototype.addEvent = function (a, b, c) {
         return null != a.addEventListener ? a.addEventListener(b, c, !1) : null != a.attachEvent ? a.attachEvent("on" + b, c) : a[b] = c
      }, a.prototype.removeEvent = function (a, b, c) {
         return null != a.removeEventListener ? a.removeEventListener(b, c, !1) : null != a.detachEvent ? a.detachEvent("on" + b, c) : delete a[b]
      }, a.prototype.innerHeight = function () {
         return "innerHeight" in window ? window.innerHeight : document.documentElement.clientHeight
      }, a
   }(), c = this.WeakMap || this.MozWeakMap || (c = function () {
      function a() {
         this.keys = [], this.values = []
      }
      return a.prototype.get = function (a) {
         var b, c, d, e, f;
         for (f = this.keys, b = d = 0, e = f.length; e > d; b = ++d)
            if (c = f[b], c === a) return this.values[b]
      }, a.prototype.set = function (a, b) {
         var c, d, e, f, g;
         for (g = this.keys, c = e = 0, f = g.length; f > e; c = ++e)
            if (d = g[c], d === a) return void(this.values[c] = b);
         return this.keys.push(a), this.values.push(b)
      }, a
   }()), a = this.MutationObserver || this.WebkitMutationObserver || this.MozMutationObserver || (a = function () {
      function a() {
         "undefined" != typeof console && null !== console && console.warn("MutationObserver is not supported by your browser."), "undefined" != typeof console && null !== console && console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")
      }
      return a.notSupported = !0, a.prototype.observe = function () {}, a
   }()), d = this.getComputedStyle || function (a, b) {
      return this.getPropertyValue = function (b) {
         var c;
         return "float" === b && (b = "styleFloat"), e.test(b) && b.replace(e, function (a, b) {
            return b.toUpperCase()
         }), (null != (c = a.currentStyle) ? c[b] : void 0) || null
      }, this
   }, e = /(\-([a-z]){1})/g, this.WOW = function () {
      function e(a) {
         null == a && (a = {}), this.scrollCallback = f(this.scrollCallback, this), this.scrollHandler = f(this.scrollHandler, this), this.resetAnimation = f(this.resetAnimation, this), this.start = f(this.start, this), this.scrolled = !0, this.config = this.util().extend(a, this.defaults), null != a.scrollContainer && (this.config.scrollContainer = document.querySelector(a.scrollContainer)), this.animationNameCache = new c, this.wowEvent = this.util().createEvent(this.config.boxClass)
      }
      return e.prototype.defaults = {
         boxClass: "wow",
         animateClass: "animated",
         offset: 0,
         mobile: !0,
         live: !0,
         callback: null,
         scrollContainer: null
      }, e.prototype.init = function () {
         var a;
         return this.element = window.document.documentElement, "interactive" === (a = document.readyState) || "complete" === a ? this.start() : this.util().addEvent(document, "DOMContentLoaded", this.start), this.finished = []
      }, e.prototype.start = function () {
         var b, c, d, e;
         if (this.stopped = !1, this.boxes = function () {
               var a, c, d, e;
               for (d = this.element.querySelectorAll("." + this.config.boxClass), e = [], a = 0, c = d.length; c > a; a++) b = d[a], e.push(b);
               return e
            }.call(this), this.all = function () {
               var a, c, d, e;
               for (d = this.boxes, e = [], a = 0, c = d.length; c > a; a++) b = d[a], e.push(b);
               return e
            }.call(this), this.boxes.length)
            if (this.disabled()) this.resetStyle();
            else
               for (e = this.boxes, c = 0, d = e.length; d > c; c++) b = e[c], this.applyStyle(b, !0);
         return this.disabled() || (this.util().addEvent(this.config.scrollContainer || window, "scroll", this.scrollHandler), this.util().addEvent(window, "resize", this.scrollHandler), this.interval = setInterval(this.scrollCallback, 50)), this.config.live ? new a(function (a) {
            return function (b) {
               var c, d, e, f, g;
               for (g = [], c = 0, d = b.length; d > c; c++) f = b[c], g.push(function () {
                  var a, b, c, d;
                  for (c = f.addedNodes || [], d = [], a = 0, b = c.length; b > a; a++) e = c[a], d.push(this.doSync(e));
                  return d
               }.call(a));
               return g
            }
         }(this)).observe(document.body, {
            childList: !0,
            subtree: !0
         }) : void 0
      }, e.prototype.stop = function () {
         return this.stopped = !0, this.util().removeEvent(this.config.scrollContainer || window, "scroll", this.scrollHandler), this.util().removeEvent(window, "resize", this.scrollHandler), null != this.interval ? clearInterval(this.interval) : void 0
      }, e.prototype.sync = function (b) {
         return a.notSupported ? this.doSync(this.element) : void 0
      }, e.prototype.doSync = function (a) {
         var b, c, d, e, f;
         if (null == a && (a = this.element), 1 === a.nodeType) {
            for (a = a.parentNode || a, e = a.querySelectorAll("." + this.config.boxClass), f = [], c = 0, d = e.length; d > c; c++) b = e[c], g.call(this.all, b) < 0 ? (this.boxes.push(b), this.all.push(b), this.stopped || this.disabled() ? this.resetStyle() : this.applyStyle(b, !0), f.push(this.scrolled = !0)) : f.push(void 0);
            return f
         }
      }, e.prototype.show = function (a) {
         return this.applyStyle(a), a.className = a.className + " " + this.config.animateClass, null != this.config.callback && this.config.callback(a), this.util().emitEvent(a, this.wowEvent), this.util().addEvent(a, "animationend", this.resetAnimation), this.util().addEvent(a, "oanimationend", this.resetAnimation), this.util().addEvent(a, "webkitAnimationEnd", this.resetAnimation), this.util().addEvent(a, "MSAnimationEnd", this.resetAnimation), a
      }, e.prototype.applyStyle = function (a, b) {
         var c, d, e;
         return d = a.getAttribute("data-wow-duration"), c = a.getAttribute("data-wow-delay"), e = a.getAttribute("data-wow-iteration"), this.animate(function (f) {
            return function () {
               return f.customStyle(a, b, d, c, e)
            }
         }(this))
      }, e.prototype.animate = function () {
         return "requestAnimationFrame" in window ? function (a) {
            return window.requestAnimationFrame(a)
         } : function (a) {
            return a()
         }
      }(), e.prototype.resetStyle = function () {
         var a, b, c, d, e;
         for (d = this.boxes, e = [], b = 0, c = d.length; c > b; b++) a = d[b], e.push(a.style.visibility = "visible");
         return e
      }, e.prototype.resetAnimation = function (a) {
         var b;
         return a.type.toLowerCase().indexOf("animationend") >= 0 ? (b = a.target || a.srcElement, b.className = b.className.replace(this.config.animateClass, "").trim()) : void 0
      }, e.prototype.customStyle = function (a, b, c, d, e) {
         return b && this.cacheAnimationName(a), a.style.visibility = b ? "hidden" : "visible", c && this.vendorSet(a.style, {
            animationDuration: c
         }), d && this.vendorSet(a.style, {
            animationDelay: d
         }), e && this.vendorSet(a.style, {
            animationIterationCount: e
         }), this.vendorSet(a.style, {
            animationName: b ? "none" : this.cachedAnimationName(a)
         }), a
      }, e.prototype.vendors = ["moz", "webkit"], e.prototype.vendorSet = function (a, b) {
         var c, d, e, f;
         d = [];
         for (c in b) e = b[c], a["" + c] = e, d.push(function () {
            var b, d, g, h;
            for (g = this.vendors, h = [], b = 0, d = g.length; d > b; b++) f = g[b], h.push(a["" + f + c.charAt(0).toUpperCase() + c.substr(1)] = e);
            return h
         }.call(this));
         return d
      }, e.prototype.vendorCSS = function (a, b) {
         var c, e, f, g, h, i;
         for (h = d(a), g = h.getPropertyCSSValue(b), f = this.vendors, c = 0, e = f.length; e > c; c++) i = f[c], g = g || h.getPropertyCSSValue("-" + i + "-" + b);
         return g
      }, e.prototype.animationName = function (a) {
         var b;
         try {
            b = this.vendorCSS(a, "animation-name").cssText
         } catch (c) {
            b = d(a).getPropertyValue("animation-name")
         }
         return "none" === b ? "" : b
      }, e.prototype.cacheAnimationName = function (a) {
         return this.animationNameCache.set(a, this.animationName(a))
      }, e.prototype.cachedAnimationName = function (a) {
         return this.animationNameCache.get(a)
      }, e.prototype.scrollHandler = function () {
         return this.scrolled = !0
      }, e.prototype.scrollCallback = function () {
         var a;
         return !this.scrolled || (this.scrolled = !1, this.boxes = function () {
            var b, c, d, e;
            for (d = this.boxes, e = [], b = 0, c = d.length; c > b; b++) a = d[b], a && (this.isVisible(a) ? this.show(a) : e.push(a));
            return e
         }.call(this), this.boxes.length || this.config.live) ? void 0 : this.stop()
      }, e.prototype.offsetTop = function (a) {
         for (var b; void 0 === a.offsetTop;) a = a.parentNode;
         for (b = a.offsetTop; a = a.offsetParent;) b += a.offsetTop;
         return b
      }, e.prototype.isVisible = function (a) {
         var b, c, d, e, f;
         return c = a.getAttribute("data-wow-offset") || this.config.offset, f = this.config.scrollContainer && this.config.scrollContainer.scrollTop || window.pageYOffset, e = f + Math.min(this.element.clientHeight, this.util().innerHeight()) - c, d = this.offsetTop(a), b = d + a.clientHeight, e >= d && b >= f
      }, e.prototype.util = function () {
         return null != this._util ? this._util : this._util = new b
      }, e.prototype.disabled = function () {
         return !this.config.mobile && this.util().isMobile(navigator.userAgent)
      }, e
   }()
}).call(this);
/*

	Template Name: SeoBin
	Author: Themewinter
	Author URI: https://themeforest.net/user/themewinter
	Description: SeoBin
	Version: 1.0

   1. Menu Active link
   2. Drop down Menu
	3. Main Slideshow
	4. Testimonial Slider
   5. Testimonial Slider
   6. Testimonial Box Carousel
	7. Counter Up
	8. Clients Carousel
   9. Back to top
   10. video Popup
   11. Our Mission Carousel
   12. Map
   13. Contact Form
   14. Service List Box Slider
   15. On Hover Timeline Active Changed
   16. On Click search bar
   17. Onclick off canvas menu visible
   18. Wow Initialize
   19. Accordion
   
  
*/

$(function ($) {
   "use strict";

   if ($(window).width() < 991) {
      $(".navbar-nav li a").on("click", function () {
         $(this).parent("li").find(".dropdown-menu").slideToggle();
         $(this).find("i").toggleClass("fa-angle-up fa-angle-down");
      });

   }



   /*Main Slideshow*/
   $(".tw-hero-slider").owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      nav: true,
      dots: false,
      autoplayTimeout: 8000,
      autoplayHoverPause: true,
      mouseDrag: false,
      smartSpeed: 1100,
      navText: ['<i class="icon icon-left-arrow2">', '<i class="icon icon-right-arrow2">'],
   });

   /*Testimonial Slider*/
   $(".tw-testimonial-carousel").owlCarousel({
      items: 1,
      loop: true,
      autoplay: true,
      nav: false,
      dots: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      mouseDrag: false,
      smartSpeed: 900,
   });

   /* Testimonial Slider */
   if ($(".testimonial-slider").length > 0) {
      $(".testimonial-slider").owlCarousel({
         items: 1,
         loop: true,
         autoplay: true,
         nav: false,
         dots: true,
         autoplayTimeout: 5000,
         autoplayHoverPause: true,
         mouseDrag: true,
         smartSpeed: 900,
      });
   };

   /* Testimonial Slider */
   if ($(".testimonial-carousel-gray").length > 0) {
      $(".testimonial-carousel-gray").owlCarousel({
         items: 2,
         margin: 20,
         loop: true,
         autoplay: true,
         nav: false,
         dots: true,
         autoplayTimeout: 5000,
         autoplayHoverPause: true,
         mouseDrag: true,
         smartSpeed: 900,
      });
   };
   /* Testimonial Box Carousel */
   if ($(".testimonial-box-carousel").length > 0) {
      $(".testimonial-box-carousel").owlCarousel({
         items: 3,
         margin: 20,
         loop: true,
         autoplay: true,
         nav: false,
         dots: true,
         autoplayTimeout: 5000,
         autoplayHoverPause: true,
         mouseDrag: true,
         responsiveClass: true,
         smartSpeed: 900,
         responsive: {
            0: {
               items: 1,
            },
            600: {
               items: 2,
            },
            1000: {
               items: 3,
            }
         }
      });
   };


   /* Counter UP */
   $(".counter").counterUp({
      delay: 10,
      time: 2000
   });

   /* Client carousel */
   $(".clients-carousel").owlCarousel({
      items: 4,
      loop: true,
      nav: false,
      dots: true,
      autoplay: true,
      responsiveClass: true,
      autoplayHoverPause: true,
      mouseDrag: false,
      smartSpeed: 900,
      responsive: {
         0: {
            items: 1,
         },
         600: {
            items: 2,
         },
         1000: {
            items: 4,
         }
      }
   });

   /* Back to top */
   $(window).scroll(function () {
      if ($(this).scrollTop()) {
         $('.back-to-top button').fadeIn();
      } else {
         $('.back-to-top button').fadeOut();
      }
   });
   $(".back-to-top button").on('click', function () {
      $("html, body").animate({
         scrollTop: 0
      }, 1000);
   });

   /* Video Popup */
   if ($('.video-popup').length > 0) {
      $('.video-popup').magnificPopup({
         disableOn: 700,
         type: 'iframe',
         mainClass: 'mfp-fade',
         removalDelay: 160,
         preloader: false,
         fixedContentPos: false
      });
   };

   /* Our Mission Carousel */
   $('.mission-carousel').owlCarousel({
      items: 1,
      loop: true,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayHoverPause: true,
      mouseDrag: false,
      smartSpeed: 900,
      animateOut: 'animated slideInRight',
      animateIn: 'animated slideInRight',
   });

   /* Map */
   if ($('#map').length > 0) {

      var contactmap = {
         lat: -37.816218,
         lng: 144.964068
      };

      $('#map')
         .gmap3({
            zoom: 12,
            center: contactmap,
            scrollwheel: false,
            mapTypeId: "shadeOfGrey",
            mapTypeControlOptions: {
               mapTypeIds: [google.maps.MapTypeId.ROADMAP, "shadeOfGrey"]
            }
         })

         .styledmaptype(
            "shadeOfGrey", [

               {
                  "featureType": "administrative",
                  "elementType": "geometry.stroke",
                  "stylers": [{
                     "color": "#fefefe"
                  }, {
                     "lightness": 17
                  }, {
                     "weight": 1.2
                  }]
               },
               {
                  "featureType": "administrative",
                  "elementType": "geometry.fill",
                  "stylers": [{
                     "color": "#fefefe"
                  }, {
                     "lightness": 20
                  }]
               },
               {
                  "featureType": "transit",
                  "elementType": "geometry",
                  "stylers": [{
                     "color": "#f2f2f2"
                  }, {
                     "lightness": 19
                  }]
               },
               {
                  "featureType": "all",
                  "elementType": "labels.icon",
                  "stylers": [{
                     "visibility": "off"
                  }]
               },
               {
                  "featureType": "all",
                  "elementType": "labels.text.fill",
                  "stylers": [{
                     "saturation": 36
                  }, {
                     "color": "#333333"
                  }, {
                     "lightness": 40
                  }]
               },
               {
                  "featureType": "all",
                  "elementType": "labels.text.stroke",
                  "stylers": [{
                     "visibility": "on"
                  }, {
                     "color": "#ffffff"
                  }, {
                     "lightness": 16
                  }]
               },
               {
                  "featureType": "poi",
                  "elementType": "geometry",
                  "stylers": [{
                     "color": "#f5f5f5"
                  }, {
                     "lightness": 21
                  }]
               },
               {
                  "featureType": "road.local",
                  "elementType": "geometry",
                  "stylers": [{
                     "color": "#ffffff"
                  }, {
                     "lightness": 16
                  }]
               },
               {
                  "featureType": "road.arterial",
                  "elementType": "geometry",
                  "stylers": [{
                     "color": "#ffffff"
                  }, {
                     "lightness": 18
                  }]
               },
               {
                  "featureType": "road.highway",
                  "elementType": "geometry.stroke",
                  "stylers": [{
                     "color": "#ffffff"
                  }, {
                     "lightness": 29
                  }, {
                     "weight": 0.2
                  }]
               },
               {
                  "featureType": "road.highway",
                  "elementType": "geometry.fill",
                  "stylers": [{
                     "color": "#ffffff"
                  }, {
                     "lightness": 17
                  }]
               },
               {
                  "featureType": "landscape",
                  "elementType": "geometry",
                  "stylers": [{
                     "color": "#f5f5f5"
                  }, {
                     "lightness": 20
                  }]
               },
               {
                  "featureType": "water",
                  "elementType": "geometry",
                  "stylers": [{
                     "color": "#e9e9e9"
                  }, {
                     "lightness": 17
                  }]
               }
            ], {
               name: "HQ"
            }
         )

         .marker({
            position: contactmap,
            icon: './images/icon/map_marker.png'
         })

         .infowindow({
            position: contactmap,
            content: "16122 Collins Street West. Victoria"
         })

         .then(function (infowindow) {
            var map = this.get(0);
            var marker = this.get(1);
            marker.addListener('click', function () {
               infowindow.open(map, marker);
            });
         });
   };

   /* Contact Form */
   $('#contact-form').submit(function () {

      var $form = $(this),
         $error = $form.find('.error-container'),
         action = $form.attr('action');

      $error.slideUp(750, function () {
         $error.hide();

         var $name = $form.find('.form-name'),
            $phone = $form.find('.form-phone'),
            $email = $form.find('.form-email'),
            $subject = $form.find('.form-subject'),
            $message = $form.find('.form-message');

         $.post(action, {
               name: $name.val(),
               phone: $phone.val(),
               email: $email.val(),
               subject: $subject.val(),
               message: $message.val()
            },
            function (data) {
               $error.html(data);
               $error.slideDown('slow');

               if (data.match('success') != null) {
                  $name.val('');
                  $phone.val('');
                  $email.val('');
                  $subject.val('');
                  $message.val('');
               }
            }
         );

      });

      return false;

   });

   /* Service List Box Slider */
   if ($(".service-list-carousel").length > 0) {
      $(".service-list-carousel").owlCarousel({
         items: 3,
         loop: true,
         margin: 10,
         autoplay: true,
         nav: true,
         navText: ['<i class="icon icon-arrow-left"></i>', '<i class="icon icon-arrow-right"></i>'],
         dots: false,
         autoplayTimeout: 5000,
         autoplayHoverPause: true,
         mouseDrag: true,
         responsiveClass: true,
         smartSpeed: 900,
         responsive: {
            0: {
               items: 1,
            },
            600: {
               items: 2,
            },
            1000: {
               items: 3,
               margin: 5,
            }
         }
      });
   };

   /* On Hover Timeline Active Changed */
   $(".timeline-wrapper .row").hover(function () {
      $(".timeline-item").find(".timeline-badge").removeClass("active");
      $(this).find(".timeline-badge").addClass("active");
   });
   $(".timeline-wrapper .row").hover(function () {
      $(".timeline-item").find(".timeline-date").removeClass("active");
      $(this).find(".timeline-date").addClass("active");
   });

   /* On Click search bar */
   $(".tw-search i, .tw-offcanvas-menu i").on('click', function () {
      $(".search-bar").addClass('active');
   });
   $(".search-bar i.fa-close").on('click', function () {
      $(".search-bar").removeClass('active');
   });

   /* Onclick offcanvas menu visible */
   $(".tw-menu-bar").on("click", function () {
      $(".offcanvas-wrapper").addClass('active');
      $(".offcanvas-menu-overlay").addClass('menu-show');
   });
   $(".menu-close-btn, .offcanvas-menu-overlay").on("click", function () {
      $(".offcanvas-wrapper").removeClass('active');
      $(".offcanvas-menu-overlay").removeClass('menu-show');
   });

   /* Wow Initialize */
   new WOW().init();

   /* Accordion */
   function toggleIcon(e) {
      $(e.target)
         .prev('.card-header')
         .find(".faq-indicator")
         .toggleClass('fa-minus fa-plus');
   }
   $('#accordion').on('hidden.bs.collapse', toggleIcon);
   $('#accordion').on('shown.bs.collapse', toggleIcon);

   /* Navbar fixed */
   $(window).on('scroll', function () {
      if ($(window).scrollTop() > 400) {
         $('.tw-head, .tw-header').addClass('navbar-fixed');
      } else {
         $('.tw-head, .tw-header').removeClass('navbar-fixed');
      }
      if ($(window).scrollTop() < 400) {
         setTimeout(() => {
            $('header').removeClass('off-canvas');
         }, 0);
      } else {
         setTimeout(() => {
            $('header').addClass('off-canvas');
         }, 0);
      }
   });

});