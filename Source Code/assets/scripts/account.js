//Transition of account page
const sign_up_btn = document.getElementById("sign-up");
const sign_in_btn = document.getElementById("sign-in");
const account = document.getElementById("container2");

sign_up_btn.addEventListener("click", () => {
	account.classList.add("panel-active");
});

sign_in_btn.addEventListener("click", () => {
	account.classList.remove("panel-active");
});