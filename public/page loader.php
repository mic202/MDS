<head>
       <style type="text/css">
            .loader {
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url('sources/images/mic_pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
            }
        </style>
</head>


<body>
	<div class="loader" style="background-color: #fff;"></div>
</body>





<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("fast");
    })
</script>


