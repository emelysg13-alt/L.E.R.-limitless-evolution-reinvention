function actualizarReloj() {
  const reloj = document.getElementById("reloj");
  const ahora = new Date();
  reloj.textContent = ahora.toLocaleTimeString();
}
setInterval(actualizarReloj, 1000);
actualizarReloj();

const pelota = document.getElementById('pelota');

let posX = window.innerWidth / 2;
let posY = window.innerHeight / 2;
let angle = 0;
let velocityX = 0;
let velocityY = 0;
const friction = 0.98;

function moverPelota() {
  velocityX *= friction;
  velocityY *= friction;

  posX += velocityX;
  posY += velocityY;

  if (posX <= 0 || posX >= window.innerWidth - 50) {
    velocityX *= -0.8;
    posX = Math.max(0, Math.min(posX, window.innerWidth - 50));
  }

  if (posY <= 0 || posY >= window.innerHeight - 50) {
    velocityY *= -0.8;
    posY = Math.max(0, Math.min(posY, window.innerHeight - 50));
  }

  angle += (velocityX + velocityY) * 0.5;

  pelota.style.left = `${posX}px`;
  pelota.style.top = `${posY}px`;
  pelota.style.transform = `translate(-50%, -50%) rotate(${angle}deg)`;

  requestAnimationFrame(moverPelota);
}

moverPelota();

pelota.addEventListener('mouseenter', (e) => {
  const rect = pelota.getBoundingClientRect();
  const centerX = rect.left + rect.width / 2;
  const centerY = rect.top + rect.height / 2;

  const deltaX = centerX - e.clientX;
  const deltaY = centerY - e.clientY;

  const mag = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
  velocityX += (deltaX / mag) * 8;
  velocityY += (deltaY / mag) * 8;
});
