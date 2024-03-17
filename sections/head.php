<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!-- Site Metas -->
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />

<title><?= $name_website ?> <?php if (isset($_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'])) {
                              if (!empty($_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'])) {
                                echo " - " . $_SESSION['project_prediksi_pertumbuhan_penduduk']['name_page'];
                              }
                            } ?></title>

<!-- bootstrap core css -->
<link rel="stylesheet" type="text/css" href="<?= $baseURL ?>assets/css/bootstrap.css" />

<!-- fonts style -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

<!--owl slider stylesheet -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

<!-- font awesome style -->
<link href="<?= $baseURL ?>assets/css/font-awesome.min.css" rel="stylesheet" />

<!-- Custom styles for this template -->
<link href="<?= $baseURL ?>assets/css/styles.css" rel="stylesheet" />
<!-- responsive style -->
<link href="<?= $baseURL ?>assets/css/responsive.css" rel="stylesheet" />

<script src="<?= $baseURL ?>assets/sweetalert/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">