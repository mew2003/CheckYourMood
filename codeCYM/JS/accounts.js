let checkbox = document.getElementById('check');
checkbox.addEventListener('click', function() {
    if (checkbox.checked) {
        document.getElementById('oldPassword').type='text';
        document.getElementById('newPassword').type='text';
        document.getElementById('confirmPassword').type='text';
    } else {
        document.getElementById('oldPassword').type='password';
        document.getElementById('newPassword').type='password';
        document.getElementById('confirmPassword').type='password';
    }
});