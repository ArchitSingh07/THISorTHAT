function startTransition() {
  const logo = document.getElementById('title-logo');
  logo.classList.add('fade-to-or');

  // Flag animation trigger for main page
  sessionStorage.setItem("fromTitle", "yes");

  setTimeout(() => {
    window.location.href = "main_page.html";
  }, 1000);
}
window.animateQuestionCards = function(callback) {
  const leftBtn = document.getElementById("left-question-btn");
  const rightBtn = document.getElementById("right-question-btn");
  const leftBox = document.getElementById("left-text-box");
  const rightBox = document.getElementById("right-text-box");

  // Animate OUT
  leftBtn.classList.add("fade-left-out");
  rightBtn.classList.add("fade-right-out");
  leftBox.classList.add("fade-left-out");
  rightBox.classList.add("fade-right-out");

  setTimeout(() => {
    if (callback) callback();

    // Remove OUT
    leftBtn.classList.remove("fade-left-out");
    rightBtn.classList.remove("fade-right-out");
    leftBox.classList.remove("fade-left-out");
    rightBox.classList.remove("fade-right-out");

    // Animate IN
    leftBtn.classList.add("fade-behind-in");
    rightBtn.classList.add("fade-behind-in");
    leftBox.classList.add("fade-behind-in");
    rightBox.classList.add("fade-behind-in");

    setTimeout(() => {
      leftBtn.classList.remove("fade-behind-in");
      rightBtn.classList.remove("fade-behind-in");
      leftBox.classList.remove("fade-behind-in");
      rightBox.classList.remove("fade-behind-in");
    }, 400);
  }, 400);
};
 window.transitionToMain = function () {
  const page = document.querySelector(".content");
  page.classList.add("bob-up-exit");

  setTimeout(() => {
    window.location.href = "main_page.html";
  }, 1000); // Match animation duration
};
