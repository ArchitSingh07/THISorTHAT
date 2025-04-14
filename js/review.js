document.addEventListener("DOMContentLoaded", async () => {
  const review = JSON.parse(sessionStorage.getItem("lastReview"));
  const rows = document.querySelectorAll(".review-table tr");
  if (!review) return;

  for (let i = 0; i < review.length; i++) {
    const { id, picked } = review[i];
    const res = await fetch(`php/get_question.php?id=${id}`);
    const q = await res.json();

    const total = q.votes_a + q.votes_b;
    const percentA = Math.round((q.votes_a / total) * 100);
    const percentB = 100 - percentA;
    const pickedLabel = picked === "a" ? q.option_a : q.option_b;

    const cells = rows[i + 1].children; // +1 to skip <thead>
    cells[0].innerText = i + 1;
    cells[1].innerText = q.option_a;
    cells[2].innerText = q.option_b;
    cells[3].innerText = `${percentA}%`;
    cells[4].innerText = `${percentB}%`;
    cells[5].innerText = pickedLabel;
  }
});
