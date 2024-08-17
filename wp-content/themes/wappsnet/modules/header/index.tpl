<head>
    <!--app seo settings-->
    <title>{$seo.title}</title>
    <meta charset="{$seo.chars}"/>
    <meta property="og:locale" content="en"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{$seo.title}">
    <meta property="og:url" content="{$seo.link}">
    <meta property="og:image" content="{$seo.image}">
    <meta property="og:description" content="{$seo.text}">
    <meta name="description" content="{$seo.desc}">

    <!--app view settings-->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <!--app scripts links-->
    <link rel="stylesheet" href="{$scripts['css']}"/>
</head>

<body class="{$class}">