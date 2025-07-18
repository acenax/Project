<?php
if (!isset($_SESSION['login'])) {
    header('location:' . site_url());
}

session_destroy();
?>
<script>
Swal.fire({
    icon: 'success',
    title: 'ออกจากระบบเรียบร้อย'
}).then(function() {
    window.location.reload()// = './?'; //'//' + window.location.hostname
}), setTimeout(function() {
    window.location.reload();// = './?'; //'//' + window.location.hostname
}, 5000)
</script>