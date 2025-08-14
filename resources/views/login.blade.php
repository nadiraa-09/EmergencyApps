<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>YMB Systems</title>

    <!-- Favicon -->
    <!-- <link rel="shortcut icon" href="src/favicon.ico"> -->
    <link rel="shortcut icon" href="dist/assets/img/yokogawa.ico">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="dist/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">

    <!-- CSS Front Template -->

    <link rel="preload" href="dist/assets/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="dist/assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">

    <style data-hs-appearance-onload-styles>
        * {
            transition: unset !important;
        }

        body {
            opacity: 0;
        }
    </style>

    <script>
        window.hs_config = {
            "autopath": "@@autopath",
            "deleteLine": "hs-builder:delete",
            "deleteLine:build": "hs-builder:build-delete",
            "deleteLine:dist": "hs-builder:dist-delete",
            "previewMode": false,
            "startPath": "/index.html",
            "vars": {
                "themeFont": "https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap",
                "version": "?v=1.0"
            },
            "layoutBuilder": {
                "extend": {
                    "switcherSupport": true
                },
                "header": {
                    "layoutMode": "default",
                    "containerMode": "container-fluid"
                },
                "sidebarLayout": "default"
            },
            "themeAppearance": {
                "layoutSkin": "default",
                "sidebarSkin": "default",
                "styles": {
                    "colors": {
                        "primary": "#377dff",
                        "transparent": "transparent",
                        "white": "#fff",
                        "dark": "132144",
                        "gray": {
                            "100": "#f9fafc",
                            "900": "#1e2022"
                        }
                    },
                    "font": "Inter"
                }
            },
            "languageDirection": {
                "lang": "en"
            },
            "skipFilesFromBundle": {
                "dist": ["dist/assets/js/hs.theme-appearance.js", "dist/assets/js/hs.theme-appearance-charts.js",
                    "dist/assets/js/demo.js"
                ],
                "build": ["dist/assets/css/theme.css",
                    "dist/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js",
                    "dist/assets/js/demo.js", "dist/assets/css/theme-dark.css", "dist/assets/css/docs.css",
                    "dist/vendor/icon-set/style.css", "dist/assets/js/hs.theme-appearance.js",
                    "dist/assets/js/hs.theme-appearance-charts.js",
                    "node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js",
                    "dist/assets/js/demo.js"
                ]
            },
            "minifyCSSFiles": ["dist/assets/css/theme.css", "dist/assets/css/theme-dark.css"],
            "copyDependencies": {
                "dist": {
                    "dist/assets/js/theme-custom.js": ""
                },
                "build": {
                    "dist/assets/js/theme-custom.js": "",
                    "node_modules/bootstrap-icons/font/*fonts/**": "dist/assets/css"
                }
            },
            "buildFolder": "",
            "replacePathsToCDN": {},
            "directoryNames": {
                "src": "/src",
                "dist": "/dist",
                "build": "/build"
            },
            "fileNames": {
                "dist": {
                    "js": "theme.min.js",
                    "css": "theme.min.css"
                },
                "build": {
                    "css": "theme.min.css",
                    "js": "theme.min.js",
                    "vendorCSS": "vendor.min.css",
                    "vendorJS": "vendor.min.js"
                }
            },
            "fileTypes": "jpg|png|svg|mp4|webm|ogv|json"
        }
        window.hs_config.gulpRGBA = (p1) => {
            const options = p1.split(',')
            const hex = options[0].toString()
            const transparent = options[1].toString()

            var c;
            if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                c = hex.substring(1).split('');
                if (c.length == 3) {
                    c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c = '0x' + c.join('');
                return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',' + transparent + ')';
            }
            throw new Error('Bad Hex');
        }
        window.hs_config.gulpDarken = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = -parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
        window.hs_config.gulpLighten = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
    </script>
</head>

<body>

    <script src="dist/assets/js/hs.theme-appearance.js"></script>

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main">
        <div class="position-fixed top-0 end-0 start-0 bg-img-start"
            style="height: 32rem; background-image: url(dist/assets/svg/components/card-6.svg);">
            <div class="shape shape-bottom zi-1">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                    viewBox="0 0 1921 273">
                    <polygon fill="#fff" points="0,273 1921,273 1921,0 " />
                </svg>
            </div>
        </div>

        <div class="container py-5 py-sm-7">
            <a class="d-flex justify-content-center mb-5" href="/index.php">
                <!-- <img class="zi-2" src="dist/assets/svg/logos/logo.svg" alt="Image Description" style="width: 8rem;"> -->
                <img class="zi-2" src="dist/assets/img/front_image.png" alt="Image Description" style="width: 8rem;">
            </a>

            <div class="mx-auto" style="max-width: 30rem;">
                <div class="card card-lg mb-5">
                    <div class="card-body">
                        <form action="process/Auth.process.php" class="js-validate needs-validation" method="post"
                            novalidate>
                            @csrf
                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg" name="username"
                                    id="username" placeholder="nomor badge" aria-label="username" required>
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control form-control-lg"
                                        name="password" id="password" placeholder="password" aria-label="password"
                                        data-hs-toggle-password-options='{"target": "#changePassTarget","defaultClass": "bi-eye-slash","showClass": "bi-eye","classChangeTarget": "#changePassIcon"}'>
                                    <a id="changePassTarget" class="input-group-append input-group-text"
                                        href="javascript:;">
                                        <i id="changePassIcon" class="bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" name="login" id="login">Sign
                                    in</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="position-relative text-center zi-1">
                    <small class="text-cap text-body mb-4">PT1. Yokogawa Manufacturing Batam</small>
                </div>
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <!-- JS Global Compulsory  -->
    <script src="dist/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="dist/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="dist/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="dist/assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>

    <!-- JS Front -->
    <script src="dist/assets/js/theme.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#login-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/login',
                    data: $('#login').serialize(),
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Berhasil!',
                                text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/pages/dashboard';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal!',
                                text: response.message,
                            });
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });

        (function() {
            window.onload = function() {
                new HSTogglePassword('.js-toggle-password')
            }
        })()
    </script>
</body>

</html>