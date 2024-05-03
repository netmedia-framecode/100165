<?php if (!isset($_SESSION[""])) {
  session_start();
}
error_reporting(~E_NOTICE & ~E_DEPRECATED);
require_once("db_connect.php");
require_once(__DIR__ . "/../models/sql.php");
require_once("functions.php");

$messageTypes = ["success", "info", "warning", "danger", "dark"];

$baseURL = "http://$_SERVER[HTTP_HOST]/apps/tugas/prediksi_pertumbuhan_penduduk/";
$hostname = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];
if (strpos($hostname, 'apps.test') !== false && $port == 8080) {
  $baseURL = str_replace('/apps/', '/', $baseURL);
}
$name_website = "Prediksi Pertumbuhan Penduduk";

$select_auth = "SELECT * FROM auth";
$views_auth = mysqli_query($conn, $select_auth);

$tentang = "SELECT * FROM tentang";
$views_tentang = mysqli_query($conn, $tentang);

$kontak = "SELECT * FROM kontak";
$views_kontak = mysqli_query($conn, $kontak);
if (isset($_POST['add_kontak'])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (kontak($conn, $validated_post, $action = 'insert', $pesan = $_POST['pesan']) > 0) {
    $message = "Pesan anda berhasil dikirim.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: kontak");
    exit();
  }
}

$periode = "SELECT * FROM data_periode ORDER BY periode ASC";
$views_periode = mysqli_query($conn, $periode);

$variabel = "SELECT * FROM data_variabel ORDER BY nama_variabel ASC";
$views_variabel = mysqli_query($conn, $variabel);

if (isset($_POST["uji_prediksi_rl"])) {
  $_SESSION["project_prediksi_pertumbuhan_penduduk"]['prediksi_rl'] = [
    'uji_periode' => $_POST['uji_periode'],
    'data_migrasi' => $_POST['data_migrasi'],
    'variabel_dependen' => $_POST['variabel_dependen'],
    'variabel_independen' => $_POST['variabel_independen']
  ];
  $to_page = strtolower($_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"]);
  $to_page = str_replace(" ", "-", $to_page);
  header("Location: $to_page");
  exit();
}
if (isset($_POST["uji_prediksi_es"])) {
  $_SESSION["project_prediksi_pertumbuhan_penduduk"]['prediksi_es'] = [
    'uji_periode' => $_POST['uji_periode'],
    'nilai_alpha' => $_POST['nilai_alpha'],
    'variabel_dependen' => $_POST['variabel_dependen']
  ];
  $to_page = strtolower($_SESSION["project_prediksi_pertumbuhan_penduduk"]["name_page"]);
  $to_page = str_replace(" ", "-", $to_page);
  header("Location: $to_page");
  exit();
}

$dataset = "SELECT dataset.*, data_periode.periode, data_variabel.nama_variabel
FROM dataset 
JOIN data_periode ON dataset.id_periode=data_periode.id_periode 
JOIN data_variabel ON dataset.id_variabel=data_variabel.id_variabel 
ORDER BY data_periode.periode ASC
";
$views_dataset = mysqli_query($conn, $dataset);

$hasil_rl = "SELECT * FROM hasil_rl ORDER BY periode ASC";
$views_hasil_rl = mysqli_query($conn, $hasil_rl);
$hasil_es = "SELECT * FROM hasil_es ORDER BY periode ASC";
$views_hasil_es = mysqli_query($conn, $hasil_es);

if (!isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"])) {
  if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["time_message"]) && (time() - $_SESSION["project_prediksi_pertumbuhan_penduduk"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["message_$type"])) {
        unset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["message_$type"]);
      }
    }
    unset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["time_message"]);
  }
  if (isset($_POST["register"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (register($conn, $validated_post, $action = 'insert') > 0) {
      header("Location: verification?en=" . $_SESSION['data_auth']['en_user']);
      exit();
    }
  }
  if (isset($_POST["re_verifikasi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (re_verifikasi($conn, $validated_post, $action = 'update') > 0) {
      $message = "Kode token yang baru telah dikirim ke email anda.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: verification?en=" . $_SESSION['data_auth']['en_user']);
      exit();
    }
  }
  if (isset($_POST["verifikasi"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (verifikasi($conn, $validated_post, $action = 'update') > 0) {
      $message = "Akun anda berhasil di verifikasi.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["forgot_password"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (forgot_password($conn, $validated_post, $action = 'update', $baseURL) > 0) {
      $message = "Kami telah mengirim link ke email anda untuk melakukan reset kata sandi.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["new_password"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (new_password($conn, $validated_post, $action = 'update') > 0) {
      $message = "Kata sandi anda telah berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: ./");
      exit();
    }
  }
  if (isset($_POST["login"])) {
    if (login($conn, $_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"])) {
  $id_user = valid($conn, $_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["id"]);
  $id_role = valid($conn, $_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["id_role"]);
  $role = valid($conn, $_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["role"]);
  $email = valid($conn, $_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["email"]);
  $name = valid($conn, $_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["name"]);
  if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["time_message"]) && (time() - $_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["message_$type"])) {
        unset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["message_$type"]);
      }
    }
    unset($_SESSION["project_prediksi_pertumbuhan_penduduk"]["users"]["time_message"]);
  }
  $profile = "SELECT users.*, user_role.role, user_status.status 
                      FROM users
                      JOIN user_role ON users.id_role=user_role.id_role 
                      JOIN user_status ON users.id_active=user_status.id_status 
                      WHERE users.id_user='$id_user'
                    ";
  $view_profile = mysqli_query($conn, $profile);
  if (isset($_POST["edit_profil"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (profil($conn, $validated_post, $action = 'update', $id_user) > 0) {
      $message = "Profil Anda berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: profil");
      exit();
    }
  }
  if (isset($_POST["setting"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (setting($conn, $validated_post, $action = 'update') > 0) {
      $message = "Setting pada system login berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: setting");
      exit();
    }
  }

  $users = "SELECT users.*, user_role.role, user_status.status 
                    FROM users
                    JOIN user_role ON users.id_role=user_role.id_role 
                    JOIN user_status ON users.id_active=user_status.id_status
                  ";
  $views_users = mysqli_query($conn, $users);
  $user_role = "SELECT * FROM user_role";
  $views_user_role = mysqli_query($conn, $user_role);
  if (isset($_POST["edit_users"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (users($conn, $validated_post, $action = 'update') > 0) {
      $message = "data users berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: users");
      exit();
    }
  }
  if (isset($_POST["add_role"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (role($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Role baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: role");
      exit();
    }
  }
  if (isset($_POST["edit_role"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (role($conn, $validated_post, $action = 'update') > 0) {
      $message = "Role " . $_POST['roleOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: role");
      exit();
    }
  }
  if (isset($_POST["delete_role"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (role($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Role " . $_POST['role'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: role");
      exit();
    }
  }

  $menu = "SELECT * 
                    FROM user_menu 
                    ORDER BY menu ASC
                  ";
  $views_menu = mysqli_query($conn, $menu);
  if (isset($_POST["add_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Menu baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu");
      exit();
    }
  }
  if (isset($_POST["edit_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu($conn, $validated_post, $action = 'update') > 0) {
      $message = "Menu " . $_POST['menuOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu");
      exit();
    }
  }
  if (isset($_POST["delete_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Menu " . $_POST['menu'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu");
      exit();
    }
  }

  $sub_menu = "SELECT user_sub_menu.*, user_menu.menu, user_status.status 
                        FROM user_sub_menu 
                        JOIN user_menu ON user_sub_menu.id_menu=user_menu.id_menu 
                        JOIN user_status ON user_sub_menu.id_active=user_status.id_status 
                        ORDER BY user_sub_menu.title ASC
                      ";
  $views_sub_menu = mysqli_query($conn, $sub_menu);
  $user_status = "SELECT * 
                          FROM user_status
                        ";
  $views_user_status = mysqli_query($conn, $user_status);
  if (isset($_POST["add_sub_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu($conn, $validated_post, $action = 'insert', $baseURL) > 0) {
      $message = "Sub Menu baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu");
      exit();
    }
  }
  if (isset($_POST["edit_sub_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu($conn, $validated_post, $action = 'update', $baseURL) > 0) {
      $message = "Sub Menu " . $_POST['titleOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu");
      exit();
    }
  }
  if (isset($_POST["delete_sub_menu"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu($conn, $validated_post, $action = 'delete', $baseURL) > 0) {
      $message = "Sub Menu " . $_POST['title'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu");
      exit();
    }
  }

  $user_access_menu = "SELECT user_access_menu.*, user_role.role, user_menu.menu
                                FROM user_access_menu 
                                JOIN user_role ON user_access_menu.id_role=user_role.id_role 
                                JOIN user_menu ON user_access_menu.id_menu=user_menu.id_menu
                              ";
  $views_user_access_menu = mysqli_query($conn, $user_access_menu);
  $menu_check = "SELECT user_menu.* 
                    FROM user_menu 
                    ORDER BY user_menu.menu ASC
                  ";
  $views_menu_check = mysqli_query($conn, $menu_check);
  if (isset($_POST["add_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_access($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Akses ke menu berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu-access");
      exit();
    }
  }
  if (isset($_POST["edit_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_access($conn, $validated_post, $action = 'update') > 0) {
      $message = "Akses menu " . $_POST['menu'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu-access");
      exit();
    }
  }
  if (isset($_POST["delete_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (menu_access($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Akses menu " . $_POST['menu'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: menu-access");
      exit();
    }
  }

  $user_access_sub_menu = "SELECT user_access_sub_menu.*, user_role.role, user_sub_menu.title
                                FROM user_access_sub_menu 
                                JOIN user_role ON user_access_sub_menu.id_role=user_role.id_role 
                                JOIN user_sub_menu ON user_access_sub_menu.id_sub_menu=user_sub_menu.id_sub_menu
                              ";
  $views_user_access_sub_menu = mysqli_query($conn, $user_access_sub_menu);
  $sub_menu_check = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu 
                    JOIN user_menu ON user_sub_menu.id_menu=user_menu.id_menu
                    ORDER BY user_sub_menu.title ASC
                  ";
  $views_sub_menu_check = mysqli_query($conn, $sub_menu_check);
  if (isset($_POST["add_sub_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu_access($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Akses ke sub menu berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu-access");
      exit();
    }
  }
  if (isset($_POST["edit_sub_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu_access($conn, $validated_post, $action = 'update') > 0) {
      $message = "Akses sub menu " . $_POST['title'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu-access");
      exit();
    }
  }
  if (isset($_POST["delete_sub_menu_access"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (sub_menu_access($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Akses sub menu " . $_POST['title'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: sub-menu-access");
      exit();
    }
  }

  if (isset($_POST["add_variabel"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (variabel($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Variabel baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: variabel");
      exit();
    }
  }
  if (isset($_POST["edit_variabel"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (variabel($conn, $validated_post, $action = 'update') > 0) {
      $message = "Variabel " . $_POST['nama_variabelOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: variabel");
      exit();
    }
  }
  if (isset($_POST["delete_variabel"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (variabel($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Variabel " . $_POST['nama_variabel'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: variabel");
      exit();
    }
  }

  $last_periode = "SELECT * FROM data_periode ORDER BY periode DESC LIMIT 1";
  $views_last_periode = mysqli_query($conn, $last_periode);
  if (mysqli_num_rows($views_last_periode) > 0) {
    $data_last_periode = mysqli_fetch_assoc($views_last_periode);
    $new_periode = $data_last_periode['periode'] + 1;
  } else {
    $new_periode = 2015;
  }
  if (isset($_POST["add_periode"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (periode($conn, $validated_post, $action = 'insert') > 0) {
      $message = "Periode baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: periode");
      exit();
    }
  }
  if (isset($_POST["edit_periode"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (periode($conn, $validated_post, $action = 'update') > 0) {
      $message = "Periode " . $_POST['periodeOld'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: periode");
      exit();
    }
  }
  if (isset($_POST["delete_periode"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (periode($conn, $validated_post, $action = 'delete') > 0) {
      $message = "Periode " . $_POST['periode'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: periode");
      exit();
    }
  }

  $select_periode = "SELECT * FROM data_periode WHERE NOT EXISTS (SELECT 1 FROM dataset JOIN data_variabel ON dataset.id_variabel = data_variabel.id_variabel WHERE dataset.id_periode = data_periode.id_periode AND dataset.id_variabel = data_variabel.id_variabel)";
  $views_select_periode = mysqli_query($conn, $select_periode);
  if (isset($_POST["add_dataset"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (dataset($conn, $validated_post, $action = 'insert', $baseURL) > 0) {
      $message = "Dataset baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: dataset");
      exit();
    }
  }
  if (isset($_POST["edit_dataset"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (dataset($conn, $validated_post, $action = 'update', $baseURL) > 0) {
      $message = "Dataset periode " . $_POST['periode'] . " dengan nama variabel " . $_POST['nama_variabel'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: dataset");
      exit();
    }
  }
  if (isset($_POST["delete_dataset"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (dataset($conn, $validated_post, $action = 'delete', $baseURL) > 0) {
      $message = "Dataset periode " . $_POST['periode'] . " dengan nama variabel " . $_POST['nama_variabel'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: dataset");
      exit();
    }
  }

  if (isset($_POST["edit_tentang"])) {
    if (tentang($conn, $_POST, $action = 'update') > 0) {
      $message = "Deskripsi tentang berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: tentang");
      exit();
    }
  }

  if (isset($_POST["delete_kontak"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (kontak($conn, $validated_post, $action = 'delete', $_POST['pesan']) > 0) {
      $message = "Pesan berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: kontak");
      exit();
    }
  }

  $data_uji = "SELECT * FROM data_uji ORDER BY periode ASC";
  $views_data_uji = mysqli_query($conn, $data_uji);
  if (isset($_POST["add_data_uji"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (data_uji($conn, $validated_post, $action = 'insert', $baseURL) > 0) {
      $message = "Data uji baru berhasil ditambahkan.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: data-uji");
      exit();
    }
  }
  if (isset($_POST["edit_data_uji"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (data_uji($conn, $validated_post, $action = 'update', $baseURL) > 0) {
      $message = "Data uji periode " . $_POST['periode'] . " berhasil diubah.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: data-uji");
      exit();
    }
  }
  if (isset($_POST["delete_data_uji"])) {
    $validated_post = array_map(function ($value) use ($conn) {
      return valid($conn, $value);
    }, $_POST);
    if (data_uji($conn, $validated_post, $action = 'delete', $baseURL) > 0) {
      $message = "Data uji periode " . $_POST['periode'] . " berhasil dihapus.";
      $message_type = "success";
      alert($message, $message_type);
      header("Location: data-uji");
      exit();
    }
  }

  if (isset($_POST["prediksi"])) {
    $uji_periode = valid($conn, $_POST['uji_periode']);
    $metode = valid($conn, $_POST['metode']);
    $nilai_alpha = valid($conn, $_POST['nilai_alpha']);
    $variabel_dependen = valid($conn, $_POST['variabel_dependen']);
    $variabel_independen = valid($conn, $_POST['variabel_independen']);
    $check_data_uji_periode = "SELECT * FROM data_uji WHERE periode='$uji_periode'";
    $views_data_uji_periode = mysqli_query($conn, $check_data_uji_periode);
    if ($metode == 1) {
      $nama_metode = "Regression Linear";
    } else if ($metode == 2) {
      $nama_metode = "Single Exponential Smoothing";
    }
    if (mysqli_num_rows($views_data_uji_periode) == 0) {
      $message = "Maaf, anda belum memasukan data uji untuk periode $uji_periode.";
      $message_type = "danger";
      alert($message, $message_type);
      header("Location: prediksi");
      exit();
    } else if (mysqli_num_rows($views_data_uji_periode) > 0) {
      $data = mysqli_fetch_assoc($views_data_uji_periode);
      $_SESSION["project_prediksi_pertumbuhan_penduduk"]['prediksi'] = [
        'uji_periode' => $uji_periode,
        'metode' => $metode,
        'nilai_alpha' => $nilai_alpha,
        'data_migrasi' => $data['jumlah'],
        'variabel_dependen' => $variabel_dependen,
        'variabel_independen' => $variabel_independen
      ];
      header("Location: prediksi");
      exit();
    }
  }
  if (isset($_POST['re_prediksi'])) {
    unset($_SESSION["project_prediksi_pertumbuhan_penduduk"]['prediksi']);
    header("Location: prediksi");
    exit();
  }
}
