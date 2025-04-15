let currentQuestion = null;
let uniquenessScore = 1000;
let userAnswers = [];

function loadQuestion() {
  fetch("php/get_question.php") 
    .then(res => res.json())
    .then(q => {
      currentQuestion = q;
      document.getElementById("left-question-btn").textContent = q.option_a;
      document.getElementById("right-question-btn").textContent = q.option_b;

      document.getElementById("left-text-box").textContent = "";
      document.getElementById("right-text-box").textContent = "";

    });
}

function submitVote(choice) {
  if (!currentQuestion) return;
  
  const formData = new FormData();
formData.append("id", currentQuestion.id);
formData.append("choice", choice);
formData.append("uniqueness", uniquenessScore);
  
  fetch("php/submit_vote.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(votes => {
    const total = votes.votes_a + votes.votes_b;
    const percentA = Math.round((votes.votes_a / total) * 100);
    const percentB = 100 - percentA;
    
    document.getElementById("left-text-box").textContent = `${percentA}%`;
    document.getElementById("right-text-box").textContent = `${percentB}%`;
    
    const pickedPercent = choice === "a" ? percentA : percentB;
    
    console.log("Picked percent:", pickedPercent);
function updateUniqueness(score, pickedPercent) {
  const diff = Math.abs(pickedPercent - 50);
  const k = 15;
  const factor = (50 - diff) / 50;
  const change = Math.round(k * factor);
  return pickedPercent < 50 ? score + change : score - change;
}

uniquenessScore = updateUniqueness(uniquenessScore, pickedPercent);
console.log("New uniquenessScore:", uniquenessScore);
sessionStorage.setItem("uniquenessScore", uniquenessScore);
document.getElementById("profile-score").textContent = uniquenessScore;

      userAnswers.push({ id: currentQuestion.id, picked: choice });

      // Save and redirect to review page every 10 questions
      if (userAnswers.length % 10 === 0) {
        sessionStorage.setItem("lastReview", JSON.stringify(userAnswers));
        userAnswers = [];
        window.location.href = "review.html";
      }
    });
}

document.addEventListener("DOMContentLoaded", () => {
  loadQuestion();

  document.getElementById("left-question-btn").addEventListener("click", () => submitVote("a"));
  document.getElementById("right-question-btn").addEventListener("click", () => submitVote("b"));
  document.getElementById("next-button").onclick = () => {
    animateQuestionCards(loadQuestion); // 🎯 play anim, then load
  };

  const savedScore = sessionStorage.getItem("uniquenessScore");
  if (savedScore) uniquenessScore = parseInt(savedScore);
});
