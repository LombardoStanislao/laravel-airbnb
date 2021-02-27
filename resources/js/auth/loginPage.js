const signInButton = document.querySelector("#sign-in-button");
const signUpButton = document.querySelector("#sign-up-button");
const container = document.querySelector("#container-register-signin");

signUpButton.addEventListener('click', () => {
    container.classList.add("sign-up-mode");
})

signInButton.addEventListener('click', () => {
    container.classList.remove("sign-up-mode");
})
