<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Globus</title>
    <meta name="author" content="Daniel Seifert (Karma Implementor)" />
    <meta name="copyright" content="Daniel Seifert 2016" />
    <meta name="robots" content="noindex" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        canvas,
        html {
            width: 100%;
            height: 100%;
        }
        canvas {
            position: absolute;
            top: 0;
            left: 0;
        }
        svg {
            position: absolute;
            bottom: 3px;
            left: 3px;
            min-width: 31px;
            min-height: 31px;
            width: 22%;
            height: 22%;
            opacity: 0.3;
            transition: opacity 500ms;
            transition-delay: 2s;
        }
        body:hover svg {
            opacity: 1;
            transition-delay: 0s;
        }
    </style>
</head>
<body>
<script>
    function r18(r19, r20) {
        function cc(a, b, c) {
            c = r19.createElement("canvas");
            c.width = a;
            c.height = b || a;
            return c;
        }
        function gc(a, b) {
            return cc(a, b).getContext("2d");
        }
        function r21(a, b) {
            return a[0] * b[0] + a[1] * b[1] + a[2] * b[2];
        }
        function r22(a) {
            var t = window.devicePixelRatio || 1;
            return a !== r20 ? Math.round(a * t) : t;
        }
        function r23(a) {
            var s,
                t = r21(a, a);
            if (t < 155.25) {
                t = -1 / a[2];
                s = r24.width * 5;
                return [(0.1 + t * a[0]) * s, r24.height - (0.1 + t * a[1]) * s];
            }
        }
        function r25(a, b) {
            a = 6.2831853071796 * a;
            b = 3.1415926535898 * (b + 0.5);
            var t = Math.sin(b);
            return [t * Math.sin(a), Math.cos(b), t * Math.cos(a)];
        }
        function r26() {
            var r27 = new Float32Array(16);
            this.r28 = function () {
                r27.set([1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1]);
            };
            this.r28();
            this.r29 = function () {
                return r27;
            };
            function r30(a) {
                var t = [];
                for (var i = 0; i < 16; ++i) {
                    t[i] = 0;
                    for (var j = 0; j < 4; ++j) t[i] += a[(i & 3) + (j << 2)] * r27[((i >> 2) << 2) + j];
                }
                r27.set(t);
            }
            this.r31 = function (a) {
                return [r27[0] * a[0] + r27[4] * a[1] + r27[8] * a[2] + r27[12], r27[1] * a[0] + r27[5] * a[1] + r27[9] * a[2] + r27[13], r27[2] * a[0] + r27[6] * a[1] + r27[10] * a[2] + r27[14]];
            };
            this.r32 = function (a, b, c) {
                r30([1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, a, b, c, 1]);
            };
            this.r33 = function (a) {
                var c = Math.cos(a),
                    s = Math.sin(a);
                r30([1, 0, 0, 0, 0, c, s, 0, 0, -s, c, 0, 0, 0, 0, 1]);
            };
            this.r34 = function (a) {
                var c = Math.cos(a),
                    s = Math.sin(a);
                r30([c, 0, -s, 0, 0, 1, 0, 0, s, 0, c, 0, 0, 0, 0, 1]);
            };
        }
        function r35(a, b, e) {
            var r36 = g.createProgram(),
                r37 = {},
                r38 = {};
            (function () {
                function c(a, b) {
                    a = g.createShader(a);
                    g.shaderSource(a, "precision highp float;" + b);
                    g.compileShader(a);
                    g.attachShader(r36, a);
                }
                c(g.VERTEX_SHADER, a);
                c(g.FRAGMENT_SHADER, b);
                g.linkProgram(r36);
                if (!g.getProgramParameter(r36, g.LINK_STATUS)) throw 0;
                function l(a) {
                    var t,
                        r = /uniform\s*\w+\s*(\w+)/g;
                    while ((t = r.exec(a)) !== null) r38[t[1]] = g.getUniformLocation(r36, t[1]);
                    r = /attribute\s*\w+\s*(\w+)/g;
                    while ((t = r.exec(a)) !== null) r37[t[1]] = g.getAttribLocation(r36, t[1]);
                }
                l(a);
                l(b);
            })();
            this.r39 = function () {
                g.useProgram(r36);
                if (r38.r1 !== r20) g.uniformMatrix4fv(r38.r1, false, r40.r29());
                if (r38.r2 !== r20) g.uniformMatrix4fv(r38.r2, false, r41);
                for (var i in r37) g.enableVertexAttribArray(r37[i]);
                e(r38, r37);
                for (var i in r37) g.disableVertexAttribArray(r37[i]);
            };
            this.r42 = function (a, b, c) {
                g.useProgram(r36);
                g["uniform" + a](r38[b], c);
            };
        }
        function r43(r44) {
            var r45 = [],
                r46 = [],
                r47,
                r48 = new Int16Array(2 * r44.r49);
            function r50() {
                var i = 1000,
                    j = r44.r51,
                    s = j.length,
                    t = g.createBuffer();
                r45.unshift(t);
                g.bindBuffer(g.ARRAY_BUFFER, t);
                t = new r44.r51.constructor(1000 * r44.r51.length);
                while (i--) t.set(j, i * s);
                g.bufferData(g.ARRAY_BUFFER, t, g.STATIC_DRAW);
                t = g.createBuffer();
                r46.unshift(t);
                g.bindBuffer(g.ARRAY_BUFFER, t);
                g.bufferData(g.ARRAY_BUFFER, new Int16Array(2000 * r44.r49), g.STATIC_DRAW);
                r47 = 0;
            }
            r50();
            this.r52 = function (a) {
                r47 == 1000 && r50();
                a = new Int16Array([Math.floor(65535 * a[0]), Math.floor(65535 * a[1])]);
                var i = r44.r49;
                while (i--) r48.set(a, i << 1);
                g.bindBuffer(g.ARRAY_BUFFER, r46[0]);
                g.bufferSubData(g.ARRAY_BUFFER, r47 * r48.buffer.byteLength, r48);
                ++r47;
            };
            this.r53 = function (r37) {
                var s,
                    t = r44.r49;
                for (var i = r45.length; i--; ) {
                    s = t * (i ? 1000 : r47);
                    if (s) {
                        g.bindBuffer(g.ARRAY_BUFFER, r46[i]);
                        g.vertexAttribPointer(r37.r4, 2, g.SHORT, true, 0, 0);
                        g.bindBuffer(g.ARRAY_BUFFER, r45[i]);
                        r44.r54(r37);
                        g.drawArrays(g.TRIANGLES, 0, s);
                    }
                }
            };
        }
        var r55 = {
                r8: "attribute vec2 r3;varying vec2 r9;void main(){r9=r3*0.1;gl_Position=vec4(r3,.0,1.0);}",
                r10:
                    "uniform sampler2D r7;uniform vec2 r11;uniform mat4 r1;uniform float r12;varying vec2 r9;void main(){float t=dot(r9,r9);gl_FragColor.a=1.0-smoothstep(r11.x,r11.y,sqrt(t));++t;t=(12.5-sqrt(156.25-t*(155.25)))/t;vec3 r13=vec3(t*r9,-t+12.5);r13=normalize(r13*mat3(r1[0].xyz,r1[1].xyz,r1[2].xyz));vec3 r14=texture2D(r7,vec2(0.1591549430919*atan(r13.x,r13.z),0.31830988618379*asin(r13.y))+.5).rgb;vec2 r15=r9;r15.x+=r12;t=dot(r15,r15);++t;t=(12.5-sqrt(156.25-t*155.25))/t;r13=normalize(vec3(t*r15,-t+12.5)*mat3(r1[0].xyz,r1[1].xyz,r1[2].xyz));r14+=texture2D(r7,vec2(0.1591549430919*atan(r13.x,r13.z),0.31830988618379*asin(r13.y))+.5).rgb;r15.y+=r12;t=dot(r15,r15);++t;t=(12.5-sqrt(156.25-t*155.25))/t;r13=normalize(vec3(t*r15,-t+12.5)*mat3(r1[0].xyz,r1[1].xyz,r1[2].xyz));r14+=texture2D(r7,vec2(0.1591549430919*atan(r13.x,r13.z),0.31830988618379*asin(r13.y))+.5).rgb;r15=r9;r15.y+=r12;t=dot(r15,r15);++t;t=(12.5-sqrt(156.25-t*155.25))/t;r13=normalize(vec3(t*r15,-t+12.5)*mat3(r1[0].xyz,r1[1].xyz,r1[2].xyz));r14+=texture2D(r7,vec2(0.1591549430919*atan(r13.x,r13.z),0.31830988618379*asin(r13.y))+.5).rgb;gl_FragColor.rgb=r14*.25;gl_FragColor.rgb*=gl_FragColor.a;}",
                r0:
                    "uniform mat4 r1;uniform mat4 r2;attribute float r3;attribute vec2 r4;varying vec2 r5;void main(){float t=r3*2.0943951023932;vec3 p=vec3(cos(t),sin(t),1.0);r5=0.66666666666667*(p.xy+.5);r5.y+=0.16666666666667;p.xy*=0.11355;t=1.5707963267949*r4.y;float t1=sin(t);t=cos(t);p=vec3(p.x,t*p.y-t1,t1*p.y+t);t=3.1415926535898*r4.x;t1=sin(t);t=cos(t);gl_Position=r2*r1*vec4(t*p.x+t1*p.z,p.y,t*p.z-t1*p.x,1.0);}",
                r6: "uniform sampler2D r7;varying vec2 r5;void main(){vec4 t=texture2D(r7,r5);t.rgb*=t.a;gl_FragColor=t;}",
                r56: "varying vec2 r9;void main(){float t=dot(r9,r9);++t;t=-12.5/t;vec3 p=vec3(-t*r9,t+12.5);t=dot(p,p);t=0.3/pow(t,8.5);gl_FragColor=vec4(t,t,t,t);}",
                r57:
                    "varying vec2 r9;void main(){float t=dot(r9,r9);++t;float r=156.25-t*155.25;r=(12.5-sqrt(r))/t;vec3 r16=vec3(r*r9,-r+12.5);vec3 p=normalize(vec3(400.0,-70.0,312.5)-r16);r16=normalize(r16);float r17=0.42000*max(dot(r16,p),.0)+0.30000*pow(max(dot(reflect(p,r16),normalize(vec3(.0,.0,-12.5)+r16)),.0),6.8);t=-12.5/t;p=vec3(-t*r9,t+12.5);r17+=0.3/pow(2.0-dot(p,p),8.5);gl_FragColor=vec4(r17,r17,r17,r17);}",
            },
            r58 = cc(1),
            g = r58.getContext("webgl", { antialias: false, depth: false }) || r58.getContext("experimental-webgl", { antialias: false, depth: false }),
            r59 = gc(1),
            r24 = r59.canvas,
            r41 = new Float32Array([10, 0, 0, 0, 0, 10, 0, 0, 0, 0, -9.8, -1, 0, 0, -118.8, 0]),
            r40 = new r26(),
            r60,
            r61,
            r62 = 0,
            r63,
            r64 = 0.3,
            r65 = 0,
            r66 = 0.4,
            r67 = 0,
            r68,
            r69,
            r70 = [];
        (function (t, i) {
            r19.body.insertBefore(r24, r19.body.firstChild);
            r19.body.insertBefore(r58, r19.body.firstChild);
            g.activeTexture(g.TEXTURE0);
            g.pixelStorei(g.UNPACK_FLIP_Y_WEBGL, true);
            g.hint(g.GENERATE_MIPMAP_HINT, g.NICEST);
            g.enable(g.CULL_FACE);
            g.cullFace(g.BACK);
            g.enable(g.BLEND);
            r61 = (function (a) {
                g.bindBuffer(g.ARRAY_BUFFER, a);
                g.bufferData(g.ARRAY_BUFFER, new Int8Array([-1, 1, -1, -1, 1, 1, 1, -1]), g.STATIC_DRAW);
                return function (r37) {
                    g.bindBuffer(g.ARRAY_BUFFER, a);
                    g.vertexAttribPointer(r37.r3, 2, g.BYTE, false, 0, 0);
                    g.drawArrays(g.TRIANGLE_STRIP, 0, 4);
                };
            })(g.createBuffer());
            t = {
                r51: new Int8Array([0, 1, 2]),
                r49: 3,
                r54: function (r37) {
                    g.vertexAttribPointer(r37.r3, 1, g.BYTE, false, 0, 0);
                },
            };
            r60 = new r43(t);
            r24.addEventListener("mousemove", function (e) {
                r67 = e.pageY < 35 ? -0.55 : e.pageY > 106.5 ? 0.55 : 0;
            });
            r24.addEventListener("mouseout", function () {
                r67 = 0;
            });
        })();
        var r71 = new r35(r55.r8, r55.r56, function (r38, r37) {
                g.blendFunc(g.ONE_MINUS_DST_ALPHA, g.ONE);
                r61(r37);
            }),
            r72 = new r35(r55.r8, r55.r57, function (r38, r37) {
                g.blendFuncSeparate(g.DST_ALPHA, g.ONE_MINUS_SRC_ALPHA, g.ZERO, g.ONE);
                r61(r37);
            }),
            r73 = (function () {
                var r74;
                (function () {
                    function a(b) {
                        r74 = [];
                        while (b.width > 1) {
                            var t = g.createTexture();
                            r74.push(t);
                            g.bindTexture(g.TEXTURE_2D, t);
                            g.texImage2D(g.TEXTURE_2D, 0, g.RGB, g.RGB, g.UNSIGNED_BYTE, b);
                            g.texParameteri(g.TEXTURE_2D, g.TEXTURE_MAG_FILTER, g.LINEAR);
                            g.texParameteri(g.TEXTURE_2D, g.TEXTURE_MIN_FILTER, g.LINEAR);
                            t = gc(b.width >> 1, b.height >> 1);
                            t.drawImage(b, 0, 0, t.canvas.width, t.canvas.height);
                            b = t.canvas;
                        }
                        r74.reverse();
                    }
                    var w = Math.pow(2, Math.min(9, Math.log(g.getParameter(g.MAX_TEXTURE_SIZE)) / Math.LN2) | 0),
                        h = w >> 1,
                        t = gc(w, h);
                    t.fillStyle = "#aaa";
                    t.fillRect(0, 0, w, h);
                    t.fillStyle = "#555";
                    for (var i = w; i >= 0; i -= w >> 4) t.fillRect(i, 0, w >> 8, h);
                    for (var i = h; i > 0; i -= h >> 3) t.fillRect(0, i, w, h >> 7);
                    a(t.canvas);
                    (function r75(t) {
                        t = new Image();
                        t.onload = function () {
                            a(this);
                        };
                        t.onerror = function () {
                            setTimeout(r75, 3000);
                        };
                        t.src = "/newsite/img/" + w;
                    })();
                })();
                return function (r38, r37) {
                    g.uniform1f(r38.r12, 0.1 / g.drawingBufferWidth);
                    var t = Math.atan(Math.asin(0.08));
                    g.uniform2fv(r38.r11, [t - 0.46 / g.drawingBufferWidth, t]);
                    g.bindTexture(g.TEXTURE_2D, r74[Math.min(Math.ceil(Math.log((-31.415926535898 / -11.5) * g.drawingBufferWidth) / 0.69314718055995), r74.length) - 1]);
                    g.blendFunc(g.ONE, g.ZERO);
                    r61(r37);
                };
            })();
        r73 = new r35(r55.r8, r55.r10, r73);
        r73.r42("1i", "r7", 0);
        var r76 = (function () {
            var r77 = g.createTexture();
            (function (c, t) {
                c.beginPath();
                c.arc(21.5, 21.5, 12, 0, 6.283185307179586);
                c.fillStyle = "#000";
                c.fill();
                c.beginPath();
                c.arc(21.5, 21.5, 8.5, 0, 6.283185307179586);
                c.fillStyle = "rgb(" + 84 + "," + 255 + "," + 0 + ")";
                c.fill();
                t.drawImage(c.canvas, 0, 10.5);
                g.bindTexture(g.TEXTURE_2D, r77);
                g.texImage2D(g.TEXTURE_2D, 0, g.RGBA, g.RGBA, g.UNSIGNED_BYTE, t.canvas);
                g.texParameteri(g.TEXTURE_2D, g.TEXTURE_WRAP_S, g.CLAMP_TO_EDGE);
                g.texParameteri(g.TEXTURE_2D, g.TEXTURE_WRAP_T, g.CLAMP_TO_EDGE);
                g.texParameteri(g.TEXTURE_2D, g.TEXTURE_MIN_FILTER, g.LINEAR_MIPMAP_LINEAR);
                g.texParameteri(g.TEXTURE_2D, g.TEXTURE_MAG_FILTER, g.LINEAR);
                g.generateMipmap(g.TEXTURE_2D);
            })(gc(43), gc(64));
            return function (r38, r37) {
                g.blendFuncSeparate(g.DST_ALPHA, g.ONE_MINUS_SRC_ALPHA, g.ZERO, g.ONE);
                g.bindTexture(g.TEXTURE_2D, r77);
                r60.r53(r37);
            };
        })();
        r76 = new r35(r55.r0, r55.r6, r76);
        r76.r42("1i", "r7", 0);
        function r80() {
            var r81 = {};
            this.r82 = {};
            this.r83 = function (d, r84) {
                var r85 = d.length,
                    l,
                    i = 0,
                    t;
                while (i < r85) {
                    l = d[i].split("\t");
                    if (l.length == 2 || l.length == 3) {
                        t = l[0] + "," + l[1];
                        l[0] = l[0] / 368 - 0.5;
                        l[1] = l[1] / 184 - 0.5;
                        if (l[2]) this.r82[t] = l;
                        if (!r81[t]) {
                            r81[t] = true;
                            r60.r52(l);
                        }
                    }
                    ++i;
                }
                for (var i in this.r82) if (this.r82[i][2] < r84) delete this.r82[i];
            };
        }
        var r86 = new r80(),
            r87 = (function () {
                var r88;
                function r89() {
                    r88 = gc(r22(35));
                }
                r89();
                r70.push(r89);
                return function () {
                    r59.clearRect(0, 0, r24.width, r24.height);
                    function u(a) {
                        a = r23(r40.r31(r25(a[0], a[1])));
                        a && r59.drawImage(r88.canvas, a[0] - 0.5 * r88.canvas.width, a[1] - 0.5 * r88.canvas.width);
                    }
                    r88.clearRect(0, 0, r88.canvas.width, r88.canvas.width);
                    function r90(o, t, w) {
                        o += 255 * t;
                        o = o > 255 ? 255 : o | 0;
                        r88.strokeStyle = "rgba(" + o + "," + o + "," + o + "," + t + ")";
                        r88.lineWidth = w * r22();
                        r88.beginPath();
                        o = 0.5 * r88.canvas.width;
                        r88.arc(o, o, o * (1 - t), 0, 6.2831853071796);
                        r88.stroke();
                    }
                    r88.fillStyle = "rgba(255,255,255," + Math.cos((0.001 * r69) % 1.5707963267948966) + ")";
                    r88.beginPath();
                    o = 0.5 * r88.canvas.width;
                    r88.arc(0.5 * r88.canvas.width, 0.5 * r88.canvas.width, 0.03 * r88.canvas.width, 0, 6.2831853071796);
                    r88.fill();
                    r90(0, Math.cos((0.001 * r69) % 1.5707963267948966), 1);
                    r90(45, Math.cos((0.3 + 0.001 * r69) % 1.5707963267948966), 1);
                    r90(45, Math.cos((0.6 + 0.001 * r69) % 1.5707963267948966), 1.3);
                    r90(0, Math.cos((0.001 * r69) % 1.5707963267948966), 1);
                    r90(45, Math.cos((0.3 + 0.001 * r69) % 1.5707963267948966), 1);
                    r90(45, Math.cos((0.6 + 0.001 * r69) % 1.5707963267948966), 1.3);
                    for (var i in r86.r82) u(r86.r82[i]);
                };
            })();
        (function () {
            function ur() {
                return "&r=" + ((1679615 * Math.random()) | 0).toString(36);
            }
            (function r91() {
                function e() {
                    setTimeout(r91, 6000);
                }
                r92("1647038158	500	0.60449	0.18945");
            })();
            function r92(l) {
                var st = 0,
                    ri,
                    r93 = +l[0],
                    r94 = +l[1];
                r86.r83([Math.round(l[2] * 368) + "\t" + Math.round(l[3] * 184) + "\t1"], 1);
                r63 = 0.8 + 2 * Math.PI * (+l[2] + 0.25);
                l = (function (r95) {
                    return function (a) {
                        if (a !== r20) r95 = a;
                        if (!r95 || r19.hidden) {
                            cancelAnimationFrame(r68);
                            r68 = 0;
                        } else if (!r68) {
                            r69 = new Date().getTime();
                            r39();
                        }
                    };
                })();
                r19.addEventListener("visibilitychange", function () {
                    l();
                });
                if ("IntersectionObserverEntry" in window && "isIntersecting" in window.IntersectionObserverEntry.prototype)
                    new IntersectionObserver(function (a) {
                        l(a[0].isIntersecting);
                    }).observe(r19.documentElement);
                else
                    addEventListener("message", function (a) {
                        l(a.data);
                    });
                r93 &&
                (function r96() {
                    if (r68) {
                        var r = new XMLHttpRequest();
                        r.open("GET", "/index.php?page_id=1986");
                        r.onload = r.onerror = function () {
                            try {
                                var r51 = r.responseText.split("\n");
                                if (r51.shift() != "rm") throw 0;
                                st = parseInt(r51.shift(), 36);
                                ri = 10000 * (r51.shift() | 0);
                                ri = st < r93 ? 1 : ri;
                                r86.r83(r51, (ri != 1 ? st : r93) - r94);
                                //setTimeout(r96, ri);
                            } catch (e) {
                                ri = 1;
                                setTimeout(r96, 6000);
                            }
                        };
                        r.send(null);
                    } else {
                        setTimeout(r96, 500);
                    }
                })();
            }
        })();
        function r39() {
            var t = new Date().getTime(),
                r97 = 0.001 * (t - r69);
            r69 = t;
            t = r22(142);
            if (t != r58.width) {
                r58.width = r58.height = r24.width = r24.height = t;
                g.viewport(0, 0, t, t);
                for (var i in r70) r70[i]();
            }
            function r98(a) {
                a = r97 * (a || 1) * 7;
                return a < 1 ? a : 1;
            }
            r64 += r67 * r97;
            r62 += r98() * (r64 - r62);
            r65 += r98(0.1) * (r66 - r65);
            r63 += r65 * r97;
            r40.r28();
            r40.r34(r63);
            r40.r33(r62);
            r40.r32(0, 0, -12.5);
            r73.r39();
            r76.r39();
            r71.r39();
            r72.r39();
            r87();
            r68 = requestAnimationFrame(r39);
        }
    }
    if ("IntersectionObserverEntry" in window && "isIntersecting" in window.IntersectionObserverEntry.prototype)
        new IntersectionObserver(function (a, b) {
            if (a[0].isIntersecting) {
                b.disconnect();
                r18(document);
            }
        }).observe(document.documentElement);
    else {
        function r99(a) {
            if (a.data) {
                removeEventListener("message", r99);
                r18(document);
            }
        }
        addEventListener("message", r99);
    }
</script>
</body>
</html>
