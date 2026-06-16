<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

body{
    font-family:Arial,sans-serif;
    background:#f8fafc;
    margin:0;
    padding:20px;
}

.container{
    max-width:700px;
    margin:auto;
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 12px rgba(0,0,0,.08);
}

.header{
    background:#0f172a;
    color:white;
    padding:24px;
}

.logo{
    font-size:22px;
    font-weight:800;
}

.content{
    padding:24px;
}

.card{
    background:#f8fafc;
    border-radius:12px;
    padding:16px;
    margin-top:15px;
}

.label{
    color:#64748b;
    font-size:12px;
}

.value{
    font-size:15px;
    font-weight:700;
    margin-bottom:12px;
}

.footer{
    padding:20px;
    background:#f1f5f9;
    color:#64748b;
    font-size:12px;
}

.button{
    display:inline-block;
    padding:12px 20px;
    background:#2563eb;
    color:white !important;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
}

</style>
</head>

<body>

<div class="container">

    <div class="header">
        <div class="logo">
            SSI Service Management
        </div>
    </div>

    <div class="content">
        {!! $slot !!}
    </div>

    <div class="footer">
        PT Sinergi Solusi Informatika<br>
        Automated Notification
    </div>

</div>

</body>
</html>
