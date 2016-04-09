<!DOCTYPE html>
<html>
<head>
    <title>國立中正大學 校務建言系統</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="/assets/css/css/kube.min.css" />
    <link rel="stylesheet" href="/assets/css/css/style.css" />
    <link rel="stylesheet" href="/assets/css/icon/css/font-awesome.min.css" />
    <script src="/assets/js/vue.js"></script>
    <script src="/assets/js/dropzonejs.js"></script>
    <link rel="stylesheet" href="/assets/css/css/dropzonejs.css">

</head>
<body>

<div class="navbar">
    <blocks cols="4">
        <div class="title-redesign">
            <p>國立中正大學</p>
            <h1>校務建言系統</h1>
        </div>

    </blocks>


</div>

<div class="cos-container">
    @yield('content')
</div>

</body>
</html>