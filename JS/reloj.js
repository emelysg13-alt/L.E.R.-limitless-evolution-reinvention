function actualizarReloj() {
  const reloj = document.getElementById("reloj");
  const ahora = new Date();
  reloj.textContent = ahora.toLocaleTimeString();
}

setInterval(actualizarReloj, 1000);
actualizarReloj();
