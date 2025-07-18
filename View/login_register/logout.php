<?php
if (!isset($_SESSION['login'])) {
    header('location:' . site_url());
}

echo __FILE__;

session_destroy();
?>
<script>
Swal.fire({
    icon: 'success',
    title: 'ออกจากระบบเรียบร้อย'
}).then(function() {
    window.location = '?'; //window.location.hostname
}), setTimeout(function() {
    window.location = '?'; //window.location.hostname
}, 5000)
</script>