document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') && urlParams.get('status') === 'success') {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Login Successful!',
            showConfirmButton: false,
            timer: 1500
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status') && urlParams.get('status') === 'logout') {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Logout Successful!',
            showConfirmButton: false,
            timer: 1500
        });
    }
});