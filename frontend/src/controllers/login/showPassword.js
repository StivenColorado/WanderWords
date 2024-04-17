document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordVisibilityButton = document.querySelector('#togglePasswordVisibility');
    const passwordInput = document.querySelector('#passwordInput');
    const eyeIcon = document.querySelector('#eyeIcon');
    const closeEyeIcon = document.querySelector('#closeEyeIcon');
    togglePasswordVisibilityButton.addEventListener('click', togglePasswordVisibility);

    function togglePasswordVisibility() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            closeEyeIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('hidden');
            closeEyeIcon.classList.add('hidden');
        }
    }
});
