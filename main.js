const registerForm = document.querySelector('.registerForm ');
const loginForm = document.querySelector('.loginForm');

const registerBtn = document.querySelector('.registerBtn');
const loginBtn = document.querySelector('.loginBtn');

const registerExit = document.querySelector('.registerForm .fa-times');
const loginExit = document.querySelector('.loginForm .fa-times');


registerBtn.addEventListener('click', () => { registerForm.style.display = 'inline-block' })
loginBtn.addEventListener('click', () => { loginForm.style.display = 'inline-block' })

registerExit.addEventListener('click', () => { registerForm.style.display = 'none' })
loginExit.addEventListener('click', () => { loginForm.style.display = 'none' })