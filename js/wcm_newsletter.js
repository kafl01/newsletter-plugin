//här behöver vi hitta formuläret fr sidan och skicka det vidare
const newsletterForm = document.querySelector("#our_newsletter");

newsletterForm.addEventListener("submit", sendAjaxRequest);

function sendAjaxRequest(event) {
  event.preventDefault();

  const actionUrl = newsletterForm.getAttribute("action");
  const formData = FormData(newsletterForm);

  fetch(actionUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data.message);
    })
    .catch((error) => {
      console.error("Error: ", error);
    });
}
