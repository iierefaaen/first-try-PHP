<?php

session_start();
session_unset();
session_destroy();

// hapus cookie
// waktu minus artinya cookie hilang
setcookie("id", "", time() - 686795460);
setcookie("key", "", time() - 74565660);

echo "<script>
window.location.href = 'login.php';
</script>
";