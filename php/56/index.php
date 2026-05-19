<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cek PHP - 5.6</title>
    <style>
        body {
            font-family: Segoe UI, Arial, sans-serif;
            margin: 2rem;
            background: #f7f9fb
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
            max-width: 760px
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>CEK PHP</h1>
        <p><strong>Versi PHP:</strong> <?php echo phpversion(); ?></p>
        <p><strong>SAPI:</strong> <?php echo php_sapi_name(); ?></p>
        <p><strong>Waktu server:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <p><strong>Extensions terpasang:</strong> <?php echo count(get_loaded_extensions()); ?> &nbsp;(<a href="?phpinfo=1">phpinfo()</a>)</p>
    </div>

    <?php if (isset($_GET['phpinfo'])) {
        phpinfo();
    } ?>
</body>

</html>